<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🏢 Oficinas</h1>
        <p class="subtitulo">Gestión de oficinas y ubicaciones</p>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h2>Listado de Oficinas</h2>
            <a href="/OFICINAS/CREAR" class="btn-accion btn-primario">➕ Nueva Oficina</a>
        </div>

        <?php if (empty($oficinas)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #666;">
                <div style="font-size: 48px; margin-bottom: 20px;">📭</div>
                <h3 style="color: #333; margin-bottom: 10px;">No hay oficinas registradas</h3>
                <p style="margin-bottom: 25px;">Comienza agregando una nueva oficina al sistema</p>
                <a href="/OFICINAS/CREAR" class="btn-accion btn-primario">➕ Crear Primera Oficina</a>
            </div>
        <?php else: ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th>Dirección</th>
                        <th style="width: 150px;">Ciudad</th>
                        <th style="width: 150px;">Provincia</th>
                        <th style="width: 120px;">Teléfono</th>
                        <th style="width: 100px;">CP</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($oficinas as $o): ?>
                    <tr>
                        <td><?= htmlspecialchars($o['Direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($o['Ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($o['Provincia'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($o['Telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($o['Codigo_postal'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
