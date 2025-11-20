<div class="container mt-4">
    <h2>Productos con Gama y Cantidad en Pedidos</h2>

    <?php if (empty($datos)): ?>
        <p>No hay registros.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Producto</th>
                    <th>Producto</th>
                    <th>Gama</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id_producto']) ?></td>
                        <td><?= htmlspecialchars($row['Producto']) ?></td>
                        <td><?= htmlspecialchars($row['Gama']) ?></td>
                        <td><?= htmlspecialchars($row['Cantidad']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
