<div class="container mt-5">
    <h2 class="mb-4">Lista de Productos</h2>

    <a href="/PRODUCTOS/CREAR" class="btn btn-success mb-3">Agregar nuevo</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
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
                <?php foreach($productos as $p): ?>
                <tr>
                    <td><?= $p["Id_producto"] ?></td>
                    <td><?= $p["Nombre"] ?></td>
                    <td><?= $p["Descripcion"] ?></td>
                    <td>$<?= number_format($p["Precio_venta"], 2) ?></td>
                    <td><?= $p["Stock"] ?></td>
                    <td><?= $p["Fk_id_gama"] ?></td>
                    <td>
                        <a href="/PRODUCTOS/EDITAR/<?= $p['Id_producto'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="/PRODUCTOS/ELIMINAR/<?= $p['Id_producto'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
