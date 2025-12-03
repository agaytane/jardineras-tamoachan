<h2>Clientes</h2>
<a href="index.php?c=cliente&a=crear" class="btn btn-success mb-3">Nuevo Cliente</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th>
    </tr>
    <?php foreach ($clientes as $c): ?>
    <tr>
        <td><?= $c['Id_cliente'] ?></td>
        <td><?= $c['Nombre_cte']." ".$c['Apellido_cte'] ?></td>
        <td><?= $c['Email_cte'] ?></td>
        <td><?= $c['Telefono_cte'] ?></td>
        <td><?= $c['Direccion_cte'] ?></td>
        <td>
            <a href="index.php?c=cliente&a=editar&id=<?= $c['Id_cliente'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="index.php?c=cliente&a=eliminar&id=<?= $c['Id_cliente'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
