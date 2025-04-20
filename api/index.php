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

// Obtención de la ruta solicitada para el enrutamiento interno
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'];

// Inclusión de dependencias principales
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/controllers/ServiciosController.php';
require_once BASE_PATH . '/controllers/NosotrosController.php';
require_once BASE_PATH . '/models/Contacto.php'; // Asegúrate de tener este modelo

// Inicialización de la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Autenticación Bearer para proteger la API (excepto contacto)
if ($route !== 'contacto') {
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer backcrispity') {
        http_response_code(401);
        echo json_encode(['message' => 'No autorizado']);
        exit;
    }
}

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
                http_response_code(405);
                echo json_encode(['message' => 'Método no permitido']);
        }
        break;

    case 'nosotros':
        $nosotrosController = new NosotrosController($db);
        switch ($method) {
            case 'GET':
                $nosotrosController->getNosotros();
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
                http_response_code(405);
                echo json_encode(['message' => 'Método no permitido']);
        }
        break;

    case 'contacto':
        // Solo permite POST para contacto
        if ($method === 'POST') {
            // Recibe datos en formato x-www-form-urlencoded o JSON
            $input = $_POST;
            if (empty($input)) {
                $input = json_decode(file_get_contents("php://input"), true);
            }
            $nombre = $input['name'] ?? '';
            $email = $input['email'] ?? '';
            $servicio = $input['service'] ?? '';
            $mensaje = $input['message'] ?? '';

            if (empty($nombre) || empty($email) || empty($servicio) || empty($mensaje)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
                exit;
            }

            $contactoModel = new Contacto($db);
            $result = $contactoModel->crearContacto($nombre, $email, $servicio, $mensaje);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Formulario enviado correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar los datos.']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Método no permitido']);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint no encontrado']);
        break;
}
?>