<div class="container mt-5">
    <h2 class="mb-4">Agregar Empleado</h2>

    <form method="POST" action="/EMPLEADOS/CREAR">

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="Nombre_emp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="Apellido_emp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="Email_emp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="Telefono_emp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Puesto</label>
            <select name="Puesto" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($puestos as $p): ?>
                    <option value="<?= $p ?>"><?= $p ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Salario</label>
            <input type="number" step="0.01" min="0" name="Salario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nombre del Jefe</label>
            <input type="text" name="Nombre_jefe" class="form-control">
        </div>

        <div class="mb-3">
            <label>Seleccione la Oficina</label>
            <select name="Fk_id_oficina" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($oficinas as $oficina): ?>
                    <option value="<?= $oficina['Id_oficina'] ?>">
                        <?= htmlspecialchars($oficina['Direccion'] . ' - ' . $oficina['Ciudad']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="/EMPLEADOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
