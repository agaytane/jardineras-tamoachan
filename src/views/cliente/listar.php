<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>👥 Listado de Clientes</h2>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h3>Gestión de Clientes</h3>
            <a href="/CLIENTES/CREAR" class="btn btn-success">
                ➕ Nuevo Cliente
            </a>
        </div>

        <?php if (!empty($clientes)): ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th style="width: 120px;">Teléfono</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['Nombre_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($c['Apellido_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($c['Email_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($c['Telefono_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($c['Direccion_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #999;">
                <p style="font-size: 18px; margin-bottom: 20px;">📭 No hay clientes registrados</p>
                <a href="/CLIENTES/CREAR" class="btn btn-primario">
                    Crear Primer Cliente
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="/INICIO" class="btn btn-secundario">← Volver al Inicio</a>
    </div>
</div>
