<div class="container mt-4">
    <h2>Detalle de Pedidos con Información Adicional</h2>

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" id="buscarTabla" class="form-control" placeholder="Buscar por Pedido, Producto o Nombre">
    </div>

    <?php if (empty($datos)): ?>
        <p>No hay registros.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover" id="tablaPedidos">
            <thead class="table-dark">
                <tr>
                    <th>Pedido</th>
                    <th>Producto</th>
                    <th>Nombre Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha Pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Pedido']) ?></td>
                        <td><?= htmlspecialchars($row['Producto']) ?></td>
                        <td><?= htmlspecialchars($row['Nombre_producto']) ?></td>
                        <td><?= htmlspecialchars($row['Cantidad']) ?></td>
                        <td><?= htmlspecialchars($row['Fecha_pedido']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
// Filtrar tabla por columnas específicas
document.getElementById('buscarTabla').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    let filas = document.querySelectorAll('#tablaPedidos tbody tr');

    filas.forEach(fila => {
        // Obtenemos solo las columnas que queremos buscar: Pedido, Producto, Nombre Producto
        let cPedido = fila.cells[0].textContent.toLowerCase();
        let cProducto = fila.cells[1].textContent.toLowerCase();
        let cNombre = fila.cells[2].textContent.toLowerCase();

        // Mostrar fila si alguna columna contiene el filtro
        if(cPedido.includes(filtro) || cProducto.includes(filtro) || cNombre.includes(filtro)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});
</script>
