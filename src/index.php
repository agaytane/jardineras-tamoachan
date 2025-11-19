<?php
// 1. Cargar la conexión PDO
require_once __DIR__ . '/config/database.php';

// 2. Obtener URL amigable
$url = isset($_GET['url']) ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) : '';
$partes = explode('/', $url);

// Acción principal
$accion = empty($url) ? 'INICIO' : strtoupper($partes[0]);

// Si hay parámetros (ej: PRODUCTOS/EDITAR/5)
$param1 = $partes[1] ?? null;

switch ($accion) {

    case 'INICIO':
    case 'EMPLEADOS':
        require_once __DIR__ . '/controllers/Ctrl_Empl.php';
        $controller = new EmpleadoController($conn);
        $controller->index();
        break;

    case 'DETALLES_PEDIDO':
        require_once __DIR__ . '/controllers/Ctrl_Dpedidos.php';
        $controller = new DpedidosController($conn);
        $controller->index();
        break;

    /* ==========================================================
       CRUD PRODUCTOS COMPLETO
       ========================================================== */
    case 'PRODUCTOS':
        require_once __DIR__ . '/controllers/Ctrl_Producto.php';
        $controller = new ProductoController($conn);

        if (!$param1) {
            // PRODUCTOS → lista
            $controller->index();
        } else {

            switch (strtoupper($param1)) {

                case 'CREAR':  // PRODUCTOS/CREAR
                    $controller->crear();
                    break;

                case 'GUARDAR': // POST PRODUCTOS/GUARDAR
                    $controller->guardar();
                    break;

                case 'EDITAR': // PRODUCTOS/EDITAR/ID
                    $id = $partes[2] ?? null;
                    if ($id) $controller->editar($id);
                    else echo "Error: falta ID.";
                    break;

                case 'ACTUALIZAR': // POST PRODUCTOS/ACTUALIZAR
                    $controller->actualizar();
                    break;

                case 'ELIMINAR': // PRODUCTOS/ELIMINAR/ID
                    $id = $partes[2] ?? null;
                    if ($id) $controller->eliminar($id);
                    else echo "Error: falta ID.";
                    break;

                default:
                    echo "<h2>404 - Acción de productos no encontrada</h2>";
            }
        }

        break;

    default:
        echo "<h2>404 - Ruta no encontrada</h2>";
        break;
}

