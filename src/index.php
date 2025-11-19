<?php
// =========================================
//  CARGAR CONEXIÓN
// =========================================
require_once __DIR__ . '/config/database.php';

// =========================================
//  BUFFER PARA CAPTURAR TODO LO QUE IMPRIMA
//  CUALQUIER CONTROLADOR O VISTA
// =========================================
ob_start();

// =========================================
//  OBTENER URL AMIGABLE
// =========================================
$url = isset($_GET['url']) ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) : '';
$partes = explode('/', $url);

// Acción principal
$accion = empty($url) ? 'INICIO' : strtoupper($partes[0]);
$param1 = $partes[1] ?? null;

// =========================================
//  RUTEO PRINCIPAL
// =========================================
switch ($accion) {

    // ========================================================
    //  INICIO / EMPLEADOS (usa mismo controlador)
    // ========================================================
    case 'INICIO':
    case 'EMPLEADOS':
        require_once __DIR__ . '/controllers/Ctrl_Empl.php';
        $controller = new EmpleadoController($conn);
        $controller->index();
        break;

    // ========================================================
    //  DETALLES DE PEDIDOS
    // ========================================================
    case 'DETALLES_PEDIDO':
        require_once __DIR__ . '/controllers/Ctrl_Dpedidos.php';
        $controller = new DpedidosController($conn);
        $controller->index();
        break;

    // ========================================================
    //  PRODUCTOS CRUD COMPLETO
    // ========================================================
    case 'PRODUCTOS':
        require_once __DIR__ . '/controllers/Ctrl_Producto.php';
        $controller = new ProductoController($conn);

        if (!$param1) {
            // PRODUCTOS → lista
            $controller->index();
        } else {

            switch (strtoupper($param1)) {

                case 'CREAR':
                    $controller->crear();
                    break;

                case 'GUARDAR':
                    $controller->guardar();
                    break;

                case 'EDITAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->editar($id) : print("Error: falta ID.");
                    break;

                case 'ACTUALIZAR':
                    $controller->actualizar();
                    break;

                case 'ELIMINAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->eliminar($id) : print("Error: falta ID.");
                    break;

                default:
                    echo "<h2>404 - Acción de productos no encontrada</h2>";
            }
        }
        break;

    // ========================================================
    //  404
    // ========================================================
    default:
        echo "<h2>404 - Ruta no encontrada</h2>";
        break;
}

// ========================================================
//  CAPTURAR TODO LO QUE SE GENERÓ EN EL CONTROLADOR
// ========================================================
$contenido = ob_get_clean();

// ========================================================
//  LLAMAR A LA VISTA CONTENEDORA
//  (NO MODIFICA CONTROLADORES, SOLO ENVUELVE SU SALIDA)
// ========================================================
require __DIR__ . "/views/render.php";
