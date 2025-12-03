<h2>Editar Oficina</h2>

<form method="POST" action="index.php?c=oficina&a=actualizar">
    <input type="hidden" name="Id_oficina" value="<?= $oficina['Id_oficina'] ?>">
    <input name="Direccion" class="form-control mb-2" value="<?= $oficina['Direccion'] ?>">
    <input name="Telefono" class="form-control mb-2" value="<?= $oficina['Telefono'] ?>">
    <input name="Ciudad" class="form-control mb-2" value="<?= $oficina['Ciudad'] ?>">
    <input name="Provincia" class="form-control mb-2" value="<?= $oficina['Provincia'] ?>">
    <input name="Codigo_postal" class="form-control mb-2" value="<?= $oficina['Codigo_postal'] ?>">
    <button class="btn btn-primary">Actualizar</button>
</form>
