<?php
// app/models/Tabla_portal.php

// 1. Usamos la ruta EXACTA que ya funciona en tu proyecto
require_once(__DIR__.'/../config/Connect.php');

class Tabla_portal {
    
    private $connect;

    public function __construct() {
        // 2. CONEXIÓN CORREGIDA (Igual que en Tabla_usuarios.php)
        $db = new Connect();
        
        // EL SECRETO ESTABA AQUÍ:
        // No es una función $db->connect(), es una PROPIEDAD $db->connect
        $this->connect = $db->connect;
    }

    // --- CONSULTA 1: ARTISTAS EN TENDENCIA ---
    public function getTendenciasArtistas() {
        $sql = "SELECT a.pseudonimo_artista, a.biografia_artista, u.imagen_usuario, COUNT(v.id_votacion) as total_votos
                FROM artistas a
                INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                LEFT JOIN nominaciones n ON a.id_artista = n.id_artista
                LEFT JOIN votaciones v ON n.id_nominacion = v.id_nominacion
                WHERE a.estatus_artista = 2
                GROUP BY a.id_artista
                ORDER BY total_votos DESC LIMIT 3";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    // --- CONSULTA 2: ÁLBUMES EN TENDENCIA ---
    public function getTendenciasAlbumes() {
        $sql = "SELECT al.titulo_album, al.imagen_album, ar.pseudonimo_artista, COUNT(v.id_votacion) as total_votos
                FROM albumes al
                INNER JOIN artistas ar ON al.id_artista = ar.id_artista
                LEFT JOIN nominaciones n ON al.id_album = n.id_album
                LEFT JOIN votaciones v ON n.id_nominacion = v.id_nominacion
                WHERE al.estatus_album = 2
                GROUP BY al.id_album
                ORDER BY total_votos DESC LIMIT 3";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    // --- CONSULTA 3: LISTA DE CATEGORÍAS ---
    public function getCategoriasActivas() {
        $sql = "SELECT * FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 2 ORDER BY nombre_categoria_nominacion ASC";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    // --- CONSULTA 4: FECHA LÍMITE ---
    public function getFechaLimite() {
        $sql = "SELECT fecha_categoria_nominacion FROM categorias_nominaciones WHERE estatus_categoria_nominacion = 2 LIMIT 1";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result->fecha_categoria_nominacion : '2025-12-31'; 
        } catch (PDOException $e) {
            return '2025-12-31';
        }
    }

    // --- CONSULTA 5: NOMINACIONES COMPLETAS (Para votar) ---
    public function getNominacionesCompletas() {
        $sql = "SELECT n.id_nominacion, c.id_categoria_nominacion, c.nombre_categoria_nominacion, 
                       c.descripcion_categoria_nominacion, ar.pseudonimo_artista, u.imagen_usuario as foto_artista,
                       al.titulo_album, al.imagen_album
                FROM nominaciones n
                INNER JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
                INNER JOIN artistas ar ON n.id_artista = ar.id_artista
                INNER JOIN usuarios u ON ar.id_usuario = u.id_usuario
                LEFT JOIN albumes al ON n.id_album = al.id_album
                WHERE c.estatus_categoria_nominacion = 2
                ORDER BY c.id_categoria_nominacion ASC";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    // --- NUEVA FUNCIÓN: REGISTRAR VOTO ---
    // Copia esto y pégalo antes de la última llave "}" de tu archivo
    public function registrarVoto($id_usuario, $id_nominacion) {
        
        // 1. Averiguamos a qué categoría pertenece esta nominación
        $sqlCat = "SELECT id_categoria_nominacion FROM nominaciones WHERE id_nominacion = :id_nom";
        
        if($this->connect) {
            $stmtCat = $this->connect->prepare($sqlCat);
            $stmtCat->bindParam(":id_nom", $id_nominacion);
            $stmtCat->execute();
            $cat = $stmtCat->fetch(PDO::FETCH_OBJ);

            if (!$cat) return "error"; // Nominación no existe

            // 2. Verificamos si este usuario YA VOTÓ en esta misma categoría
            $sqlCheck = "SELECT COUNT(*) as votos FROM votaciones v
                         INNER JOIN nominaciones n ON v.id_nominacion = n.id_nominacion
                         WHERE v.id_usuario = :id_user AND n.id_categoria_nominacion = :id_cat";
            
            $stmtCheck = $this->connect->prepare($sqlCheck);
            $stmtCheck->bindParam(":id_user", $id_usuario);
            $stmtCheck->bindParam(":id_cat", $cat->id_categoria_nominacion);
            $stmtCheck->execute();
            $check = $stmtCheck->fetch(PDO::FETCH_OBJ);

            if ($check->votos > 0) {
                return "duplicado"; // ¡Ya votó! No dejamos pasar.
            }

            // 3. Si está limpio, insertamos el voto
            try {
                $sqlInsert = "INSERT INTO votaciones (fecha_votacion, id_nominacion, id_usuario)
                              VALUES (NOW(), :id_nom, :id_user)";
                $stmt = $this->connect->prepare($sqlInsert);
                $stmt->bindParam(":id_nom", $id_nominacion);
                $stmt->bindParam(":id_user", $id_usuario);
                
                if($stmt->execute()){
                    return "exito";
                }
            } catch (PDOException $e) {
                return "error";
            }
        }
        return "error";
    }
    // --- CONSULTA 6: MIS VOTOS (Historial del usuario) ---
    public function getMisVotos($id_usuario) {
        $sql = "SELECT 
                    v.fecha_votacion,
                    c.nombre_categoria_nominacion,
                    ar.pseudonimo_artista,
                    u.imagen_usuario as foto_artista,
                    al.titulo_album,
                    al.imagen_album
                FROM votaciones v
                INNER JOIN nominaciones n ON v.id_nominacion = n.id_nominacion
                INNER JOIN categorias_nominaciones c ON n.id_categoria_nominacion = c.id_categoria_nominacion
                INNER JOIN artistas ar ON n.id_artista = ar.id_artista
                INNER JOIN usuarios u ON ar.id_usuario = u.id_usuario
                LEFT JOIN albumes al ON n.id_album = al.id_album
                WHERE v.id_usuario = :id
                ORDER BY v.fecha_votacion DESC";
        
        if($this->connect) {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        return [];
    }
} 
?>