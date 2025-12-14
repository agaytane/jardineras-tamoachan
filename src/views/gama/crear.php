<div class="container mt-5">
    <h2>Nueva Gama</h2>

    <form method="POST" action="/GAMA/GUARDAR">
        <div class="mb-2">
            <label>Nombre</label>
            <input name="Nombre_gama" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Descripción</label>
            <textarea name="Descripcion_gama" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="/GAMA" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
