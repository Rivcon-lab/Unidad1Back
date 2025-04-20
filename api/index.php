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

// Manejar preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Autenticación Bearer para proteger la API
$headers = getallheaders();
if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer backcrispity') {
    http_response_code(401);
    echo json_encode(['message' => 'No autorizado']);
    exit;
}

// Inclusión de dependencias principales
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/controllers/ServiciosController.php';
require_once BASE_PATH . '/controllers/NosotrosController.php';

// Inicialización de la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
// Obtención de la ruta solicitada para el enrutamiento interno
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'];

// Enrutamiento de endpoints según la ruta y el método HTTP
switch ($route) {
    case 'servicios':
        $servicioController = new ServiciosController($db);
        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $servicioController->getServicios($_GET['id']);
                } else {
                    $servicioController->getServicios();
                }
                break;
            case 'POST':
                $servicioController->createServicio();
                break;
            case 'PUT':
                if (isset($_GET['id'])) {
                    $servicioController->updateServicio($_GET['id']);
                } else {
                    echo json_encode(['message' => 'ID requerido para actualizar']);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $servicioController->deleteServicio($_GET['id']);
                } else {
                    echo json_encode(['message' => 'ID requerido para eliminar']);
                }
                break;
            default:
                echo json_encode(['message' => 'Método no permitido']);
        }
        break;

        case 'nosotros':
            $nosotrosController = new NosotrosController($db);
            switch ($method) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        $nosotrosController->getNosotros();
                    } else {
                        $nosotrosController->getNosotros();
                    }
                    break;
                case 'POST':
                    $nosotrosController->createNosotros();
                    break;
                case 'PUT':
                    if (isset($_GET['id'])) {
                        $nosotrosController->updateNosotros($_GET['id']);
                    } else {
                        echo json_encode(['message' => 'ID requerido para actualizar']);
                    }
                    break;
                case 'DELETE':
                    if (isset($_GET['id'])) {
                        $nosotrosController->deleteNosotros($_GET['id']);
                    } else {
                        echo json_encode(['message' => 'ID requerido para eliminar']);
                    }
                    break;
                default:
                    echo json_encode(['message' => 'Método no permitido']);
            }
            break;
}
?>