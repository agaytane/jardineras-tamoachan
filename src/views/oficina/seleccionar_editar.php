<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>✏️ Seleccionar Oficina</h1>
        <p class="subtitulo">Elige la oficina que deseas editar</p>
    </div>

    <div class="tarjeta-formulario">
        <form action="/OFICINAS/EDITAR" method="POST">
            <div class="grupo-formulario">
                <label class="etiqueta-formulario">
                    Oficina <span class="requerido">*</span>
                </label>
                <select name="id" class="select-formulario" required>
                    <option value="">-- Seleccione una oficina --</option>
                    <?php foreach ($oficinas as $oficina): ?>
                        <option value="<?= htmlspecialchars($oficina['Id_oficina'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(($oficina['Direccion'] ?? '') . ' - ' . ($oficina['Ciudad'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="contenedor-botones">
                <button type="submit" class="btn-accion btn-warning">🔍 Buscar Oficina</button>
                <a href="/OFICINAS" class="btn-accion btn-secundario">Cancelar</a>
            </div>
        </form>
    </div>
</div>

