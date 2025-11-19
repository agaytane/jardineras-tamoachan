<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Detalle de Pedidos — Vista</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <style>
        :root{
            --bg:#f6f7fb;
            --card:#fff;
            --muted:#666;
            --accent:#2b7cff;
            --border:#e1e6ef;
        }
        body{
            margin:0;
            font-family: Inter, system-ui, Arial, sans-serif;
            background:var(--bg);
            color:#222;
        }
        .container{
            max-width:1200px;
            margin:28px auto;
            padding:18px;
        }
        header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:18px;
        }
        h1{ margin:0; font-size:20px; }
        .card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:10px;
            padding:14px;
            box-shadow: 0 6px 18px rgba(30,40,80,0.03);
        }
        table{
            width:100%;
            border-collapse:collapse;
            font-size:14px;
        }
        thead th{
            text-align:left;
            padding:10px 12px;
            background:linear-gradient(180deg,#fbfdff,#f3f7ff);
            border-bottom:1px solid var(--border);
            position:sticky;
            top:0;
            z-index:2;
        }
        tbody td{
            padding:10px 12px;
            border-bottom:1px dashed #eee;
            vertical-align:middle;
        }
        tbody tr:nth-child(even){ background:#fcfdff; }
        .right{ text-align:right; }
        .muted{ color:var(--muted); font-size:13px; }
        .tot-row td{
            border-top:2px solid #ddd;
            font-weight:600;
            background:#fafbff;
        }
        .empty{
            padding:28px;
            text-align:center;
            color:var(--muted);
        }
        .small{
            font-size:13px;
            color:var(--muted);
        }
        /* responsive */
        @media (max-width:900px){
            thead th:nth-child(3), td:nth-child(3),
            thead th:nth-child(4), td:nth-child(4),
            thead th:nth-child(8), td:nth-child(8) { display:none; }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Detalle de Pedidos</h1>
        <div class="small">Vista: <strong>Vista_Detalle_Pedidos</strong></div>
    </header>

    <div class="card">
        <?php if (isset($error)): ?>
            <div class="empty"><?= htmlspecialchars($error) ?></div>
        <?php else: ?>

            <?php if (empty($detalles)): ?>
                <div class="empty">No hay registros en la vista.</div>
            <?php else: ?>

                <table aria-label="Detalle de pedidos">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Producto</th>
                            <th class="right">Precio Unitario</th>
                            <th class="right">Cantidad</th>
                            <th class="right">Subtotal</th>
                            <th class="right">Total Pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['Id_pedido']) ?></td>
                                <td class="small"><?= htmlspecialchars($row['Fecha_pedido']) ?></td>
                                <td><?= htmlspecialchars($row['Estado']) ?></td>
                                <td><?= htmlspecialchars($row['Cliente']) ?></td>
                                <td><?= htmlspecialchars($row['Empleado']) ?></td>
                                <td><?= htmlspecialchars($row['Producto']) ?></td>

                                <td class="right">
                                    <?= isset($row['PrecioUnitario']) ? number_format((float)$row['PrecioUnitario'],2) : '-' ?>
                                </td>
                                <td class="right">
                                    <?= isset($row['Cantidad']) ? (int)$row['Cantidad'] : '-' ?>
                                </td>
                                <td class="right">
                                    <?= isset($row['Subtotal']) ? number_format((float)$row['Subtotal'],2) : '-' ?>
                                </td>
                                <td class="right">
                                    <?= isset($row['Total_Pedido']) ? number_format((float)$row['Total_Pedido'],2) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>