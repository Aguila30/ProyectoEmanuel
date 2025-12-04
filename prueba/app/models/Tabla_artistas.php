<?php
// app/models/Tabla_artistas.php

// 1. Conexión a la Base de Datos (Usamos la ruta segura)
require_once(__DIR__.'/../config/Connect.php');

class Tabla_artistas {
    
    private $connect;
    private $table = 'artistas';
    private $primary_key = 'id_artista';

    public function __construct() {
        $db = new Connect();
        // Detectamos conexión automáticamente
        if (method_exists($db, 'connect')) {
            $this->connect = $db->connect();
        } elseif (method_exists($db, 'conectar')) {
            $this->connect = $db->conectar();
        } else {
            $this->connect = $db->connect; 
        }
    }

    // --- LEER TODOS LOS ARTISTAS ---
    public function readAllArtistas() {
        // Hacemos INNER JOIN con usuarios para obtener la FOTO (imagen_usuario)
        $sql = "SELECT 
                    a.id_artista,
                    a.pseudonimo_artista,
                    a.nacionalidad_artista,
                    a.estatus_artista,
                    a.biografia_artista,
                    u.imagen_usuario 
                FROM " . $this->table . " a
                INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                ORDER BY a.pseudonimo_artista ASC";
        
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // --- CREAR UN ARTISTA ---
    public function createArtista($data = array()) {
        try {
            $fields = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO " . $this->table . " ($fields) VALUES ($values)";
            
            $stmt = $this->connect->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // --- OBTENER UN ARTISTA POR ID ---
    public function readGetArtista($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = :id";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    // --- ACTUALIZAR ARTISTA ---
    public function updateArtista($id, $data = array()) {
        try {
            $fields = [];
            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key";
            }
            $setParams = implode(", ", $fields);
            
            $sql = "UPDATE " . $this->table . " SET $setParams WHERE " . $this->primary_key . " = :id";
            
            $stmt = $this->connect->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // --- ELIMINAR ARTISTA ---
    public function deleteArtista($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $this->primary_key . " = :id";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>