<?php
require_once dirname(__DIR__) . '/models/Servicios.php';

class ServiciosController {
    private $servicio;

    public function __construct($db) {
        $this->servicio = new Servicio($db);
    }

    // Devuelve todos los Servicios en el idioma solicitado
    public function getServicios() {
        $lenguaje = isset($_GET['lenguaje']) && in_array($_GET['lenguaje'], ['esp', 'eng']) ? $_GET['lenguaje'] : 'esp';
        $stmt = $this->servicio->readAll();
        $Servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($Servicios as $servicio) {
            $result[] = [
                "id" => $servicio["id"],
                "titulo" => $servicio["titulo_" . $lenguaje],
                "descripcion" => $servicio["descripcion_" . $lenguaje]
            ];
        }
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
    }

    // Crea un nuevo servicio
    public function createServicio() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->servicio->create($data)) {
            echo json_encode(['message' => 'Servicio creado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al crear el servicio']);
        }
    }

    // Actualiza un servicio existente
    public function updateServicio($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->servicio->update($id, $data)) {
            echo json_encode(['message' => 'Servicio actualizado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al actualizar el servicio']);
        }
    }

    // Elimina un servicio por su ID
    public function deleteServicio($id) {
        if ($this->servicio->delete($id)) {
            echo json_encode(['message' => 'Servicio eliminado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al eliminar el servicio']);
        }
    }
}
?>