<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Editar Empleado</h1>
        <p class="subtitulo">Actualizar información del empleado</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/EMPLEADOS/ACTUALIZAR">
            <input type="hidden" name="Id_empleado" value="<?= htmlspecialchars($empleado['Id_empleado'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nombre <span class="requerido">*</span>
                </label>
                <input type="text" name="Nombre_emp" class="campo-formulario" value="<?= htmlspecialchars($empleado['Nombre_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Apellido <span class="requerido">*</span>
                </label>
                <input type="text" name="Apellido_emp" class="campo-formulario" value="<?= htmlspecialchars($empleado['Apellido_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Email</label>
                <input type="email" name="Email_emp" class="campo-formulario" value="<?= htmlspecialchars($empleado['Email_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Teléfono</label>
                <input type="text" name="Telefono_emp" class="campo-formulario" value="<?= htmlspecialchars($empleado['Telefono_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Puesto <span class="requerido">*</span>
                </label>
                <select name="Puesto" class="select-formulario" required>
                    <option value="">-- Seleccione un puesto --</option>
                    <?php foreach ($puestos as $p): ?>
                        <option value="<?= htmlspecialchars($p ?? '', ENT_QUOTES, 'UTF-8') ?>" <?= ($empleado['Puesto'] ?? '') === $p ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Salario <span class="requerido">*</span>
                </label>
                <input type="number" step="0.01" min="0" name="Salario" class="campo-formulario" value="<?= htmlspecialchars($empleado['Salario'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Nombre del Jefe</label>
                <input type="text" name="Nombre_jefe" class="campo-formulario" value="<?= htmlspecialchars($empleado['Nombre_jefe'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Oficina <span class="requerido">*</span>
                </label>
                <select name="Fk_id_oficina" class="select-formulario" required>
                    <option value="">-- Seleccione una oficina --</option>
                    <?php foreach ($oficinas as $oficina): ?>
                        <option value="<?= htmlspecialchars($oficina['Id_oficina'] ?? '', ENT_QUOTES, 'UTF-8') ?>" <?= ($empleado['Fk_id_oficina'] ?? '') == $oficina['Id_oficina'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars(($oficina['Direccion'] ?? '') . ' - ' . ($oficina['Ciudad'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-success">✅ Actualizar Empleado</button>
                <a href="/EMPLEADOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>