<div class="container mt-5">
    <h2 class="mb-4">Editar Empleado</h2>

    <form method="POST" action="/EMPLEADOS/ACTUALIZAR">
        <input type="hidden" name="Id_empleado" value="<?= $empleado['Id_empleado'] ?>">

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="Nombre_emp" class="form-control" value="<?= htmlspecialchars($empleado['Nombre_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="Apellido_emp" class="form-control" value="<?= htmlspecialchars($empleado['Apellido_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="Email_emp" class="form-control" value="<?= htmlspecialchars($empleado['Email_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="Telefono_emp" class="form-control" value="<?= htmlspecialchars($empleado['Telefono_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="mb-3">
            <label>Puesto</label>
            <select name="Puesto" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($puestos as $p): ?>
                    <option value="<?= $p ?>" <?= ($empleado['Puesto'] ?? '') === $p ? 'selected' : '' ?>><?= $p ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Salario</label>
            <input type="number" step="0.01" min="0" name="Salario" class="form-control" value="<?= $empleado['Salario'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label>Nombre del Jefe</label>
            <input type="text" name="Nombre_jefe" class="form-control" value="<?= htmlspecialchars($empleado['Nombre_jefe'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="mb-3">
            <label>Seleccione la Oficina</label>
            <select name="Fk_id_oficina" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($oficinas as $oficina): ?>
                    <option value="<?= $oficina['Id_oficina'] ?>" <?= ($empleado['Fk_id_oficina'] ?? '') == $oficina['Id_oficina'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($oficina['Direccion'] . ' - ' . $oficina['Ciudad'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">✅ Guardar Cambios</button>
        <a href="/EMPLEADOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>