<div class="container mt-5">
    <h2 class="mb-4">Listado de Productos</h2>
    <a href="/PRODUCTOS/CREAR" class="btn btn-success mb-3">➕ Nuevo Producto</a>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Gama</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['Nombre'] ?></td>
                <td><?= $p['Descripcion'] ?></td>
                <td>$<?= $p['Precio_venta'] ?></td>
                <td><?= $p['Stock'] ?></td>
                <td><?= $p['Fk_id_gama'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
