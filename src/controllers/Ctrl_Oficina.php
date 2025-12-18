<?php
require_once __DIR__ . '/../models/OficinaModel.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/error_helper.php';

class OficinaController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new OficinaModel($conn);
    }

    /* =========================
       INDEX
    ========================== */
    public function index() {
        $ruta = "OFICINAS";
        $titulo = "Oficinas";
        require __DIR__ . '/../views/oficina/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $oficinas = $this->modelo->listar();
        require __DIR__ . '/../views/oficina/listar.php';
    }

    /* =========================
       CREAR
    ========================== */
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require __DIR__ . '/../views/oficina/crear.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /OFICINAS");
            exit;
        }

        if (empty($_POST['Direccion']) || empty($_POST['Ciudad'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Dirección y ciudad son requeridas.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Oficina&ruta=OFICINAS");
            exit;
        }

        $data = [
            'direccion'      => trim($_POST['Direccion']),
            'telefono'       => trim($_POST['Telefono'] ?? ''),
            'ciudad'         => trim($_POST['Ciudad']),
            'provincia'      => trim($_POST['Provincia']),
            'codigo_postal'  => trim($_POST['Codigo_postal'])
        ];

        try {
            $this->modelo->insertar($data);
            $_SESSION['exito'] = "✅ Oficina creada correctamente.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Oficina&ruta=OFICINAS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al crear oficina.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Oficina&ruta=OFICINAS");
        }
        exit;
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
        $oficinas = $this->modelo->listar();
        require __DIR__ . '/../views/oficina/seleccionar_editar.php';
        return;
    }

    $oficina = $this->modelo->obtener($id);

    if (!$oficina) {
        $_SESSION['error'] = "❌ Oficina no encontrada.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Oficina&ruta=OFICINAS");
        exit;
    }

    require __DIR__ . '/../views/oficina/editar.php';
}


    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /OFICINAS");
            exit;
        }

        if (empty($_POST['Id_oficina'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Falta el identificador de oficina.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Oficina&ruta=OFICINAS");
            exit;
        }

        $data = [
            'id_oficina'     => (int) $_POST['Id_oficina'],
            'direccion'      => trim($_POST['Direccion']),
            'telefono'       => trim($_POST['Telefono']),
            'ciudad'         => trim($_POST['Ciudad']),
            'provincia'      => trim($_POST['Provincia']),
            'codigo_postal'  => trim($_POST['Codigo_postal'])
        ];

        try {
            $this->modelo->actualizar($data);
            $_SESSION['exito'] = "✅ Oficina actualizada.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Oficina&ruta=OFICINAS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar oficina.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Oficina&ruta=OFICINAS");
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
        $oficinas = $this->modelo->listar();
        require __DIR__ . '/../views/oficina/seleccionar_eliminar.php';
        return;
    }

    if (!$this->modelo->obtener($id)) {
        $_SESSION['error'] = "❌ Oficina no encontrada.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Oficina&ruta=OFICINAS");
        exit;
    }

    try {
        $this->modelo->eliminar($id);
        $_SESSION['exito'] = "✅ Oficina eliminada.";
        header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Oficina&ruta=OFICINAS");
    } catch (Exception $e) {
        [$msg, $det] = map_pdo_error($e, 'Oficina', 'eliminar');
        $_SESSION['error'] = $msg;
        $count = $this->modelo->contarEmpleadosAsociados($id);
        $_SESSION['detalle'] = "Está asociada a $count empleados. Reubique o elimine los empleados antes.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Oficina&ruta=OFICINAS");
    }
    exit;
}

}
