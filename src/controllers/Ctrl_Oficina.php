<?php
require_once '../models/OficinaModel.php';

class OficinaController {
    private $modelo;

    public function __construct($conn) {
        $this->modelo = new OficinaModel($conn);
    }

    public function index() {
        $ruta = "OFICINA";
        $titulo = "Oficinas";
        require __DIR__ . '/../views/oficina/index.php';
    }


    public function crear() {
        require '../views/oficina/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /OFICINA");
        }
    }

    public function editar($id) {
        $oficina = $this->modelo->obtener($id);
        require '../views/oficina/editar.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST);
        header("Location: /OFICINA");
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header("Location: /OFICINA");
    }
}
