<h2>Gamas de Productos</h2>
<a href="index.php?c=gama&a=crear" class="btn btn-success mb-3">Nueva Gama</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th>
    </tr>
    <?php foreach ($gamas as $g): ?>
    <tr>
        <td><?= $g['Id_gama'] ?></td>
        <td><?= $g['Nombre_gama'] ?></td>
        <td><?= $g['Descripcion_gama'] ?></td>
        <td>
            <a href="index.php?c=gama&a=editar&id=<?= $g['Id_gama'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="index.php?c=gama&a=eliminar&id=<?= $g['Id_gama'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
