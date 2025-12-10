<?php
namespace App\Controllers;

use App\Models\EmpleadoModel;

class EmpleadoController {
    private $modelo;
    public function __construct(\PDO $conn) {
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
        $message = "Empleado no encontrado";
        $button = ['url' => '/EMPLEADOS/EDITAR', 'text' => 'Intentar otro'];
        require __DIR__ . '/../views/errors/generic.php';
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
