<div class="container mt-5">
    <h2 class="mb-4">Listado de Pedidos</h2>

    <a href="/PEDIDOS/CREAR" class="btn btn-success mb-3">➕ Nuevo Pedido</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Fecha Pedido</th>
                <th>Fecha Entrega</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Empleado</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['Fecha_pedido'] ?></td>
                <td><?= $p['Fecha_entrega'] ?></td>
                <td><?= $p['Estado'] ?></td>
                <td><?= $p['Fk_id_cliente'] ?></td>
                <td><?= $p['Fk_id_empleado'] ?></td>
                
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
