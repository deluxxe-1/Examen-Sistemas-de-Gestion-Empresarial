-- Sistema de CodaERP: Base de Datos con Control de Roles (RBAC)

CREATE TABLE IF NOT EXISTS clientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    empresa VARCHAR(100),
    segmento VARCHAR(50) DEFAULT 'General',
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
    estado VARCHAR(30) DEFAULT 'Pendiente',
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    metodo_pago VARCHAR(50),
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

CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol VARCHAR(50) DEFAULT 'Empleado', -- Admin, Empleado
    fecha_alta DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Datos por defecto

-- Hashes generados con password_hash de PHP (Bcrypt). El pass es: '1234' para ambos.
INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES 
('Administrador', 'admin@codaerp.com', '$2y$12$l7xYbTVaRGNUodVMpkeVy.vqsxZHh3BpsrcXsYvffEASOly2GVXaq', 'Admin'),
('Comercial Ventas', 'ventas@codaerp.com', '$2y$12$l7xYbTVaRGNUodVMpkeVy.vqsxZHh3BpsrcXsYvffEASOly2GVXaq', 'Empleado');

INSERT INTO categorias (nombre) VALUES ('Electrónica'), ('Software'), ('Servicios'), ('Oficina');
INSERT INTO clientes (nombre, email, empresa, segmento) VALUES 
('Ana García', 'ana@techsol.com', 'Tech Solutions', 'B2B'),
('Luis Pérez', 'luis.perez@startuplabs.io', 'StartupLabs', 'VIP'),
('María López', 'mlopez@freelance.net', null, 'B2C');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES
('Licencia ERP Cloud Anual', 'Suscripción SaaS', 1200.00, 999, 2),
('Terminal TPV Inteligente', 'Hardware Android', 350.50, 45, 1);

INSERT INTO pedidos (cliente_id, estado, total, metodo_pago) VALUES
(1, 'Pagado', 1550.50, 'Transferencia'),
(2, 'Pendiente', 800.00, 'Tarjeta');

INSERT INTO pedido_lineas (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES
(1, 1, 1, 1200.00, 1200.00),
(1, 2, 1, 350.50, 350.50),
(2, 3, 1, 800.00, 800.00);
