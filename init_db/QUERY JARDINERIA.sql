CREATE DATABASE JARDINES_TAMOANCHAN;
USE JARDINES_TAMOANCHAN
USE MASTER;

CREATE TABLE OFICINA (
    Id_oficina INT IDENTITY(1,1) PRIMARY KEY,
    Direccion VARCHAR(35),
    Telefono VARCHAR(15),
    Ciudad VARCHAR (20),
    Provincia VARCHAR (20),
    Codigo_postal VARCHAR (6) 
    );
GO
CREATE TABLE EMPLEADO (
    Id_empleado INT IDENTITY(1,1) PRIMARY KEY,
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
    Id_cliente INT IDENTITY(1,1) PRIMARY KEY,
    Nombre_cte VARCHAR(10),
    Apellido_cte VARCHAR(10),
    Email_cte VARCHAR(30),
    Telefono_cte VARCHAR(15),
    Direccion_cte VARCHAR(20)
)
GO
CREATE TABLE PEDIDO (
    Id_pedido INT IDENTITY(1,1) PRIMARY KEY,
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
    Id_gama INT IDENTITY(1,1) PRIMARY KEY,
    Nombre_gama VARCHAR(20),
    Descripcion_gama VARCHAR(40)
)
GO
CREATE TABLE PRODUCTO (
    Id_producto INT IDENTITY(1,1) PRIMARY KEY,
    Nombre VARCHAR(20),
    Descripcion VARCHAR(40),
    Precio_venta DECIMAL(10,2),
    Stock INT,
    Fk_id_gama INT FOREIGN KEY REFERENCES GAMA_PRODUCTO(Id_gama)  
)
GO
CREATE TABLE DETALLE_PEDIDO(
    Fk_id_pedido INT,
    Fk_id_producto INT,
    Cantidad INT,
    CONSTRAINT PK_DETALLE_PEDIDO PRIMARY KEY (Fk_id_pedido, Fk_id_producto),
    FOREIGN KEY (Fk_id_pedido) REFERENCES PEDIDO(Id_pedido),
    FOREIGN KEY (Fk_id_producto) REFERENCES PRODUCTO(Id_producto),
    CONSTRAINT CK_CANTIDAD_POSITIVA CHECK (Cantidad > 0)
);
GO

--WEB PROCEDURES PARA PRODUCTO

CREATE TYPE DetallePedidoType AS TABLE
(
    ProductoId INT,
    Cantidad INT
);
GO

-- PROCEDIMIENTOS ALMACENADOS OPTIMIZADOS

-- 1. PROCEDIMIENTOS PARA PRODUCTO (Optimizados)
GO
CREATE PROCEDURE SP_INSERTAR_PRODUCTO
    @Nombre VARCHAR(20),
    @Descripcion VARCHAR(40), -- Corregido a 40 para coincidir con la tabla
    @Precio_venta DECIMAL(10,2),
    @Stock INT,
    @Fk_id_gama INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        INSERT INTO PRODUCTO (
            Nombre,
            Descripcion,
            Precio_venta,
            Stock,
            Fk_id_gama
        )
        VALUES (
            @Nombre,
            @Descripcion,
            @Precio_venta,
            @Stock,
            @Fk_id_gama
        );
        
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

CREATE PROCEDURE SP_ACTUALIZAR_PRODUCTO
    @Id_producto INT,
    @Nombre VARCHAR(20),
    @Descripcion VARCHAR(40), -- Corregido a 40
    @Precio_venta DECIMAL(10,2),
    @Stock INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        UPDATE PRODUCTO
        SET Nombre = @Nombre,
            Descripcion = @Descripcion,
            Precio_venta = @Precio_venta,
            Stock = @Stock
        WHERE Id_producto = @Id_producto;
        
        IF @@ROWCOUNT = 0
            THROW 50001, 'Producto no encontrado', 1;
            
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;

END;
GO

CREATE PROCEDURE SP_ELIMINAR_PRODUCTO
    @Id_producto INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Verificar si el producto está en pedidos
        IF EXISTS (SELECT 1 FROM DETALLE_PEDIDO WHERE Fk_id_producto = @Id_producto)
            THROW 50002, 'No se puede eliminar, el producto tiene pedidos asociados', 1;
        
        DELETE FROM PRODUCTO WHERE Id_producto = @Id_producto;
        
        IF @@ROWCOUNT = 0
            THROW 50001, 'Producto no encontrado', 1;
            
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

CREATE PROCEDURE SP_LISTAR_PRODUCTOS
AS
BEGIN
    SET NOCOUNT ON;
    SELECT 
        P.Id_producto,
        P.Nombre,
        P.Descripcion,
        P.Precio_venta,
        P.Stock,
        P.Fk_id_gama,
        GP.Nombre_gama
    FROM PRODUCTO P
    LEFT JOIN GAMA_PRODUCTO GP ON P.Fk_id_gama = GP.Id_gama
    ORDER BY P.Nombre;
