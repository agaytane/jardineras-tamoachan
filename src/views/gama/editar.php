<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Editar Gama</h1>
        <p class="subtitulo">Actualizar información de la gama de productos</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/GAMA/ACTUALIZAR">
            <input type="hidden" name="Id_gama" value="<?= htmlspecialchars($gama['Id_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nombre <span class="requerido">*</span>
                </label>
                <input type="text" name="Nombre_gama" class="campo-formulario" value="<?= htmlspecialchars($gama['Nombre_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Descripción</label>
                <textarea name="Descripcion_gama" class="textarea-formulario" rows="4"><?= htmlspecialchars($gama['Descripcion_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-success">✅ Actualizar Gama</button>
                <a href="/GAMA" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
