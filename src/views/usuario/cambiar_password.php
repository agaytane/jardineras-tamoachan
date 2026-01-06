<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>🔑 Cambiar Contraseña</h1>
        <p class="subtitulo">Establecer nueva contraseña para el usuario</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/USUARIOS/PASSWORD">
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['Id_usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Usuario
                </label>
                <input type="text" class="campo-formulario" 
                       value="<?= htmlspecialchars($usuario['Usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       readonly disabled>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nueva Contraseña <span class="requerido">*</span>
                </label>
                <input type="password" name="nueva_password" class="campo-formulario" required minlength="4" maxlength="255">
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">🔒 Cambiar Contraseña</button>
                <a href="/USUARIOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
