<?php
require_once __DIR__ . '/../models/ProductoModel.php';

class ProductoController {

    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new ProductoModel($conn);
    }

    // ================================
    // VALIDAR PERMISOS
    // ================================
    private function requireRole($rolesPermitidos = []) {
        $rol = $_SESSION['rol'] ?? null;

        if (!$rol || !in_array($rol, $rolesPermitidos)) {
            $message = "❌ No tienes permisos para acceder a esta sección.";
            $button = ['url' => '/', 'text' => 'Volver al inicio'];
            require __DIR__ . '/../views/errors/generic.php';
            exit;
        }
    }

    // ========================
    // PANTALLA PRINCIPAL
    // ========================
    public function index() {
        $ruta = "PRODUCTOS";
        $titulo = "Productos";
        require __DIR__ . '/../views/producto/index.php';
    }

    // ========================
    // LISTAR — TODOS PUEDEN
    // ========================
    public function listar() {
        $productos = $this->modelo->listar();
        require __DIR__ . '/../views/producto/listar.php';
    }

    // ========================
    // CREAR — ADMIN, GERENTE
    // ========================
    public function crear() {
        $this->requireRole(['ADMIN', 'GERENTE']);
        require __DIR__ . '/../views/producto/crear.php';
    }

    public function guardar() {
        $this->requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /PRODUCTOS");
        }
    }

    // ========================
    // EDITAR — ADMIN, GERENTE
    // ========================
    public function editar($id = null) {

        $this->requireRole(['ADMIN', 'GERENTE']);

        // Si viene del formulario POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        // Sin ID → pedir ID
        if (!$id) {
            require __DIR__ . '/../views/producto/seleccionar_editar.php';
            return;
        }

        // Buscar producto
        $producto = $this->modelo->obtener($id);

        if (!$producto) {
            $message = "❌ Producto no encontrado";
            $button = ['url' => '/PRODUCTOS/EDITAR', 'text' => 'Intentar otro ID'];
            require __DIR__ . '/../views/errors/generic.php';
            return;
        }

        require __DIR__ . '/../views/producto/editar.php';
    }

    // ========================
    // ACTUALIZAR — ADMIN, GERENTE
    // ========================
    public function actualizar() {
        $this->requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->actualizar($_POST);
        }
        header("Location: /PRODUCTOS");
    }

    // ========================
    // ELIMINAR — SOLO ADMIN
    // ========================
    public function eliminar($id = null) {
        $this->requireRole(['ADMIN']);

        // Si viene por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/producto/seleccionar_eliminar.php';
            return;
        }

        $producto = $this->modelo->obtener($id);

        if (!$producto) {
            $message = "❌ Producto no encontrado";
            $button = ['url' => '/PRODUCTOS/ELIMINAR', 'text' => 'Intentar otro'];
            require __DIR__ . '/../views/errors/generic.php';
            return;
        }

        $this->modelo->eliminar($id);
        header("Location: /PRODUCTOS");
    }
}
