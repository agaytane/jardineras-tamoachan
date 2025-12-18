<div class="container mt-5">
    <h2 class="mb-4">Eliminar Cliente</h2>

    <form action="/CLIENTES/ELIMINAR" method="POST">
        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <?php if (!empty($clientes) && is_array($clientes)): ?>
                <select name="id" class="form-select" required>
                    <option value="">— Selecciona un cliente —</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?= htmlspecialchars($c['Id_cliente']) ?>">
                            <?= htmlspecialchars($c['Id_cliente'] . ' - ' . $c['Nombre_cte'] . ' ' . $c['Apellido_cte']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="number" name="id" class="form-control" placeholder="ID del Cliente" required>
            <?php endif; ?>
        </div>

        <div class="alert alert-warning" role="alert">
            Esta acción es irreversible. Confirma antes de continuar.
        </div>

        <button class="btn btn-danger">Eliminar</button>
        <a href="/CLIENTES" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
