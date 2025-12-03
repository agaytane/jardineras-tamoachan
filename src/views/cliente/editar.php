<h2>Editar Cliente</h2>

<form method="POST" action="index.php?c=cliente&a=actualizar">
    <input type="hidden" name="Id_cliente" value="<?= $cliente['Id_cliente'] ?>">
    <input name="Nombre_cte" class="form-control mb-2" value="<?= $cliente['Nombre_cte'] ?>">
    <input name="Apellido_cte" class="form-control mb-2" value="<?= $cliente['Apellido_cte'] ?>">
    <input name="Email_cte" class="form-control mb-2" value="<?= $cliente['Email_cte'] ?>">
    <input name="Telefono_cte" class="form-control mb-2" value="<?= $cliente['Telefono_cte'] ?>">
    <input name="Direccion_cte" class="form-control mb-2" value="<?= $cliente['Direccion_cte'] ?>">
    <button class="btn btn-primary">Actualizar</button>
</form>
