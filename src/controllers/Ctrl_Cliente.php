<?php
require_once __DIR__ . '/../models/ClienteModel.php';

class ClienteController {
    private $modelo;

    public function __construct($conn) {
        $this->modelo = new ClienteModel($conn);
    }

    public function index() {
        $ruta = "CLIENTE";
        $titulo = "Clientes";
        require __DIR__ . '/../views/cliente/index.php';
    }
    public function listar() {
        $datos = $this->modelo->listar();
        require __DIR__ . '/../views/cliente/listar.php';
    }

    public function crear() {
        require __DIR__ . '/../views/cliente/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /CLIENTE");
        }
    }

    public function editar($id = null) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    if (!$id) {
        require __DIR__ . '/../views/cliente/seleccionar_editar.php';
        return;
    }

    $cliente = $this->modelo->obtener($id);

    if (!$cliente) {
        echo "<div class='alert alert-danger'>Cliente no encontrado</div>";
        echo "<a href='/CLIENTE/EDITAR' class='btn btn-secondary'>Intentar otro</a>";
        return;
    }

    require __DIR__ . '/../views/cliente/editar.php';
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
