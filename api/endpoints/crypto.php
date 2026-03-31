<?php
function handle_crypto($method, $body) {
    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Use POST para criptografía']);
        return;
    }

    $accion = isset($body['accion']) ? $body['accion'] : '';
    $texto = isset($body['texto']) ? $body['texto'] : '';

    if (empty($texto)) {
        http_response_code(400);
        echo json_encode(['error' => 'Debe proporcionar "texto"']);
        return;
    }

    // Demostración de Técnicas Criptográficas (Preguntas 4 y 5 Bloque 1)
    switch ($accion) {
        case 'cifrar': // Criptografía de ida y vuelta (Simétrica)
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(CRYPTO_METHOD));
            $cifrado = openssl_encrypt($texto, CRYPTO_METHOD, SECRET_KEY, 0, $iv);
            $resultado = base64_encode($iv . $cifrado);
            
            echo json_encode([
                'status' => 'success',
                'operacion' => 'Cifrado Simétrico AES-256',
                'original' => $texto,
                'resultado' => $resultado,
                'es_reversible' => true
            ]);
            break;

        case 'descifrar':
            $datos = base64_decode($texto);
            $iv_length = openssl_cipher_iv_length(CRYPTO_METHOD);
            $iv = substr($datos, 0, $iv_length);
            $cifrado = substr($datos, $iv_length);
            $descifrado = openssl_decrypt($cifrado, CRYPTO_METHOD, SECRET_KEY, 0, $iv);
            
            if ($descifrado === false) {
                http_response_code(400);
                echo json_encode(['error' => 'Error al descifrar (Clave o texto inválido)']);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'operacion' => 'Descifrado AES-256',
                    'resultado' => $descifrado
                ]);
            }
            break;

        case 'hash': // Hashing irreversible
            $hash_bcrypt = password_hash($texto, PASSWORD_BCRYPT);
            $hash_sha256 = hash('sha256', $texto);
            
            echo json_encode([
                'status' => 'success',
                'operacion' => 'Funciones Hash (Irreversibles)',
                'original' => $texto,
                'bcrypt' => $hash_bcrypt,
                'sha256' => $hash_sha256,
                'es_reversible' => false
            ]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Acción inválida. Use cifrar, descifrar o hash']);
    }
}
?>
