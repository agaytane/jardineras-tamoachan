<?php
require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class ProductoController {

    private ProductoModel $modelo;

    public function __construct($conn) {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new ProductoModel($conn);
    }

    // =============================
    // INDEX → LISTAR
    // =============================
    public function index() {
        $ruta = "PRODUCTOS";
        $titulo = "Productos";
        require __DIR__ . '/../views/producto/index.php';
    }

    // =============================
    // LISTAR
    // =============================
    public function listar() {
        $productos = $this->modelo->listar();
        require __DIR__ . '/../views/producto/listar.php';
    }

    // =============================
    // CREAR
    // =============================
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);

        // Mostrar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $gamas = $this->modelo->obtenerGamas();
            require __DIR__ . '/../views/producto/crear.php';
            return;
        }

        // Validaciones
        if (
            empty($_POST['nombre']) ||
            !isset($_POST['precio_venta']) ||
            !isset($_POST['stock']) ||
            $_POST['precio_venta'] < 0 ||
            $_POST['stock'] < 0
        ) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            header("Location: /PRODUCTOS/CREAR");
            exit;
        }

        $data = [
            'nombre'        => trim($_POST['nombre']),
            'descripcion'   => trim($_POST['descripcion'] ?? ''),
            'precio_venta'  => (float) $_POST['precio_venta'],
            'stock'         => (int) $_POST['stock'],
            'fk_id_gama'    => !empty($_POST['fk_id_gama']) ? (int) $_POST['fk_id_gama'] : null
        ];

        try {
            $this->modelo->insertar($data);
            $_SESSION['exito'] = "✅ Producto creado correctamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al crear producto.";
        }

        header("Location: /PRODUCTOS");
        exit;
    }

    // =============================
    // EDITAR
    // =============================
    public function editar($id = null) {
    requireRole(['ADMIN', 'GERENTE']);

    // 1️⃣ Si viene por POST (desde seleccionar_editar)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    // 2️⃣ Si NO hay ID → mostrar selector
    if (!$id) {
        $productos = $this->modelo->listar();
        require __DIR__ . '/../views/producto/seleccionar_editar.php';
        return;
    }

    // 3️⃣ Obtener producto
    $producto = $this->modelo->obtener($id);

    if (!$producto) {
        $_SESSION['error'] = "❌ Producto no encontrado.";
        header("Location: /PRODUCTOS");
        exit;
    }

    // 4️⃣ Obtener gamas para el select
    $gamas = $this->modelo->obtenerGamas();

    // 5️⃣ Mostrar formulario de edición
    require __DIR__ . '/../views/producto/editar.php';
}


    // =============================
    // ACTUALIZAR
    // =============================
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
            $_SESSION['error'] = "❌ Datos inválidos.";
            header("Location: /PRODUCTOS");
            exit;
        }

        $data = [
            'id_producto'   => (int) $_POST['id_producto'],
            'nombre'        => trim($_POST['nombre']),
            'descripcion'   => trim($_POST['descripcion'] ?? ''),
            'precio_venta'  => (float) $_POST['precio_venta'],
            'stock'         => (int) $_POST['stock']
        ];

        try {
            $this->modelo->actualizar($data);
            $_SESSION['exito'] = "✅ Producto actualizado.";
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar.";
        }

        header("Location: /PRODUCTOS");
        exit;
    }

    // =============================
    // ELIMINAR
    // =============================
public function eliminar($id = null) {
    requireRole(['ADMIN']);

    // Si viene por POST (desde el formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    // Si no hay ID, mostrar selección
    if (!$id) {
        $productos = $this->modelo->listar();
        require __DIR__ . '/../views/producto/seleccionar_eliminar.php';
        return;
    }

    // Verificar que existe
    $producto = $this->modelo->obtener($id);
    if (!$producto) {
        $_SESSION['error'] = "❌ Producto no encontrado.";
        header("Location: /PRODUCTOS");
        exit;
    }

    // Eliminar
    try {
        $this->modelo->eliminar($id);
        $_SESSION['exito'] = "✅ Producto eliminado correctamente.";
    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al eliminar: " . $e->getMessage();
    }

    header("Location: /PRODUCTOS");
    exit;
}

}
