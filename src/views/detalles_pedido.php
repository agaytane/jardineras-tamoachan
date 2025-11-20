<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalle de Pedidos</h1>
        <small>Vista: <strong>Vista_Detalle_Pedidos</strong></small>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-warning text-center"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>

        <?php if (empty($detalles)): ?>
            <div class="alert alert-info text-center">No hay registros en la vista.</div>
        <?php else: ?>

            <?php
           
               //AGRUPAMOS EL RESULTADO POR ID_PEDIDO
              
            $agrupado = [];

            foreach ($detalles as $row) {
                $id = $row['Id_pedido'];

                // si no existe, inicializamos
                if (!isset($agrupado[$id])) {
                    $agrupado[$id] = [
                        'Id_pedido'     => $id,
                        'Fecha_pedido'  => $row['Fecha_pedido'],
                        'Estado'        => $row['Estado'],
                        'Cliente'       => $row['Cliente'],
                        'Empleado'      => $row['Empleado'],
                        'Total_Pedido'  => $row['Total_Pedido'] ?? 0,
                        'Productos'     => []
                    ];
                }

                // Agregamos producto al array
                $agrupado[$id]['Productos'][] = [
                    'Producto'        => $row['Producto'],
                    'Cantidad'        => $row['Cantidad'],
                    'PrecioUnitario'  => $row['PrecioUnitario'],
                    'Subtotal'        => $row['Subtotal']
                ];
            }
            ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Detalle de Productos</th>
                            <th class="text-end">Total Pedido</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($agrupado as $pedido): ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido['Id_pedido']) ?></td>
                            <td><?= htmlspecialchars($pedido['Fecha_pedido']) ?></td>
                            <td><?= htmlspecialchars($pedido['Estado']) ?></td>
                            <td><?= htmlspecialchars($pedido['Cliente']) ?></td>
                            <td><?= htmlspecialchars($pedido['Empleado']) ?></td>

                            <td>
                                <ul class="mb-0">
                                <?php foreach ($pedido['Productos'] as $prod): ?>
                                    <li>
                                        <strong><?= htmlspecialchars($prod['Producto']) ?></strong>
                                        — Cant: <?= (int)$prod['Cantidad'] ?>
                                        — PU: <?= number_format((float)$prod['PrecioUnitario'], 2) ?>
                                        — Sub: <?= number_format((float)$prod['Subtotal'], 2) ?>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </td>

                            <td class="text-end">
                                <?= number_format((float)$pedido['Total_Pedido'], 2) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    <?php endif; ?>
</div>
