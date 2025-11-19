<h2>Lista de Productos</h2>
<a href="/PRODUCTOS/CREAR">Agregar nuevo</a>
<br><br>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Gama</th>

        <th>Acciones</th>
    </tr>

    <?php foreach($productos as $p): ?>
    <tr>
        <td><?= $p["Id_producto"] ?></td>
        <td><?= $p["Nombre"] ?></td>
        <td><?= $p["Descripcion"] ?></td>
        <td><?= $p["Precio_venta"] ?></td>
        <td><?= $p["Stock"] ?></td>
        <td><?= $p["Fk_id_gama"] ?></td>
        <td>
        </td>
        <td>
            <a href="/PRODUCTOS/EDITAR/<?= $p['Id_producto'] ?>">Editar</a>
            |
            <a href="/PRODUCTOS/ELIMINAR/<?= $p['Id_producto'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
