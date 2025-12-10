<?php
namespace App;

use App\Helpers\Auth;
use App\Controllers\LoginController;
use App\Controllers\InicioController;
use App\Controllers\EmpleadoController;
use App\Controllers\ClienteController;
use App\Controllers\ProductoController;

class Router {
    
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function dispatch($url) {
        $url = filter_var(trim($url, '/'), FILTER_SANITIZE_URL);
        $partes = explode('/', $url);

        // 1. Determinar Controlador Principal
        $seccion = empty($url) ? 'LOGIN' : strtoupper($partes[0]);
        $accion  = isset($partes[1]) ? strtoupper($partes[1]) : 'INDEX';
        $id      = $partes[2] ?? null;

        // 2. Cargar Configuración de Rutas
        $routes = require __DIR__ . '/config/routes.php';

        // 3. Validar si la sección existe
        if (!array_key_exists($seccion, $routes)) {
            $this->sendNotFound();
            return;
        }

        $routeConfig = $routes[$seccion];
        $actions = $routeConfig['actions'];

        // 4. Validar si la sub-acción existe, si no, usar INDEX por defecto o error
        if (!array_key_exists($accion, $actions)) {
            // Si la acción no existe, y es una URL base (ej: /PRODUCTOS), forzamos INDEX
            if ($accion === 'INDEX' || !isset($partes[1])) {
                $accion = 'INDEX';
            } else {
                // Si puso /PRODUCTOS/ALGO_RARO
                $this->sendNotFound(); 
                return;
            }
        }
        
        // (Doble check por si forzamos INDEX arriba y no existe en config)
        if (!isset($actions[$accion])) {
            $this->sendNotFound();
            return;
        }

        $actionConfig = $actions[$accion];

        // 5. Verificación de Seguridad (Middleware Simplificado)
        $isPublic = isset($routeConfig['public']) && $routeConfig['public'] 
                    || isset($actionConfig['public']) && $actionConfig['public'];

        if (!$isPublic) {
            Auth::check(); // Verifica login

            // Verifica Roles
            if (isset($actionConfig['roles']) && !empty($actionConfig['roles'])) {
                Auth::requireRole($actionConfig['roles']);
            }
        }

        // 6. Instanciar y Ejecutar (USANDO DI CONTAINER)
        $controllerName = $routeConfig['controller'];
        $method = $actionConfig['method'];

        if (class_exists($controllerName)) {
            try {
                // EL CONTENEDOR RESUELVE DEPENDENCIAS MAGICAMENTE ✨
                $controller = $this->container->resolve($controllerName);

                if (method_exists($controller, $method)) {
                    $controller->$method($id);
                } else {
                    $this->sendNotFound();
                }
            } catch (\Exception $e) {
                // Error de resolución de dependencias u otro
                http_response_code(500);
                echo "Error interno: " . $e->getMessage();
            }
        } else {
            $this->sendNotFound();
        }
    }

    private function sendNotFound() {
        http_response_code(404);
        require __DIR__ . '/views/errors/generic.php'; 
        // Nota: Podriamos tener un 404 especifico, pero el generico sirve si le pasamos variables.
        // O simplemente echo "404"; como antes, pero mejor usar la vista.
        // Pero generic.php espera $message. Forzemos variables antes de require o usemos una simple.
        echo "<div class='container mt-5'><div class='alert alert-warning text-center'><h1>404</h1><p>Ruta no encontrada.</p><a href='/INICIO' class='btn btn-primary'>Ir al Inicio</a></div></div>";
    }
}