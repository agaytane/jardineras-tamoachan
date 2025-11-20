<div class="container mt-5">
    <h2 class="mb-4">Agregar Producto</h2>

    <form action="/PRODUCTOS/GUARDAR" method="POST" class="row g-3">

        <div class="col-md-2">
            <label for="Id_producto" class="form-label">ID</label>
            <input type="number" class="form-control" id="Id_producto" name="Id_producto" required>
        </div>

        <div class="col-md-5">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" required>
        </div>

        <div class="col-md-5">
            <label for="Descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="Descripcion" name="Descripcion" required>
        </div>

        <div class="col-md-4">
            <label for="Precio_venta" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="Precio_venta" name="Precio_venta" required>
        </div>

        <div class="col-md-4">
            <label for="Stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="Stock" name="Stock" required>
        </div>

        <div class="col-md-4">
            <label for="Fk_id_gama" class="form-label">Gama</label>
            <input type="number" class="form-control" id="Fk_id_gama" name="Fk_id_gama" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar Producto</button>
            <a href="/PRODUCTOS" class="btn btn-secondary">Cancelar</a>
        </div>

    </form>
</div>
