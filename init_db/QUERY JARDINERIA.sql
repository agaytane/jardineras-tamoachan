CREATE DATABASE JARDINES_TAMOANCHAN;
USE JARDINES_TAMOANCHAN

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
    Descripcion_gama VARCHAR(40)
)
GO

CREATE TABLE PRODUCTO (
    Id_producto INT PRIMARY KEY,
    Nombre VARCHAR(20),
    Descripcion VARCHAR(40),
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



-- Deshabilitar constraints temporalmente (SQL Server)
EXEC sp_MSforeachtable 'ALTER TABLE ? NOCHECK CONSTRAINT ALL'

-- Eliminar datos en orden correcto (debido a las FK)
DELETE FROM DETALLE_PEDIDO;
DELETE FROM PEDIDO;
DELETE FROM PRODUCTO;
DELETE FROM GAMA_PRODUCTO;
DELETE FROM CLIENTE;
DELETE FROM EMPLEADO;
DELETE FROM OFICINA;

-- Habilitar constraints nuevamente
EXEC sp_MSforeachtable 'ALTER TABLE ? CHECK CONSTRAINT ALL'

USE JARDINES_TAMOANCHAN;


ALTER TABLE PRODUCTO ALTER COLUMN Nombre VARCHAR(40);
ALTER TABLE PRODUCTO ALTER COLUMN Descripcion VARCHAR(40);

-- 1. GAMA_PRODUCTO (Categorías de productos de jardinería)
INSERT INTO GAMA_PRODUCTO (Id_gama, Nombre_gama, Descripcion_gama) VALUES
(1, 'Plantas', 'Plantas ornamentales y de ornato'),
(2, 'Herramientas', 'Herramientas para jardinería'),
(3, 'Fertilizantes', 'Abonos y nutrientes para plantas'),
(4, 'Macetas', 'Contenedores y jardineras'),
(5, 'Riego', 'Sistemas de riego y accesorios'),
(6, 'Semillas', 'Semillas de diversas plantas'),
(7, 'Sustratos', 'Tierras y sustratos especializados'),
(8, 'Decoración', 'Elementos decorativos jardín'),
(9, 'Pesticidas', 'Control de plagas y enfermedades'),
(10, 'Iluminación', 'Iluminación para jardín');

-- 2. OFICINA (Sucursales)
INSERT INTO OFICINA (Id_oficina, Direccion, Telefono, Ciudad, Provincia, Codigo_postal) VALUES
(1, 'Av. Jardines 123', '5551002001', 'CDMX', 'CDMX', '01000'),
(2, 'Calle Flores 456', '5551002002', 'Guadalajara', 'Jalisco', '44100'),
(3, 'Blvd. Arboledas 789', '5551002003', 'Monterrey', 'Nuevo León', '64000'),
(4, 'Av. Primavera 321', '5551002004', 'Puebla', 'Puebla', '72000'),
(5, 'Calle Rosas 654', '5551002005', 'Querétaro', 'Querétaro', '76000'),
(6, 'Av. Jardineros 987', '5551002006', 'Mérida', 'Yucatán', '97000'),
(7, 'Calle Cactus 147', '5551002007', 'Cancún', 'Quintana Roo', '77500'),
(8, 'Blvd. Palmeras 258', '5551002008', 'Toluca', 'Estado México', '50000'),
(9, 'Av. Fuentes 369', '5551002009', 'León', 'Guanajuato', '37000'),
(10, 'Calle Estanques 741', '5551002010', 'Morelia', 'Michoacán', '58000');

-- 3. EMPLEADO
INSERT INTO EMPLEADO (Id_empleado, Nombre_emp, Apellido_emp, Email_emp, Telefono_emp, Puesto, Salario, Nombre_jefe, Fk_id_oficina) VALUES
(1, 'Carlos', 'Hernández', 'carlos@jardines.com', '5512345001', 'Gerente', 28000.00, 'N/A', 1),
(2, 'Ana', 'Flores', 'ana@jardines.com', '5512345002', 'Vendedor', 16000.00, 'Carlos Hernández', 1),
(3, 'Luis', 'Jardines', 'luis@jardines.com', '5512345003', 'Vendedor', 15500.00, 'Carlos Hernández', 2),
(4, 'María', 'Rosales', 'maria@jardines.com', '5512345004', 'Asistente', 13000.00, 'Ana Flores', 3),
(5, 'Pedro', 'Verdín', 'pedro@jardines.com', '5512345005', 'Repartidor', 11000.00, 'Luis Jardines', 4),
(6, 'Sofia', 'Plantas', 'sofia@jardines.com', '5512345006', 'Vendedor', 15800.00, 'Carlos Hernández', 5),
(7, 'Diego', 'Riegos', 'diego@jardines.com', '5512345007', 'Técnico', 17000.00, 'Ana Flores', 6),
(8, 'Laura', 'Macetas', 'laura@jardines.com', '5512345008', 'Diseñadora', 16500.00, 'Luis Jardines', 7),
(9, 'Jorge', 'Abonos', 'jorge@jardines.com', '5512345009', 'Asesor', 16200.00, 'Carlos Hernández', 8),
(10, 'Elena', 'Semillas', 'elena@jardines.com', '5512345010', 'Vendedor', 15400.00, 'Ana Flores', 9);

-- 4. CLIENTE
INSERT INTO CLIENTE (Id_cliente, Nombre_cte, Apellido_cte, Email_cte, Telefono_cte, Direccion_cte) VALUES
(1, 'Roberto', 'García', 'roberto@cliente.com', '5523456001', 'Calle Jardín 123'),
(2, 'Isabel', 'Martínez', 'isabel@cliente.com', '5523456002', 'Av. Flores 456'),
(3, 'Miguel', 'López', 'miguel@cliente.com', '5523456003', 'Calle Palmeras 789'),
(4, 'Carmen', 'Díaz', 'carmen@cliente.com', '5523456004', 'Blvd. Rosas 321'),
(5, 'Fernando', 'Castro', 'fernando@cliente.com', '5523456005', 'Av. Césped 654'),
(6, 'Patricia', 'Ruiz', 'patricia@cliente.com', '5523456006', 'Calle Fuentes 987'),
(7, 'Ricardo', 'Sánchez', 'ricardo@cliente.com', '5523456007', 'Av. Estanques 147'),
(8, 'Gabriela', 'Ortega', 'gabriela@cliente.com', '5523456008', 'Calle Plantas 258'),
(9, 'Javier', 'Morales', 'javier@cliente.com', '5523456009', 'Blvd. Árboles 369'),
(10, 'Diana', 'Vega', 'diana@cliente.com', '5523456010', 'Av. Jardineros 741');

-- 5. PRODUCTO (Productos de jardinería)
INSERT INTO PRODUCTO (Id_producto, Nombre, Descripcion, Precio_venta, Stock, Fk_id_gama) VALUES
(1, 'Rosa Roja', 'Rosa roja ornamental', 120.00, 50, 1),
(2, 'Tijeras Podar', 'Tijeras profesionales podar', 350.00, 25, 2),
(3, 'Fertilizante Universal', 'Abono para todo tipo plantas', 180.00, 40, 3),
(4, 'Maceta Barro', 'Maceta barro 30cm diámetro', 95.00, 60, 4),
(5, 'Manguera 20m', 'Manguera jardín 20 metros', 420.00, 15, 5),
(6, 'Semillas Césped', 'Semillas césped inglés', 75.00, 100, 6),
(7, 'Sustrato Premium', 'Tierra preparada premium', 110.00, 80, 7),
(8, 'Fuente Jardín', 'Fuente decorativa jardín', 1500.00, 8, 8),
(9, 'Insecticida Natural', 'Control plagas natural', 220.00, 30, 9),
(10, 'Lámpara Solar', 'Lámpara solar jardín', 380.00, 20, 10);

ALTER TABLE PRODUCTO ALTER COLUMN Nombre VARCHAR(40);
ALTER TABLE PRODUCTO ALTER COLUMN Descripcion VARCHAR(40);

-- 6. PEDIDO
INSERT INTO PEDIDO (Id_pedido, Fecha_pedido, Fecha_prevista, Fecha_entrega, Estado, Comentarios, Fk_id_cliente, Fk_id_empleado) VALUES
(1, '2024-01-15', '2024-01-20', '2024-01-19', 'Entregado', 'Cliente satisfecho', 1, 2),
(2, '2024-01-16', '2024-01-22', NULL, 'Pendiente', 'Esperando pago', 2, 3),
(3, '2024-01-17', '2024-01-25', NULL, 'Procesando', 'Preparando envío', 3, 4),
(4, '2024-01-18', '2024-01-23', '2024-01-22', 'Entregado', 'Entrega rápida', 4, 5),
(5, '2024-01-19', '2024-01-26', NULL, 'Pendiente', 'Cliente frecuente', 5, 6),
(6, '2024-01-20', '2024-01-27', NULL, 'Procesando', 'Productos frágiles', 6, 7),
(7, '2024-01-21', '2024-01-28', '2024-01-26', 'Entregado', 'Todo correcto', 7, 8),
(8, '2024-01-22', '2024-01-29', NULL, 'Pendiente', 'Pedido grande', 8, 9),
(9, '2024-01-23', '2024-01-30', NULL, 'Procesando', 'Urgente', 9, 10),
(10, '2024-01-24', '2024-01-31', '2024-01-29', 'Entregado', 'Buen servicio', 10, 2);

-- 7. DETALLE_PEDIDO (Con productos repetidos y múltiples productos por pedido)
INSERT INTO DETALLE_PEDIDO (Fk_id_pedido, Fk_id_producto, Cantidad) VALUES
-- Pedido 1: Múltiples productos
(1, 1, 5),  -- 5 Rosas Rojas
(1, 3, 2),  -- 2 Fertilizantes
(1, 4, 3),  -- 3 Macetas

-- Pedido 2: Productos repetidos
(2, 2, 1),  -- 1 Tijeras
(2, 2, 1),  -- Otra Tijeras (mismo producto)
(2, 5, 1),  -- 1 Manguera

-- Pedido 3: Varios productos diferentes
(3, 6, 3),  -- 3 Semillas Césped
(3, 7, 5),  -- 5 Sustratos
(3, 9, 2),  -- 2 Insecticidas

-- Pedido 4: Producto único repetido
(4, 1, 10), -- 10 Rosas Rojas
(4, 1, 5),  -- 5 Rosas más (mismo producto)

-- Pedido 5: Combinación variada
(5, 3, 3),  -- 3 Fertilizantes
(5, 4, 2),  -- 2 Macetas
(5, 8, 1),  -- 1 Fuente

-- Pedido 6: Productos de iluminación
(6, 10, 4), -- 4 Lámparas
(6, 10, 2), -- 2 Lámparas más

-- Pedido 7: Herramientas y más
(7, 2, 2),  -- 2 Tijeras
(7, 5, 1),  -- 1 Manguera
(7, 9, 3),  -- 3 Insecticidas

-- Pedido 8: Pedido grande
(8, 1, 8),  -- 8 Rosas
(8, 4, 6),  -- 6 Macetas
(8, 7, 4),  -- 4 Sustratos

-- Pedido 9: Varios productos
(9, 3, 2),  -- 2 Fertilizantes
(9, 6, 5),  -- 5 Semillas
(9, 10, 3), -- 3 Lámparas

-- Pedido 10: Productos repetidos
(10, 2, 1), -- 1 Tijeras
(10, 2, 1), -- Otra Tijeras
(10, 4, 4); -- 4 Macetas

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
go
SELECT * FROM AGE_V_PEDIDO_CLIENTE_EMPLEADO

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
go
SELECT * FROM AGE_V_PRODUCTO_GAMA_DETALLE

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
go

SELECT * FROM AGE_V_DETALLE_PEDIDO_INFO

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
  go

  SELECT * FROM AGE_V_EMPLEADO_OFICINA_PEDIDOS

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
  go

  SELECT * FROM AGE_V_CLIENTE_PEDIDO_PRODUCTOS

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

UPDATE EMPLEADO
SET Salario = 30000
WHERE Id_empleado = 1;

SELECT * FROM EMPLEADO

UPDATE PEDIDO
SET Estado = 'Entregado', Fecha_entrega = GETDATE()
WHERE Id_pedido = 2;


SELECT * FROM PEDIDO

UPDATE PRODUCTO
SET Stock = Stock - 5
WHERE Id_producto = 1;
SELECT * FROM PRODUCTO


DELETE FROM DETALLE_PEDIDO
WHERE Fk_id_pedido = 2 AND Fk_id_producto = 2 AND Cantidad = 1;

DELETE FROM CLIENTE
WHERE Id_cliente = 10;  


SELECT COUNT(*) AS Total_Entregados
FROM PEDIDO
WHERE Estado = 'Entregado';

SELECT AVG(Salario) AS Promedio_Salarios
FROM EMPLEADO;

SELECT 
    MAX(Precio_venta) AS Precio_Maximo,
    MIN(Precio_venta) AS Precio_Minimo
FROM PRODUCTO;


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


