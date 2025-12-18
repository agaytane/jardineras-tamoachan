<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>🔍 Seleccionar Cliente a Editar</h2>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/CLIENTES/EDITAR">
            <div class="grupo-formulario">
                <label class="form-label">Cliente <span class="requerido">*</span></label>
                <?php if (!empty($clientes) && is_array($clientes)): ?>
                    <select name="id" class="select-formulario" required>
                        <option value="">— Selecciona un cliente —</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= htmlspecialchars($c['Id_cliente'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($c['Nombre_cte'] . ' ' . $c['Apellido_cte'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <p class="text-muted">No hay clientes disponibles</p>
                <?php endif; ?>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-primario">
                    <i class="fas fa-search"></i> Buscar y Editar
                </button>
                <a href="/CLIENTES" class="btn btn-accion btn-secundario">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="/CLIENTES" class="btn btn-secundario">← Volver</a>
    </div>
</div>
