<?php
namespace App;

use App\Helpers\Auth;
use App\Controllers\LoginController;
use App\Controllers\InicioController;
use App\Controllers\EmpleadoController;
use App\Controllers\ClienteController;
use App\Controllers\ProductoController;

class Router {
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function dispatch($url) {
        // =======================================================
        // LIMPIAR URL Y SEPARAR PARTES
        // =======================================================
        $url = filter_var(trim($url, '/'), FILTER_SANITIZE_URL);
        $partes = explode('/', $url);

        // Acción principal
        $accion = empty($url) ? 'LOGIN' : strtoupper($partes[0]);
        $param1 = $partes[1] ?? null;

        // =======================================================
        // 🔐 PROTEGER RUTAS (solo deja pasar LOGIN)
        // =======================================================
        $noProtegidas = ['LOGIN'];

        if (!in_array($accion, $noProtegidas)) {
            Auth::check();
        }

        // =======================================================
        // ROUTER PRINCIPAL
        // =======================================================
        switch ($accion) {
            // ---------------------
            // LOGIN
            // ---------------------
            case 'LOGIN':
                $controller = new LoginController($this->conn);

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
                $controller = new InicioController();
                $controller->index();
                break;

            // ---------------------
            // EMPLEADOS
            // ---------------------
            case 'EMPLEADOS':
                $controller = new EmpleadoController($this->conn);

                if (!$param1) {
                    $controller->index();
                } else {
                    switch (strtoupper($param1)) {

                        case 'CREAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->crear();
                            break;

                        case 'GUARDAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->guardar();
                            break;

                        case 'VER':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->listar();
                            break;

                        case 'EDITAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->editar($partes[2] ?? null);
                            break;

                        case 'ACTUALIZAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->actualizar();
                            break;

                        case 'ELIMINAR':
                            Auth::requireRole(['ADMIN']);
                            $controller->eliminar($partes[2] ?? null);
                            break;
                    }
                }
                break;

            // ---------------------
            // CLIENTES
            // ---------------------
            case 'CLIENTES':
                $controller = new ClienteController($this->conn);

                if (!$param1) {
                    $controller->index();
                } else {
                    switch (strtoupper($param1)) {

                        case 'CREAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->crear();
                            break;

                        case 'GUARDAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->guardar();
                            break;

                        case 'VER':
                            $controller->listar();
                            break;

                        case 'EDITAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->editar($partes[2] ?? null);
                            break;

                        case 'ACTUALIZAR':
                            Auth::requireRole(['ADMIN', 'GERENTE']);
                            $controller->actualizar();
                            break;

                        case 'ELIMINAR':
                            Auth::requireRole(['ADMIN']);
                            $controller->eliminar($partes[2] ?? null);
                            break;
                    }
                }
                break;

            // ---------------------
            // PRODUCTOS
            // ---------------------
            case 'PRODUCTOS':
                $controller = new ProductoController($this->conn);

                if (!$param1) {
                    $controller->index();
                } else {
                    switch (strtoupper($param1)) {

                        case 'CREAR':
                            Auth::requireRole(['ADMIN', 'INVENTARIO']);
                            $controller->crear();
                            break;

                        case 'GUARDAR':
                            Auth::requireRole(['ADMIN', 'INVENTARIO']);
                            $controller->guardar();
                            break;

                        case 'VER':
                            $controller->listar();
                            break;

                        case 'EDITAR':
                            Auth::requireRole(['ADMIN', 'INVENTARIO']);
                            $controller->editar($partes[2] ?? null);
                            break;

                        case 'ACTUALIZAR':
                            Auth::requireRole(['ADMIN', 'INVENTARIO']);
                            $controller->actualizar();
                            break;

                        case 'ELIMINAR':
                            Auth::requireRole(['ADMIN']);
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
    }
}
