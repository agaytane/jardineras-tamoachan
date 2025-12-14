<div class="container mt-5">
    <h2 class="mb-4">Listado de Clientes</h2>

    <a href="/CLIENTES/CREAR" class="btn btn-success mb-3">➕ Nuevo Cliente</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th width="180">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= $c['Id_cliente'] ?></td>
                <td><?= $c['Nombre_cte'] ?></td>
                <td><?= $c['Apellido_cte'] ?></td>
                <td><?= $c['Email_cte'] ?></td>
                <td><?= $c['Telefono_cte'] ?></td>
                <td><?= $c['Direccion_cte'] ?></td>
                <td>
                    <a href="/CLIENTES/EDITAR/<?= $c['Id_cliente'] ?>" class="btn btn-warning btn-sm">✏ Editar</a>
                    <a href="/CLIENTES/ELIMINAR/<?= $c['Id_cliente'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este cliente?')">🗑 Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
