<?php
// 1. Cargar la conexión PDO ya creada en database.php
require_once __DIR__ . '/config/database.php';

// 2. Cargar controladores
require_once __DIR__ . '/controllers/Ctrl_Empl.php';

// 3. Obtener URL amigable
$url = isset($_GET['url']) ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) : '';
$partes = explode('/', $url);

// 4. Determinar acción por defecto
$accion = empty($url) ? 'INICIO' : strtoupper($partes[0]);

// 5. Ruteo de acciones
switch ($accion) {

    case 'INICIO':
    case 'EMPLEADOS':
        // $conn viene directamente de database.php
        $controller = new EmpleadoController($conn);
        $controller->index();
        break;

    default:
        echo "<h2>404 - Ruta no encontrada</h2>";
        break;
}
?>
