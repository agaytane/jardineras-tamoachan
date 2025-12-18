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
                $_SESSION['error'] = "❌ Datos incompletos.";
                $_SESSION['detalle'] = "Cliente, empleado y fecha prevista son requeridos.";
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Pedido&ruta=PEDIDOS");
                exit;
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
                $_SESSION['error'] = "❌ El pedido debe incluir productos.";
                $_SESSION['detalle'] = "Agregue al menos un producto con cantidad > 0.";
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Pedido&ruta=PEDIDOS");
                exit;
            }

            try {
                $this->modelo->crearPedido($pedido, $detalles);
                $_SESSION['exito'] = "✅ Pedido creado correctamente.";
                header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Pedido&ruta=PEDIDOS");
            } catch (Exception $e) {
                $_SESSION['error'] = "❌ Error al crear pedido.";
                $_SESSION['detalle'] = $e->getMessage();
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Pedido&ruta=PEDIDOS");
            }
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
        // Actualización del pedido
        if (isset($_POST['Estado']) || isset($_POST['Comentarios']) || isset($_POST['Fecha_entrega'])) {
            $id = $_POST['id'] ?? $_POST['Id_pedido'] ?? null;
            if (!$id) {
                $_SESSION['error'] = "❌ Id de pedido requerido.";
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Pedido&ruta=PEDIDOS");
                exit;
            }

            $data = [
                'Estado'        => $_POST['Estado'] ?? null,
                'Comentarios'   => $_POST['Comentarios'] ?? '',
                'Fecha_entrega' => $_POST['Fecha_entrega'] ?? null,
            ];

            try {
                $this->modelo->actualizar($id, $data);
                $_SESSION['exito'] = "✅ Pedido actualizado.";
                header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Pedido&ruta=PEDIDOS");
            } catch (Exception $e) {
                $_SESSION['error'] = "❌ Error al actualizar pedido.";
                $_SESSION['detalle'] = $e->getMessage();
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Pedido&ruta=PEDIDOS");
            }
            exit;
        }

        // Selección de pedido por id
        $id = $_POST['id'] ?? null;
    }

    if (!$id) {
        $pedidos = $this->modelo->listar();
        require __DIR__ . '/../views/pedido/seleccionar_editar.php';
        return;
    }

    $resultado = $this->modelo->obtener($id);

    if (!$resultado || !$resultado['pedido']) {
        $_SESSION['error'] = "❌ Pedido no encontrado.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Pedido&ruta=PEDIDOS");
        exit;
    }

    $pedido   = $resultado['pedido'];
    $detalles = $resultado['detalles'];

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
        try {
            $this->modelo->cancelar($id);
            $_SESSION['exito'] = "✅ Pedido cancelado.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CANCELAR&entidad=Pedido&ruta=PEDIDOS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al cancelar pedido.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CANCELAR&entidad=Pedido&ruta=PEDIDOS");
        }
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
        $pedidos = $this->modelo->listar();
        require __DIR__ . '/../views/pedido/seleccionar_eliminar.php';
        return;
    }

    try {
        $this->modelo->eliminar($id);
        $_SESSION['exito'] = "✅ Pedido eliminado.";
        header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Pedido&ruta=PEDIDOS");
    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al eliminar pedido.";
        $_SESSION['detalle'] = $e->getMessage();
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Pedido&ruta=PEDIDOS");
    }
    exit;
}

}
