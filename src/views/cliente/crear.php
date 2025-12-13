<h2>Nuevo Cliente</h2>

<form method="POST" action="/CLIENTES/CREAR">

    <input type="text" name="Nombre_cte" class="form-control mb-2" placeholder="Nombre" required>

    <input type="text" name="Apellido_cte" class="form-control mb-2" placeholder="Apellido">

    <input type="email" step="0.01" min="0"
           name="Email_cte" class="form-control mb-2"
           placeholder="Email" required>

    <input type="number" min="0"
           name="Telefono_cte" class="form-control mb-2"
           placeholder="Teléfono" required>

    <input type="text"
           name="Direccion_cte" class="form-control mb-2"
           placeholder="Dirección (opcional)">

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
