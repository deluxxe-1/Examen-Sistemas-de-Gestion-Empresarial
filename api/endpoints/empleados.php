<?php
function handle_empleados($db, $method, $id, $body) {
    // Seguridad RBAC extra: Solo le devolvemos la nómina a los Admin
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Acceso denegado: Se requiere ROL Administrativo']);
        return;
    }

    if ($method === 'GET') {
        // No devolvemos el password_hash por seguridad
        $sql = "SELECT id, nombre, email, rol, fecha_alta FROM usuarios ORDER BY id ASC";
        $empleados = $db->fetchAll($sql);
        echo json_encode(['status' => 'success', 'data' => $empleados, 'total' => count($empleados)]);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
}
?>
