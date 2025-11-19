<h2>Editar Producto</h2>

<form action="/PRODUCTOS/ACTUALIZAR" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="Id_producto" value="<?= $producto['Id_producto'] ?>">

    Nombre: <input type="text" name="Nombre" value="<?= $producto['Nombre'] ?>"><br><br>
    Descripción: <input type="text" name="Descripcion" value="<?= $producto['Descripcion'] ?>"><br><br>
    Precio: <input type="number" step="0.01" name="Precio_venta" value="<?= $producto['Precio_venta'] ?>"><br><br>
    Stock: <input type="number" name="Stock" value="<?= $producto['Stock'] ?>"><br><br>
    Gama: <input type="number" name="Fk_id_gama" value="<?= $producto['Fk_id_gama'] ?>"><br><br>

    <button type="submit">Actualizar</button>

</form>
