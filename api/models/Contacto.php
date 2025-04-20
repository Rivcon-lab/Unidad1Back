<?php
class Contacto {
    private $conn;
    private $table_name = "contactos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearContacto($nombre, $email, $servicio, $mensaje) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, servicio, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nombre, $email, $servicio, $mensaje]);
    }
}
?>