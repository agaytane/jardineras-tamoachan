<div class="container mt-5">
    <h2>Editar Gama</h2>

    <form method="POST" action="/GAMA/ACTUALIZAR">
        <input type="hidden" name="Id_gama" value="<?= $gama['Id_gama'] ?>">

        <div class="mb-2">
            <label>Nombre</label>
            <input name="Nombre_gama" class="form-control"
                   value="<?= $gama['Nombre_gama'] ?>" required>
        </div>

        <div class="mb-2">
            <label>Descripción</label>
            <textarea name="Descripcion_gama" class="form-control"><?= $gama['Descripcion_gama'] ?></textarea>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="/GAMA" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
