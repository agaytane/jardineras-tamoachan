<?php

require_once __DIR__ . '/../models/EmpleadoModel.php';

class EmpleadoController {
    private $modelo;
    public function __construct($conn) {
        $this->modelo = new EmpleadoModel($conn);
    }
    public function index() {
        $ruta = "EMPLEADOS";
        $titulo = "Empleados";
        require __DIR__ . '/../views/empleado/index.php';
    }
    
    public function listar() {
        $empleados = $this->modelo->listar();
        require __DIR__ . '/../views/empleado/listar.php';
    }


    public function crear() {
        require __DIR__ . '/../views/empleado/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /EMPLEADOS");
        }
    }

    public function editar($id = null) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    if (!$id) {
        require __DIR__ . '/../views/empleado/seleccionar_editar.php';
        return;
    }

    $empleado = $this->modelo->obtener($id);

    if (!$empleado) {
        echo "<div class='alert alert-danger'>Empleado no encontrado</div>";
        echo "<a href='/EMPLEADOS/EDITAR' class='btn btn-secondary'>Intentar otro</a>";
        return;
    }

    require __DIR__ . '/../views/empleado/editar.php';
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
