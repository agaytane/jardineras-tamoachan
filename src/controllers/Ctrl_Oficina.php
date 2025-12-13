<?php
require_once __DIR__ . '/../models/OficinaModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class OficinaController {
    private $modelo;

        public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new OficinaModel($conn);
    }

    public function index() {
        $ruta = "OFICINAS";
        $titulo = "Oficinas";
        require __DIR__ . '/../views/oficina/index.php';
    }

        public function listar() {
        $oficinas = $this->modelo->listar();
        require __DIR__ . '/../views/oficina/listar.php';
    }

    // ================================
    // CREAR — ADMIN, GERENTE
    // ================================
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);
        require __DIR__ . '/../views/oficina/crear.php';
    }

    public function guardar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->insertar($_POST);
        }
        header("Location: /OFICINAS");
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
            require __DIR__ . '/../views/oficina/seleccionar_editar.php';
            return;
        }

        // Cargar oficina
        $oficina = $this->modelo->obtener($id);
        // Si no existe id de oficina
        if (!$oficina) {
            echo "<div class='alert alert-danger mt-3'>❌ Oficina no encontrada</div>";
            echo "<a href='/OFICINAS/EDITAR' class='btn btn-secondary mt-2'>Intentar otro</a>";
            return;
        }

        require __DIR__ . '/../views/oficina/editar.php';
    }
    // ================================
    // ACTUALIZAR — ADMIN, GERENTE
    // ================================
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_POST) {
            $this->modelo->actualizar($_POST);
        }

        header("Location: /OFICINAS");
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

        // Buscar oficina
        $oficina = $this->modelo->obtener($id);

        if (!$oficina) {
            echo "<div class='alert alert-danger mt-3'>❌ Oficina no encontrada</div>";
            echo "<a href='/OFICINA/ELIMINAR' class='btn btn-secondary mt-2'>Intentar otro</a>";
            return;
        }

        // Eliminar
        $this->modelo->eliminar($id);

        header("Location: /CLIENTES");
    }

}
