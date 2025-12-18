<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🌿 Nueva Gama</h1>
        <p class="subtitulo">Registrar una nueva categoría de productos</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/GAMA/CREAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nombre <span class="requerido">*</span>
                </label>
                <input type="text" name="Nombre_gama" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Descripción</label>
                <textarea name="Descripcion_gama" class="textarea-formulario" rows="4"></textarea>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">✅ Guardar Gama</button>
                <a href="/GAMA" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
