<div class="container mt-5">
    <h2 class="mb-4">Listado de Productos</h2>

    <a href="/PRODUCTOS/CREAR" class="btn btn-success mb-3">➕ Nuevo Producto</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Gama</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['Id_producto'] ?></td>
                <td><?= $p['Nombre'] ?></td>
                <td><?= $p['Descripcion'] ?></td>
                <td>$<?= $p['Precio_venta'] ?></td>
                <td><?= $p['Stock'] ?></td>
                <td><?= $p['Fk_id_gama'] ?></td>
                <td>
                    <a href="/PRODUCTOS/EDITAR/<?= $p['Id_producto'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="/PRODUCTOS/ELIMINAR/<?= $p['Id_producto'] ?>" class="btn btn-danger btn-sm">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
