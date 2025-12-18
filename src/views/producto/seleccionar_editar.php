<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>🔍 Seleccionar Producto a Editar</h2>
    </div>

    <div class="tarjeta-formulario">
        <form action="/PRODUCTOS/EDITAR" method="POST">
            <div class="grupo-formulario">
                <label class="form-label">Producto <span class="requerido">*</span></label>
                <select name="id" class="select-formulario" required>
                    <option value="">— Selecciona un producto —</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= htmlspecialchars($p['Id_producto'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($p['Nombre'] . ' - $' . number_format($p['Precio_venta'], 2), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-primario">
                    <i class="fas fa-search"></i> Buscar y Editar
                </button>
                <a href="/PRODUCTOS" class="btn btn-accion btn-secundario">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="/PRODUCTOS" class="btn btn-secundario">← Volver</a>
    </div>
</div>
