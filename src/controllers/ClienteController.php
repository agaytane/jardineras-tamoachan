<?php
namespace App\Controllers;

use App\Models\ClienteModel;
use App\Helpers\Auth;

class ClienteController {
    private $modelo;
    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new ClienteModel($conn);
    }
    // ================================
    // VALIDAR PERMISOS
    // ================================

    // ========================
    // PANTALLA PRINCIPAL CLIENTE
    // ========================
    public function index() {
        $ruta = "CLIENTES";
        $titulo = "Clientes";
        require __DIR__ . '/../views/cliente/index.php';
    }
    // ========================
    // LISTAR — TODOS PUEDEN
    // ========================
    public function listar() {
        $clientes = $this->modelo->listar();
        require __DIR__ . '/../views/cliente/listar.php';
    }
    // ========================
    // CREAR — ADMIN, GERENTE
    // ========================
    public function crear() {
        Auth::requireRole(['ADMIN', 'GERENTE']);
        require __DIR__ . '/../views/cliente/crear.php';
    }
    public function guardar() {
        Auth::requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->insertar($_POST);
            header("Location: /CLIENTE");
        }
    }
    // ========================
    // EDITAR — ADMIN, GERENTE
    // ========================
    public function editar($id = null) {
        Auth::requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/cliente/seleccionar_editar.php';
            return;
        }

        $cliente = $this->modelo->obtener($id);

        if (!$cliente) {
            echo "<div class='alert alert-danger'>Cliente no encontrado</div>";
            echo "<a href='/CLIENTE/EDITAR' class='btn btn-secondary'>Intentar otro</a>";
            return;
        }

        require __DIR__ . '/../views/cliente/editar.php';
    }
    // ========================
    // ACTUALIZAR — ADMIN, GERENTE
    // ========================
    public function actualizar() {
        Auth::requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->actualizar($_POST);
        }
        header("Location: /CLIENTE");
    }
    // ========================
    // ELIMINAR — SOLO ADMIN
    // ========================
    public function eliminar($id = null) {
        Auth::requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/cliente/seleccionar_eliminar.php';
            return;
        }

        $cliente = $this->modelo->obtener($id);

        if (!$cliente) {
            echo "<div class='alert alert-danger'>Cliente no encontrado</div>";
            echo "<a href='/CLIENTE/ELIMINAR' class='btn btn-secondary'>Intentar otro</a>";
            return;
        }

        $this->modelo->eliminar($id);
        header("Location: /CLIENTE");
    }
}
