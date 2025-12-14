<?php
require_once __DIR__ . '/../models/OficinaModel.php';
require_once __DIR__ . '/../helpers/auth.php';

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
            die("❌ Datos inválidos");
        }

        $data = [
            'Direccion'      => trim($_POST['Direccion']),
            'Telefono'       => trim($_POST['Telefono'] ?? ''),
            'Ciudad'         => trim($_POST['Ciudad']),
            'Provincia'      => trim($_POST['Provincia']),
            'Codigo_postal'  => trim($_POST['Codigo_postal'])
        ];

        $this->modelo->insertar($data);

        header("Location: /OFICINAS");
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
            require __DIR__ . '/../views/oficina/seleccionar_editar.php';
            return;
        }

        $oficina = $this->modelo->obtener($id);

        if (!$oficina) {
            die("❌ Oficina no encontrada");
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
            die("❌ Datos inválidos");
        }

        $data = [
            'Id_oficina'     => (int) $_POST['Id_oficina'],
            'Direccion'      => trim($_POST['Direccion']),
            'Telefono'       => trim($_POST['Telefono']),
            'Ciudad'         => trim($_POST['Ciudad']),
            'Provincia'      => trim($_POST['Provincia']),
            'Codigo_postal'  => trim($_POST['Codigo_postal'])
        ];

        $this->modelo->actualizar($data);

        header("Location: /OFICINAS");
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
            require __DIR__ . '/../views/oficina/seleccionar_eliminar.php';
            return;
        }

        if (!$this->modelo->obtener($id)) {
            die("❌ Oficina no encontrada");
        }

        $this->modelo->eliminar($id);

        header("Location: /OFICINAS");
        exit;
    }
}
