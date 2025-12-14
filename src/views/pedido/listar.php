<div class="container mt-5">
    <h2 class="mb-4">Listado de Pedidos</h2>

    <a href="/PEDIDO/CREAR" class="btn btn-success mb-3">➕ Nuevo Pedido</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Fecha Pedido</th>
                <th>Fecha Entrega</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Empleado</th>
                <th width="180">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['Id_pedido'] ?></td>
                <td><?= $p['Fecha_pedido'] ?></td>
                <td><?= $p['Fecha_entrega'] ?></td>
                <td><?= $p['Estado'] ?></td>
                <td><?= $p['Fk_id_cliente'] ?></td>
                <td><?= $p['Fk_id_empleado'] ?></td>
                <td>
                    <a href="/PEDIDO/EDITAR/<?= $p['Id_pedido'] ?>" class="btn btn-warning btn-sm">✏ Editar</a>
                    <a href="/PEDIDO/ELIMINAR/<?= $p['Id_pedido'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este pedido?')">🗑 Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
