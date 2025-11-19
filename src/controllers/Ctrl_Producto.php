<?php
require_once __DIR__ . '/../model/modelo.php';

class ProductoController {

    private $model;

    public function __construct($conn) {
        $this->model = new ProductModel($conn);
    }

    /* ==========================================================
       LISTAR PRODUCTOS
       ========================================================== */
    public function index() {
        $productos = $this->model->listar();
        require __DIR__ . '/../views/Productos/listar.php';
    }

    /* ==========================================================
       FORMULARIO CREAR
       ========================================================== */
    public function crear() {
        require __DIR__ . '/../views/Productos/crear.php';
    }

    /* ==========================================================
       GUARDAR NUEVO PRODUCTO
       ========================================================== */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'Id_producto'   => $_POST['Id_producto'],
                'Nombre'        => $_POST['Nombre'],
                'Descripcion'   => $_POST['Descripcion'],
                'Precio_venta'  => $_POST['Precio_venta'],
                'Stock'         => $_POST['Stock'],
                'Fk_id_gama'    => $_POST['Fk_id_gama']
            ];

            $this->model->insertar($data);
            header("Location: /PRODUCTOS");
            exit;
        }
    }

    /* ==========================================================
       FORMULARIO EDITAR
       ========================================================== */
    public function editar($id) {
        $producto = $this->model->obtener($id);

        if (!$producto) {
            echo "<h2>Producto no encontrado</h2>";
            return;
        }

        require __DIR__ . '/../views/Productos/editar.php';
    }

    /* ==========================================================
       ACTUALIZAR PRODUCTO
       ========================================================== */
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'Id_producto'   => $_POST['Id_producto'],
                'Nombre'        => $_POST['Nombre'],
                'Descripcion'   => $_POST['Descripcion'],
                'Precio_venta'  => $_POST['Precio_venta'],
                'Stock'         => $_POST['Stock'],
                'Fk_id_gama'    => $_POST['Fk_id_gama']
            ];

            $this->model->actualizar($data);
            header("Location: /PRODUCTOS");
            exit;
        }
    }

    /* ==========================================================
       ELIMINAR PRODUCTO
       ========================================================== */
    public function eliminar($id) {
        $this->model->eliminar($id);
        header("Location: /PRODUCTOS");
        exit;
    }
}
