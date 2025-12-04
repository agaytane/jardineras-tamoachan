<?php if (!$producto): ?>
    <div class="alert alert-danger">Producto no encontrado</div>
    <a href="/PRODUCTOS" class="btn btn-secondary">Volver</a>
    <?php return; ?>
<?php endif; ?>

<div class="container mt-5">
    <h2>Editar Producto</h2>

    <form action="/PRODUCTOS/ACTUALIZAR" method="POST">

        <input type="hidden" name="Id_producto" value="<?= $producto['Id_producto'] ?>">

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="Nombre" class="form-control" value="<?= $producto['Nombre'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <input type="text" name="Descripcion" class="form-control" value="<?= $producto['Descripcion'] ?>">
        </div>

        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" name="Precio_venta" class="form-control" value="<?= $producto['Precio_venta'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="Stock" class="form-control" value="<?= $producto['Stock'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Gama</label>
            <input type="number" name="Fk_id_gama" class="form-control" value="<?= $producto['Fk_id_gama'] ?>" required>
        </div>

        <button type="submit" class="btn btn-success">✅ Guardar Cambios</button>
        <a href="/PRODUCTOS" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
