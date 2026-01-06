<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Editar Usuario</h1>
        <p class="subtitulo">Modificar datos del usuario</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/USUARIOS/ACTUALIZAR">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['Id_usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nombre de Usuario
                </label>
                <input type="text" class="campo-formulario" 
                       value="<?= htmlspecialchars($usuario['Usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       readonly disabled>
                <small style="color:#666; display:block; margin-top:6px;">El nombre de usuario no se puede modificar.</small>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Rol <span class="requerido">*</span>
                </label>
                <select name="fk_id_rol" class="select-formulario" required>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= htmlspecialchars($r['Id_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                <?= ($r['Id_rol'] == $usuario['Fk_id_rol']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['Nombre_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?> - 
                            <?= htmlspecialchars($r['Descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario" style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="activo" value="1" 
                           <?= ($usuario['Activo'] ?? 0) ? 'checked' : '' ?>
                           style="width: auto; margin: 0;">
                    Usuario Activo
                </label>
                <small style="color:#666; display:block; margin-top:6px;">Desmarque para desactivar el usuario sin eliminarlo.</small>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">💾 Guardar Cambios</button>
                <a href="/USUARIOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
