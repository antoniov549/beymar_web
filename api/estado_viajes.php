<?php
// Mostrar errores (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Encabezados
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

// Configuración y librerías
require_once './../config/db.php';
require_once './../config/jwt_config.php';
require_once './../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Función para verificar token
function verificarToken($token) {
    try {
        return JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
    } catch (Exception $e) {
        return false;
    }
}

// Obtener token del encabezado
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token no proporcionado']);
    exit;
}

if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Formato de token inválido']);
    exit;
}

$token = $matches[1];
$decoded = verificarToken($token);
if (!$decoded) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido o expirado']);
    exit;
}

// Obtener el usuario_id dentro de data
$conductor_id = null;
if (is_object($decoded) && property_exists($decoded, 'data') && property_exists($decoded->data, 'usuario_id')) {
    $conductor_id = $decoded->data->usuario_id;
}

if (!$conductor_id) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'El token no contiene un usuario válido']);
    exit;
}

// Obtener datos enviados por POST
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['viaje_id']) || empty($data['viaje_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El campo viaje_id es requerido']);
    exit;
}

$viaje_id = intval($data['viaje_id']);
$fecha_fin = date('Y-m-d H:i:s');

// Conexión a la BD
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Verificar que el viaje pertenece al conductor autenticado
$sqlCheck = "SELECT * FROM viajes WHERE viaje_id = ? AND conductor_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $viaje_id, $conductor_id);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'No tienes permiso para modificar este viaje']);
    $stmtCheck->close();
    $conn->close();
    exit;
}
$stmtCheck->close();

// Actualizar estado y fecha_fin
$sql = "UPDATE viajes 
        SET estado = 'Finalizado', fecha_fin = ? 
        WHERE viaje_id = ? AND conductor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $fecha_fin, $viaje_id, $conductor_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'El viaje se actualizó a Finalizado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo actualizar el viaje o ya estaba finalizado'
        ]);
    }
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al ejecutar la actualización'
    ]);
}

$stmt->close();
$conn->close();
