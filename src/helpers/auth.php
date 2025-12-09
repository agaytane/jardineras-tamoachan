<?php
function requireRole($rolesPermitidos = []) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $rol = isset($_SESSION['rol']) ? strtoupper($_SESSION['rol']) : null;

    if (!$rol || !in_array($rol, $rolesPermitidos)) {
        require __DIR__ . "/../views/error/no_acceso.php";
        exit;
    }
}
