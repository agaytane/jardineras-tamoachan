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
