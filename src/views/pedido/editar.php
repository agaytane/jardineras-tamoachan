<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Editar Pedido</h1>
        <p class="subtitulo">Actualizar información del pedido</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/PEDIDOS/EDITAR">
            <input type="hidden" name="id" value="<?= htmlspecialchars($pedido['Id_pedido'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Fecha de Entrega</label>
                <input type="date" name="Fecha_entrega" class="campo-formulario" value="<?= htmlspecialchars($pedido['Fecha_entrega'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
                <small style="color:#666; display:block; margin-top:6px;">Se define automáticamente al marcar el estado como "Entregado".</small>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Estado <span class="requerido">*</span>
                </label>
                <select name="Estado" class="select-formulario" required>
                    <option value="Pendiente" <?= ($pedido['Estado'] ?? '') == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Entregado" <?= ($pedido['Estado'] ?? '') == 'Entregado' ? 'selected' : '' ?>>Entregado</option>
                    <option value="Cancelado" <?= ($pedido['Estado'] ?? '') == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Comentarios</label>
                <textarea name="Comentarios" class="textarea-formulario" rows="4"><?= htmlspecialchars($pedido['Comentarios'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-success">✅ Actualizar Pedido</button>
                <a href="/PEDIDOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