END;
GO

CREATE PROCEDURE SP_OBTENER_PRODUCTO
    @Id_producto INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT 
        P.Id_producto,
        P.Nombre,
        P.Descripcion,
        P.Precio_venta,
        P.Stock,
        P.Fk_id_gama,
        GP.Nombre_gama
    FROM PRODUCTO P
    LEFT JOIN GAMA_PRODUCTO GP ON P.Fk_id_gama = GP.Id_gama
    WHERE P.Id_producto = @Id_producto;
END;
GO

-- 2. PROCEDIMIENTOS PARA EMPLEADO (Optimizados y corregidos)
CREATE PROCEDURE SP_INSERTAR_EMPLEADO
    @Nombre_emp VARCHAR(10),
    @Apellido_emp VARCHAR(10),
    @Email_emp VARCHAR(30),
    @Telefono_emp VARCHAR(15),
    @Puesto VARCHAR(10),
    @Salario DECIMAL(10,2),
    @Nombre_jefe VARCHAR(20),
    @Fk_id_oficina INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Verificar si la oficina existe
        IF NOT EXISTS (SELECT 1 FROM OFICINA WHERE Id_oficina = @Fk_id_oficina)
            THROW 50003, 'La oficina especificada no existe', 1;
        
        INSERT INTO EMPLEADO (
            Nombre_emp,
            Apellido_emp,
            Email_emp,
            Telefono_emp,
            Puesto,
            Salario,
            Nombre_jefe,
            Fk_id_oficina
        )
        VALUES (
            @Nombre_emp,
            @Apellido_emp,
            @Email_emp,
            @Telefono_emp,
            @Puesto,
            @Salario,
            @Nombre_jefe,
            @Fk_id_oficina
        );
        
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

CREATE PROCEDURE SP_ACTUALIZAR_EMPLEADO
    @Id_empleado INT,
    @Email_emp VARCHAR(30),
    @Telefono_emp VARCHAR(15),
    @Puesto VARCHAR(10),
    @Salario DECIMAL(10,2),
    @Nombre_jefe VARCHAR(20),
    @Fk_id_oficina INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Verificar si la oficina existe
        IF NOT EXISTS (SELECT 1 FROM OFICINA WHERE Id_oficina = @Fk_id_oficina)
            THROW 50003, 'La oficina especificada no existe', 1;
        
        UPDATE EMPLEADO
        SET Email_emp = @Email_emp,
            Telefono_emp = @Telefono_emp,
            Puesto = @Puesto,
            Salario = @Salario,
            Nombre_jefe = @Nombre_jefe,
            Fk_id_oficina = @Fk_id_oficina
        WHERE Id_empleado = @Id_empleado;
        
        IF @@ROWCOUNT = 0
            THROW 50001, 'Empleado no encontrado', 1;
            
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

CREATE PROCEDURE SP_ELIMINAR_EMPLEADO
    @Id_empleado INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Verificar si el empleado tiene pedidos asociados
        IF EXISTS (SELECT 1 FROM PEDIDO WHERE Fk_id_empleado = @Id_empleado)
            THROW 50004, 'No se puede eliminar, el empleado tiene pedidos asociados', 1;
        
        DELETE FROM EMPLEADO WHERE Id_empleado = @Id_empleado;
        
        IF @@ROWCOUNT = 0
            THROW 50001, 'Empleado no encontrado', 1;
            
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

CREATE PROCEDURE SP_LISTAR_EMPLEADOS
AS
BEGIN
    SET NOCOUNT ON;
    SELECT 
        E.Id_empleado,
        E.Nombre_emp,
        E.Apellido_emp,
        E.Email_emp,
        E.Telefono_emp,
        E.Puesto,
        E.Salario,
        E.Nombre_jefe,
        E.Fk_id_oficina,
        O.Ciudad + ', ' + O.Provincia AS Ubicacion_Oficina
    FROM EMPLEADO E
    LEFT JOIN OFICINA O ON E.Fk_id_oficina = O.Id_oficina
    ORDER BY E.Apellido_emp, E.Nombre_emp;
END;
GO

CREATE PROCEDURE SP_OBTENER_EMPLEADO
    @Id_empleado INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT 
        E.Id_empleado,
        E.Nombre_emp,
        E.Apellido_emp,
        E.Email_emp,
        E.Telefono_emp,
        E.Puesto,
        E.Salario,
        E.Nombre_jefe,
        E.Fk_id_oficina,
        O.Direccion AS Direccion_Oficina,
        O.Telefono AS Telefono_Oficina,
        O.Ciudad,
        O.Provincia
    FROM EMPLEADO E
    LEFT JOIN OFICINA O ON E.Fk_id_oficina = O.Id_oficina
    WHERE E.Id_empleado = @Id_empleado;
