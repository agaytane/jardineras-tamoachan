<h2>Nuevo Producto</h2>

<form method="POST" action="index.php?c=producto&a=guardar">
    <input type="number" name="Id_producto" class="form-control mb-2" placeholder="ID">
    <input type="text" name="Nombre" class="form-control mb-2" placeholder="Nombre">
    <input type="text" name="Descripcion" class="form-control mb-2" placeholder="Descripción">
    <input type="number" step="0.01" name="Precio_venta" class="form-control mb-2" placeholder="Precio">
    <input type="number" name="Stock" class="form-control mb-2" placeholder="Stock">
    <input type="number" name="Fk_id_gama" class="form-control mb-2" placeholder="Gama">

    <button class="btn btn-primary">Guardar</button>
</form>
