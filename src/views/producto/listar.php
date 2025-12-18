<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>🌱 Listado de Productos</h2>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h3>Gestión de Productos</h3>
            <a href="/PRODUCTOS/CREAR" class="btn btn-success">
                ➕ Nuevo Producto
            </a>
        </div>

        <?php if (!empty($productos)): ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="width: 100px;">Precio</th>
                        <th style="width: 80px;">Stock</th>
                        <th>Gama</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['Nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($p['Descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>$<?= htmlspecialchars($p['Precio_venta'] ?? '0.00', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php 
                                $stock = intval($p['Stock'] ?? 0);
                                $badgeClass = $stock > 10 ? 'badge-activo' : ($stock > 0 ? 'badge-pendiente' : 'badge-inactivo');
                                $stockText = $stock > 0 ? $stock . ' un.' : 'Sin stock';
                            ?>
                            <span class="badge-estado <?= $badgeClass ?>"><?= $stockText ?></span>
                        </td>
                        <td><?= htmlspecialchars($p['Fk_id_gama'] ?? 'Sin gama', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #999;">
                <p style="font-size: 18px; margin-bottom: 20px;">📭 No hay productos registrados</p>
                <a href="/PRODUCTOS/CREAR" class="btn btn-primario">
                    Crear Primer Producto
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="/INICIO" class="btn btn-secundario">← Volver al Inicio</a>
    </div>
</div>
