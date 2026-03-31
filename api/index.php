<?php
// Router Principal API (Preguntas 1-3 Bloque 1)
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db/database.php';

header('Content-Type: application/json; charset=utf-8');

// Parsear URL ej: /api/clientes/1
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/api'; // Ajustar según servidor web local

// Limpiamos el query string
$path = parse_url($request_uri, PHP_URL_PATH);
// Extraemos las partes
$parts = explode('/', trim($path, '/'));

// Identificar recurso y acción
$recurso = isset($parts[1]) ? $parts[1] : ''; // ej: clientes
$id = isset($parts[2]) ? $parts[2] : null;    // ej: 1

$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true);

$db = Database::getInstance();

try {
    switch ($recurso) {
        case 'clientes':
            require_once 'endpoints/clientes.php';
            handle_clientes($db, $method, $id, $body);
            break;
            
        case 'productos':
            require_once 'endpoints/productos.php';
            handle_productos($db, $method, $id, $body);
            break;
            
        case 'pedidos':
            require_once 'endpoints/pedidos.php';
            handle_pedidos($db, $method, $id, $body);
            break;

        case 'crypto':
            require_once 'endpoints/crypto.php';
            handle_crypto($method, $body);
            break;

        case 'docs':
            require_once 'endpoints/docs.php';
            handle_docs();
            break;
            
        case 'stats':
            // Para la gráfica (Pregunta 12 Bloque 2)
            if ($method === 'GET') {
                $ventas_mensuales = $db->fetchAll("
                    SELECT strftime('%Y-%m', fecha_pedido) as mes, SUM(total) as revenue 
                    FROM pedidos 
                    GROUP BY mes 
                    ORDER BY mes ASC
                ");
                $clientes_segmento = $db->fetchAll("
                    SELECT segmento, COUNT(*) as cantidad 
                    FROM clientes 
                    GROUP BY segmento
                ");
                echo json_encode([
                    'status' => 'success',
                    'data' => [
                        'ventas' => $ventas_mensuales,
                        'clientes' => $clientes_segmento
                    ]
                ]);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado. Opciones: /clientes, /productos, /pedidos, /crypto, /docs, /stats']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor', 'detalles' => $e->getMessage()]);
}
?>
