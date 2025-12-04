<div class="container mt-5">
    <h2 class="mb-4">Editar Producto</h2>
    <p>Ingresa el ID del producto que deseas editar:</p>

    <form action="/PRODUCTOS/EDITAR" method="POST">
        <div class="mb-3">
            <label class="form-label">ID del Producto</label>
            <input type="number" name="id" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning">✏️ Buscar Producto</button>
        <a href="/PRODUCTOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
