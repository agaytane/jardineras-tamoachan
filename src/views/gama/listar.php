<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🌿 Gamas de Productos</h1>
        <p class="subtitulo">Categorías y líneas de productos</p>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h2>Listado de Gamas</h2>
            <a href="/GAMA/CREAR" class="btn-accion btn-primario">➕ Nueva Gama</a>
        </div>

        <?php if (empty($gamas)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #666;">
                <div style="font-size: 48px; margin-bottom: 20px;">📭</div>
                <h3 style="color: #333; margin-bottom: 10px;">No hay gamas registradas</h3>
                <p style="margin-bottom: 25px;">Comienza agregando una nueva gama de productos</p>
                <a href="/GAMA/CREAR" class="btn-accion btn-primario">➕ Crear Primera Gama</a>
            </div>
        <?php else: ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th style="width: 250px;">Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($gamas as $g): ?>
                    <tr>
                        <td><?= htmlspecialchars($g['Nombre_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($g['Descripcion_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
