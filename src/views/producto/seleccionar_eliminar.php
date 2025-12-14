<div class="container mt-5">
    <h2 class="mb-4">Eliminar Cliente</h2>

    <form action="/CLIENTES/ELIMINAR" method="POST">
        <div class="mb-3">
            <label>ID del Cliente</label>
            <input type="number" name="id" class="form-control" required>
        </div>

        <button class="btn btn-danger">Eliminar</button>
        <a href="/CLIENTES" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
