<div class="container mt-5">
    <h2 class="mb-4">Editar Producto</h2>

    <form action="/PRODUCTOS/ACTUALIZAR" method="POST" class="row g-3">

        <input type="hidden" name="Id_producto" value="<?= htmlspecialchars($producto['Id_producto']) ?>">

        <div class="col-md-6">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?= htmlspecialchars($producto['Nombre']) ?>" required>
        </div>

        <div class="col-md-6">
            <label for="Descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="Descripcion" name="Descripcion" value="<?= htmlspecialchars($producto['Descripcion']) ?>" required>
        </div>

        <div class="col-md-4">
            <label for="Precio_venta" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="Precio_venta" name="Precio_venta" value="<?= htmlspecialchars($producto['Precio_venta']) ?>" required>
        </div>

        <div class="col-md-4">
            <label for="Stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="Stock" name="Stock" value="<?= htmlspecialchars($producto['Stock']) ?>" required>
        </div>

        <div class="col-md-4">
            <label for="Fk_id_gama" class="form-label">Gama</label>
            <input type="number" class="form-control" id="Fk_id_gama" name="Fk_id_gama" value="<?= htmlspecialchars($producto['Fk_id_gama']) ?>" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="/PRODUCTOS" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
