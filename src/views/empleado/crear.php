<div class="container mt-5">
    <h2 class="mb-4">Agregar Empleado</h2>

    <form method="POST" action="/EMPLEADOS/GUARDAR">

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="Nombre_emp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="Apellido_emp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="Email_emp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="Telefono_emp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Puesto</label>
            <input type="text" name="Puesto" class="form-control">
        </div>

        <div class="mb-3">
            <label>Salario</label>
            <input type="number" step="0.01" name="Salario" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nombre del Jefe</label>
            <input type="text" name="Nombre_jefe" class="form-control">
        </div>

        <div class="mb-3">
            <label>ID Oficina</label>
            <input type="number" name="Fk_id_oficina" class="form-control">
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="/EMPLEADOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
