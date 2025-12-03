<?php
require_once '../models/PedidoModel.php';

class PedidoController {
    private $modelo;

    public function __construct($conn) {
        $this->modelo = new PedidoModel($conn);
    }

    public function index() {
        $pedidos = $this->modelo->listar();
        require '../views/pedido/index.php';
    }

    public function crear() {
        require '../views/pedido/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /PEDIDO");
        }
    }

    public function editar($id) {
        $pedido = $this->modelo->obtener($id);
        require '../views/pedido/editar.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST);
        header("Location: /PEDIDO");
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header("Location: /PEDIDO");
    }
}