END;
GO

-- 3. PROCEDIMIENTOS PARA PEDIDOS CON TRANSACCIONES
CREATE PROCEDURE SP_CREAR_PEDIDO
    @Fecha_pedido DATE,
    @Fecha_prevista DATE,
    @Estado VARCHAR(15),
    @Comentarios VARCHAR(50),
    @Fk_id_cliente INT,
    @Fk_id_empleado INT,
    @Detalles DetallePedidoType READONLY
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        IF NOT EXISTS (SELECT 1 FROM CLIENTE WHERE Id_cliente = @Fk_id_cliente)
            THROW 50001, 'Cliente no existe', 1;

        IF NOT EXISTS (SELECT 1 FROM EMPLEADO WHERE Id_empleado = @Fk_id_empleado)
            THROW 50002, 'Empleado no existe', 1;

        INSERT INTO PEDIDO (
            Fecha_pedido, Fecha_prevista, Fecha_entrega,
            Estado, Comentarios, Fk_id_cliente, Fk_id_empleado
        )
        VALUES (
            @Fecha_pedido, @Fecha_prevista, NULL,
            @Estado, @Comentarios, @Fk_id_cliente, @Fk_id_empleado
        );

        DECLARE @IdPedido INT = SCOPE_IDENTITY();

        INSERT INTO DETALLE_PEDIDO (Fk_id_pedido, Fk_id_producto, Cantidad)
        SELECT @IdPedido, ProductoId, Cantidad
        FROM @Detalles;

        UPDATE P
        SET P.Stock = P.Stock - D.Cantidad
        FROM PRODUCTO P
        INNER JOIN @Detalles D ON P.Id_producto = D.ProductoId;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO


-- 4. TRIGGERS PARA MANTENER INTEGRIDAD DE DATOS

-- Trigger para actualizar stock cuando se elimina un pedido
CREATE TRIGGER TR_ELIMINAR_PEDIDO
ON PEDIDO
AFTER DELETE
AS
BEGIN
    SET NOCOUNT ON;
    
    UPDATE P
    SET P.Stock = P.Stock + DP.Cantidad
    FROM PRODUCTO P
    INNER JOIN DETALLE_PEDIDO DP ON P.Id_producto = DP.Fk_id_producto
    INNER JOIN deleted D ON DP.Fk_id_pedido = D.Id_pedido;
    
    -- Eliminar detalles del pedido
    DELETE FROM DETALLE_PEDIDO
    WHERE Fk_id_pedido IN (SELECT Id_pedido FROM deleted);
END;
GO

-- Stored procedure alternative: create order using JSON (compatible with PDO)
CREATE OR ALTER PROCEDURE SP_CREAR_PEDIDO_JSON
    @Fecha_pedido DATE,
    @Fecha_prevista DATE,
    @Estado VARCHAR(15),
    @Comentarios VARCHAR(50),
    @Fk_id_cliente INT,
    @Fk_id_empleado INT,
    @DetallesJson NVARCHAR(MAX)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        IF NOT EXISTS (SELECT 1 FROM CLIENTE WHERE Id_cliente = @Fk_id_cliente)
            THROW 50001, 'Cliente no existe', 1;

        IF NOT EXISTS (SELECT 1 FROM EMPLEADO WHERE Id_empleado = @Fk_id_empleado)
            THROW 50002, 'Empleado no existe', 1;

        INSERT INTO PEDIDO (
            Fecha_pedido, Fecha_prevista, Fecha_entrega,
            Estado, Comentarios, Fk_id_cliente, Fk_id_empleado
        )
        VALUES (
            @Fecha_pedido, @Fecha_prevista, NULL,
            @Estado, @Comentarios, @Fk_id_cliente, @Fk_id_empleado
        );

        DECLARE @IdPedido INT = SCOPE_IDENTITY();

        -- Insert details from JSON array [{"producto_id":..., "cantidad":...}, ...]
        INSERT INTO DETALLE_PEDIDO (Fk_id_pedido, Fk_id_producto, Cantidad)
        SELECT @IdPedido, ProductoId, Cantidad
        FROM OPENJSON(@DetallesJson)
        WITH (
            ProductoId INT '$.producto_id',
            Cantidad   INT '$.cantidad'
        );

        -- Decrease stock based on details
        UPDATE P
        SET P.Stock = P.Stock - D.Cantidad
        FROM PRODUCTO P
        INNER JOIN OPENJSON(@DetallesJson)
            WITH (
                ProductoId INT '$.producto_id',
                Cantidad   INT '$.cantidad'
            ) D ON P.Id_producto = D.ProductoId;

        COMMIT TRANSACTION;

        -- Return created Id for app usage
        SELECT @IdPedido AS Id_pedido;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- Trigger para validar salario mínimo
