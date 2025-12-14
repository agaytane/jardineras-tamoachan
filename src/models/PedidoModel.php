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
        $sql = "EXEC SP_OBTENER_PEDIDO :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Primer result set: pedido
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        // Segundo result set: detalles
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
        // Creamos un table type para enviar a SP_CREAR_PEDIDO
        $table = [];
        foreach ($detalles as $d) {
            $table[] = [
                'ProductoId' => $d['producto_id'],
                'Cantidad'   => $d['cantidad']
            ];
        }

        // Preparar array de parámetros
        $sql = "EXEC SP_CREAR_PEDIDO 
                @Fecha_pedido=:fp,
                @Fecha_prevista=:fv,
                @Estado=:est,
                @Comentarios=:com,
                @Fk_id_cliente=:cli,
                @Fk_id_empleado=:emp,
                @Detalles=:det";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fp', $pedido['Fecha_pedido']);
        $stmt->bindParam(':fv', $pedido['Fecha_prevista']);
        $stmt->bindParam(':est', $pedido['Estado']);
        $stmt->bindParam(':com', $pedido['Comentarios']);
        $stmt->bindParam(':cli', $pedido['Fk_id_cliente'], PDO::PARAM_INT);
        $stmt->bindParam(':emp', $pedido['Fk_id_empleado'], PDO::PARAM_INT);
        // Nota: PDO nativo no soporta Table Type, necesitarías SQLSRV o enviar múltiples inserciones.
        // Para simplificar, puedes usar tu método anterior de transacción.

        // Como alternativa seguimos usando tu transacción:
        try {
            $this->conn->beginTransaction();

            $sqlPedido = "INSERT INTO PEDIDO
                          (Fecha_pedido, Fecha_prevista, Estado, Comentarios, Fk_id_cliente, Fk_id_empleado)
                          VALUES (:fp, :fv, :est, :com, :cli, :emp)";
            $stmtPedido = $this->conn->prepare($sqlPedido);
            $stmtPedido->execute([
                ':fp'  => $pedido['Fecha_pedido'],
                ':fv'  => $pedido['Fecha_prevista'],
                ':est' => $pedido['Estado'],
                ':com' => $pedido['Comentarios'],
                ':cli' => $pedido['Fk_id_cliente'],
                ':emp' => $pedido['Fk_id_empleado']
            ]);

            $pedidoId = $this->conn->lastInsertId();

            $sqlDetalle = "INSERT INTO DETALLE_PEDIDO
                           (Fk_id_pedido, Fk_id_producto, Cantidad)
                           VALUES (:ped, :prod, :cant)";
            $stmtDetalle = $this->conn->prepare($sqlDetalle);

            foreach ($detalles as $d) {
                $stmtDetalle->execute([
                    ':ped'  => $pedidoId,
                    ':prod' => $d['producto_id'],
                    ':cant' => $d['cantidad']
                ]);
            }

            $this->conn->commit();
            return $pedidoId;

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
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
}

