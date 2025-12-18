<?php
require_once __DIR__ . '/../models/GamaModel.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/error_helper.php';

class GamaController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new GamaModel($conn);
    }

    /* =========================
       INDEX
    ========================== */
    public function index() {
        $ruta = "GAMA";
        $titulo = "Gamas";
        require __DIR__ . '/../views/gama/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $gamas = $this->modelo->listar();
        require __DIR__ . '/../views/gama/listar.php';
    }

    /* =========================
       CREAR
    ========================== */
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require __DIR__ . '/../views/gama/crear.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /GAMA");
            exit;
        }

        if (empty($_POST['Nombre_gama'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "El nombre de la gama es requerido.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Gama&ruta=GAMA");
            exit;
        }

        $data = [
            'nombre_gama'      => trim($_POST['Nombre_gama']),
            'descripcion_gama' => trim($_POST['Descripcion_gama'] ?? '')
        ];


        try {
            $this->modelo->insertar($data);
            $_SESSION['exito'] = "✅ Gama creada correctamente.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Gama&ruta=GAMA");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al crear gama.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Gama&ruta=GAMA");
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
        $gamas = $this->modelo->listar();
        require __DIR__ . '/../views/gama/seleccionar_editar.php';
        return;
    }

    $gama = $this->modelo->obtener($id);

    if (!$gama) {
        $_SESSION['error'] = "❌ Gama no encontrada.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Gama&ruta=GAMA");
        exit;
    }

    require __DIR__ . '/../views/gama/editar.php';
}

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /GAMA");
            exit;
        }

        if (empty($_POST['Id_gama'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Falta el identificador de la gama.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Gama&ruta=GAMA");
            exit;
        }

        $data = [
            'id_gama'          => (int) $_POST['Id_gama'],
            'nombre_gama'      => trim($_POST['Nombre_gama']),
            'descripcion_gama' => trim($_POST['Descripcion_gama'])
        ];

        try {
            $this->modelo->actualizar($data);
            $_SESSION['exito'] = "✅ Gama actualizada.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Gama&ruta=GAMA");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar gama.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Gama&ruta=GAMA");
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
        $gamas = $this->modelo->listar();
        require __DIR__ . '/../views/gama/seleccionar_eliminar.php';
        return;
    }

    if (!$this->modelo->obtener($id)) {
        $_SESSION['error'] = "❌ Gama no encontrada.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Gama&ruta=GAMA");
        exit;
    }

    try {
        $this->modelo->eliminar($id);
        $_SESSION['exito'] = "✅ Gama eliminada.";
        header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Gama&ruta=GAMA");
    } catch (Exception $e) {
        [$msg, $det] = map_pdo_error($e, 'Gama', 'eliminar');
        $_SESSION['error'] = $msg;
        $count = $this->modelo->contarProductosAsociados($id);
        $_SESSION['detalle'] = "Está asociada a $count productos. Elimine o cambie la gama de esos productos.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Gama&ruta=GAMA");
    }
    exit;
}
}
