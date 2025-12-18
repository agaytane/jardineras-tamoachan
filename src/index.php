<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/auth.php';
require_once __DIR__ . '/helpers/url_helper.php'; 

session_start();
ob_start();

// Obtener URL limpia
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = strtok($request_uri, '?');
$base_path = '';

if ($base_path && strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

$url = trim($request_uri, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$partes = explode('/', $url);

$accion = empty($url) ? 'LOGIN' : strtoupper($partes[0]);
$metodo = isset($partes[1]) ? strtoupper($partes[1]) : null;
$param = $partes[2] ?? null;

// Proteger rutas
$noProtegidas = ['LOGIN'];
if (!isset($_SESSION['usuario']) && !in_array($accion, $noProtegidas)) {
    header("Location: /LOGIN");
    exit;
}

// Router
switch ($accion) {
    case 'LOGIN':
        require_once __DIR__ . '/controllers/Ctrl_Login.php';
        $controller = new LoginController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'AUTENTICAR':
                    $controller->autenticar();
                    break;
                case 'LOGOUT':
                    $controller->logout();
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'INICIO':
        require_once __DIR__ . '/controllers/Ctrl_Inicio.php';
        $controller = new InicioController();
        $controller->index();
        break;

    case 'EMPLEADOS':
        require_once __DIR__ . '/controllers/Ctrl_Empl.php';
        $controller = new EmpleadoController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'CREAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->crear();
                    break;
                case 'VER':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->listar();
                    break;
                case 'EDITAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->editar($param);
                    break;
                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;
                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($param);
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'GAMA':
        require_once __DIR__ . '/controllers/Ctrl_Gama.php';
        $controller = new GamaController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'VER':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->listar();
                    break;
                case 'CREAR':
                    requireRole(['ADMIN', 'INVENTARIO']);
                    $controller->crear();
                    break;
                case 'EDITAR':
                    requireRole(['ADMIN', 'INVENTARIO']);
                    $controller->editar($param);
                    break;
                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'INVENTARIO']);
                    $controller->actualizar();
                    break;
                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($param);
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'OFICINAS':
        require_once __DIR__ . '/controllers/Ctrl_Oficina.php';
        $controller = new OficinaController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'VER':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->listar();
                    break;
                case 'CREAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->crear();
                    break;
                case 'EDITAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->editar($param);
                    break;
                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;
                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($param);
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'PEDIDOS':
        require_once __DIR__ . '/controllers/Ctrl_Pedido.php';
        $controller = new PedidoController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'VER':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->listar();
                    break;
                case 'CREAR':
                    requireRole(['ADMIN', 'VENTAS']);
                    $controller->crear();
                    break;
                case 'CANCELAR':
                    requireRole(['ADMIN', 'VENTAS']);
                    $controller->cancelar($param);
                    break;
                case 'EDITAR':
                    requireRole(['ADMIN', 'VENTAS']);
                    $controller->editar($param);
                    break;
                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->editar();
                    break;
                case 'DETALLES':
                    $controller->detalles($param);
                    break;
                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($param);
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'CLIENTES':
        require_once __DIR__ . '/controllers/Ctrl_Cliente.php';
        $controller = new ClienteController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'CREAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->crear();
                    break;
                case 'VER':
                    $controller->listar();
                    break;
                case 'EDITAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->editar($param);
                    break;
                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;
                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($param);
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'PRODUCTOS':
        require_once __DIR__ . '/controllers/Ctrl_Producto.php';
        $controller = new ProductoController($conn);
        if (!$metodo) {
            $controller->index();
        } else {
            switch ($metodo) {
                case 'CREAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->crear();
                    break;
                case 'VER':
                case 'LISTAR':
                    $controller->listar();
                    break;
                case 'EDITAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->editar($param);
                    break;
                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;
                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($param);
                    break;
                default:
                    $controller->index();
            }
        }
        break;

    case 'VISTAS':
        require_once __DIR__ . '/controllers/Ctrl_Vistas.php';
        $controller = new VistasController($conn);
        if (!$metodo) {
            $controller->empleadoOficinaPedidos(); // fallback
        } else {
            switch ($metodo) {
                case 'RESULTADO':
                    $controller->resultado();
                    break;
                case 'INFO_EMP_OFI_PED':
                    $controller->empleadoOficinaPedidos();
                    break;
                case 'INFO_PED_CLIENT_EMP':
                    $controller->pedidoClienteEmpleado();
                    break;
                case 'INFO_PROD_GAMA':
                    $controller->productoGamaDetalle();
                    break;
                case 'INFO_DET_PED':
                    $controller->detallePedidoInfo();
                    break;
                case 'INFO_CLIENT_PED_PROD':
                    $controller->clientePedidoProductos();
                    break;
                default:
                    $controller->empleadoOficinaPedidos();
            }
        }
        break;

    default:
        require __DIR__ . '/views/error/404.php';
}

// Render general
$contenido = ob_get_clean();
require __DIR__ . "/views/render.php";

