CREATE DATABASE JARDINES_TAMOANCHAN;
USE JARD
CREATE TABLE OFICINA (
    Id_oficina INT PRIMARY KEY,
    Direccion VARCHAR(35),
    Telefono VARCHAR(15),
    Ciudad VARCHAR (20),
    Provincia VARCHAR (20),
    Codigo_postal VARCHAR (6) 
    );
GO
CREATE TABLE EMPLEADO (
    Id_empleado INT PRIMARY KEY,
    Nombre_emp VARCHAR(10),
    Apellido_emp VARCHAR(10),
    Email_emp VARCHAR(30),
    Telefono_emp VARCHAR(15),
    Puesto VARCHAR(10),
    Salario DECIMAL(10,2),
    Nombre_jefe VARCHAR(20),
    Fk_id_oficina INT FOREIGN KEY REFERENCES OFICINA(Id_oficina) 
)
GO
CREATE TABLE CLIENTE (
    Id_cliente INT PRIMARY KEY,
    Nombre_cte VARCHAR(10),
    Apellido_cte VARCHAR(10),
    Email_cte VARCHAR(30),
    Telefono_cte VARCHAR(15),
    Direccion_cte VARCHAR(20)
)
GO
CREATE TABLE PEDIDO (
    Id_pedido INT PRIMARY KEY,
    Fecha_pedido DATE,
    Fecha_prevista DATE,
    Fecha_entrega DATE,
    Estado VARCHAR(15),
    Comentarios VARCHAR(30),
    Fk_id_cliente INT FOREIGN KEY REFERENCES CLIENTE(Id_cliente),
    Fk_id_empleado INT FOREIGN KEY REFERENCES EMPLEADO(Id_empleado)
)
GO

CREATE TABLE GAMA_PRODUCTO(
    Id_gama INT PRIMARY KEY,
    Nombre_gama VARCHAR(20),
    Descripcion_gama VARCHAR(30)
)
GO

CREATE TABLE PRODUCTO (
    Id_producto INT PRIMARY KEY,
    Nombre VARCHAR(20),
    Descripcion VARCHAR(20),
    Precio_venta DECIMAL(10,2),
    Stock INT,
    Fk_id_gama INT FOREIGN KEY REFERENCES GAMA_PRODUCTO(Id_gama)  
)
GO

CREATE TABLE DETALLE_PEDIDO(
    Fk_id_pedido INT FOREIGN KEY REFERENCES PEDIDO(Id_pedido),
    Fk_id_producto INT FOREIGN KEY REFERENCES PRODUCTO(Id_producto),
    Cantidad INT
) 
GO

INSERT INTO GAMA_PRODUCTO (Id_gama, Nombre_gama, Descripcion_gama) VALUES
(1, 'Oficina', 'Artículos de oficina'),
(2, 'Electrónica', 'Productos electrónicos'),
(3, 'Hogar', 'Accesorios del hogar'),
(4, 'Escolar', 'Material escolar'),
(5, 'Computo', 'Accesorios de computación');

INSERT INTO OFICINA (Id_oficina, Direccion, Telefono, Ciudad, Provincia, Codigo_postal) VALUES
(1, 'Av Reforma 100', '5551234567', 'CDMX', 'CDMX', '01000'),
(2, 'Calle Norte 50', '5559876543', 'Monterrey', 'NL', '64000'),
(3, 'Centro 22', '5548761234', 'Guadalajara', 'JAL', '44100'),
(4, 'Av Sur 350', '5557654321', 'Puebla', 'PUE', '72000'),
(5, 'Calle 16', '5554442211', 'Toluca', 'MEX', '50000');

INSERT INTO EMPLEADO (Id_empleado, Nombre_emp, Apellido_emp, Email_emp, Telefono_emp, Puesto, Salario, Nombre_jefe, Fk_id_oficina) VALUES
(1, 'Juan', 'Perez', 'juan@empresa.com', '5512345678', 'Gerente', 25000.00, 'N/A', 1),
(2, 'Ana', 'Lopez', 'ana@empresa.com', '5598765432', 'Vendedor', 15000.00, 'Juan Perez', 1),
(3, 'Luis', 'Gomez', 'luis@empresa.com', '5511122233', 'Vendedor', 14000.00, 'Juan Perez', 2),
(4, 'Maria', 'Soto', 'maria@empresa.com', '5588877766', 'Asistente', 12000.00, 'Ana Lopez', 3),
(5, 'Pedro', 'Ruiz', 'pedro@empresa.com', '5577766655', 'Repartidor', 10000.00, 'Luis Gomez', 4);


