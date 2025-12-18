<?php
require_once __DIR__ . '/../models/GamaModel.php';
require_once __DIR__ . '/../helpers/auth.php';

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
            die("❌ Datos inválidos");
        }

        $data = [
            'nombre_gama'      => trim($_POST['Nombre_gama']),
            'descripcion_gama' => trim($_POST['Descripcion_gama'] ?? '')
        ];


        $this->modelo->insertar($data);

        header("Location: /GAMA");
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
        die("❌ Gama no encontrada");
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
            die("❌ Datos inválidos");
        }

        $data = [
            'id_gama'          => (int) $_POST['Id_gama'],
            'nombre_gama'      => trim($_POST['Nombre_gama']),
            'descripcion_gama' => trim($_POST['Descripcion_gama'])
        ];

        $this->modelo->actualizar($data);

        header("Location: /GAMA");
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
        die("❌ Gama no encontrada");
    }

    $this->modelo->eliminar($id);

    header("Location: /GAMA");
    exit;
}
}
