<?php
class ProductoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_PRODUCTOS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_PRODUCTO @Id_producto = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_INSERTAR_PRODUCTO 
                @Nombre = :nombre,
                @Descripcion = :descripcion,
                @Precio_venta = :precio_venta,
                @Stock = :stock,
                @Fk_id_gama = :fk_id_gama
        ");
        
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? '',
            ':precio_venta' => $data['precio_venta'],
            ':stock' => $data['stock'],
            ':fk_id_gama' => $data['fk_id_gama'] ?? null
        ]);
    }

    public function actualizar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_ACTUALIZAR_PRODUCTO 
                @Id_producto = :id_producto,
                @Nombre = :nombre,
                @Descripcion = :descripcion,
                @Precio_venta = :precio_venta,
                @Stock = :stock
        ");
        
        return $stmt->execute([
            ':id_producto' => $data['id_producto'],
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? '',
            ':precio_venta' => $data['precio_venta'],
            ':stock' => $data['stock']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_PRODUCTO @Id_producto = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerGamas() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_GAMAS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function productosBajoStock() {
        $stmt = $this->conn->query("SELECT * FROM VW_PRODUCTOS_BAJO_STOCK");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarDetallesAsociados($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLE_PEDIDO WHERE Fk_id_producto = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
