<h2>Nuevo Producto</h2>

<form method="POST" action="/PRODUCTOS/CREAR">

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>

    <input type="text" name="descripcion" class="form-control mb-2" placeholder="Descripción">

    <input type="number" step="0.01" min="0"
           name="precio_venta" class="form-control mb-2"
           placeholder="Precio" required>

    <input type="number" min="0"
           name="stock" class="form-control mb-2"
           placeholder="Stock" required>

    <input type="number" min="1"
           name="fk_id_gama" class="form-control mb-2"
           placeholder="Gama (opcional)">

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
