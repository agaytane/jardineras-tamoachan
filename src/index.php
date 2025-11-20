<?php
require_once __DIR__ . '/config/database.php';
ob_start();
$url = isset($_GET['url']) ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) : '';
$partes = explode('/', $url);

// Acción principal
$accion = empty($url) ? 'INICIO' : strtoupper($partes[0]);
$param1 = $partes[1] ?? null;

switch ($accion) {

    case 'INICIO':
        require_once __DIR__ . '/controllers/Ctrl_Inicio.php';
        $controller = new InicioController();
        $controller->index();
        break;

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

    case 'VISTAS':
        require_once __DIR__ . '/controllers/Ctrl_Vistas.php';
        $controller = new VistasController($conn);
        $accionVista = strtoupper($partes[1] ?? '');

        switch ($accionVista) {
            case 'PEDIDO_CLIENTE_EMPLEADO':
                $controller->pedidoClienteEmpleado();
                break;
            case 'PRODUCTO_GAMA_DETALLE':
                $controller->productoGamaDetalle();
                break;
            case 'DETALLE_PEDIDO_INFO':
                $controller->detallePedidoInfo();
                break;
            case 'EMPLEADO_OFICINA_PEDIDOS':
                $controller->empleadoOficinaPedidos();
                break;
            case 'CLIENTE_PEDIDO_PRODUCTOS':
                $controller->clientePedidoProductos();
                break;
            default:
                echo "<h2>404 - Vista no encontrada</h2>";
       }
        break;



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

   
    default:
        echo "<h2>404 - Ruta no encontrada</h2>";
        break;
}
$contenido = ob_get_clean();
require __DIR__ . "/views/render.php";
