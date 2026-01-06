<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>➕ Nuevo Usuario</h1>
        <p class="subtitulo">Registrar un nuevo usuario en el sistema</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/USUARIOS/CREAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Nombre de Usuario <span class="requerido">*</span>
                </label>
                <input type="text" name="usuario" class="campo-formulario" required maxlength="20" 
                       placeholder="Ej: juanperez" pattern="[a-zA-Z0-9_]+" 
                       title="Solo letras, números y guiones bajos">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Contraseña <span class="requerido">*</span>
                </label>
                <input type="password" name="password" class="campo-formulario" required minlength="4" maxlength="255">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Rol <span class="requerido">*</span>
                </label>
                <select name="fk_id_rol" class="select-formulario" required>
                    <option value="">-- Seleccione un rol --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= htmlspecialchars($r['Id_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($r['Nombre_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?> - 
                            <?= htmlspecialchars($r['Descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-primario">✅ Guardar Usuario</button>
                <a href="/USUARIOS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
