<h2>Editar Producto</h2>

<form method="POST" action="index.php?c=producto&a=actualizar">
    <input type="hidden" name="Id_producto" value="<?= $producto['Id_producto'] ?>">

    <input type="text" name="Nombre" class="form-control mb-2" value="<?= $producto['Nombre'] ?>">
    <input type="text" name="Descripcion" class="form-control mb-2" value="<?= $producto['Descripcion'] ?>">
    <input type="number" step="0.01" name="Precio_venta" class="form-control mb-2" value="<?= $producto['Precio_venta'] ?>">
    <input type="number" name="Stock" class="form-control mb-2" value="<?= $producto['Stock'] ?>">
    <input type="number" name="Fk_id_gama" class="form-control mb-2" value="<?= $producto['Fk_id_gama'] ?>">

    <button class="btn btn-primary">Actualizar</button>
</form>
