<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🗑️ Eliminar Pedido</h1>
        <p class="subtitulo">Selecciona el pedido que deseas eliminar</p>
    </div>

    <div class="tarjeta-formulario">
        <div style="background: linear-gradient(135deg, #ffe6e6 0%, #f9d4d4 100%); border-left: 5px solid #ff3b30; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <h3 style="color: #d32f2f; margin: 0 0 10px 0; font-size: 18px;">⚠️ Advertencia</h3>
            <p style="color: #666; margin: 0;">Esta acción eliminará permanentemente el pedido seleccionado. Esta operación no se puede deshacer.</p>
        </div>

        <form action="/PEDIDOS/ELIMINAR" method="POST" onsubmit="return confirm('¿ Está completamente seguro de eliminar este pedido? Esta acción es PERMANENTE.')">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Pedido a eliminar <span class="requerido">*</span>
                </label>
                <select name="id" class="select-formulario" required>
                    <option value="">-- Seleccione un pedido --</option>
                    <?php foreach ($pedidos as $pedido): ?>
                        <option value="<?= htmlspecialchars($pedido['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            Pedido #<?= htmlspecialchars($pedido['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($pedido['Fecha_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($pedido['Estado'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-danger">🗑 Eliminar Pedido</button>
                <a href="/PEDIDOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
