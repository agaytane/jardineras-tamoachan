<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>📦 Pedidos</h1>
        <p class="subtitulo">Gestión de pedidos y entregas</p>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h2>Listado de Pedidos</h2>
            <a href="/PEDIDOS/CREAR" class="btn-accion btn-primario">➕ Nuevo Pedido</a>
        </div>

        <?php if (empty($pedidos)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #666;">
                <div style="font-size: 48px; margin-bottom: 20px;">📭</div>
                <h3 style="color: #333; margin-bottom: 10px;">No hay pedidos registrados</h3>
                <p style="margin-bottom: 25px;">Comienza agregando un nuevo pedido al sistema</p>
                <a href="/PEDIDOS/CREAR" class="btn-accion btn-primario">➕ Crear Primer Pedido</a>
            </div>
        <?php else: ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th style="width: 120px;">Fecha Pedido</th>
                        <th style="width: 120px;">Fecha Entrega</th>
                        <th style="width: 120px;">Estado</th>
                        <th style="width: 100px;">Cliente</th>
                        <th style="width: 100px;">Empleado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['Fecha_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($p['Fecha_entrega'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php 
                                $estado = strtolower($p['Estado'] ?? '');
                                $badgeClass = 'badge-pendiente';
                                if ($estado === 'entregado' || $estado === 'completado') {
                                    $badgeClass = 'badge-activo';
                                } elseif ($estado === 'cancelado' || $estado === 'rechazado') {
                                    $badgeClass = 'badge-inactivo';
                                }
                            ?>
                            <span class="badge-estado <?= $badgeClass ?>"><?= htmlspecialchars($p['Estado'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                        </td>
                        <td><?= htmlspecialchars($p['Fk_id_cliente'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($p['Fk_id_empleado'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
