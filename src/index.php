<?php
require_once __DIR__ . '/config/database.php';

ob_start();

$url = isset($_GET['url']) 
    ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) 
    : '';

$partes = explode('/', $url);

// Acción principal
$accion = empty($url) ? 'INICIO' : strtoupper($partes[0]);
$param1 = $partes[1] ?? null;

switch ($accion) {

    /* ===========================
       INICIO
       =========================== */
    case 'INICIO':
        require_once __DIR__ . '/controllers/Ctrl_Inicio.php';
        $controller = new InicioController();
        $controller->index();
        break;

    /* ===========================
       EMPLEADOS
       =========================== */
    case 'EMPLEADOS':
        require_once __DIR__ . '/controllers/Ctrl_Empl.php';
        $controller = new EmpleadoController($conn);

    if (!$param1) {
           $controller->index(); // SOLO MENÚ
    } else {
        switch (strtoupper($param1)) {

            case 'CREAR':
                $controller->crear();
                break;

            case 'GUARDAR':
                $controller->guardar();
                break;

            case 'VER':
                $controller->listar(); // AQUÍ ya se listan
                break;

            case 'EDITAR':
                $id = $partes[2] ?? null;
                $controller->editar($id);
                break;

            case 'ACTUALIZAR':
                $controller->actualizar();
                break;

            case 'ELIMINAR':
                $id = $partes[2] ?? null;
                $controller->eliminar($id);
                break;
        }
    }
    break;

    /* ===========================
       DETALLE PEDIDO
       =========================== */
    case 'DETALLES_PEDIDO':
        require_once __DIR__ . '/controllers/Ctrl_Dpedidos.php';
        $controller = new DpedidosController($conn);
        $controller->index();
        break;

    /* ===========================
       VISTAS SQL
       =========================== */
    case 'VISTAS':
        require_once __DIR__ . '/controllers/Ctrl_Vistas.php';
        $controller = new VistasController($conn);

        $accionVista = strtoupper($param1 ?? '');

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

    /* ===========================
       OFICINA
       =========================== */
    case 'OFICINA':
        require_once __DIR__ . '/controllers/Ctrl_Oficina.php';
        $controller = new OficinaController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
                case 'CREAR': $controller->crear(); break;
                case 'GUARDAR': $controller->guardar(); break;

                case 'EDITAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->editar($id) : print("Falta ID");
                    break;

                case 'ACTUALIZAR': $controller->actualizar(); break;

                case 'ELIMINAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->eliminar($id) : print("Falta ID");
                    break;

                default:
                    echo "<h2>404 - Acción Oficina no encontrada</h2>";
            }
        }
        break;

    /* ===========================
       CLIENTE
       =========================== */
    case 'CLIENTE':
        require_once __DIR__ . '/controllers/Ctrl_Cliente.php';
        $controller = new ClienteController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
                case 'CREAR': $controller->crear(); break;
                case 'GUARDAR': $controller->guardar(); break;

                case 'EDITAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->editar($id) : print("Falta ID");
                    break;

                case 'ACTUALIZAR': $controller->actualizar(); break;

                case 'ELIMINAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->eliminar($id) : print("Falta ID");
                    break;
            }
        }
        break;

    /* ===========================
       PEDIDO
       =========================== */
    case 'PEDIDO':
        require_once __DIR__ . '/controllers/Ctrl_Pedido.php';
        $controller = new PedidoController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
                case 'CREAR': $controller->crear(); break;
                case 'GUARDAR': $controller->guardar(); break;

                case 'EDITAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->editar($id) : print("Falta ID");
                    break;

                case 'ACTUALIZAR': $controller->actualizar(); break;

                case 'ELIMINAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->eliminar($id) : print("Falta ID");
                    break;
            }
        }
        break;

    /* ===========================
       GAMA
       =========================== */
    case 'GAMA':
        require_once __DIR__ . '/controllers/Ctrl_Gama.php';
        $controller = new GamaController($conn);

        if (!$param1) {
            $controller->index();
        } else {
            switch (strtoupper($param1)) {
                case 'CREAR': $controller->crear(); break;
                case 'GUARDAR': $controller->guardar(); break;

                case 'EDITAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->editar($id) : print("Falta ID");
                    break;

                case 'ACTUALIZAR': $controller->actualizar(); break;

                case 'ELIMINAR':
                    $id = $partes[2] ?? null;
                    $id ? $controller->eliminar($id) : print("Falta ID");
                    break;
            }
        }
        break;

    /* ===========================
       PRODUCTOS
       =========================== */
    case 'PRODUCTOS':
    require_once __DIR__ . '/controllers/Ctrl_Producto.php';
    $controller = new ProductoController($conn);

    if (!$param1) {
        $controller->index(); // SOLO MENÚ
    } else {

        switch (strtoupper($param1)) {

            case 'CREAR':
                $controller->crear();
                break;

            case 'GUARDAR':
                $controller->guardar();
                break;

            case 'VER':
                $controller->listar(); // AQUÍ ya se listan
                break;

            case 'EDITAR':
                $id = $partes[2] ?? null;
                $controller->editar($id);
                break;

            case 'ACTUALIZAR':
                $controller->actualizar();
                break;

            case 'ELIMINAR':
                $id = $partes[2] ?? null;
                $controller->eliminar($id);
                break;
        }
    }
break;


    default:
        echo "<h2>404 - Ruta no encontrada</h2>";
        break;
}

/* ===========================
   RENDER GENERAL
   =========================== */
$contenido = ob_get_clean();
require __DIR__ . "/views/render.php";
