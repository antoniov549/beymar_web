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
if (!$decoded || !isset($decoded->user_name)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido o sin datos de usuario']);
    exit;
}

$user_name = $decoded->user_name;

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Consultar datos del usuario
$stmt = $conn->prepare("SELECT usuario_id, user_name, nombre, apellido, correo, rol_id, estado, created_at, updated_at FROM usuarios WHERE user_name = ?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'usuario' => $row]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
?>
