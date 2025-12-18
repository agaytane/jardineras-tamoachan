<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>👤 Agregar Cliente</h2>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/CLIENTES/CREAR">
            <div class="grupo-formulario">
                <label class="form-label">Nombre <span class="requerido">*</span></label>
                <input type="text" name="Nombre_cte" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Apellido <span class="requerido">*</span></label>
                <input type="text" name="Apellido_cte" class="campo-formulario" required>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Email</label>
                <input type="email" name="Email_cte" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Teléfono</label>
                <input type="text" name="Telefono_cte" class="campo-formulario">
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Dirección</label>
                <input type="text" name="Direccion_cte" class="campo-formulario">
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-primario">
                    <i class="fas fa-save"></i> Guardar Cliente
                </button>
                <a href="/CLIENTES" class="btn btn-accion btn-secundario">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="/CLIENTES" class="btn btn-accion btn-secundario">← Volver</a>
    </div>
</div>
