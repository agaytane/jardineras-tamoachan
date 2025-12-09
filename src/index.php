<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

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
// INSTANCIAR ROUTER Y DESPACHAR
// =======================================================
$router = new Router($conn);
$router->dispatch($url);

// =======================================================
// RENDER GENERAL
// =======================================================
$contenido = ob_get_clean();
require __DIR__ . "/views/render.php";
