<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario = $_SESSION['usuario'] ?? null;
$rol = $_SESSION['rol'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Jardinería</title>
    <link href="/assets/css/estilos_jardineria.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="/INICIO">🌿 Jardinería</a>

        <?php if ($usuario): ?>
            <span class="navbar-text text-white me-3">
                Usuario: <strong><?= $usuario ?></strong> | Rol: <strong><?= $rol ?></strong>
            </span>

            <div class="d-flex">

                <!-- ✅ ADMIN -->
                <?php if ($rol === 'ADMIN'): ?>
                    <a href="/PRODUCTOS" class="btn btn-light me-2">Productos</a>
                    <a href="/EMPLEADOS" class="btn btn-light me-2">Empleados</a>
                    <a href="/VISTAS/PEDIDO_CLIENTE_EMPLEADO" class="btn btn-light me-2">Vistas</a>
                <?php endif; ?>

                <!-- ✅ GERENTE -->
                <?php if ($rol === 'GERENTE'): ?>
                    <a href="/VISTAS/CLIENTE_PEDIDO_PRODUCTOS" class="btn btn-light me-2">Reportes</a>
                <?php endif; ?>

                <!-- ✅ EMPLEADO -->
                <?php if ($rol === 'EMPLEADO'): ?>
                    <a href="/PRODUCTOS" class="btn btn-light me-2">Ventas</a>
                <?php endif; ?>

                <!-- ✅ INVENTARIO -->
                <?php if ($rol === 'INVENTARIO'): ?>
                    <a href="/PRODUCTOS" class="btn btn-light me-2">Inventario</a>
                <?php endif; ?>

                <a href="/LOGIN/CERRAR" class="btn btn-danger">Cerrar Sesión</a>
            </div>

        <?php else: ?>
            <a href="/LOGIN" class="btn btn-light">Iniciar Sesión</a>
        <?php endif; ?>

    </div>
</nav>


