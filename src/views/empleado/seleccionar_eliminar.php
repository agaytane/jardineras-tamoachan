<div class="container mt-5">
    <h2 class="mb-4">Eliminar Empleado</h2>

    <form action="/EMPLEADOS/ELIMINAR" method="POST">
        <div class="mb-3">
            <label>Seleccione el Empleado</label>
            <select name="id" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($empleados as $empleado): ?>
                    <option value="<?= $empleado['Id_empleado'] ?>">
                        <?= htmlspecialchars(($empleado['Nombre_emp'] ?? '') . ' ' . ($empleado['Apellido_emp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-danger">🗑 Eliminar</button>
        <a href="/EMPLEADOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