INSERT INTO CLIENTE (Id_cliente, Nombre_cte, Apellido_cte, Email_cte, Telefono_cte, Direccion_cte) VALUES
(1, 'Carlos', 'Mena', 'carlos@gmail.com', '5512340000', 'Calle 1'),
(2, 'Laura', 'Diaz', 'laura@gmail.com', '5523451111', 'Calle 2'),
(3, 'Diego', 'Santos', 'diego@gmail.com', '5534562222', 'Calle 3'),
(4, 'Sofia', 'Vega', 'sofia@gmail.com', '5545673333', 'Calle 4'),
(5, 'Bruno', 'Reyes', 'bruno@gmail.com', '5556784444', 'Calle 5');

INSERT INTO PRODUCTO (Id_producto, Nombre, Descripcion, Precio_venta, Stock, Fk_id_gama) VALUES
(1, 'Laptop', 'Laptop 14 pulgadas', 15000.00, 10, 5),
(2, 'Mouse', 'Mouse inalámbrico', 250.00, 50, 5),
(3, 'Escritorio', 'Escritorio madera', 3500.00, 5, 1),
(4, 'Cuaderno', 'Cuaderno rayado', 40.00, 100, 4),
(5, 'Audífonos', 'Audífonos bluetooth', 700.00, 20, 2);

INSERT INTO PEDIDO (Id_pedido, Fecha_pedido, Fecha_prevista, Fecha_entrega, Estado, Comentarios, Fk_id_cliente, Fk_id_empleado) VALUES
(1, '2025-01-10', '2025-01-15', NULL, 'Pendiente', 'Entrega estándar', 1, 2),
(2, '2025-01-12', '2025-01-18', NULL, 'Pendiente', 'Revisión de stock', 2, 3),
(3, '2025-01-13', '2025-01-20', NULL, 'Pendiente', 'Urgente', 3, 1),
(4, '2025-01-14', '2025-01-19', NULL, 'Pendiente', 'Cliente frecuente', 4, 4),
(5, '2025-01-15', '2025-01-22', NULL, 'Pendiente', 'Pago en efectivo', 5, 5);


INSERT INTO DETALLE_PEDIDO (Fk_id_pedido, Fk_id_producto, Cantidad) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1),
(4, 4, 5),
(5, 5, 1);

--5 Vistas

--VISTA PEDIDO CON CLIENTE Y EMPLEADO
CREATE VIEW AGE_V_PEDIDO_CLIENTE_EMPLEADO AS
SELECT 
    p.Id_pedido,
    p.Fecha_pedido,
    c.Nombre_cte + ' ' + c.Apellido_cte AS Cliente,
    e.Nombre_emp + ' ' + e.Apellido_emp AS Empleado
FROM PEDIDO p, CLIENTE c, EMPLEADO e
WHERE p.Fk_id_cliente = c.Id_cliente
  AND p.Fk_id_empleado = e.Id_empleado;

  SELECT * FROM AGE_V_PEDIDO_CLIENTE_EMPLEADO;

--VISTA PRODUCTO CON GAMA Y DETALLE PEDIDO
CREATE VIEW AGE_V_PRODUCTO_GAMA_DETALLE AS
SELECT 
    pr.Id_producto,
    pr.Nombre AS Producto,
    g.Nombre_gama AS Gama,
    dp.Cantidad
FROM PRODUCTO pr, GAMA_PRODUCTO g, DETALLE_PEDIDO dp
WHERE pr.Fk_id_gama = g.Id_gama
  AND dp.Fk_id_producto = pr.Id_producto;

--VISTA DETALLE PEDIDO CON INFORMACION ADICIONAL
CREATE VIEW AGE_V_DETALLE_PEDIDO_INFO AS
SELECT 
    dp.Fk_id_pedido AS Pedido,
    dp.Fk_id_producto AS Producto,
    pr.Nombre AS Nombre_producto,
    dp.Cantidad,
    p.Fecha_pedido
FROM DETALLE_PEDIDO dp, PEDIDO p, PRODUCTO pr
WHERE dp.Fk_id_pedido = p.Id_pedido
  AND dp.Fk_id_producto = pr.Id_producto;


--VISTA EMPLEADO CON OFICINA Y PEDIDOS
CREATE VIEW AGE_V_EMPLEADO_OFICINA_PEDIDOS AS
SELECT 
    e.Id_empleado,
    e.Nombre_emp + ' ' + e.Apellido_emp AS Empleado,
    o.Ciudad AS Oficina,
    p.Id_pedido
FROM EMPLEADO e, OFICINA o, PEDIDO p
WHERE e.Fk_id_oficina = o.Id_oficina
  AND p.Fk_id_empleado = e.Id_empleado;

--VISTA CLIENTE CON PEDIDOS Y PRODUCTOS
CREATE VIEW AGE_V_CLIENTE_PEDIDO_PRODUCTOS AS
SELECT 
    c.Id_cliente,
    c.Nombre_cte + ' ' + c.Apellido_cte AS Cliente,
    p.Id_pedido,
    dp.Fk_id_producto AS Producto,
    dp.Cantidad
