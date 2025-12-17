<?php
function requireRole(array $rolesPermitidos = [])
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $rol = $_SESSION['rol'] ?? null;
    $rol = $rol ? strtoupper($rol) : null;

    if (!$rol || !in_array($rol, $rolesPermitidos)) {
        // Marcar error y dejar que el router renderice
        $_SESSION['error_code'] = 403;
        header("Location: /ERROR/403");
        exit;
    }
}
