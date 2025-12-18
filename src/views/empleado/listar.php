<div class="container mt-5">
    <h2 class="mb-4">Listado de Empleados</h2>

    <a href="/EMPLEADOS/CREAR" class="btn btn-success mb-3">➕ Nuevo Empleado</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>

                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Puesto</th>
                <th>Salario</th>
                <th>Jefe</th>
                <th>Oficina</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($empleados as $e): ?>
            <tr>

                <td><?= htmlspecialchars($e['Nombre_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Apellido_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Email_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Telefono_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Puesto'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Salario'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Nombre_jefe'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($e['Fk_id_oficina'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

