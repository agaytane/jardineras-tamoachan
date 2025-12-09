<?php
require_once '../models/GamaModel.php';

class GamaController {
    private $modelo;

    public function __construct($conn) {
        $this->modelo = new GamaModel($conn);
    }

    public function index() {
        $gamas = $this->modelo->listar();
        require '../views/gama/index.php';
    }

    public function crear() {
        require '../views/gama/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /GAMA");
        }
    }

    public function editar($id = null) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    if (!$id) {
        require __DIR__ . '/../views/gama/seleccionar_editar.php';
        return;
    }

    $gama = $this->modelo->obtener($id);

    if (!$gama) {
        echo "<div class='alert alert-danger'>Gama no encontrada</div>";
        echo "<a href='/GAMA/EDITAR' class='btn btn-secondary'>Intentar otro</a>";
        return;
    }

    require __DIR__ . '/../views/gama/editar.php';
}


    public function actualizar() {
        $this->modelo->actualizar($_POST);
        header("Location: /GAMA");
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header("Location: /GAMA");
    }
}
