<h2>Nuevo Empleado</h2>

<form method="POST" action="index.php?c=empleado&a=guardar">
    <input type="number" name="Id_empleado" class="form-control mb-2" placeholder="ID" required>
    <input type="text" name="Nombre_emp" class="form-control mb-2" placeholder="Nombre" required>
    <input type="text" name="Apellido_emp" class="form-control mb-2" placeholder="Apellido" required>
    <input type="email" name="Email_emp" class="form-control mb-2" placeholder="Email" required>
    <input type="text" name="Telefono_emp" class="form-control mb-2" placeholder="Teléfono">
    <input type="text" name="Puesto" class="form-control mb-2" placeholder="Puesto">
    <input type="number" name="Salario" class="form-control mb-2" placeholder="Salario">
    <input type="text" name="Nombre_jefe" class="form-control mb-2" placeholder="Jefe">
    <input type="number" name="Fk_id_oficina" class="form-control mb-2" placeholder="Oficina">

    <button class="btn btn-primary">Guardar</button>
</form>
