<div class="container mt-4">
    <h2>Empleados con Oficina y Pedidos</h2>

    <?php if (empty($datos)): ?>
        <p>No hay registros.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Empleado</th>
                    <th>Empleado</th>
                    <th>Oficina</th>
                    <th>ID Pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id_empleado']) ?></td>
                        <td><?= htmlspecialchars($row['Empleado']) ?></td>
                        <td><?= htmlspecialchars($row['Oficina']) ?></td>
                        <td><?= htmlspecialchars($row['Id_pedido']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
