<?php
$titulo_pagina = "Editar Empleado";
?>
<div class="contenedor-vista">
    <!-- ENCABEZADO -->
    <div class="encabezado-pagina">
        <h1>
            <i class="fas fa-user-edit"></i>
            Editar Empleado
        </h1>
        <p class="subtitulo">Modifica la información del empleado seleccionado</p>
    </div>

    <!-- FORMULARIO -->
    <div class="tarjeta-formulario">
        <form method="POST" action="<?php echo route('EMPLEADOS/ACTUALIZAR'); ?>">
            <input type="hidden" name="Id_empleado" value="<?= $empleado['Id_empleado'] ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="grupo-formulario">
                        <label for="Nombre_emp">
                            <i class="fas fa-user me-1"></i>
                            Nombre <span class="requerido">*</span>
                        </label>
                        <input type="text" 
                               id="Nombre_emp" 
                               name="Nombre_emp" 
                               class="campo-formulario" 
                               value="<?= htmlspecialchars($empleado['Nombre_emp'] ?? '') ?>" 
                               required
                               placeholder="Ingrese el nombre">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="grupo-formulario">
                        <label for="Apellido_emp">
                            <i class="fas fa-user me-1"></i>
                            Apellido <span class="requerido">*</span>
                        </label>
                        <input type="text" 
                               id="Apellido_emp" 
                               name="Apellido_emp" 
                               class="campo-formulario" 
                               value="<?= htmlspecialchars($empleado['Apellido_emp'] ?? '') ?>" 
                               required
                               placeholder="Ingrese el apellido">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="grupo-formulario">
                        <label for="Email_emp">
                            <i class="fas fa-envelope me-1"></i>
                            Email
                        </label>
                        <input type="email" 
                               id="Email_emp" 
                               name="Email_emp" 
                               class="campo-formulario" 
                               value="<?= htmlspecialchars($empleado['Email_emp'] ?? '') ?>"
                               placeholder="correo@ejemplo.com">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="grupo-formulario">
                        <label for="Telefono_emp">
                            <i class="fas fa-phone me-1"></i>
                            Teléfono
                        </label>
                        <input type="tel" 
                               id="Telefono_emp" 
                               name="Telefono_emp" 
                               class="campo-formulario" 
                               value="<?= htmlspecialchars($empleado['Telefono_emp'] ?? '') ?>"
                               placeholder="(123) 456-7890">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="grupo-formulario">
                        <label for="Puesto">
                            <i class="fas fa-briefcase me-1"></i>
                            Puesto
                        </label>
                        <input type="text" 
                               id="Puesto" 
                               name="Puesto" 
                               class="campo-formulario" 
                               value="<?= htmlspecialchars($empleado['Puesto'] ?? '') ?>"
                               placeholder="Ej: Gerente, Vendedor, etc.">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="grupo-formulario">
                        <label for="Salario">
                            <i class="fas fa-dollar-sign me-1"></i>
                            Salario
                        </label>
                        <input type="number" 
                               id="Salario" 
                               name="Salario" 
                               step="0.01" 
                               class="campo-formulario" 
                               value="<?= $empleado['Salario'] ?? '' ?>"
                               placeholder="0.00">
                    </div>
                </div>
            </div>
            
            <!-- BOTONES -->
            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">
                    <i class="fas fa-save me-2"></i> Actualizar
                </button>
                
                <a href="<?php echo route('EMPLEADOS'); ?>" class="btn-accion btn-secundario">
                    <i class="fas fa-times me-2"></i> Cancelar
                </a>
                
                <a href="<?php echo route('EMPLEADOS/ELIMINAR/' . ($empleado['Id_empleado'] ?? '')); ?>" 
                   class="btn-accion btn-danger"
                   onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
                    <i class="fas fa-trash me-2"></i> Eliminar
                </a>
            </div>
        </form>
    </div>
</div>