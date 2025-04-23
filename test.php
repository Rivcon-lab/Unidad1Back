<?php
try {
    $pdo = new PDO("mysql:host=192.168.0.59;dbname=unidad1back", "root", "nqfqTWeKfbYdv");
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>