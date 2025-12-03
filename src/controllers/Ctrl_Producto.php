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
        $datos = $this->modelo->listar();
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

    public function editar($id) {
        $producto = $this->modelo->obtener($id);
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
