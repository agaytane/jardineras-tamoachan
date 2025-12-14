<div class="container mt-5">
    <h2>Editar Pedido</h2>

    <form method="POST" action="/PEDIDOS/ACTUALIZAR">
        <input type="hidden" name="Id_pedido" value="<?= $pedido['Id_pedido'] ?>">

        <input type="date" name="Fecha_entrega" class="form-control mb-2"
               value="<?= $pedido['Fecha_entrega'] ?>">

        <select name="Estado" class="form-control mb-2">
            <option <?= $pedido['Estado']=='Pendiente'?'selected':'' ?>>Pendiente</option>
            <option <?= $pedido['Estado']=='Entregado'?'selected':'' ?>>Entregado</option>
            <option <?= $pedido['Estado']=='Cancelado'?'selected':'' ?>>Cancelado</option>
        </select>

        <textarea name="Comentarios" class="form-control mb-2"><?= $pedido['Comentarios'] ?></textarea>

        <button class="btn btn-primary">Actualizar</button>
        <a href="/PEDIDOS" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
