<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../helpers/auth.php';//mensajes de error y validaciones para required roles

class ClienteController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new ClienteModel($conn);
    }
    // ================================
    // PANTALLA PRINCIPAL CLIENTES
    // ================================
    public function index() {
        $ruta = "CLIENTES";
        $titulo = "Clientes";
        require __DIR__ . '/../views/cliente/index.php';
    }
    // ================================
    // LISTAR — SIN RESTRICCIONES
    // ================================
    public function listar() {
        $clientes = $this->modelo->listar();
        require __DIR__ . '/../views/cliente/listar.php';
    }
    // ================================
    // CREAR — ADMIN, GERENTE
    // ================================
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);
        require __DIR__ . '/../views/cliente/crear.php';
    }

    public function guardar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->insertar($_POST);
        }
        header("Location: /CLIENTES");
    }

    // ================================
    // EDITAR — ADMIN, GERENTE
    // ================================
    public function editar($id = null) {
        requireRole(['ADMIN', 'GERENTE']);

        // Si viene vía formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        // Si no mandaron ID → pedirlo
        if (!$id) {
            require __DIR__ . '/../views/cliente/seleccionar_editar.php';
            return;
        }

        // Cargar cliente
        $cliente = $this->modelo->obtener($id);
        // Si no existe id de cliente
        if (!$cliente) {
            echo "<div class='alert alert-danger mt-3'>❌ Cliente no encontrado</div>";
            echo "<a href='/CLIENTES/EDITAR' class='btn btn-secondary mt-2'>Intentar otro</a>";
            return;
        }

        require __DIR__ . '/../views/cliente/editar.php';
    }
    // ================================
    // ACTUALIZAR — ADMIN, GERENTE
    // ================================
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->actualizar($_POST);
        }

        header("Location: /CLIENTES");
    }
    // ================================
    // ELIMINAR — SOLO ADMIN
    // ================================
    public function eliminar($id = null) {
        requireRole(['ADMIN']);

        // Si viene desde formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        // Si no viene ID → pantalla para pedirlo
        if (!$id) {
            require __DIR__ . '/../views/cliente/seleccionar_eliminar.php';
            return;
        }

        // Buscar cliente
        $cliente = $this->modelo->obtener($id);

        if (!$cliente) {
            echo "<div class='alert alert-danger mt-3'>❌ Cliente no encontrado</div>";
            echo "<a href='/CLIENTES/ELIMINAR' class='btn btn-secondary mt-2'>Intentar otro</a>";
            return;
        }

        // Eliminar
        $this->modelo->eliminar($id);

        header("Location: /CLIENTES");
    }
}
