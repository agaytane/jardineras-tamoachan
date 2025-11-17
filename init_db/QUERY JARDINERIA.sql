CREATE DATABASE AGE_JARDINES_TAMOANCHAN;
USE AGE_JARDINES_TAMOANCHAN;

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
CREATE TABLE PRODUCTO (
    Id_producto INT PRIMARY KEY,
    Nombre VARCHAR(20),
    Descripcion VARCHAR(20),
    Precio_venta DECIMAL(10,2),
    Stock INT,
    Fk_id_gama INT FOREIGN KEY REFERENCES GAMA_PRODUCTO(Id_gama)  
)
GO

CREATE TABLE GAMA_PRODUCTO(
    Id_gama INT PRIMARY KEY,
    Nombre_gama VARCHAR(20),
    Descripcion_gama VARCHAR(30)
)
GO

CREATE TABLE DETALLE_PEDIDO(
    Fk_id_pedido INT FOREIGN KEY REFERENCES PEDIDO(Id_pedido),
    Fk_id_producto INT FOREIGN KEY REFERENCES PRODUCTO(Id_producto),
    Cantidad INT
) 
GO
