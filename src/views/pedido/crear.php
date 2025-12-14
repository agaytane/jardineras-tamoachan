<div class="container mt-5">
    <h2>Nuevo Pedido</h2>

    <form method="POST" action="/PEDIDOS/GUARDAR">

        <div class="mb-3">
            <label>Fecha prevista</label>
            <input type="date" name="fecha_prevista" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Cliente</label>
            <select name="cliente" class="form-control" required>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?= $c['Id_cliente'] ?>">
                        <?= $c['Nombre_cte'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Empleado</label>
            <select name="empleado" class="form-control" required>
                <?php foreach ($empleados as $e): ?>
                    <option value="<?= $e['Id_empleado'] ?>">
                        <?= $e['Nombre_emp'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <h5>Productos</h5>

        <?php for ($i = 0; $i < 5; $i++): ?>
        <div class="row mb-2">
            <div class="col-md-8">
                <select name="productos[]" class="form-control">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= $p['Id_producto'] ?>">
                            <?= $p['Nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="cantidades[]" class="form-control" min="1">
            </div>
        </div>
        <?php endfor; ?>

        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Guardar Pedido</button>
        <a href="/PEDIDOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