CREATE TRIGGER TR_VALIDAR_SALARIO
ON EMPLEADO
AFTER INSERT, UPDATE
AS
BEGIN
    IF EXISTS (
        SELECT 1 FROM inserted
        WHERE Salario < 1000 AND Puesto NOT IN ('Practicante', 'Becario')
    )
        THROW 50003, 'Salario inválido', 1;
END;
GO


-- Trigger para evitar eliminación de gamas con productos asociados
CREATE TRIGGER TR_ELIMINAR_GAMA
ON GAMA_PRODUCTO
INSTEAD OF DELETE
AS
BEGIN
    SET NOCOUNT ON;
    
    IF EXISTS (
        SELECT 1 FROM deleted D
        INNER JOIN PRODUCTO P ON D.Id_gama = P.Fk_id_gama
    )
    BEGIN
        THROW 50008, 'No se puede eliminar la gama, tiene productos asociados', 1;
    END
    ELSE
    BEGIN
        DELETE FROM GAMA_PRODUCTO
        WHERE Id_gama IN (SELECT Id_gama FROM deleted);
    END
END;
GO

-- Trigger para actualizar fecha de entrega cuando cambia el estado
CREATE TRIGGER TR_ACTUALIZAR_ENTREGA
ON PEDIDO
AFTER UPDATE
AS
BEGIN
    IF UPDATE(Estado)
    BEGIN
        UPDATE P
        SET Fecha_entrega = GETDATE()
        FROM PEDIDO P
        JOIN inserted i ON P.Id_pedido = i.Id_pedido
        JOIN deleted d ON P.Id_pedido = d.Id_pedido
        WHERE i.Estado = 'Entregado' AND d.Estado <> 'Entregado';
    END
END;
GO


-- 5. TIPO DE TABLA PARA DETALLES DE PEDIDO
CREATE TYPE DetallePedidoType AS TABLE
(
    ProductoId INT,
    Cantidad INT
);
GO

-- 6. PROCEDIMIENTO PARA ACTUALIZAR STOCK DESPUÉS DE CANCELAR PEDIDO
CREATE PROCEDURE SP_CANCELAR_PEDIDO
    @Id_pedido INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Verificar que el pedido existe y no está ya cancelado
        IF NOT EXISTS (SELECT 1 FROM PEDIDO WHERE Id_pedido = @Id_pedido)
            THROW 50001, 'Pedido no encontrado', 1;
            
        IF EXISTS (SELECT 1 FROM PEDIDO WHERE Id_pedido = @Id_pedido AND Estado = 'Cancelado')
            THROW 50009, 'El pedido ya está cancelado', 1;
        
        -- Devolver stock a productos
        UPDATE P
        SET P.Stock = P.Stock + DP.Cantidad
        FROM PRODUCTO P
        INNER JOIN DETALLE_PEDIDO DP ON P.Id_producto = DP.Fk_id_producto
        WHERE DP.Fk_id_pedido = @Id_pedido;
        
        -- Actualizar estado del pedido
        UPDATE PEDIDO
        SET Estado = 'Cancelado',
            Comentarios = ISNULL(Comentarios + ' ', '') + 'Cancelado: ' + CONVERT(VARCHAR, GETDATE(), 103)
        WHERE Id_pedido = @Id_pedido;
        
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

-- 7. PROCEDIMIENTO PARA GENERAR REPORTE DE VENTAS
CREATE PROCEDURE SP_REPORTE_VENTAS
    @FechaInicio DATE,
    @FechaFin DATE
AS
BEGIN
    SET NOCOUNT ON;
    
    SELECT 
        P.Id_pedido,
        P.Fecha_pedido,
        C.Nombre_cte + ' ' + C.Apellido_cte AS Cliente,
        E.Nombre_emp + ' ' + E.Apellido_emp AS Empleado,
        P.Estado,
        SUM(PR.Precio_venta * DP.Cantidad) AS Total_Venta,
        COUNT(DISTINCT DP.Fk_id_producto) AS Cantidad_Productos
    FROM PEDIDO P
    INNER JOIN CLIENTE C ON P.Fk_id_cliente = C.Id_cliente
    INNER JOIN EMPLEADO E ON P.Fk_id_empleado = E.Id_empleado
    INNER JOIN DETALLE_PEDIDO DP ON P.Id_pedido = DP.Fk_id_pedido
    INNER JOIN PRODUCTO PR ON DP.Fk_id_producto = PR.Id_producto
    WHERE P.Fecha_pedido BETWEEN @FechaInicio AND @FechaFin
    GROUP BY P.Id_pedido, P.Fecha_pedido, C.Nombre_cte, C.Apellido_cte, 
             E.Nombre_emp, E.Apellido_emp, P.Estado
    ORDER BY P.Fecha_pedido DESC;
