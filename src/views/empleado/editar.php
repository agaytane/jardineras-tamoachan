<div class="container mt-5">
    <h2>Editar Empleado</h2>

    <form method="POST" action="/EMPLEADOS/ACTUALIZAR">
        <input type="hidden" name="Id_empleado" value="<?= $empleado['Id_empleado'] ?>">

        <input name="Nombre_emp" class="form-control mb-2" value="<?= $empleado['Nombre_emp'] ?>" required>
        <input name="Apellido_emp" class="form-control mb-2" value="<?= $empleado['Apellido_emp'] ?>" required>
        <input name="Email_emp" class="form-control mb-2" value="<?= $empleado['Email_emp'] ?>">
        <input name="Telefono_emp" class="form-control mb-2" value="<?= $empleado['Telefono_emp'] ?>">
        <input name="Puesto" class="form-control mb-2" value="<?= $empleado['Puesto'] ?>">
        <input name="Salario" type="number" step="0.01" class="form-control mb-2" value="<?= $empleado['Salario'] ?>">

        <button class="btn btn-primary">Actualizar</button>
        <a href="/EMPLEADOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
