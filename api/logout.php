<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');

require_once './../config/db.php';
require_once './../config/jwt_config.php';
require_once './../config/jwt_utils.php';

// Verificar token JWT
$headers = array_change_key_case(getallheaders(), CASE_LOWER);


if (!isset($headers['authorization'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token no proporcionado']);
    exit;
}

$authHeader = $headers['authorization'];
if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Formato de token inválido']);
    exit;
}

$token = $matches[1];
$decoded = verificarToken($token);
if (!$decoded || !isset($decoded->usuario_id)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido o sin datos de usuario']);
    exit;
}

$usuario_id = $decoded->usuario_id;

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// eliminar token de usuario
$stmt = $conn->prepare("DELETE FROM notificaciones WHERE usuario_id = ?");
$stmt->bind_param("s", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();


    echo json_encode(['success' => true]);


$stmt->close();
$conn->close();
?>
