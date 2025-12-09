<?php
require_once __DIR__ . '/config/database.php';

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
// FUNCIÓN PARA VALIDAR ROL DESDE EL ROUTER (GLOBAL)
// =======================================================
function requireRole($rolesPermitidos = []) {
    $rol = isset($_SESSION['rol']) ? strtoupper($_SESSION['rol']) : null; // <- CORREGIDO

    if (!$rol || !in_array($rol, $rolesPermitidos)) {
        echo "<div class='alert alert-danger mt-3'>❌ No tienes permisos para acceder a esta sección.</div>";
        echo "<a href='/INICIO' class='btn btn-secondary mt-3'>Volver</a>";
        exit;
    }
}
// =======================================================
// ROUTER PRINCIPAL
// =======================================================
switch ($accion) {
    // ---------------------
    // LOGIN
    // ---------------------
    case 'LOGIN':
        require_once __DIR__ . '/controllers/LoginController.php';
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
        require_once __DIR__ . '/controllers/InicioController.php';
        $controller = new InicioController();
        $controller->index();
        break;

    // ---------------------
    // EMPLEADOS
    // ---------------------
    case 'EMPLEADOS':
        require_once __DIR__ . '/controllers/EmpleadoController.php';
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
                    requireRole(['ADMIN', 'GERENTE',]);
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
        require_once __DIR__ . '/controllers/ClienteController.php';
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
        require_once __DIR__ . '/controllers/ProductoController.php';
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
