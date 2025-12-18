<h2>Editar Cliente</h2>

<form method="POST" action="/CLIENTES/ACTUALIZAR">
    <input type="hidden" name="Id_cliente" value="<?= $cliente['Id_cliente'] ?>" readonly>
    <input name="Nombre_cte" class="form-control mb-2" value="<?= $cliente['Nombre_cte'] ?>" readonly>
    <input name="Apellido_cte" class="form-control mb-2" value="<?= $cliente['Apellido_cte'] ?>"readonly>
    <input name="Email_cte" class="form-control mb-2" value="<?= $cliente['Email_cte'] ?>">
    <input name="Telefono_cte" class="form-control mb-2" value="<?= $cliente['Telefono_cte'] ?>">
    <input name="Direccion_cte" class="form-control mb-2" value="<?= $cliente['Direccion_cte'] ?>">
    <button class="btn btn-primary">Actualizar</button>
</form>
