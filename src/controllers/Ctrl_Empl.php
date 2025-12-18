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
            $oficinas = $this->modelo->obtenerOficinas();
            $puestos = ['GERENTE', 'VENTAS', 'ADMIN', 'PRACTICANTE', 'BECARIO'];
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

        $puesto = strtoupper(trim($_POST['Puesto']));

        $salarioRaw = $_POST['Salario'] ?? '';
        $salarioInput = str_replace(',', '.', $salarioRaw);
        if ($salarioInput === '' || !is_numeric($salarioInput) || (float) $salarioInput <= 0) {
            die("❌ Salario inválido");
        }

        // Trigger TR_VALIDAR_SALARIO exige >= 1000 para puestos distintos a practicante/becario
        if (!in_array($puesto, ['PRACTICANTE', 'BECARIO'], true) && (float) $salarioInput < 1000) {
            die("❌ Salario inválido (mínimo 1000 para este puesto)");
        }

        $salario = number_format((float) $salarioInput, 2, '.', '');

        $data = [
         'nombre_emp'    => trim($_POST['Nombre_emp']),
         'apellido_emp'  => trim($_POST['Apellido_emp']),
         'email_emp'     => trim($_POST['Email_emp']),
         'telefono_emp'  => trim($_POST['Telefono_emp'] ?? ''),
         'puesto'        => $puesto,
         'salario'       => $salario,
         'nombre_jefe'   => trim($_POST['Nombre_jefe'] ?? ''),
         'fk_id_oficina' => (int) $_POST['Fk_id_oficina']
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
        $empleados = $this->modelo->listar();
        require __DIR__ . '/../views/empleado/seleccionar_editar.php';
        return;
    }

    $empleado = $this->modelo->obtener($id);

    if (!$empleado) {
        die("❌ Empleado no encontrado");
    }

    $oficinas = $this->modelo->obtenerOficinas();
    $puestos = ['GERENTE', 'VENTAS', 'ADMIN', 'PRACTICANTE', 'BECARIO'];

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

                $salarioRaw = $_POST['Salario'] ?? '';
                $salarioInput = str_replace(',', '.', $salarioRaw);
                if ($salarioInput === '' || !is_numeric($salarioInput) || (float) $salarioInput <= 0) {
                        die("❌ Salario inválido");
                }

                $puesto = strtoupper(trim($_POST['Puesto']));
                if (!in_array($puesto, ['PRACTICANTE', 'BECARIO'], true) && (float) $salarioInput < 1000) {
                        die("❌ Salario inválido (mínimo 1000 para este puesto)");
                }

                $salario = number_format((float) $salarioInput, 2, '.', '');

                 $data = [
                 'id_empleado'   => (int) $_POST['Id_empleado'],
                    'email_emp'     => trim($_POST['Email_emp']),
                    'telefono_emp'  => trim($_POST['Telefono_emp']),
                    'puesto'        => $puesto,
                                        'salario'       => $salario,
                    'nombre_jefe'   => trim($_POST['Nombre_jefe']),
                    'fk_id_oficina' => (int) $_POST['Fk_id_oficina']
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
        $empleados = $this->modelo->listar();
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
