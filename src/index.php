<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/auth.php';

session_start();
ob_start();

// =======================================================
// LIMPIAR URL Y SEPARAR PARTES
// =======================================================
$url = isset($_GET['url']) 
    ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) 
    : '';

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
// ROUTER PRINCIPAL
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

                case 'GUARDAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->guardar();
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

                case 'GUARDAR':
                    requireRole(['ADMIN', 'GERENTE']);
                    $controller->guardar();
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
        } else {
            switch (strtoupper($param1)) {

                case 'CREAR':
                    requireRole(['ADMIN', 'INVENTARIO']);
                    $controller->crear();
                    break;

                case 'GUARDAR':
                    requireRole(['ADMIN', 'INVENTARIO']);
                    $controller->guardar();
                    break;

                case 'VER':
                    $controller->listar();
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
