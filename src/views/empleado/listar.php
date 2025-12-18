<?php
$titulo_pagina = "Listado de Empleados";
?>
<div class="contenedor-vista">
    <!-- ENCABEZADO -->
    <div class="encabezado-pagina">
        <h1>
            <i class="fas fa-users"></i>
            Listado de Empleados
        </h1>
        <p class="subtitulo">Todos los empleados registrados en el sistema</p>
    </div>

    <!-- BOTÓN NUEVO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="input-group" style="max-width: 300px;">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="campo-formulario" placeholder="Buscar empleado...">
        </div>
        
        <a href="<?php echo route('EMPLEADOS/CREAR'); ?>" class="btn-accion btn-success">
            <i class="fas fa-user-plus me-2"></i> Nuevo Empleado
        </a>
    </div>

    <!-- TABLA -->
    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h3>
                <i class="fas fa-list"></i>
                Empleados Registrados
            </h3>
            <span class="badge-estado badge-activo">Total: <?= count($empleados) ?> registros</span>
        </div>
        
        <table class="tabla-jardin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Puesto</th>
                    <th>Salario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td>
                        <span class="badge-estado">#<?= $empleado['Id_empleado'] ?></span>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($empleado['Nombre_emp'] . ' ' . $empleado['Apellido_emp']) ?></strong>
                    </td>
                    <td><?= htmlspecialchars($empleado['Email_emp'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($empleado['Puesto'] ?? 'N/A') ?></td>
                    <td>$<?= number_format($empleado['Salario'] ?? 0, 2) ?></td>
                    <td>
                        <span class="badge-estado badge-activo">Activo</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="<?php echo route('EMPLEADOS/EDITAR/' . $empleado['Id_empleado']); ?>" 
                               class="btn-accion btn-warning" style="padding: 8px 12px; min-width: auto;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo route('EMPLEADOS/ELIMINAR/' . $empleado['Id_empleado']); ?>" 
                               class="btn-accion btn-danger" style="padding: 8px 12px; min-width: auto;"
                               onclick="return confirm('¿Eliminar empleado?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- PAGINACIÓN (ejemplo) -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Mostrando 1-10 de <?= count($empleados) ?> registros
        </div>
        <div class="btn-group">
            <button class="btn-accion btn-secundario" style="padding: 8px 15px;">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn-accion btn-primario" style="padding: 8px 15px;">1</button>
            <button class="btn-accion btn-secundario" style="padding: 8px 15px;">2</button>
            <button class="btn-accion btn-secundario" style="padding: 8px 15px;">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>