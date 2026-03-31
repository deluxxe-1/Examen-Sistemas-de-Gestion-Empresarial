<?php
function handle_pagos($db, $method, $id, $body) {
    if ($method === 'GET') {
        // Obtenemos los pagos relacionales mediante un JOIN simple de SQL
        $sql = "SELECT p.*, c.nombre as cliente_nombre 
                FROM pedidos p 
                LEFT JOIN clientes c ON p.cliente_id = c.id 
                ORDER BY p.fecha_pedido DESC";
        $pagos = $db->fetchAll($sql);
        echo json_encode(['status' => 'success', 'data' => $pagos, 'total' => count($pagos)]);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
}
?>
