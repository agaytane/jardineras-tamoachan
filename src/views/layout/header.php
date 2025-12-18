<?php
// Verificar si las funciones de URL existen
if (!function_exists('base_url')) {
    die('Error: Helpers no cargados. Verifica index.php');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo_pagina) ? $titulo_pagina . ' - ' : ''; ?>Jardinería</title>
    
    <!-- Bootstrap CSS -->
    <link href="<?php echo asset('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Estilos personalizados de jardinería -->
    <link href="<?php echo asset('assets/css/estilos_jardineria.css'); ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Estilos adicionales inline -->
    <style>
        /* Asegurar que las alertas se vean bien */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        
        .alert-success {
            border-left: 4px solid #4cd964;
        }
        
        .alert-danger {
            border-left: 4px solid #ff3b30;
        }
        
        .alert-info {
            border-left: 4px solid #2b7cff;
        }
        
        /* Para mostrar mensajes de usuario si está logueado */
        .user-info {
            position: absolute;
            top: 20px;
            right: 40px;
            color: white;
            z-index: 2;
        }
        
        @media (max-width: 768px) {
            .user-info {
                position: static;
                text-align: center;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER CON TU ESTILO JARDINERÍA (SIN MENÚ) -->
    <header class="header-jardin">
        <h1>
            <span class="logo-jardineria">🌿</span>
            Sistema de Gestión de Jardinería
        </h1>
        <div class="header-subtitle">
            Cultivando éxito, cosechando resultados
        </div>
        
        <!-- Información del usuario (si está logueado) -->
        <?php if (isset($_SESSION['usuario'])): ?>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span class="ms-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario'); ?></span>
            <span class="badge bg-light text-primary ms-2"><?php echo $_SESSION['usuario']['rol'] ?? 'User'; ?></span>
            <a href="<?php echo route('LOGIN/LOGOUT'); ?>" class="btn btn-sm btn-light ms-3">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>
        <?php endif; ?>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="contenido-principal">