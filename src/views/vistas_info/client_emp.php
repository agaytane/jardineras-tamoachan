<div class="container mt-4">
    <h2>Pedidos con Cliente y Empleado</h2>

    <?php if (empty($datos)): ?>
        <p>No hay registros.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha Pedido</th>
                    <th>Cliente</th>
                    <th>Empleado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id_pedido']) ?></td>
                        <td><?= htmlspecialchars($row['Fecha_pedido']) ?></td>
                        <td><?= htmlspecialchars($row['Cliente']) ?></td>
                        <td><?= htmlspecialchars($row['Empleado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
