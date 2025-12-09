<?php
require_once __DIR__ . '/../models/ProductoModel.php';
class ProductoController {
    private $modelo;

    public function __construct($conn) {
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
        require __DIR__ . '/../views/producto/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /PRODUCTOS");
        }
    }

    public function editar($id = null) {
    // Si viene por formulario (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }
    if (!$id) {
        // Si no hay ID, mostrar formulario para pedirlo
        require __DIR__ . '/../views/producto/seleccionar_editar.php';
        return;
    }
    //  Ya hay ID → buscamos el producto
    $producto = $this->modelo->obtener($id);
    if (!$producto) {
        echo "<div class='alert alert-danger mt-4'>❌ Producto no encontrado</div>";
        echo "<a href='/PRODUCTOS/EDITAR' class='btn btn-secondary mt-2'>Intentar otro ID</a>";
        return;
    }
    // Abrimos el formulario real de edición
    require __DIR__ . '/../views/producto/editar.php';
}
    public function actualizar() {
        $this->modelo->actualizar($_POST);
        header("Location: /PRODUCTOS");
    }
    
    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header("Location: /PRODUCTOS");
    }
}
