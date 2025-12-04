<div class="container mt-5">
    <h2 class="mb-4">Listado de Oficinas</h2>

    <a href="/OFICINA/CREAR" class="btn btn-success mb-3">➕ Nueva Oficina</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Teléfono</th>
                <th>CP</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($oficinas as $o): ?>
            <tr>
                <td><?= $o['Id_oficina'] ?></td>
                <td><?= $o['Direccion'] ?></td>
                <td><?= $o['Ciudad'] ?></td>
                <td><?= $o['Telefono'] ?></td>
                <td><?= $o['Codigo_postal'] ?></td>
                <td>
                    <a href="/OFICINA/EDITAR/<?= $o['Id_oficina'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="/OFICINA/ELIMINAR/<?= $o['Id_oficina'] ?>" class="btn btn-danger btn-sm">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
