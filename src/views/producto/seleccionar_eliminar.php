<div class="container mt-5">
    <h2 class="mb-4">Eliminar Producto</h2>

    <form action="/PRODUCTOS/ELIMINAR" method="POST">
        <div class="mb-3">
            <label>Seleccione el Producto</label>
            <select name="id" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto['Id_producto'] ?>">
                        <?= htmlspecialchars($producto['Nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-danger">Eliminar</button>
        <a href="/PRODUCTOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
