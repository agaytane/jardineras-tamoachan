<?php
require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/error_helper.php';

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
            $_SESSION['detalle'] = "Nombre, precio y stock son requeridos y válidos.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Producto&ruta=PRODUCTOS");
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
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Producto&ruta=PRODUCTOS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al crear producto.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Producto&ruta=PRODUCTOS");
        }
        exit;
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
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Producto&ruta=PRODUCTOS");
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
            $_SESSION['detalle'] = "ID, precio y stock válidos son requeridos.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Producto&ruta=PRODUCTOS");
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
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Producto&ruta=PRODUCTOS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Producto&ruta=PRODUCTOS");
        }
        exit;
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
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Producto&ruta=PRODUCTOS");
        exit;
    }

    // Eliminar
    try {
        $this->modelo->eliminar($id);
        $_SESSION['exito'] = "✅ Producto eliminado correctamente.";
        header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Producto&ruta=PRODUCTOS");
    } catch (Exception $e) {
        [$msg, $det] = map_pdo_error($e, 'Producto', 'eliminar');
        $_SESSION['error'] = $msg;
        $count = $this->modelo->contarDetallesAsociados($id);
        $_SESSION['detalle'] = "Está asociado a $count detalles de pedidos. Primero elimine o modifique esos detalles.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Producto&ruta=PRODUCTOS");
    }
    exit;
}

}
