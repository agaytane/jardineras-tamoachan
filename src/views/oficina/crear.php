<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🏢 Nueva Oficina</h1>
        <p class="subtitulo">Registrar una nueva ubicación en el sistema</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/OFICINAS/CREAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Dirección <span class="requerido">*</span>
                </label>
                <input type="text" name="Direccion" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Ciudad <span class="requerido">*</span>
                </label>
                <input type="text" name="Ciudad" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Provincia</label>
                <input type="text" name="Provincia" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Teléfono</label>
                <input type="text" name="Telefono" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">Código Postal</label>
                <input type="text" name="Codigo_postal" class="campo-formulario">
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">✅ Guardar Oficina</button>
                <a href="/OFICINAS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
