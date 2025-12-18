<?php
require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/EmpleadoModel.php';
require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class PedidoController {
    private $modelo;
    private $clienteModel;
    private $empleadoModel;
    private $productoModel;

    public function __construct($conn) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo        = new PedidoModel($conn);
        $this->clienteModel  = new ClienteModel($conn);
        $this->empleadoModel = new EmpleadoModel($conn);
        $this->productoModel = new ProductoModel($conn);
    }

    /* =========================
       INDEX
    ========================== */
    public function index() {
        $ruta = "PEDIDOS";
        $titulo = "Pedidos";
        require __DIR__ . '/../views/pedido/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        requireRole(['ADMIN', 'GERENTE']);
        $pedidos = $this->modelo->listar();
        require __DIR__ . '/../views/pedido/listar.php';
    }

    /* =========================
       CREAR / GUARDAR
       Unificado
    ========================== */
    public function crear() {
        requireRole(['ADMIN', 'VENTAS']);

        // Si viene POST → guardar pedido
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['cliente']) || empty($_POST['empleado']) || empty($_POST['fecha_prevista'])) {
                die("❌ Datos incompletos");
            }

            $pedido = [
                'Fecha_pedido'   => date('Y-m-d'),
                'Fecha_prevista' => $_POST['fecha_prevista'],
                'Estado'         => 'Pendiente',
                'Comentarios'    => $_POST['comentarios'] ?? '',
                'Fk_id_cliente'  => (int) $_POST['cliente'],
                'Fk_id_empleado' => (int) $_POST['empleado']
            ];

            $detalles = [];

            foreach ($_POST['productos'] as $i => $prod) {
                if (!empty($prod) && (int)$_POST['cantidades'][$i] > 0) {
                    $detalles[] = [
                        'producto_id' => (int) $prod,
                        'cantidad'    => (int) $_POST['cantidades'][$i]
                    ];
                }
            }

            if (empty($detalles)) {
                die(" El pedido debe incluir productos");
            }

            $this->modelo->crearPedido($pedido, $detalles);

            header("Location: /PEDIDOS");
            exit;
        }

        
        $clientes  = $this->clienteModel->listar();
        $empleados = $this->empleadoModel->listar();
        $productos = $this->productoModel->listar();

        require __DIR__ . '/../views/pedido/crear.php';
    }

    /* =========================
       EDITAR PEDIDO
    ========================== */
    public function editar($id = null) {
        requireRole(['ADMIN', 'VENTAS']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            require __DIR__ . '/../views/pedido/seleccionar_editar.php';
            return;
        }

        $pedido = $this->modelo->obtener($id);
        if (!$pedido) {
            die("❌ Pedido no encontrado");
        }

        $detalles = $this->modelo->obtenerDetalle($id);

        $clientes  = $this->clienteModel->listar();
        $empleados = $this->empleadoModel->listar();
        $productos = $this->productoModel->listar();

        require __DIR__ . '/../views/pedido/editar.php';
    }

    /* =========================
       CANCELAR
    ========================== */
    public function cancelar($id) {
        requireRole(['ADMIN', 'VENTAS']);
        $this->modelo->cancelar($id);
        header("Location: /PEDIDOS");
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id) {
        requireRole(['ADMIN']);
        $this->modelo->eliminar($id);
        header("Location: /PEDIDOS");
    }
}
