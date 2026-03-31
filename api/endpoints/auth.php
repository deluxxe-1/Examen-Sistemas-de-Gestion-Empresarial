<?php
function handle_auth($db, $method, $id, $body) {
    
    // Devolver los datos de la sesión actual
    if ($method === 'GET' && $id === 'me') {
        if (isset($_SESSION['usuario_id'])) {
            echo json_encode([
                'status' => 'success',
                'authed' => true,
                'user' => [
                    'id' => $_SESSION['usuario_id'],
                    'nombre' => $_SESSION['nombre'],
                    'rol' => $_SESSION['rol']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'authed' => false, 'error' => 'No session']);
        }
        return;
    }

    // Procesar el Login
    if ($method === 'POST' && $id === 'login') {
        $email = isset($body['email']) ? $body['email'] : '';
        $password = isset($body['password']) ? $body['password'] : '';

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan credenciales']);
            return;
        }

        $usuario = $db->fetch("SELECT * FROM usuarios WHERE email = ?", [$email]);

        // Pregunta 5 Examen: Verificación del Hash
        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            // Login correcto -> Crear sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre']     = $usuario['nombre'];
            $_SESSION['rol']        = $usuario['rol'];

            echo json_encode([
                'status' => 'success',
                'user' => [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'rol' => $usuario['rol']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales inválidas']);
        }
        return;
    }
    
    // Procesar Logout
    if ($method === 'POST' && $id === 'logout') {
        session_destroy();
        echo json_encode(['status' => 'success']);
        return;
    }

    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
