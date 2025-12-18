<div class="container mt-5">
    <h2 class="mb-4">Agregar Cliente</h2>

    <form method="POST" action="/CLIENTES/CREAR">

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="Nombre_cte" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="Apellido_cte" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="Email_cte" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="Telefono_cte" class="form-control">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="Direccion_cte" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/CLIENTES" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
