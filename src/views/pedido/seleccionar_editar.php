<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Seleccionar Pedido</h1>
        <p class="subtitulo">Elige el pedido que deseas editar</p>
    </div>

    <div class="tarjeta-formulario">
        <form action="/PEDIDOS/EDITAR" method="POST">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Pedido <span class="requerido">*</span>
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
                <button type="submit" class="btn-accion btn-warning">🔍 Buscar Pedido</button>
                <a href="/PEDIDOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>

