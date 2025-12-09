<?php

class Auth {
    
    /**
     * Verifica si el usuario está logueado.
     * Si no, redirige al login.
     */
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }
    }

    /**
     * Verifica si el usuario tiene uno de los roles permitidos.
     * Si no, muestra la vista de error.
     */
    public static function requireRole($rolesPermitidos = []) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $rol = $_SESSION['rol'] ?? null;
        $rol = $rol ? strtoupper($rol) : null;

        if (!$rol || !in_array($rol, $rolesPermitidos)) {
            $message = "❌ No tienes permisos para acceder a esta sección.";
            $button = ['url' => '/INICIO', 'text' => 'Volver'];
            
            // Ajustamos la ruta relativa para que funcione desde cualquier punto
            // Asumimos que Auth.php está en src/helpers/
            require __DIR__ . '/../views/errors/generic.php';
            exit;
        }
    }
}
