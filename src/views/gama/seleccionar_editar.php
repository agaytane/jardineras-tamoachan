<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Seleccionar Gama</h1>
        <p class="subtitulo">Elige la gama que deseas editar</p>
    </div>

    <div class="tarjeta-formulario">
        <form method="POST" action="/GAMA/EDITAR">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Gama <span class="requerido">*</span>
                </label>
                <select name="id" class="select-formulario" required>
                    <option value="">-- Seleccione una gama --</option>
                    <?php foreach ($gamas as $gama): ?>
                        <option value="<?= htmlspecialchars($gama['Id_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($gama['Nombre_gama'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-warning">🔍 Buscar Gama</button>
                <a href="/GAMA" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>
