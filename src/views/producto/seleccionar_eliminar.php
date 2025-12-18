<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>⚠️ Eliminar Producto</h2>
    </div>

    <div class="tarjeta-formulario">
        <form action="/PRODUCTOS/ELIMINAR" method="POST">
            <div class="grupo-formulario">
                <label class="form-label">Producto <span class="requerido">*</span></label>
                <select name="id" class="select-formulario" required>
                    <option value="">— Selecciona un producto —</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= htmlspecialchars($p['Id_producto'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($p['Nombre'] . ' - Stock: ' . $p['Stock'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="background: linear-gradient(135deg, #ffe6e6 0%, #f9d4d4 100%); border-left: 5px solid #ff3b30; padding: 15px 20px; border-radius: 8px; margin: 20px 0; color: #721c24;">
                <i class="fas fa-exclamation-triangle"></i> <strong>Advertencia:</strong> Esta acción es irreversible. Una vez eliminado, no podrá recuperar los datos de este producto.
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-danger" onclick="return confirm('¿Estás completamente seguro? Esta acción no se puede deshacer.')">
                    <i class="fas fa-trash"></i> Eliminar Definitivamente
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
