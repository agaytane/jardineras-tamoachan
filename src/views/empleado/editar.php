<h2>Editar Empleado</h2>

<form method="POST" action="index.php?c=empleado&a=actualizar">
    <input type="hidden" name="Id_empleado" value="<?= $empleado['Id_empleado'] ?>">

    <input type="text" name="Nombre_emp" class="form-control mb-2" value="<?= $empleado['Nombre_emp'] ?>">
    <input type="text" name="Apellido_emp" class="form-control mb-2" value="<?= $empleado['Apellido_emp'] ?>">
    <input type="email" name="Email_emp" class="form-control mb-2" value="<?= $empleado['Email_emp'] ?>">
    <input type="text" name="Telefono_emp" class="form-control mb-2" value="<?= $empleado['Telefono_emp'] ?>">
    <input type="text" name="Puesto" class="form-control mb-2" value="<?= $empleado['Puesto'] ?>">
    <input type="number" name="Salario" class="form-control mb-2" value="<?= $empleado['Salario'] ?>">
    <input type="text" name="Nombre_jefe" class="form-control mb-2" value="<?= $empleado['Nombre_jefe'] ?>">
    <input type="number" name="Fk_id_oficina" class="form-control mb-2" value="<?= $empleado['Fk_id_oficina'] ?>">

    <button class="btn btn-primary">Actualizar</button>
</form>
