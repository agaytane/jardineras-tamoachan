<div class="container mt-5">
    <h2 class="mb-4">Listado de Clientes</h2>

    <a href="/CLIENTE/CREAR" class="btn btn-success mb-3">➕ Nuevo Cliente</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= $c['Id_cliente'] ?></td>
                <td><?= $c['Nombre_cte'] ?></td>
                <td><?= $c['Apellido_cte'] ?></td>
                <td><?= $c['Telefono_cte'] ?></td>
                <td><?= $c['Direccion_cte'] ?></td>
                <td>
                    <a href="/CLIENTE/EDITAR/<?= $c['Id_cliente'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="/CLIENTE/ELIMINAR/<?= $c['Id_cliente'] ?>" class="btn btn-danger btn-sm">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
