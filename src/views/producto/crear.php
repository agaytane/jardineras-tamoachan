<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>🌱 Agregar Producto</h2>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/PRODUCTOS/CREAR">
            <div class="grupo-formulario">
                <label class="form-label">Nombre <span class="requerido">*</span></label>
                <input type="text" name="nombre" class="campo-formulario" placeholder="Nombre del producto" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="textarea-formulario" placeholder="Descripción detallada del producto"></textarea>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Precio de Venta <span class="requerido">*</span></label>
                <input type="number" step="0.01" min="0" name="precio_venta" class="campo-formulario" placeholder="0.00" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Stock <span class="requerido">*</span></label>
                <input type="number" min="0" name="stock" class="campo-formulario" placeholder="0" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Gama de Producto</label>
                <select name="fk_id_gama" class="select-formulario">
                    <option value="">-- Sin gama --</option>
                    <?php foreach ($gamas as $gama): ?>
                        <option value="<?= htmlspecialchars($gama['Id_gama'], ENT_QUOTES, 'UTF-8') ?>"
                            <?= (isset($_POST['fk_id_gama']) && $_POST['fk_id_gama'] == $gama['Id_gama']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($gama['Nombre_gama'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-primario">
                    <i class="fas fa-save"></i> Guardar Producto
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
