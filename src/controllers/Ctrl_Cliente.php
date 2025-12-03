<?php
require_once '../models/ClienteModel.php';

class ClienteController {
    private $modelo;

    public function __construct($conn) {
        $this->modelo = new ClienteModel($conn);
    }

    public function index() {
        $clientes = $this->modelo->listar();
        require '../views/cliente/index.php';
    }

    public function crear() {
        require '../views/cliente/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /CLIENTE");
        }
    }

    public function editar($id) {
        $cliente = $this->modelo->obtener($id);
        require '../views/cliente/editar.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST);
        header("Location: /CLIENTE");
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header("Location: /CLIENTE");
    }
}
