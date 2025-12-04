<div class="container mt-5">
    <h2 class="mb-4">Editar Empleado</h2>

    <form action="/EMPLEADOS/EDITAR" method="POST">
        <div class="mb-3">
            <label>ID del Empleado</label>
            <input type="number" name="id" class="form-control" required>
        </div>

        <button class="btn btn-warning">Buscar</button>
        <a href="/EMPLEADOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
