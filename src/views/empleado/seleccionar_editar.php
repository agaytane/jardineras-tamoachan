<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Seleccionar Empleado</h1>
        <p class="subtitulo">Elige el empleado que deseas editar</p>
    </div>

    <div class="tarjeta-formulario">
        <form action="/EMPLEADOS/EDITAR" method="POST">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Empleado <span class="requerido">*</span>
                </label>
                <select name="id" class="select-formulario" required>
                    <option value="">-- Seleccione un empleado --</option>
                    <?php foreach ($empleados as $empleado): ?>
                        <option value="<?= htmlspecialchars($empleado['Id_empleado'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(($empleado['Nombre_emp'] ?? '') . ' ' . ($empleado['Apellido_emp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-warning">🔍 Buscar Empleado</button>
                <a href="/EMPLEADOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
