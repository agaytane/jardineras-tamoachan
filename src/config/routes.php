<?php

use App\Controllers\LoginController;
use App\Controllers\InicioController;
use App\Controllers\EmpleadoController;
use App\Controllers\ClienteController;
use App\Controllers\ProductoController;

/**
 * DEFINICIÓN DE RUTAS
 * 
 * Clave principal: Primera parte de la URL (Ej: /PRODUCTOS -> 'PRODUCTOS')
 * 'controller': Clase del controlador
 * 'actions': Mapeo de segunda parte URL -> Método y Roles
 *      - Clave: Sub-acción (Ej: /PRODUCTOS/CREAR -> 'CREAR')
 *      - 'method': Nombre del método en el controlador
 *      - 'roles': Array de roles permitidos. Si está vacío [], es accesible por cualquier usuario logueado.
 *      - 'public': (Opcional) true si no requiere login.
 */

return [
    'LOGIN' => [
        'controller' => LoginController::class,
        'public' => true,
        'actions' => [
            'INDEX' => ['method' => 'index', 'public' => true],
            'AUTENTICAR' => ['method' => 'autenticar', 'public' => true],
            'LOGOUT' => ['method' => 'logout', 'public' => true],
        ]
    ],
    'INICIO' => [
        'controller' => InicioController::class,
        'actions' => [
            'INDEX' => ['method' => 'index'],
        ]
    ],
    'EMPLEADOS' => [
        'controller' => EmpleadoController::class,
        'actions' => [
            'INDEX'      => ['method' => 'index'],
            'VER'        => ['method' => 'listar',      'roles' => ['ADMIN', 'GERENTE']],
            'CREAR'      => ['method' => 'crear',       'roles' => ['ADMIN', 'GERENTE']],
            'GUARDAR'    => ['method' => 'guardar',     'roles' => ['ADMIN', 'GERENTE']],
            'EDITAR'     => ['method' => 'editar',      'roles' => ['ADMIN', 'GERENTE']],
            'ACTUALIZAR' => ['method' => 'actualizar',  'roles' => ['ADMIN', 'GERENTE']],
            'ELIMINAR'   => ['method' => 'eliminar',    'roles' => ['ADMIN']]
        ]
    ],
    'CLIENTES' => [
        'controller' => ClienteController::class,
        'actions' => [
            'INDEX'      => ['method' => 'index'],
            'VER'        => ['method' => 'listar'],     // Todos logueados pueden ver clientes? (Segun index original si, pero en router switch estaba raro, aqui asumo todos)
            'CREAR'      => ['method' => 'crear',       'roles' => ['ADMIN', 'GERENTE']],
            'GUARDAR'    => ['method' => 'guardar',     'roles' => ['ADMIN', 'GERENTE']],
            'EDITAR'     => ['method' => 'editar',      'roles' => ['ADMIN', 'GERENTE']],
            'ACTUALIZAR' => ['method' => 'actualizar',  'roles' => ['ADMIN', 'GERENTE']],
            'ELIMINAR'   => ['method' => 'eliminar',    'roles' => ['ADMIN']]
        ]
    ],
    'PRODUCTOS' => [
        'controller' => ProductoController::class,
        'actions' => [
            'INDEX'      => ['method' => 'index'],
            'VER'        => ['method' => 'listar'],
            'CREAR'      => ['method' => 'crear',       'roles' => ['ADMIN', 'INVENTARIO']],
            'GUARDAR'    => ['method' => 'guardar',     'roles' => ['ADMIN', 'INVENTARIO']],
            'EDITAR'     => ['method' => 'editar',      'roles' => ['ADMIN', 'INVENTARIO']],
            'ACTUALIZAR' => ['method' => 'actualizar',  'roles' => ['ADMIN', 'INVENTARIO']],
            'ELIMINAR'   => ['method' => 'eliminar',    'roles' => ['ADMIN']]
        ]
    ]
];
