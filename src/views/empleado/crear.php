<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>👥 Nuevo Empleado</h1>
        <p class="subtitulo">Registrar un nuevo empleado en el sistema</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/EMPLEADOS/CREAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nombre <span class="requerido">*</span>
                </label>
                <input type="text" name="Nombre_emp" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Apellido <span class="requerido">*</span>
                </label>
                <input type="text" name="Apellido_emp" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Email</label>
                <input type="email" name="Email_emp" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Teléfono</label>
                <input type="text" name="Telefono_emp" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Puesto <span class="requerido">*</span>
                </label>
                <select name="Puesto" class="select-formulario" required>
                    <option value="">-- Seleccione un puesto --</option>
                    <?php foreach ($puestos as $p): ?>
                        <option value="<?= htmlspecialchars($p ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($p ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Salario <span class="requerido">*</span>
                </label>
                <input type="number" step="0.01" min="0" name="Salario" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Nombre del Jefe</label>
                <input type="text" name="Nombre_jefe" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Oficina <span class="requerido">*</span>
                </label>
                <select name="Fk_id_oficina" class="select-formulario" required>
                    <option value="">-- Seleccione una oficina --</option>
                    <?php foreach ($oficinas as $oficina): ?>
                        <option value="<?= htmlspecialchars($oficina['Id_oficina'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(($oficina['Direccion'] ?? '') . ' - ' . ($oficina['Ciudad'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">✅ Guardar Empleado</button>
                <a href="/EMPLEADOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
