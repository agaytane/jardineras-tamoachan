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
    
    <!-- Estilos adicionales inline (opcional) -->
    <style>
        /* Aquí puedes agregar estilos adicionales específicos si necesitas */
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            font-weight: 600;
            border-radius: 6px;
        }
        
        .dropdown-item.active {
            background-color: #4cd964;
            color: white !important;
        }
        
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
    </style>
</head>
<body>
    <!-- HEADER CON TU ESTILO JARDINERÍA -->
    <header class="header-jardin">
        <h1>
            <span class="logo-jardineria">🌿</span>
            Sistema de Gestión de Jardinería
        </h1>
        <div class="header-subtitle">
            Cultivando éxito, cosechando resultados
        </div>
        
        <!-- Menú de navegación -->
        <nav class="navbar navbar-expand-lg mt-3">
            <div class="container-fluid justify-content-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarJardin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarJardin">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo is_active('INICIO') ? 'active fw-bold' : ''; ?>" 
                               href="<?php echo route('INICIO'); ?>">
                                <i class="fas fa-home me-1"></i> Inicio
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" role="button" 
                               data-bs-toggle="dropdown">
                                <i class="fas fa-users me-1"></i> Personal
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item <?php echo is_active('EMPLEADOS') ? 'active' : ''; ?>" 
                                       href="<?php echo route('EMPLEADOS'); ?>">
                                        <i class="fas fa-user-tie me-2"></i> Empleados
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item <?php echo is_active('CLIENTES') ? 'active' : ''; ?>" 
                                       href="<?php echo route('CLIENTES'); ?>">
                                        <i class="fas fa-user-friends me-2"></i> Clientes
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" role="button" 
                               data-bs-toggle="dropdown">
                                <i class="fas fa-leaf me-1"></i> Productos
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item <?php echo is_active('PRODUCTOS') ? 'active' : ''; ?>" 
                                       href="<?php echo route('PRODUCTOS'); ?>">
                                        <i class="fas fa-box me-2"></i> Productos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item <?php echo is_active('GAMA') ? 'active' : ''; ?>" 
                                       href="<?php echo route('GAMA'); ?>">
                                        <i class="fas fa-tags me-2"></i> Gamas
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo is_active('PEDIDOS') ? 'active fw-bold' : ''; ?>" 
                               href="<?php echo route('PEDIDOS'); ?>">
                                <i class="fas fa-clipboard-list me-1"></i> Pedidos
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo is_active('OFICINAS') ? 'active fw-bold' : ''; ?>" 
                               href="<?php echo route('OFICINAS'); ?>">
                                <i class="fas fa-building me-1"></i> Oficinas
                            </a>
                        </li>
                        
                        <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link text-white dropdown-toggle d-flex align-items-center" href="#" role="button" 
                               data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                <div class="d-flex flex-column">
                                    <span class="small"><?php echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario'); ?></span>
                                    <small class="badge bg-light text-primary"><?php echo $_SESSION['usuario']['rol'] ?? 'User'; ?></small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?php echo route('LOGIN/LOGOUT'); ?>">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="contenido-principal">