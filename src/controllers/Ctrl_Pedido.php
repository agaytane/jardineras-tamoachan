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

    public function editar($id = null) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    if (!$id) {
        require __DIR__ . '/../views/pedido/seleccionar_editar.php';
        return;
    }

    $pedido = $this->modelo->obtener($id);

    if (!$pedido) {
        echo "<div class='alert alert-danger'>Pedido no encontrado</div>";
        echo "<a href='/PEDIDO/EDITAR' class='btn btn-secondary'>Intentar otro</a>";
        return;
    }

    require __DIR__ . '/../views/pedido/editar.php';
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
