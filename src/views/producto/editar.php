<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>✏️ Editar Producto</h2>
    </div>

    <div class="tarjeta-formulario">
        <form action="/PRODUCTOS/ACTUALIZAR" method="POST">
            <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto['Id_producto'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="form-label">ID <span class="requerido">*</span></label>
                <input type="text" class="campo-formulario" value="<?= htmlspecialchars($producto['Id_producto'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Nombre <span class="requerido">*</span></label>
                <input type="text" name="nombre" class="campo-formulario" value="<?= htmlspecialchars($producto['Nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="textarea-formulario"><?= htmlspecialchars($producto['Descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Precio de Venta <span class="requerido">*</span></label>
                <input type="number" step="0.01" name="precio_venta" class="campo-formulario" value="<?= htmlspecialchars($producto['Precio_venta'] ?? '0.00', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Stock <span class="requerido">*</span></label>
                <input type="number" name="stock" class="campo-formulario" value="<?= htmlspecialchars($producto['Stock'] ?? '0', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Gama de Producto</label>
                <select name="fk_id_gama" class="select-formulario">
                    <option value="">-- Sin gama --</option>
                    <?php foreach ($gamas as $gama): ?>
                        <option value="<?= htmlspecialchars($gama['Id_gama'], ENT_QUOTES, 'UTF-8') ?>"
                            <?= ($producto['Fk_id_gama'] == $gama['Id_gama']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($gama['Nombre_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-primario">
                    <i class="fas fa-save"></i> Guardar Cambios
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

