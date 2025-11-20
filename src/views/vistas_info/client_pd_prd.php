<div class="container mt-4">
    <h2>Clientes con Pedidos y Productos</h2>

    <?php if (empty($datos)): ?>
        <p>No hay registros.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Cliente</th>
                    <th>Cliente</th>
                    <th>ID Pedido</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id_cliente']) ?></td>
                        <td><?= htmlspecialchars($row['Cliente']) ?></td>
                        <td><?= htmlspecialchars($row['Id_pedido']) ?></td>
                        <td><?= htmlspecialchars($row['Producto']) ?></td>
                        <td><?= htmlspecialchars($row['Cantidad']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
