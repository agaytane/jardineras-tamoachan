<div class="container mt-5">
    <h2 class="mb-4">Listado de Empleados</h2>

    <a href="/EMPLEADOS/CREAR" class="btn btn-success mb-3">➕ Nuevo Empleado</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Puesto</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Oficina</th>
                <th width="180">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($empleados as $e): ?>
            <tr>
                <td><?= $e['Id_empleado'] ?></td>
                <td><?= $e['Nombre_emp'] ?></td>
                <td><?= $e['Apellido_emp'] ?></td>
                <td><?= $e['Puesto'] ?></td>
                <td><?= $e['Email_emp'] ?></td>
                <td><?= $e['Telefono_emp'] ?></td>
                <td><?= $e['Fk_id_oficina'] ?></td>
                <td>
                    <a href="/EMPLEADOS/EDITAR/<?= $e['Id_empleado'] ?>" class="btn btn-warning btn-sm">✏ Editar</a>
                    <a href="/EMPLEADOS/ELIMINAR/<?= $e['Id_empleado'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este empleado?')">🗑 Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
