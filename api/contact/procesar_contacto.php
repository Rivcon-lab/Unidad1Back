<?php
define('BASE_PATH', dirname(__FILE__));

// Lista de orígenes permitidos
$allowed_origins = [
    "http://localhost",
    "http://localhost:80",
    "http://localhost:8080",
    "https://website.crispity.tech"
];

// Detecta el origen de la petición y responde dinámicamente
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
} else {
    header("Access-Control-Allow-Origin: http://localhost");
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/database.php';

// Verifica que el método sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Obtén los datos enviados desde el formulario
    $nombre = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $servicio = $_POST['service'] ?? '';
    $mensaje = $_POST['message'] ?? '';

    // Validación básica
    if (empty($nombre) || empty($email) || empty($servicio) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Inserta los datos en la tabla contactos (ajusta el nombre de la columna si es necesario)
    $query = "INSERT INTO contactos (nombre, email, servicio, mensaje) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$nombre, $email, $servicio, $mensaje])) {
        echo json_encode(['success' => true, 'message' => 'Formulario enviado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar los datos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>