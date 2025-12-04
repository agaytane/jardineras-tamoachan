<div class="container mt-5">
    <h2 class="mb-4">Listado de Gamas</h2>

    <a href="/GAMA/CREAR" class="btn btn-success mb-3">➕ Nueva Gama</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($gamas as $g): ?>
            <tr>
                <td><?= $g['Id_gama'] ?></td>
                <td><?= $g['Nombre_gama'] ?></td>
                <td><?= $g['Descripcion_gama'] ?></td>
                <td>
                    <a href="/GAMA/EDITAR/<?= $g['Id_gama'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="/GAMA/ELIMINAR/<?= $g['Id_gama'] ?>" class="btn btn-danger btn-sm">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
