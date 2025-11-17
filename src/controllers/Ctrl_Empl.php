<?php
require_once __DIR__ . '/../model/modelo.php';

class EmpleadoController {

    private $model;

    public function __construct($conn) {
        $this->model = new Empleado($conn);
    }

    public function index() {
        $empleados = $this->model->obtenerTodos();
        require __DIR__ . '/../views/empleado.php';
    }
}
