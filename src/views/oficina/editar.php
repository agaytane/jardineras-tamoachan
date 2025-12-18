<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Editar Oficina</h1>
        <p class="subtitulo">Actualizar información de la oficina</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/OFICINAS/ACTUALIZAR">
            <input type="hidden" name="Id_oficina" value="<?= htmlspecialchars($oficina['Id_oficina'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Dirección <span class="requerido">*</span>
                </label>
                <input type="text" name="Direccion" class="campo-formulario" value="<?= htmlspecialchars($oficina['Direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Ciudad <span class="requerido">*</span>
                </label>
                <input type="text" name="Ciudad" class="campo-formulario" value="<?= htmlspecialchars($oficina['Ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Provincia</label>
                <input type="text" name="Provincia" class="campo-formulario" value="<?= htmlspecialchars($oficina['Provincia'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Teléfono</label>
                <input type="text" name="Telefono" class="campo-formulario" value="<?= htmlspecialchars($oficina['Telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Código Postal</label>
                <input type="text" name="Codigo_postal" class="campo-formulario" value="<?= htmlspecialchars($oficina['Codigo_postal'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-success">✅ Actualizar Oficina</button>
                <a href="/OFICINAS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