END;
GO

-- 8. VISTA PARA PRODUCTOS BAJO STOCK MÍNIMO
CREATE VIEW VW_PRODUCTOS_BAJO_STOCK
AS
SELECT 
    P.Id_producto,
    P.Nombre,
    P.Descripcion,
    P.Precio_venta,
    P.Stock,
    GP.Nombre_gama,
    CASE 
        WHEN P.Stock < 10 THEN 'CRÍTICO'
        WHEN P.Stock BETWEEN 10 AND 20 THEN 'BAJO'
        ELSE 'SUFICIENTE'
    END AS Nivel_Stock
FROM PRODUCTO P
INNER JOIN GAMA_PRODUCTO GP ON P.Fk_id_gama = GP.Id_gama
WHERE P.Stock < 20;
GO

-- 9. PROCEDIMIENTO PARA ACTUALIZACIÓN MASIVA DE PRECIOS
CREATE PROCEDURE SP_ACTUALIZAR_PRECIOS_GAMA
    @Id_gama INT,
    @Porcentaje DECIMAL(5,2)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;
        
        -- Validar porcentaje
        IF @Porcentaje <= -100
            THROW 50010, 'El porcentaje no puede ser menor o igual a -100%', 1;
            
        UPDATE PRODUCTO
        SET Precio_venta = Precio_venta * (1 + (@Porcentaje / 100))
        WHERE Fk_id_gama = @Id_gama;
        
        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK TRANSACTION;
        THROW;
    END CATCH;
END;
GO

-- INSERTAR OFICINA
CREATE PROCEDURE SP_INSERTAR_OFICINA
    @Direccion VARCHAR(35),
    @Telefono VARCHAR(15),
    @Ciudad VARCHAR(20),
    @Provincia VARCHAR(20),
    @Codigo_postal VARCHAR(6)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        INSERT INTO OFICINA (Direccion, Telefono, Ciudad, Provincia, Codigo_postal)
        VALUES (@Direccion, @Telefono, @Ciudad, @Provincia, @Codigo_postal);

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- ACTUALIZAR OFICINA
CREATE PROCEDURE SP_ACTUALIZAR_OFICINA
    @Id_oficina INT,
    @Direccion VARCHAR(35),
    @Telefono VARCHAR(15),
    @Ciudad VARCHAR(20),
    @Provincia VARCHAR(20),
    @Codigo_postal VARCHAR(6)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        UPDATE OFICINA
        SET Direccion = @Direccion,
            Telefono = @Telefono,
            Ciudad = @Ciudad,
            Provincia = @Provincia,
            Codigo_postal = @Codigo_postal
        WHERE Id_oficina = @Id_oficina;

        IF @@ROWCOUNT = 0
            THROW 50001, 'Oficina no encontrada', 1;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- ELIMINAR OFICINA
CREATE PROCEDURE SP_ELIMINAR_OFICINA
    @Id_oficina INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        IF EXISTS (SELECT 1 FROM EMPLEADO WHERE Fk_id_oficina = @Id_oficina)
            THROW 50011, 'No se puede eliminar la oficina, tiene empleados asociados', 1;

        DELETE FROM OFICINA WHERE Id_oficina = @Id_oficina;

        IF @@ROWCOUNT = 0
            THROW 50001, 'Oficina no encontrada', 1;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- LISTAR OFICINAS
CREATE PROCEDURE SP_LISTAR_OFICINAS
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM OFICINA
    ORDER BY Ciudad, Provincia;
END;
GO

-- OBTENER OFICINA
CREATE PROCEDURE SP_OBTENER_OFICINA
    @Id_oficina INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM OFICINA
    WHERE Id_oficina = @Id_oficina;
END;
GO

-- INSERTAR CLIENTE
CREATE PROCEDURE SP_INSERTAR_CLIENTE
    @Nombre_cte VARCHAR(10),
    @Apellido_cte VARCHAR(10),
    @Email_cte VARCHAR(30),
    @Telefono_cte VARCHAR(15),
    @Direccion_cte VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        INSERT INTO CLIENTE
        VALUES (@Nombre_cte, @Apellido_cte, @Email_cte, @Telefono_cte, @Direccion_cte);

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- ACTUALIZAR CLIENTE
CREATE PROCEDURE SP_ACTUALIZAR_CLIENTE
    @Id_cliente INT,
    @Email_cte VARCHAR(30),
    @Telefono_cte VARCHAR(15),
    @Direccion_cte VARCHAR(20)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        UPDATE CLIENTE
        SET Email_cte = @Email_cte,
            Telefono_cte = @Telefono_cte,
            Direccion_cte = @Direccion_cte
        WHERE Id_cliente = @Id_cliente;

        IF @@ROWCOUNT = 0
            THROW 50001, 'Cliente no encontrado', 1;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- ELIMINAR CLIENTE
