<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>📝 Seleccionar Usuario</h1>
        <p class="subtitulo">Elija el usuario que desea editar</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/USUARIOS/EDITAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Usuario <span class="requerido">*</span>
                </label>
                <select name="id" class="select-formulario" required>
                    <option value="">-- Seleccione un usuario --</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= htmlspecialchars($u['Id_usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($u['Usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?> 
                            (<?= htmlspecialchars($u['Nombre_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">Continuar</button>
                <a href="/USUARIOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
