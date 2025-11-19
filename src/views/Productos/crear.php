<h2>Agregar Producto</h2>

<form action="/PRODUCTOS/GUARDAR" method="POST" enctype="multipart/form-data">

    ID: <input type="number" name="Id_producto" required><br><br>
    Nombre: <input type="text" name="Nombre" required><br><br>
    Descripción: <input type="text" name="Descripcion" required><br><br>
    Precio: <input type="number" step="0.01" name="Precio_venta" required><br><br>
    Stock: <input type="number" name="Stock" required><br><br>
    Gama: <input type="number" name="Fk_id_gama" required><br><br>

    <button type="submit">Guardar</button>
</form>
