<?php
class PedidoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* =========================
       LISTAR PEDIDOS
    ========================== */
    public function listar() {
        $sql = "EXEC SP_LISTAR_PEDIDOS";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       OBTENER PEDIDO + DETALLES
    ========================== */
    public function obtener($id) {
    $sql = "EXEC SP_OBTENER_PEDIDO @Id_pedido = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pedido) {
        return null;
    }

    $stmt->nextRowset();
    $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'pedido'   => $pedido,
        'detalles' => $detalles
    ];
}

    /* =========================
       CREAR PEDIDO + DETALLE
    ========================== */
    public function crearPedido($pedido, $detalles) {
        // Delegar la transacción al SP en SQL Server (compatible con PDO vía JSON)
        $sql = "EXEC SP_CREAR_PEDIDO_JSON 
                @Fecha_pedido=:fp,
                @Fecha_prevista=:fv,
                @Estado=:est,
                @Comentarios=:com,
                @Fk_id_cliente=:cli,
                @Fk_id_empleado=:emp,
                @DetallesJson=:dj";

        $stmt = $this->conn->prepare($sql);
        $detallesJson = json_encode($detalles, JSON_UNESCAPED_UNICODE);

        $stmt->bindParam(':fp',  $pedido['Fecha_pedido']);
        $stmt->bindParam(':fv',  $pedido['Fecha_prevista']);
        $stmt->bindParam(':est', $pedido['Estado']);
        $stmt->bindParam(':com', $pedido['Comentarios']);
        $stmt->bindParam(':cli', $pedido['Fk_id_cliente'], PDO::PARAM_INT);
        $stmt->bindParam(':emp', $pedido['Fk_id_empleado'], PDO::PARAM_INT);
        $stmt->bindParam(':dj',  $detallesJson, PDO::PARAM_STR);

        $stmt->execute();
        // El SP devuelve SELECT @IdPedido AS Id_pedido
        $pedidoId = $stmt->fetchColumn();
        return $pedidoId ?: null;
    }

    /* =========================
       OBTENER DETALLE PEDIDO
    ========================== */
    public function obtenerDetalle($id) {
        $sql = "SELECT 
                    p.Id_pedido, p.Fecha_pedido, p.Estado,
                    pr.Nombre AS Producto, d.Cantidad, pr.Precio_venta,
                    (d.Cantidad * pr.Precio_venta) AS Subtotal
                FROM PEDIDO p
                INNER JOIN DETALLE_PEDIDO d ON p.Id_pedido = d.Fk_id_pedido
                INNER JOIN PRODUCTO pr ON pr.Id_producto = d.Fk_id_producto
                WHERE p.Id_pedido = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       CANCELAR PEDIDO
    ========================== */
    public function cancelar($id) {
        $sql = "EXEC SP_CANCELAR_PEDIDO :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* =========================
       ELIMINAR PEDIDO
    ========================== */
    public function eliminar($id) {
        $sql = "DELETE FROM PEDIDO WHERE Id_pedido=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* =========================
       ACTUALIZAR PEDIDO (Estado, Comentarios, Fecha_entrega)
    ========================== */
    public function actualizar($id, $data) {
        $sql = "UPDATE PEDIDO
                SET Estado = :est,
                    Comentarios = :com,
                    Fecha_entrega = :fe
                WHERE Id_pedido = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':est', $data['Estado']);
        $stmt->bindValue(':com', $data['Comentarios']);
        $stmt->bindValue(':fe',  $data['Fecha_entrega']);
        $stmt->bindValue(':id',  $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}

