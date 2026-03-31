<?php
function handle_clientes($db, $method, $id, $body) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $cliente = $db->fetch("SELECT * FROM clientes WHERE id = ?", [$id]);
                if ($cliente) {
                    echo json_encode(['status' => 'success', 'data' => $cliente]);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Cliente no encontrado']);
                }
            } else {
                // Listado general (Pregunta 10 Bloque 2 - Consulta)
                $clientes = $db->fetchAll("SELECT * FROM clientes ORDER BY fecha_registro DESC");
                echo json_encode(['status' => 'success', 'data' => $clientes, 'total' => count($clientes)]);
            }
            break;

        case 'POST': // Crear cliente
            if (!empty($body['nombre']) && !empty($body['email'])) {
                $newId = $db->insert('clientes', [
                    'nombre' => $body['nombre'],
                    'email' => $body['email'],
                    'empresa' => isset($body['empresa']) ? $body['empresa'] : null,
                    'segmento' => isset($body['segmento']) ? $body['segmento'] : 'General'
                ]);
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Cliente creado', 'id' => $newId]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Falta nombre o email en payload']);
            }
            break;
            
        case 'PUT': // No implementado en demo corta
        case 'DELETE':
            http_response_code(501);
            echo json_encode(['error' => 'Método no implementado en esta demo corta']);
            break;
    }
}
?>
