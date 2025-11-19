<?php
require_once __DIR__ . '/../model/modelo.php';

class DpedidosController {

    private $model;

    public function __construct($conn) {
        $this->model = new VistaPedidos($conn);
    }

    public function index() {
        $detalles = $this->model->obtenerDetalles();
        require __DIR__ . '/../views/detalles_pedido.php';
    }
}
