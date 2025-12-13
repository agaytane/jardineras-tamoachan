<?php
require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class ProductoController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new ProductoModel($conn);
    }

    public function index() {
        $ruta = "PRODUCTOS";
        $titulo = "Productos";
        require __DIR__ . '/../views/producto/index.php';
    }
    public function listar() {
        $productos = $this->modelo->listar();
        require __DIR__ . '/../views/producto/listar.php';
    }
    public function crear() {
    requireRole(['ADMIN', 'GERENTE']);

    // 1️⃣ MOSTRAR FORMULARIO
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        require __DIR__ . '/../views/producto/crear.php';
        return;
    }

    // 2️⃣ PROCESAR FORMULARIO (POST)
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /PRODUCTOS");
        exit;
    }

    // 3️⃣ VALIDACIONES
    if (
        empty($_POST['nombre']) ||
        !isset($_POST['precio_venta']) ||
        !isset($_POST['stock']) ||
        $_POST['precio_venta'] < 0 ||
        $_POST['stock'] < 0
    ) {
        die("❌ Datos inválidos");
    }

    // 4️⃣ LIMPIAR DATOS
    $data = [
        'nombre'        => trim($_POST['nombre']),
        'descripcion'   => trim($_POST['descripcion'] ?? ''),
        'precio_venta'  => (float) $_POST['precio_venta'],
        'stock'         => (int) $_POST['stock'],
        'fk_id_gama'    => !empty($_POST['fk_id_gama']) ? (int) $_POST['fk_id_gama'] : null
    ];
    // 5️⃣ INSERTAR
    $this->modelo->insertar($data);
    // 6️⃣ REDIRECCIÓN
    header("Location: /PRODUCTOS");
    exit;
}
    public function editar($id = null) {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/producto/seleccionar_editar.php';
            return;
        }

        $producto = $this->modelo->obtener($id);

        if (!$producto) {
            die("❌ Producto no encontrado");
        }

        require __DIR__ . '/../views/producto/editar.php';
    }

    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /PRODUCTOS");
            exit;
        }

        if (
            empty($_POST['id_producto']) ||
            $_POST['precio_venta'] < 0 ||
            $_POST['stock'] < 0
        ) {
            die("❌ Datos inválidos");
        }

        $data = [
            'id_producto'   => (int) $_POST['id_producto'],
            'nombre'        => trim($_POST['nombre']),
            'descripcion'   => trim($_POST['descripcion'] ?? ''),
            'precio_venta'  => (float) $_POST['precio_venta'],
            'stock'         => (int) $_POST['stock'],
            'fk_id_gama'    => !empty($_POST['fk_id_gama']) ? (int) $_POST['fk_id_gama'] : null
        ];

        $this->modelo->actualizar($data);

        header("Location: /PRODUCTOS");
        exit;
    }

    public function eliminar($id = null) {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/producto/seleccionar_eliminar.php';
            return;
        }

        if (!$this->modelo->obtener($id)) {
            die("❌ Producto no encontrado");
        }

        $this->modelo->eliminar($id);

        header("Location: /PRODUCTOS");
        exit;
    }
}
