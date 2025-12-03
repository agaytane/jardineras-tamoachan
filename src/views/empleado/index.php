<h2 class="text-center mt-4">Lista de Empleados</h2>

<a href="index.php?c=empleado&a=crear" class="btn btn-success mb-3">Nuevo Empleado</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Puesto</th>
            <th>Salario</th>
            <th>Oficina</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($empleados as $e): ?>
        <tr>
            <td><?= $e['Id_empleado'] ?></td>
            <td><?= $e['Nombre_emp'] . " " . $e['Apellido_emp'] ?></td>
            <td><?= $e['Email_emp'] ?></td>
            <td><?= $e['Puesto'] ?></td>
            <td>$<?= $e['Salario'] ?></td>
            <td><?= $e['Fk_id_oficina'] ?></td>
            <td>
                <a href="index.php?c=empleado&a=editar&id=<?= $e['Id_empleado'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="index.php?c=empleado&a=eliminar&id=<?= $e['Id_empleado'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
