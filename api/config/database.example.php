<?php
class Database {
    private $host = "192.168.0.example";
    private $db_name = "unidad1back";
    private $username = "example";
    private $password = "example";
    public $conn;

    // Establece y retorna la conexión PDO a la base de datos
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
