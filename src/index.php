<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/auth.php';
require_once __DIR__ . '/helpers/url_helper.php'; 

session_start();
ob_start();

// =======================================================
// 🆕 OBTENER URL LIMPIA DESDE REQUEST_URI
// =======================================================
$request_uri = $_SERVER['REQUEST_URI'];

// Remover query string si existe (ej: /productos?pagina=1 → /productos)
$request_uri = strtok($request_uri, '?');

// Si la aplicación está en un subdirectorio, remover la ruta base
$base_path = ''; // Cambia esto si tu app está en subdirectorio
// Ejemplo: si está en http://localhost/miapp/, entonces:
// $base_path = '/miapp';

if ($base_path && strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Obtener solo el path y limpiar
$url = trim($request_uri, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

// =======================================================
// DEBUG (opcional - eliminar en producción)
// =======================================================
if (isset($_GET['debug'])) {
    echo "<pre style='background:#f0f0f0;padding:10px;'>";
    echo "REQUEST_URI: " . htmlspecialchars($_SERVER['REQUEST_URI']) . "\n";
    echo "URL limpia: " . htmlspecialchars($url) . "\n";
    echo "Partes: ";
    print_r(explode('/', $url));
    echo "</pre>";
}

// Separar partes de la URL
$partes = explode('/', $url);

// Acción principal
$accion = empty($url) ? 'LOGIN' : strtoupper($partes[0]);
$param1 = $partes[1] ?? null;

// =======================================================
// 🔐 PROTEGER RUTAS (solo deja pasar LOGIN)
// =======================================================
$noProtegidas = ['LOGIN'];

if (!isset($_SESSION['usuario']) && !in_array($accion, $noProtegidas)) {
    header("Location: /LOGIN");
    exit;
}

// =======================================================
// ROUTER PRINCIPAL (igual que antes)
// =======================================================
switch ($accion) {

    // ---------------------
    // LOGIN
    // ---------------------
    case 'LOGIN':
        require_once __DIR__ . '/controllers/Ctrl_Login.php';
        $controller = new LoginController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
                case 'AUTENTICAR':
                    $controller->autenticar();
                    break;

                case 'LOGOUT':
                    $controller->logout();
                    break;
            }
        }
        break;

    // ---------------------
    // INICIO
    // ---------------------
    case 'INICIO':
        require_once __DIR__ . '/controllers/Ctrl_Inicio.php';
        $controller = new InicioController();
        $controller->index();
        break;

    // ---------------------
    // EMPLEADOS
    // ---------------------
    case 'EMPLEADOS':
        require_once __DIR__ . '/controllers/Ctrl_Empl.php';
        $controller = new EmpleadoController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {

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
                    $controller->editar($partes[2] ?? null);
                    break;

                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;

                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($partes[2] ?? null);
                    break;
            }
        }
        break;
    
    // ---------------------
    // GAMA
    // ---------------------
    case 'GAMA':
        require_once __DIR__ . '/controllers/Ctrl_Gama.php';
        $controller = new GamaController(conn: $conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
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
                    $controller->editar($partes[2] ?? null);
                    break;

                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'INVENTARIO']);
                    $controller->actualizar();
                    break;

                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($partes[2] ?? null);
                    break;
            }
        }
        break;
    
    // ---------------------
    // OFICINAS
    // ---------------------
    case 'OFICINAS':
        require_once __DIR__ . '/controllers/Ctrl_Oficina.php';
        $controller = new OficinaController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {

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
                    $controller->editar($partes[2] ?? null);
                    break;

                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;

                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($partes[2] ?? null);
                    break;
            }
        }
        break;
    
    // ---------------------
    // PEDIDOS
    // ---------------------
    case 'PEDIDOS':
        require_once __DIR__ . '/controllers/Ctrl_Pedido.php';
        $controller = new PedidoController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
                
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
                    $controller->cancelar($partes[2] ?? null);
                    break;

                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($partes[2] ?? null);
                    break;
            }
        }
        break;

    // ---------------------
    // CLIENTES
    // ---------------------
    case 'CLIENTES':
        require_once __DIR__ . '/controllers/Ctrl_Cliente.php';
        $controller = new ClienteController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {

                case 'CREAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->crear();
                    break;

                case 'VER':
                    $controller->listar();
                    break;

                case 'EDITAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->editar($partes[2] ?? null);
                    break;

                case 'ACTUALIZAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->actualizar();
                    break;

                case 'ELIMINAR':
                    requireRole(['ADMIN']);
                    $controller->eliminar($partes[2] ?? null);
                    break;
            }
        }
        break;

    // ---------------------
    // PRODUCTOS
    // ---------------------
    case 'PRODUCTOS':
        require_once __DIR__ . '/controllers/Ctrl_Producto.php';
        $controller = new ProductoController($conn);

        if (!$param1) {
            $controller->index();
            break;
        }
        switch (strtoupper($param1)) {
            case 'CREAR':
                requireRole(['ADMIN', 'GERENTE']);
                $controller->crear();
                break;
            case 'LISTAR':
                $controller->listar();
                break;
            case 'VER': // alias opcional
                $controller->listar();
                break;
            case 'EDITAR':
                requireRole(['ADMIN', 'GERENTE']);
                $controller->editar($partes[2] ?? null);
                break;
            case 'ACTUALIZAR':
                requireRole(['ADMIN', 'GERENTE']);
                $controller->actualizar();
                break;
            case 'ELIMINAR':
                requireRole(['ADMIN']);
                $controller->eliminar($partes[2] ?? null);
                break;
            default:
                header("HTTP/1.0 404 Not Found");
                echo "<h3>❌ Acción no válida en PRODUCTOS</h3>";
                break;
        }
        break;
    
    // ---------------------
    // ERRORES
    // ---------------------
    case 'ERROR':
        $codigo = $param1 ?? '404';

        switch ($codigo) {
            case '403':
                require __DIR__ . '/views/error/no_acceso.php';
                break;

            case '404':
            default:
                require __DIR__ . '/views/error/404.php';
                break;
        }
        break;

    // ---------------------
    // ERROR 404
    // ---------------------
    default:
        echo "<h2>404 - Ruta no encontrada</h2>";
        break;
}

// =======================================================
// RENDER GENERAL
// =======================================================
$contenido = ob_get_clean();
require __DIR__ . "/views/render.php";