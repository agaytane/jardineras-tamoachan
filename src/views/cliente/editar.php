<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h2>✏️ Editar Cliente</h2>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/CLIENTES/ACTUALIZAR">
            <div class="grupo-formulario">
                <label class="form-label">ID <span class="requerido">*</span></label>
                <input type="text" class="campo-formulario" value="<?= htmlspecialchars($cliente['Id_cliente'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
                <input type="hidden" name="Id_cliente" value="<?= htmlspecialchars($cliente['Id_cliente'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Nombre</label>
                <input type="text" name="Nombre_cte" class="campo-formulario" value="<?= htmlspecialchars($cliente['Nombre_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Apellido</label>
                <input type="text" name="Apellido_cte" class="campo-formulario" value="<?= htmlspecialchars($cliente['Apellido_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly disabled>
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Email</label>
                <input type="email" name="Email_cte" class="campo-formulario" value="<?= htmlspecialchars($cliente['Email_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Teléfono</label>
                <input type="text" name="Telefono_cte" class="campo-formulario" value="<?= htmlspecialchars($cliente['Telefono_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="grupo-formulario">
                <label class="form-label">Dirección</label>
                <input type="text" name="Direccion_cte" class="campo-formulario" value="<?= htmlspecialchars($cliente['Direccion_cte'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn btn-accion btn-primario">
                    <i class="fas fa-save"></i> Actualizar
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
