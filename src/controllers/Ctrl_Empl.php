<?php
require_once __DIR__ . '/../models/EmpleadoModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class EmpleadoController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new EmpleadoModel($conn);
    }

    /* =========================
       INDEX
    ========================== */
    public function index() {
        $ruta = "EMPLEADOS";
        $titulo = "Empleados";
        require __DIR__ . '/../views/empleado/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $empleados = $this->modelo->listar();
        require __DIR__ . '/../views/empleado/listar.php';
    }

    /* =========================
       CREAR
    ========================== */
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require __DIR__ . '/../views/empleado/crear.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /EMPLEADOS");
            exit;
        }

        if (
            empty($_POST['Nombre_emp']) ||
            empty($_POST['Apellido_emp']) ||
            empty($_POST['Email_emp']) ||
            empty($_POST['Puesto'])
        ) {
            die("❌ Datos inválidos");
        }

        $data = [
            'Nombre_emp'    => trim($_POST['Nombre_emp']),
            'Apellido_emp'  => trim($_POST['Apellido_emp']),
            'Email_emp'     => trim($_POST['Email_emp']),
            'Telefono_emp'  => trim($_POST['Telefono_emp'] ?? ''),
            'Puesto'        => trim($_POST['Puesto']),
            'Salario'       => (float) $_POST['Salario'],
            'Nombre_jefe'   => trim($_POST['Nombre_jefe'] ?? ''),
            'Fk_id_oficina' => (int) $_POST['Fk_id_oficina']
        ];

        $this->modelo->insertar($data);

        header("Location: /EMPLEADOS");
        exit;
    }

    /* =========================
       EDITAR
    ========================== */
    public function editar($id = null) {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/empleado/seleccionar_editar.php';
            return;
        }

        $empleado = $this->modelo->obtener($id);

        if (!$empleado) {
            die("❌ Empleado no encontrado");
        }

        require __DIR__ . '/../views/empleado/editar.php';
    }

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /EMPLEADOS");
            exit;
        }

        if (empty($_POST['Id_empleado'])) {
            die("❌ Datos inválidos");
        }

        $data = [
            'Id_empleado'   => (int) $_POST['Id_empleado'],
            'Nombre_emp'    => trim($_POST['Nombre_emp']),
            'Apellido_emp'  => trim($_POST['Apellido_emp']),
            'Email_emp'     => trim($_POST['Email_emp']),
            'Telefono_emp'  => trim($_POST['Telefono_emp']),
            'Puesto'        => trim($_POST['Puesto']),
            'Salario'       => (float) $_POST['Salario'],
            'Nombre_jefe'   => trim($_POST['Nombre_jefe']),
            'Fk_id_oficina' => (int) $_POST['Fk_id_oficina']
        ];

        $this->modelo->actualizar($data);

        header("Location: /EMPLEADOS");
        exit;
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id = null) {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/empleado/seleccionar_eliminar.php';
            return;
        }

        if (!$this->modelo->obtener($id)) {
            die("❌ Empleado no encontrado");
        }

        $this->modelo->eliminar($id);

        header("Location: /EMPLEADOS");
        exit;
    }
}