CREATE PROCEDURE SP_ELIMINAR_CLIENTE
    @Id_cliente INT
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        IF EXISTS (SELECT 1 FROM PEDIDO WHERE Fk_id_cliente = @Id_cliente)
            THROW 50012, 'No se puede eliminar el cliente, tiene pedidos asociados', 1;

        DELETE FROM CLIENTE WHERE Id_cliente = @Id_cliente;

        IF @@ROWCOUNT = 0
            THROW 50001, 'Cliente no encontrado', 1;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- LISTAR CLIENTES
CREATE PROCEDURE SP_LISTAR_CLIENTES
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM CLIENTE
    ORDER BY Apellido_cte, Nombre_cte;
END;
GO

-- OBTENER CLIENTE
CREATE PROCEDURE SP_OBTENER_CLIENTE
    @Id_cliente INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM CLIENTE
    WHERE Id_cliente = @Id_cliente;
END;
GO

-- INSERTAR GAMA
CREATE PROCEDURE SP_INSERTAR_GAMA
    @Nombre_gama VARCHAR(20),
    @Descripcion_gama VARCHAR(40)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        INSERT INTO GAMA_PRODUCTO (Nombre_gama, Descripcion_gama)
        VALUES (@Nombre_gama, @Descripcion_gama);

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- ACTUALIZAR GAMA
CREATE PROCEDURE SP_ACTUALIZAR_GAMA
    @Id_gama INT,
    @Nombre_gama VARCHAR(20),
    @Descripcion_gama VARCHAR(40)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        UPDATE GAMA_PRODUCTO
        SET Nombre_gama = @Nombre_gama,
            Descripcion_gama = @Descripcion_gama
        WHERE Id_gama = @Id_gama;

        IF @@ROWCOUNT = 0
            THROW 50001, 'Gama no encontrada', 1;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0 ROLLBACK;
        THROW;
    END CATCH;
END;
GO

-- LISTAR GAMAS
CREATE PROCEDURE SP_LISTAR_GAMAS
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM GAMA_PRODUCTO
    ORDER BY Nombre_gama;
END;
GO

-- OBTENER GAMA
CREATE PROCEDURE SP_OBTENER_GAMA
    @Id_gama INT
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM GAMA_PRODUCTO
    WHERE Id_gama = @Id_gama;
END;
GO

-- LISTAR PEDIDOS
CREATE OR ALTER PROCEDURE SP_LISTAR_PEDIDOS
AS
BEGIN
    SET NOCOUNT ON;
    SELECT 
        P.Id_pedido,
        P.Fecha_pedido,
        P.Fecha_prevista,
        P.Fecha_entrega,
        P.Estado,
        P.Fk_id_cliente,  -- agregamos
        P.Fk_id_empleado, -- agregamos
        C.Nombre_cte + ' ' + C.Apellido_cte AS Cliente,
        E.Nombre_emp + ' ' + E.Apellido_emp AS Empleado
    FROM PEDIDO P
    JOIN CLIENTE C ON P.Fk_id_cliente = C.Id_cliente
    JOIN EMPLEADO E ON P.Fk_id_empleado = E.Id_empleado
    ORDER BY P.Fecha_pedido DESC;
END;
GO




-- OBTENER PEDIDO
CREATE PROCEDURE SP_OBTENER_PEDIDO
    @Id_pedido INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT * FROM PEDIDO WHERE Id_pedido = @Id_pedido;

    SELECT 
        DP.Fk_id_producto,
        PR.Nombre,
        DP.Cantidad,
        PR.Precio_venta,
        (DP.Cantidad * PR.Precio_venta) AS Subtotal
    FROM DETALLE_PEDIDO DP
    JOIN PRODUCTO PR ON DP.Fk_id_producto = PR.Id_producto
    WHERE DP.Fk_id_pedido = @Id_pedido;
END;
GO



SELECT Nombre, Existencia as Mayor_Existencia
FROM PRODUCTO
WHERE Existencia = (SELECT MAX(Existencia) FROM PRODUCTO);

-- el indice capturado completo 
-- desventajas de sql server
-- vision: desarrollo de soluciones tecnologicas 
-- complemetar politicas de la empresa sanciones  
-- cuadro de roles completo
-- correccion de diseño modular login 

CREATE TABLE ROLES (
 Id_rol INT PRIMARY KEY IDENTITY(1,1),
 Nombre_rol VARCHAR(20) NOT NULL,
 Descripcion VARCHAR(50)
 );
 
