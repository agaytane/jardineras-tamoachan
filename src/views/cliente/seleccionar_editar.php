<div class="container mt-5">
    <h2 class="mb-4">Editar Cliente</h2>
    <form action="/CLIENTES/EDITAR" method="POST">
        <div class="mb-3">
            <label>ID del Cliente</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <button class="btn btn-warning">Buscar</button>
        <a href="/CLIENTES" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
