<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Container;
use App\Router;

session_start();
ob_start();

// =======================================================
// LIMPIAR URL Y SEPARAR PARTES
// =======================================================
$url = isset($_GET['url']) 
    ? filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL) 
    : '';

// =======================================================
// CONTENEDOR DE DEPENDENCIAS
// =======================================================
$container = new Container();

// Registramos la conexión PDO en el contenedor
$container->set(PDO::class, function() use ($conn) {
    return $conn;
});

// =======================================================
// INSTANCIAR ROUTER Y DESPACHAR
// =======================================================
// El Router ahora recibe el Container, no la conexión directa
$router = new Router($container);
$router->dispatch($url);

// =======================================================
// RENDER GENERAL
// =======================================================
$contenido = ob_get_clean();
require __DIR__ . "/views/render.php";
