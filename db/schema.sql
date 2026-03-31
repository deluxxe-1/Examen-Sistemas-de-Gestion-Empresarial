-- Sistema de CodaERP: Base de Datos
-- Pregunta 9: Tablas y campos que tiene la base de datos

CREATE TABLE IF NOT EXISTS clientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    empresa VARCHAR(100),
    segmento VARCHAR(50) DEFAULT 'General', -- B2B, B2C, VIP
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT 1
);

CREATE TABLE IF NOT EXISTS categorias (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INTEGER DEFAULT 0,
    categoria_id INTEGER,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cliente_id INTEGER NOT NULL,
    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(30) DEFAULT 'Pendiente', -- Pendiente, Pagado, Enviado, Entregado, Cancelado
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    metodo_pago VARCHAR(50), -- Tarjeta, Transferencia, Cripto
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE TABLE IF NOT EXISTS pedido_lineas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pedido_id INTEGER NOT NULL,
    producto_id INTEGER NOT NULL,
    cantidad INTEGER NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE IF NOT EXISTS logs_auditoria (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    entidad VARCHAR(50) NOT NULL,
    entidad_id INTEGER NOT NULL,
    accion VARCHAR(20) NOT NULL, -- CREATE, UPDATE, DELETE
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_id INTEGER, -- Quién hizo el cambio
    detalles_json TEXT -- Payload con el estado anterior y nuevo
);

-- Datos por defecto para demostración
INSERT INTO categorias (nombre) VALUES ('Electrónica'), ('Software'), ('Servicios'), ('Oficina');
INSERT INTO clientes (nombre, email, empresa, segmento) VALUES 
('Ana García', 'ana@techsol.com', 'Tech Solutions', 'B2B'),
('Luis Pérez', 'luis.perez@startuplabs.io', 'StartupLabs', 'VIP'),
('María López', 'mlopez@freelance.net', null, 'B2C');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES
('Licencia ERP Cloud Anual', 'Suscripción SaaS ERP módulo base', 1200.00, 999, 2),
('Terminal TPV Inteligente', 'Hardware Android con NFC', 350.50, 45, 1),
('Consultoría Implementación', '10 horas de configuración experta', 800.00, 100, 3);

INSERT INTO pedidos (cliente_id, estado, total, metodo_pago) VALUES
(1, 'Pagado', 1550.50, 'Transferencia'),
(2, 'Pendiente', 800.00, 'Tarjeta');

INSERT INTO pedido_lineas (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES
(1, 1, 1, 1200.00, 1200.00),
(1, 2, 1, 350.50, 350.50),
(2, 3, 1, 800.00, 800.00);