CREATE TABLE USUARIOS (
 Id_usuario INT PRIMARY KEY IDENTITY(1,1),
 Usuario VARCHAR(20) NOT NULL UNIQUE,
 Password VARCHAR(255) NOT NULL,
 Fk_id_rol INT,
 Activo BIT DEFAULT 1,
 FOREIGN KEY (Fk_id_rol) REFERENCES ROLES(Id_rol)
 );
 
 INSERT INTO ROLES (Nombre_rol, Descripcion) VALUES
 ('ADMIN', 'Acceso completo al sistema'),
 ('GERENTE', 'Acceso a reportes y gestión'),
 ('EMPLEADO', 'Acceso a ventas y productos'),
 ('INVENTARIO', 'Solo acceso a inventario');

 -- Usuario ADMIN
INSERT INTO USUARIOS (Usuario, Password, Fk_id_rol, Activo)
VALUES ('admin', 'admin123', 1, 1);
-- Usuario GERENTE
INSERT INTO USUARIOS (Usuario, Password, Fk_id_rol, Activo)
VALUES ('gerente', 'gerente123', 2, 1);
-- Usuario EMPLEADO
INSERT INTO USUARIOS (Usuario, Password, Fk_id_rol, Activo)
VALUES ('empleado', 'empleado123', 3, 1);
-- Usuario INVENTARIO
INSERT INTO USUARIOS (Usuario, Password, Fk_id_rol, Activo)
VALUES ('inventario', 'inv123', 4, 1);

SELECT Id_empleado, Nombre_emp, Apellido_emp
FROM EMPLEADO;
SELECT * FROM USUARIOS;

 INSERT INTO USUARIOS (Usuario, Password, Fk_id_rol, Activo)
 VALUES ('ADMIN', '$2y$10$7zLcmtGvE8oEH2E/pYjY3uW82vXfBobyi9aHpZRExJZt1lPhkvOqW', 1, 1);
 -- Password hashed for 'admin123'

UPDATE dbo.USUARIOS
SET Password = ''
WHERE Usuario = 'ADMIN';


-- Eliminar datos en orden correcto (debido a las FK)
BEGIN TRANSACTION;

-- 1️⃣ TABLAS HIJAS
DELETE FROM DETALLE_PEDIDO;
DELETE FROM PEDIDO;

-- 2️⃣ TABLAS INDEPENDIENTES
DELETE FROM PRODUCTO;
DELETE FROM GAMA_PRODUCTO;
DELETE FROM CLIENTE;
DELETE FROM EMPLEADO;
DELETE FROM OFICINA;

-- 3️⃣ REINICIAR IDENTITIES
DBCC CHECKIDENT ('OFICINA', RESEED, 10);
DBCC CHECKIDENT ('EMPLEADO', RESEED, 10);
DBCC CHECKIDENT ('CLIENTE', RESEED, 10);
DBCC CHECKIDENT ('PEDIDO', RESEED, 10);
DBCC CHECKIDENT ('GAMA_PRODUCTO', RESEED, 10);
DBCC CHECKIDENT ('PRODUCTO', RESEED, 10);

COMMIT;



/* =========================
   1️⃣ OFICINA (IDs 11–15)
========================= */
INSERT INTO OFICINA (Direccion, Telefono, Ciudad, Provincia, Codigo_postal)
VALUES
('Av Reforma 100', '5510000001', 'CDMX', 'CDMX', '01000'),
('Calle Juarez 45', '5510000002', 'Puebla', 'Puebla', '72000'),
('Blvd Atlixco 200', '5510000003', 'Puebla', 'Puebla', '72100'),
('Av Central 300', '5510000004', 'Toluca', 'EdoMex', '50000'),
('Insurgentes Sur 500', '5510000005', 'CDMX', 'CDMX', '03100');
GO
select * from OFICINA;
/* =========================
   2️⃣ EMPLEADO (IDs 11–15)
   Usa oficinas 11–15
========================= */
INSERT INTO EMPLEADO
(Nombre_emp, Apellido_emp, Email_emp, Telefono_emp, Puesto, Salario, Nombre_jefe, Fk_id_oficina)
VALUES
('Pedro', 'Sanchez', 'pedro@mail.com', '5521111111', 'GERENTE', 18000.00, NULL, 11),
('Laura', 'Torres', 'laura@mail.com', '5522222222', 'VENTAS', 12000.00, 'Pedro', 11),
('Miguel', 'Hernandez', 'miguel@mail.com', '5523333333', 'VENTAS', 12000.00, 'Pedro', 12),
('Sofia', 'Ruiz', 'sofia@mail.com', '5524444444', 'ADMIN', 20000.00, NULL, 13),
('Jorge', 'Castro', 'jorge@mail.com', '5525555555', 'VENTAS', 11000.00, 'Pedro', 14);
GO

