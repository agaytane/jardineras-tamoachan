<h2>Nuevo Producto</h2>

<form method="POST" action="/PRODUCTOS/CREAR">

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>

    <input type="text" name="descripcion" class="form-control mb-2" placeholder="Descripción">

    <input type="number" step="0.01" min="0"
           name="precio_venta" class="form-control mb-2"
           placeholder="Precio" required>

    <input type="number" min="0"
           name="stock" class="form-control mb-2"
           placeholder="Stock" required>

    <div class="mb-3">
        <label class="form-label">Gama</label>
        <select name="fk_id_gama" class="form-control">
            <option value="">-- Sin gama --</option>
            <?php foreach ($gamas as $gama): ?>
                <option
                    value="<?= $gama['Id_gama'] ?>"
                    <?= (isset($_POST['fk_id_gama']) && $_POST['fk_id_gama'] == $gama['Id_gama']) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($gama['Nombre_gama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
