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
                        <th style="width: 50px;">Ver</th>
                        <th style="width: 120px;">Fecha Pedido</th>
                        <th style="width: 120px;">Fecha Prevista</th>
                        <th style="width: 120px;">Fecha Entrega</th>
                        <th style="width: 140px;">Estado</th>
                        <th style="width: 180px;">Cliente</th>
                        <th style="width: 180px;">Empleado</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $p): ?>
                    <?php 
                        // Datos base y formatos
                        $fechaPedido   = htmlspecialchars($p['Fecha_pedido']   ?? '', ENT_QUOTES, 'UTF-8');
                        $fechaPrevista = htmlspecialchars($p['Fecha_prevista'] ?? ($p['FechaPrevista'] ?? ''), ENT_QUOTES, 'UTF-8');
                        $fechaEntrega  = htmlspecialchars($p['Fecha_entrega']  ?? '', ENT_QUOTES, 'UTF-8');

                        $estadoRaw  = $p['Estado'] ?? '';
                        $estado     = strtolower($estadoRaw);
                        $badgeClass = 'badge-pendiente';
                        if ($estado === 'entregado' || $estado === 'completado') {
                            $badgeClass = 'badge-activo';
                        } elseif ($estado === 'cancelado' || $estado === 'rechazado') {
                            $badgeClass = 'badge-inactivo';
                        }

                        // Atraso si está pendiente y fecha prevista vencida
                        $hoy = date('Y-m-d');
                        $vencido = false;
                        if (!empty($p['Fecha_prevista']) && $estado === 'pendiente') {
                            $vencido = ($p['Fecha_prevista'] < $hoy);
                        }

                        // Cliente y empleado con nombre amigable si está disponible
                        $clienteNombre = trim(($p['Cliente'] ?? (($p['Nombre_cte'] ?? '') . ' ' . ($p['Apellido_cte'] ?? ''))));
                        if ($clienteNombre === '') {
                            $clienteNombre = (string)($p['Fk_id_cliente'] ?? '');
                        }

                        $empleadoNombre = trim(($p['Empleado'] ?? (($p['Nombre_emp'] ?? '') . ' ' . ($p['Apellido_emp'] ?? ''))));
                        if ($empleadoNombre === '') {
                            $empleadoNombre = (string)($p['Fk_id_empleado'] ?? '');
                        }

                        // Notas (comentarios) recortadas
                        $comentarios = $p['Comentarios'] ?? '';
                        $resumenNotas = $comentarios !== '' ? mb_strimwidth($comentarios, 0, 80, '…', 'UTF-8') : '';
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <button onclick="toggleDetalles(<?= htmlspecialchars($p['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?>)" 
                                    class="btn-accion btn-secundario" 
                                    style="padding: 4px 8px; font-size: 12px;" 
                                    title="Ver detalles de productos">
                                📋
                            </button>
                        </td>
                        <td><?= $fechaPedido ?></td>
                        <td><?= $fechaPrevista ?></td>
                        <td><?= $fechaEntrega ?></td>
                        <td>
                            <span class="badge-estado <?= $badgeClass ?>"><?= htmlspecialchars($estadoRaw, ENT_QUOTES, 'UTF-8') ?></span>
                            <?php if ($vencido): ?>
                                <span class="badge-estado badge-inactivo" style="margin-left: 6px;">⚠️ Vencido</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($clienteNombre, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($empleadoNombre, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($resumenNotas, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <tr id="detalles-<?= htmlspecialchars($p['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?>" style="display: none;">
                        <td colspan="8" style="background: #f8f9fa; padding: 20px;">
                            <div style="max-width: 900px; margin: 0 auto;">
                                <h4 style="margin-bottom: 15px; color: #333;">📦 Productos del Pedido #<?= htmlspecialchars($p['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                                <div class="detalles-productos-cargando" data-pedido="<?= htmlspecialchars($p['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    <p style="color: #666;">Cargando detalles...</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php if (!empty($comentarios)): ?>
                        <tr>
                            <td colspan="7" style="background: #fafafa; color: #555;">
                                📝 <strong>Comentarios:</strong> <?= htmlspecialchars($comentarios, ENT_QUOTES, 'UTF-8') ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
let detallesCache = {};

function toggleDetalles(pedidoId) {
    const row = document.getElementById('detalles-' + pedidoId);
    if (!row) return;

    if (row.style.display === 'none') {
        row.style.display = 'table-row';
        if (!detallesCache[pedidoId]) {
            cargarDetalles(pedidoId);
        }
    } else {
        row.style.display = 'none';
    }
}

async function cargarDetalles(pedidoId) {
    const container = document.querySelector(`.detalles-productos-cargando[data-pedido="${pedidoId}"]`);
    if (!container) return;

    try {
        const response = await fetch(`/PEDIDOS/DETALLES/${pedidoId}`);
        const data = await response.json();

        if (data.success && data.detalles && data.detalles.length > 0) {
            let html = '<table style="width: 100%; border-collapse: collapse;">';
            html += '<thead><tr style="background: #e9ecef;">';
            html += '<th style="padding: 10px; text-align: left; border: 1px solid #dee2e6;">Producto</th>';
            html += '<th style="padding: 10px; text-align: center; border: 1px solid #dee2e6; width: 100px;">Cantidad</th>';
            html += '<th style="padding: 10px; text-align: right; border: 1px solid #dee2e6; width: 120px;">Precio Unit.</th>';
            html += '<th style="padding: 10px; text-align: right; border: 1px solid #dee2e6; width: 120px;">Subtotal</th>';
            html += '</tr></thead><tbody>';

            let total = 0;
            data.detalles.forEach(d => {
                const subtotal = d.Cantidad * d.Precio_venta;
                total += subtotal;
                html += '<tr>';
                html += `<td style="padding: 10px; border: 1px solid #dee2e6;">${escapeHtml(d.Nombre || 'N/A')}</td>`;
                html += `<td style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">${d.Cantidad}</td>`;
                html += `<td style="padding: 10px; text-align: right; border: 1px solid #dee2e6;">$${Number(d.Precio_venta).toFixed(2)}</td>`;
                html += `<td style="padding: 10px; text-align: right; border: 1px solid #dee2e6;">$${subtotal.toFixed(2)}</td>`;
                html += '</tr>';
            });

            html += '<tr style="background: #f8f9fa; font-weight: bold;">';
            html += '<td colspan="3" style="padding: 12px; text-align: right; border: 1px solid #dee2e6;">Total:</td>';
            html += `<td style="padding: 12px; text-align: right; border: 1px solid #dee2e6;">$${total.toFixed(2)}</td>`;
            html += '</tr>';
            html += '</tbody></table>';

            container.innerHTML = html;
            detallesCache[pedidoId] = true;
        } else {
            container.innerHTML = '<p style="color: #999;">Sin productos asociados</p>';
        }
    } catch (error) {
        container.innerHTML = '<p style="color: #dc3545;">Error al cargar detalles</p>';
    }
}

function escapeHtml(text) {
    const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
    return String(text).replace(/[&<>"']/g, m => map[m]);
}
</script>