/* =========================
   3️⃣ CLIENTE (IDs 11–15)
========================= */
INSERT INTO CLIENTE
(Nombre_cte, Apellido_cte, Email_cte, Telefono_cte, Direccion_cte)
VALUES
('Carlos', 'Lopez', 'carlos@mail.com', '5531111111', 'Col Roma'),
('Ana', 'Martinez', 'ana@mail.com', '5532222222', 'Col Centro'),
('Luis', 'Gomez', 'luis@mail.com', '5533333333', 'Col Juarez'),
('Maria', 'Perez', 'maria@mail.com', '5534444444', 'Col Del Valle'),
('Javier', 'Ramirez', 'javier@mail.com', '5535555555', 'Col Narvarte');
GO

/* =========================
   4️⃣ GAMA_PRODUCTO (IDs 11–15)
========================= */
INSERT INTO GAMA_PRODUCTO (Nombre_gama, Descripcion_gama)
VALUES
('Herramientas', 'Herramientas de jardinería'),
('Plantas', 'Plantas ornamentales'),
('Macetas', 'Macetas decorativas'),
('Riego', 'Sistemas de riego'),
('Sustratos', 'Tierra y fertilizantes');
GO

/* =========================
   5️⃣ PRODUCTO (IDs 11–15)
   Usa gamas 11–15
========================= */
INSERT INTO PRODUCTO
(Nombre, Descripcion, Precio_venta, Stock, Fk_id_gama)
VALUES
('Pala', 'Pala de acero', 350.00, 50, 11),
('Rosa', 'Rosa roja', 120.00, 100, 12),
('Maceta barro', 'Maceta mediana', 200.00, 40, 13),
('Aspersor', 'Aspersor circular', 450.00, 30, 14),
('Abono', 'Abono orgánico', 180.00, 60, 15);
GO

/* =========================
   6️⃣ PEDIDO (IDs 11–15)
   Usa clientes y empleados 11–15
========================= */
INSERT INTO PEDIDO
(Fecha_pedido, Fecha_prevista, Fecha_entrega, Estado, Comentarios, Fk_id_cliente, Fk_id_empleado)
VALUES
(GETDATE(), DATEADD(DAY, 5, GETDATE()), NULL, 'Pendiente', 'Pedido inicial', 11, 12),
(GETDATE(), DATEADD(DAY, 3, GETDATE()), NULL, 'Pendiente', 'Entrega rápida', 12, 13),
(GETDATE(), DATEADD(DAY, 7, GETDATE()), NULL, 'Pendiente', 'Cliente frecuente', 13, 14),
(GETDATE(), DATEADD(DAY, 4, GETDATE()), NULL, 'Pendiente', 'Compra mayor', 14, 15),
(GETDATE(), DATEADD(DAY, 6, GETDATE()), NULL, 'Pendiente', 'Pedido web', 15, 11);
GO
SELECT * FROM PEDIDO

/* =========================
   7️⃣ DETALLE_PEDIDO
========================= */
INSERT INTO DETALLE_PEDIDO
(Fk_id_pedido, Fk_id_producto, Cantidad)
VALUES
(11, 11, 2),
(11, 12, 5),
(12, 13, 3),
(13, 14, 1),
(14, 15, 4);
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- 7. PROCEDIMIENTO PARA GENERAR REPORTE DE VENTAS
ALTER PROCEDURE [dbo].[SP_REPORTE_VENTAS]
    @FechaInicio DATE,
    @FechaFin DATE
AS
BEGIN
    SET NOCOUNT ON;
    
    SELECT 
        P.Id_pedido,
        P.Fecha_pedido,
        C.Nombre_cte + ' ' + C.Apellido_cte AS Cliente,
        E.Nombre_emp + ' ' + E.Apellido_emp AS Empleado,
        P.Estado,
        SUM(PR.Precio_venta * DP.Cantidad) AS Total_Venta,
        COUNT(DISTINCT DP.Fk_id_producto) AS Cantidad_Productos
    FROM PEDIDO P
    INNER JOIN CLIENTE C ON P.Fk_id_cliente = C.Id_cliente
    INNER JOIN EMPLEADO E ON P.Fk_id_empleado = E.Id_empleado
    INNER JOIN DETALLE_PEDIDO DP ON P.Id_pedido = DP.Fk_id_pedido
    INNER JOIN PRODUCTO PR ON DP.Fk_id_producto = PR.Id_producto
    WHERE P.Fecha_pedido BETWEEN @FechaInicio AND @FechaFin
    GROUP BY P.Id_pedido, P.Fecha_pedido, C.Nombre_cte, C.Apellido_cte, 
             E.Nombre_emp, E.Apellido_emp, P.Estado
    ORDER BY P.Fecha_pedido DESC;
END;