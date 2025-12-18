<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🗑️ Eliminar Empleado</h1>
        <p class="subtitulo">Selecciona el empleado que deseas eliminar</p>
    </div>

    <div class="tarjeta-formulario">
        <div style="background: linear-gradient(135deg, #ffe6e6 0%, #f9d4d4 100%); border-left: 5px solid #ff3b30; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <h3 style="color: #d32f2f; margin: 0 0 10px 0; font-size: 18px;">⚠️ Advertencia</h3>
            <p style="color: #666; margin: 0;">Esta acción eliminará permanentemente el empleado seleccionado. Esta operación no se puede deshacer.</p>
        </div>

        <form action="/EMPLEADOS/ELIMINAR" method="POST" onsubmit="return confirm('¿ Está completamente seguro de eliminar este empleado? Esta acción es PERMANENTE.')">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Empleado a eliminar <span class="requerido">*</span>
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
                <button type="submit" class="btn-accion btn-danger">🗑 Eliminar Empleado</button>
                <a href="/EMPLEADOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
