<?php
require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class ProductoController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new ProductoModel($conn);
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
        requireRole(['ADMIN', 'GERENTE']);
        require __DIR__ . '/../views/producto/crear.php';
    }

    public function guardar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /PRODUCTOS");
        }
    }

    // ========================
    // EDITAR — ADMIN, GERENTE
    // ========================
    public function editar($id = null) {

        requireRole(['ADMIN', 'GERENTE']);

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
            echo "<div class='alert alert-danger mt-4'>❌ Producto no encontrado</div>";
            echo "<a href='/PRODUCTOS/EDITAR' class='btn btn-secondary mt-2'>Intentar otro ID</a>";
            return;
        }

        require __DIR__ . '/../views/producto/editar.php';
    }

    // ========================
    // ACTUALIZAR — ADMIN, GERENTE
    // ========================
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->actualizar($_POST);
        }
        header("Location: /PRODUCTOS");
    }

    // ========================
    // ELIMINAR — SOLO ADMIN
    // ========================
    public function eliminar($id = null) {
        requireRole(['ADMIN']);

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
            echo "<div class='alert alert-danger'>❌ Producto no encontrado</div>";
            echo "<a href='/PRODUCTOS/ELIMINAR' class='btn btn-secondary'>Intentar otro</a>";
            return;
        }

        $this->modelo->eliminar($id);
        header("Location: /PRODUCTOS");
    }
}
