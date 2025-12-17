<?php
/**
 * Helper para manejar URLs en la aplicación
 */

/**
 * Obtiene la URL base de la aplicación
 */
function base_url($path = '') {
    // Detectar protocolo
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) 
        ? 'https://' 
        : 'http://';
    
    // Obtener host
    $host = $_SERVER['HTTP_HOST'];
    
    // Ruta base (si está en subdirectorio)
    $base = ''; // Cambia si está en subdirectorio, ej: '/miapp'
    
    // Construir URL base
    $url = $protocol . $host . $base;
    
    // Agregar slash final
    if (!empty($path) || $path === '0') {
        $url .= '/' . ltrim($path, '/');
    }
    
    return $url;
}

/**
 * Redirige a una URL relativa
 */
function redirect($path) {
    header("Location: " . base_url($path));
    exit;
}

/**
 * Genera una URL para un recurso estático
 */
function asset($path) {
    return base_url($path);
}

/**
 * Genera una URL para una ruta de la aplicación
 */
function route($path) {
    return base_url($path);
}

/**
 * Obtiene la URL actual
 */
function current_url() {
    return base_url($_SERVER['REQUEST_URI']);
}

/**
 * Verifica si la URL actual coincide con un patrón
 */
function is_active($route, $exact = false) {
    $current = trim($_SERVER['REQUEST_URI'], '/');
    $route = trim($route, '/');
    
    if ($exact) {
        return $current === $route;
    }
    
    return strpos($current, $route) === 0;
}