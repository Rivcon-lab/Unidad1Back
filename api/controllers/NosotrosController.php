<?php
require_once dirname(__DIR__) . '/models/Nosotros.php';

class NosotrosController {
    private $Nosotros;

    public function __construct($db) {
        $this->Nosotros = new Nosotros($db);
    }

    // Devuelve toda la información de about_us en el idioma solicitado
    public function getNosotros() {
        $lenguaje = isset($_GET['lenguaje']) && in_array($_GET['lenguaje'], ['esp', 'eng']) ? $_GET['lenguaje'] : 'esp';
        $stmt = $this->Nosotros->readAll();
        $NosotrosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($NosotrosData as $item) {
            $result[] = [
                "id" => $item["id"],
                "titulo" => $item["titulo_" . $lenguaje],
                "descripcion" => $item["descripcion_" . $lenguaje]
            ];
        }
        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
    }

    // Crea un nuevo registro about_us
    public function createNosotros() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->Nosotros->create($data)) {
            echo json_encode(['message' => 'Registro creado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al crear el registro']);
        }
    }

    // Actualiza un registro about_us existente
    public function updateNosotros($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->Nosotros->update($id, $data)) {
            echo json_encode(['message' => 'Registro actualizado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al actualizar el registro']);
        }
    }

    // Elimina un registro about_us por su ID
    public function deleteNosotros($id) {
        if ($this->Nosotros->delete($id)) {
            echo json_encode(['message' => 'Registro eliminado correctamente']);
        } else {
            echo json_encode(['message' => 'Error al eliminar el registro']);
        }
    }
}
?>