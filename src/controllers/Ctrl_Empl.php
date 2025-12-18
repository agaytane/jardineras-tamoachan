<?php
require_once __DIR__ . '/../models/EmpleadoModel.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/error_helper.php';

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
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Nombre, apellido, email y puesto son requeridos.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Empleado&ruta=EMPLEADOS");
            exit;
        }

        $puesto = strtoupper(trim($_POST['Puesto']));

        $salarioRaw = $_POST['Salario'] ?? '';
        $salarioInput = str_replace(',', '.', $salarioRaw);
        if ($salarioInput === '' || !is_numeric($salarioInput) || (float) $salarioInput <= 0) {
            $_SESSION['error'] = "❌ Salario inválido.";
            $_SESSION['detalle'] = "El salario debe ser numérico y mayor a 0.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Empleado&ruta=EMPLEADOS");
            exit;
        }

        // Trigger TR_VALIDAR_SALARIO exige >= 1000 para puestos distintos a practicante/becario
        if (!in_array($puesto, ['PRACTICANTE', 'BECARIO'], true) && (float) $salarioInput < 1000) {
            $_SESSION['error'] = "❌ Salario inválido.";
            $_SESSION['detalle'] = "Mínimo 1000 para puestos distintos a practicante/becario.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Empleado&ruta=EMPLEADOS");
            exit;
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


        try {
            $this->modelo->insertar($data);
            $_SESSION['exito'] = "✅ Empleado creado correctamente.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Empleado&ruta=EMPLEADOS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al crear empleado.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Empleado&ruta=EMPLEADOS");
        }
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
        $_SESSION['error'] = "❌ Empleado no encontrado.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Empleado&ruta=EMPLEADOS");
        exit;
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
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Falta el identificador de empleado.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Empleado&ruta=EMPLEADOS");
            exit;
        }

                $salarioRaw = $_POST['Salario'] ?? '';
                $salarioInput = str_replace(',', '.', $salarioRaw);
                if ($salarioInput === '' || !is_numeric($salarioInput) || (float) $salarioInput <= 0) {
                    $_SESSION['error'] = "❌ Salario inválido.";
                    $_SESSION['detalle'] = "El salario debe ser numérico y mayor a 0.";
                    header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Empleado&ruta=EMPLEADOS");
                    exit;
                }

                $puesto = strtoupper(trim($_POST['Puesto']));
                if (!in_array($puesto, ['PRACTICANTE', 'BECARIO'], true) && (float) $salarioInput < 1000) {
                    $_SESSION['error'] = "❌ Salario inválido.";
                    $_SESSION['detalle'] = "Mínimo 1000 para puestos distintos a practicante/becario.";
                    header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Empleado&ruta=EMPLEADOS");
                    exit;
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


        try {
            $this->modelo->actualizar($data);
            $_SESSION['exito'] = "✅ Empleado actualizado.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Empleado&ruta=EMPLEADOS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar empleado.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Empleado&ruta=EMPLEADOS");
        }
        exit;
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
        $_SESSION['error'] = "❌ Empleado no encontrado.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Empleado&ruta=EMPLEADOS");
        exit;
    }

    try {
        $this->modelo->eliminar($id);
        $_SESSION['exito'] = "✅ Empleado eliminado.";
        header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Empleado&ruta=EMPLEADOS");
    } catch (Exception $e) {
        [$msg, $det] = map_pdo_error($e, 'Empleado', 'eliminar');
        $_SESSION['error'] = $msg;
        $count = $this->modelo->contarPedidosAsociados($id);
        $_SESSION['detalle'] = "Tiene $count pedidos asociados. Primero reasigne o atienda esos pedidos.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Empleado&ruta=EMPLEADOS");
    }
    exit;
}

}