FROM CLIENTE c, PEDIDO p, DETALLE_PEDIDO dp
WHERE p.Fk_id_cliente = c.Id_cliente
  AND dp.Fk_id_pedido = p.Id_pedido;

--INDEXES
CREATE INDEX IDX_PRODUCTO_NOMBRE ON PRODUCTO (Nombre);
CREATE INDEX IDX_PRODUCTO_GAMA ON PRODUCTO (Fk_id_gama);

CREATE INDEX IDX_CLIENTE_EMAIL ON CLIENTE (Email_cte);
CREATE INDEX IDX_CLIENTE_NOMBRE ON CLIENTE (Nombre_cte, Apellido_cte);

CREATE INDEX IDX_PEDIDO_FECHA ON PEDIDO (Fecha_pedido);
CREATE INDEX IDX_PEDIDO_ESTADO ON PEDIDO (Estado);
CREATE INDEX IDX_PEDIDO_CLIENTE ON PEDIDO (Fk_id_cliente);
CREATE INDEX IDX_PEDIDO_EMPLEADO ON PEDIDO (Fk_id_empleado);

CREATE INDEX IDX_DP_PEDIDO ON DETALLE_PEDIDO (Fk_id_pedido);
CREATE INDEX IDX_DP_PRODUCTO ON DETALLE_PEDIDO (Fk_id_producto);

CREATE INDEX IDX_EMPLEADO_NOMBRE ON EMPLEADO (Nombre_emp, Apellido_emp);
CREATE INDEX IDX_EMPLEADO_OFICINA ON EMPLEADO (Fk_id_oficina);

CREATE INDEX IDX_OFICINA_CIUDAD ON OFICINA (Ciudad);
CREATE INDEX IDX_OFICINA_PROVINCIA ON OFICINA (Provincia);


--WEB
GO
CREATE VIEW Vista_Detalle_Pedidos AS
SELECT
    dp.Fk_id_pedido AS Id_pedido,
    p.Fecha_pedido,
    p.Estado,
    c.Nombre_cte + ' ' + c.Apellido_cte AS Cliente,
    e.Nombre_emp + ' ' + e.Apellido_emp AS Empleado,

    pr.Nombre AS Producto,
    pr.Precio_venta AS PrecioUnitario,
    dp.Cantidad,
    (dp.Cantidad * pr.Precio_venta) AS Subtotal,
    SUM(dp.Cantidad * pr.Precio_venta)
        OVER(PARTITION BY dp.Fk_id_pedido) AS Total_Pedido

FROM DETALLE_PEDIDO dp
JOIN PEDIDO p 
    ON dp.Fk_id_pedido = p.Id_pedido
JOIN CLIENTE c 
    ON p.Fk_id_cliente = c.Id_cliente
JOIN EMPLEADO e 
    ON p.Fk_id_empleado = e.Id_empleado
JOIN PRODUCTO pr 
    ON dp.Fk_id_producto = pr.Id_producto;

GO
CREATE PROCEDURE SP_INSERTAR_PRODUCTO
    @Id_producto INT,
    @Nombre VARCHAR(20),
    @Descripcion VARCHAR(20),
    @Precio_venta DECIMAL(10,2),
    @Stock INT,
    @Fk_id_gama INT
AS
BEGIN
    SET NOCOUNT ON;
    INSERT INTO PRODUCTO (
        Id_producto,
        Nombre,
        Descripcion,
        Precio_venta,
        Stock,
        Fk_id_gama
     
    )
    VALUES (
        @Id_producto,
        @Nombre,
        @Descripcion,
        @Precio_venta,
        @Stock,
        @Fk_id_gama
    );
END;

GO

CREATE PROCEDURE SP_ACTUALIZAR_PRODUCTO
    @Id_producto INT,
    @Nombre VARCHAR(20),
    @Descripcion VARCHAR(20),
    @Precio_venta DECIMAL(10,2),
    @Stock INT,
    @Fk_id_gama INT
AS
BEGIN
        UPDATE PRODUCTO
        SET Nombre = @Nombre,
            Descripcion = @Descripcion,
            Precio_venta = @Precio_venta,
            Stock = @Stock,
            Fk_id_gama = @Fk_id_gama
        WHERE Id_producto = @Id_producto;
END;
GO

CREATE PROCEDURE SP_ELIMINAR_PRODUCTO
    @Id_producto INT
AS
BEGIN
    DELETE FROM PRODUCTO WHERE Id_producto = @Id_producto;
END;
GO

CREATE PROCEDURE SP_LISTAR_PRODUCTOS
AS
BEGIN
    SELECT 
        Id_producto,
        Nombre,
        Descripcion,
        Precio_venta,
        Stock,
        Fk_id_gama    
    FROM PRODUCTO;
END;

GO

CREATE PROCEDURE SP_OBTENER_PRODUCTO
    @Id_producto INT
AS
BEGIN
    SELECT * FROM PRODUCTO WHERE Id_producto = @Id_producto;
END;


