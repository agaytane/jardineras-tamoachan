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

    public function editar($id) {
        $gama = $this->modelo->obtener($id);
        require '../views/gama/editar.php';
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
