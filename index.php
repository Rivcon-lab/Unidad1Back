<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

// Incluir dependencias
require_once 'config/database.php';
require_once 'controllers/ServiciosController.php';


// Instanciar base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar controlador
$servicioController = new ServiciosController($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $servicioController->getServicio($_GET['id']);
        } else {
            $servicioController->getServicios();
        }
        break;
    case 'POST':
        $servicioController->createServicio();
        break;
    case 'PUT':
        $servicioController->updateServicio($_GET['id']);
        break;
    case 'DELETE':
        $servicioController->deleteServicio($_GET['id']);
        break;
    default:
        echo json_encode(['message' => 'Método no permitido']);
        break;
}

?>