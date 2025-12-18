<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>⚠️ Eliminar Cliente</h2>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/CLIENTES/ELIMINAR">
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

            <div style="background: linear-gradient(135deg, #ffe6e6 0%, #f9d4d4 100%); border-left: 5px solid #ff3b30; padding: 15px 20px; border-radius: 8px; margin: 20px 0; color: #721c24;">
                <i class="fas fa-exclamation-triangle"></i> <strong>Advertencia:</strong> Esta acción es irreversible. Una vez eliminado, no podrá recuperar los datos de este cliente.
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-danger" onclick="return confirm('¿Estás completamente seguro? Esta acción no se puede deshacer.')">
                    <i class="fas fa-trash"></i> Eliminar Definitivamente
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
