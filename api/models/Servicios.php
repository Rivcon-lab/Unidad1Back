<?php
class Servicio {
    private $conn;
    private $table_name = "servicios";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtiene todos los registros de servicios
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Inserta un nuevo servicio en la base de datos
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " (titulo_esp, titulo_eng, descripcion_esp, descripcion_eng) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['titulo_esp'],
            $data['titulo_eng'],
            $data['descripcion_esp'],
            $data['descripcion_eng']
        ]);
    }

    // Actualiza un servicio existente por su ID
    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET titulo_esp=?, titulo_eng=?, descripcion_esp=?, descripcion_eng=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['titulo_esp'],
            $data['titulo_eng'],
            $data['descripcion_esp'],
            $data['descripcion_eng'],
            $id
        ]);
    }

    // Elimina un servicio por su ID
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtiene un servicio específico por su ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
?>