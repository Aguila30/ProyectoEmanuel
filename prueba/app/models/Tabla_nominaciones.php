<?php
require_once(__DIR__ . '/../config/Connect.php');

class Tabla_nominaciones {
    private $connect;
    private $table = 'nominaciones';
    private $primary_key = 'id_nominacion';

    public function __construct() {
        $db = new Connect();
        $this->connect = $db->connect;
    }
    // ------------------------
    // CRUD
    // ------------------------

    public function createNominacion($data = array()) {

        // Dynamic fields
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($values)";

        try {
            $stmt = $this->connect->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    public function readAllNominaciones() {
    // Usamos 'AS' para renombrar las columnas y que coincidan con tu HTML
    $sql = "SELECT 
                n.*, 
                c.nombre_categoria_nominacion AS categoria, 
                ar.pseudonimo_artista AS artista,
                a.titulo_album AS descripcion
            FROM {$this->table} n 
            INNER JOIN categorias_nominaciones c 
                ON n.id_categoria_nominacion = c.id_categoria_nominacion
            INNER JOIN albumes a 
                ON n.id_album = a.id_album
            INNER JOIN artistas ar
                ON n.id_artista = ar.id_artista
            ORDER BY n.id_nominacion DESC;";

    try {
        $stmt = $this->connect->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return (!empty($rows)) ? $rows : array();
    } catch (PDOException $e) {
        echo "Error in query: " . $e->getMessage();
    }
}

    public function readGetNominacion($id = 0) {

        $sql = "
            SELECT * FROM {$this->table}
            WHERE {$this->primary_key} = :id;
        ";

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $row = $stmt->fetch();
            return (!empty($row)) ? $row : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    }

    public function updateNominacion($id = 0, $data = array()) {

        $params = array();
        $fields = array();

        foreach ($data as $key => $value) {
            $params[":".$key] = $value;
            $fields[] = "$key = :$key";
        }

        try {
            $setParams = implode(", ", $fields);

            $sql = "
                UPDATE {$this->table}
                SET {$setParams}
                WHERE {$this->primary_key} = :id;
            ";

            $stmt = $this->connect->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(":id", $id);

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    public function deleteNominacion($id = 0) {

        $sql = "
            DELETE FROM {$this->table}
            WHERE {$this->primary_key} = :id;
        ";

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    // ------------------------
    // QUERIES ESPECIALES
    // ------------------------

    public function buscarPorCategoria($id_categoria) {

        $sql = "
            SELECT * FROM {$this->table}
            WHERE id_categoria_nominacion = :cat;
        ";

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":cat", $id_categoria);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            return (!empty($rows)) ? $rows : array();

        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return array();
        }
    }
}
