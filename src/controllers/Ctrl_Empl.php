<?php
require_once '../models/EmpleadoModel.php';

class EmpleadoController {
    private $modelo;

    public function __construct($conn) {
        $this->modelo = new EmpleadoModel($conn);
    }

    public function index() {
    $ruta = "EMPLEADOS";
    $titulo = "Empleados";
    require __DIR__ . '/../views/empleados/index.php';
}


    public function crear() {
        require '../views/empleados/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /EMPLEADOS");
        }
    }

    public function editar($id) {
        $empleado = $this->modelo->obtener($id);
        require '../views/empleados/editar.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST);
        header("Location: /EMPLEADOS");
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header("Location: /EMPLEADOS");
    }
}
