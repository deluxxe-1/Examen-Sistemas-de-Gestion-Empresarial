<?php
// Parámetros configurables del SSGG (Pregunta 6 bloque 2)

define('SITE_TITLE', 'CodaERP - Módulo Base');
define('APP_VERSION', '1.0.0');
define('ENVIRONMENT', 'development'); // production, staging, development

// Base de datos (SQLite)
define('DB_PATH', __DIR__ . '/db/codaerp.sqlite');

// Configuración de Criptografía
define('CRYPTO_METHOD', 'AES-256-CBC');
// En un entorno real, la clave y el IV se cargarían de variables de entorno (.env)
define('SECRET_KEY', '5f4dcc3b5aa765d61d8327deb882cf99'); // Hash MD5 simulado 32 bytes
define('SECRET_IV', 'e3c847e3a9dcabdf'); // 16 bytes IV

// Colores UI (Temas css)
define('THEME_PRIMARY', '#3b82f6'); // Azul
define('THEME_SECONDARY', '#10b981'); // Esmeralda

// CORS para la API
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo de errores basado en entorno
if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
?>
