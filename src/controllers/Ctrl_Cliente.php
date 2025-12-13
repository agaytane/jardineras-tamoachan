<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class ClienteController {
    private $modelo;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new ClienteModel($conn);
    }

    /* =========================
       INDEX
    ========================== */
    public function index() {
        $ruta = "CLIENTES";
        $titulo = "Clientes";
        require __DIR__ . '/../views/cliente/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $clientes = $this->modelo->listar();
        require __DIR__ . '/../views/cliente/listar.php';
    }

    /* =========================
       CREAR
    ========================== */
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);

        // 1️⃣ Mostrar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require __DIR__ . '/../views/cliente/crear.php';
            return;
        }
        // 2️⃣ Procesar POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /CLIENTES");
            exit;
        }

        // 3️⃣ Validaciones
        if (
            empty($_POST['Nombre_cte']) ||
            empty($_POST['Apellido_cte']) ||
            empty($_POST['Email_cte'])
        ) {
            die("❌ Datos inválidos");
        }

        // 4️⃣ Limpiar datos
        $data = [
            'Nombre_cte'    => trim($_POST['Nombre_cte']),
            'Apellido_cte'  => trim($_POST['Apellido_cte']),
            'Email_cte'     => trim($_POST['Email_cte']),
            'Telefono_cte'  => trim($_POST['Telefono_cte'] ?? ''),
            'Direccion_cte' => trim($_POST['Direccion_cte'] ?? '')
        ];

        // 5️⃣ Insertar
        $this->modelo->insertar($data);

        // 6️⃣ Redirigir
        header("Location: /CLIENTES");
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
            require __DIR__ . '/../views/cliente/seleccionar_editar.php';
            return;
        }

        $cliente = $this->modelo->obtener($id);

        if (!$cliente) {
            die("❌ Cliente no encontrado");
        }

        require __DIR__ . '/../views/cliente/editar.php';
    }

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /CLIENTES");
            exit;
        }

        if (empty($_POST['Id_cliente'])) {
            die("❌ Datos inválidos");
        }

        $data = [
            'Id_cliente'    => (int) $_POST['Id_cliente'],
            'Email_cte'     => trim($_POST['Email_cte']),
            'Telefono_cte'  => trim($_POST['Telefono_cte']),
            'Direccion_cte' => trim($_POST['Direccion_cte'])
        ];

        $this->modelo->actualizar($data);

        header("Location: /CLIENTES");
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
            require __DIR__ . '/../views/cliente/seleccionar_eliminar.php';
            return;
        }

        if (!$this->modelo->obtener($id)) {
            die("❌ Cliente no encontrado");
        }

        $this->modelo->eliminar($id);

        header("Location: /CLIENTES");
        exit;
    }
}
