<div class="container mt-5">
    <h2>Editar Producto</h2>

    <form action="/PRODUCTOS/ACTUALIZAR" method="POST">

        <input type="hidden" name="id_producto" value="<?= $producto['Id_producto'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input
                type="text"
                name="nombre"
                class="form-control"
                value="<?= htmlspecialchars($producto['Nombre']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input
                type="text"
                name="descripcion"
                class="form-control"
                value="<?= htmlspecialchars($producto['Descripcion']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input
                type="number"
                step="0.01"
                name="precio_venta"
                class="form-control"
                value="<?= $producto['Precio_venta'] ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input
                type="number"
                name="stock"
                class="form-control"
                value="<?= $producto['Stock'] ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Gama</label>
            <select name="fk_id_gama" class="form-control">
                <option value="">-- Sin gama --</option>
                <?php foreach ($gamas as $gama): ?>
                    <option
                        value="<?= $gama['Id_gama'] ?>"
                        <?= ($producto['Fk_id_gama'] == $gama['Id_gama']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($gama['Nombre_gama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">✅ Guardar Cambios</button>
        <a href="/PRODUCTOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

