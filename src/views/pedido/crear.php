<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>📦 Nuevo Pedido</h1>
        <p class="subtitulo">Registrar un nuevo pedido en el sistema</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/PEDIDOS/GUARDAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Fecha Prevista <span class="requerido">*</span>
                </label>
                <input type="date" name="fecha_prevista" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Cliente <span class="requerido">*</span>
                </label>
                <select name="cliente" class="select-formulario" required>
                    <option value="">-- Seleccione un cliente --</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?= htmlspecialchars($c['Id_cliente'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(($c['Nombre_cte'] ?? '') . ' ' . ($c['Apellido_cte'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Empleado <span class="requerido">*</span>
                </label>
                <select name="empleado" class="select-formulario" required>
                    <option value="">-- Seleccione un empleado --</option>
                    <?php foreach ($empleados as $e): ?>
                        <option value="<?= htmlspecialchars($e['Id_empleado'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(($e['Nombre_emp'] ?? '') . ' ' . ($e['Apellido_emp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Productos</label>
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 10px;">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px; margin-bottom: 10px;">
                        <select name="productos[]" class="select-formulario">
                            <option value="">-- Seleccionar producto --</option>
                            <?php foreach ($productos as $p): ?>
                                <option value="<?= htmlspecialchars($p['Id_producto'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($p['Nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="cantidades[]" class="campo-formulario" min="1" placeholder="Cantidad">
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Comentarios</label>
                <textarea name="comentarios" class="textarea-formulario" rows="4"></textarea>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">✅ Guardar Pedido</button>
                <a href="/PEDIDOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
