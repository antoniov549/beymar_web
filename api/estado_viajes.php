<?php
// Mostrar errores (solo en desarrollo)
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

// Verificar token JWT
$headers = array_change_key_case(getallheaders(), CASE_LOWER);

if (!isset($headers['authorization'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token no proporcionado']);
    exit;
}

if (!preg_match('/Bearer\s(\S+)/', $headers['authorization'], $matches)) {
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

// Obtener usuario_id desde el token
$usuario_id = null;
if (is_object($decoded) && property_exists($decoded, 'data') && property_exists($decoded->data, 'usuario_id')) {
    $usuario_id = $decoded->data->usuario_id;
}

if (!$usuario_id) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'El token no contiene un usuario válido']);
    exit;
}

// Conectar a la BD
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Buscar conductor_id correspondiente al usuario_id
$sqlConductor = "SELECT conductor_id FROM conductores WHERE usuario_id = ?";
$stmtConductor = $conn->prepare($sqlConductor);
$stmtConductor->bind_param("i", $usuario_id);
$stmtConductor->execute();
$resultConductor = $stmtConductor->get_result();

if ($resultConductor->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'No existe conductor asociado a este usuario']);
    $stmtConductor->close();
    $conn->close();
    exit;
}

$rowConductor = $resultConductor->fetch_assoc();
$conductor_id = $rowConductor['conductor_id'];
$stmtConductor->close();

// Obtener datos del POST
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['viaje_id']) || empty($data['viaje_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El campo viaje_id es requerido']);
    exit;
}

$viaje_id = intval($data['viaje_id']);
$fecha_actual = date('Y-m-d H:i:s');

// Verificar que el viaje pertenece al conductor y obtener estado actual
$sqlCheck = "SELECT estado FROM viajes WHERE viaje_id = ? AND conductor_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $viaje_id, $conductor_id);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => "No tienes permiso para modificar este viaje [$viaje_id] con conductor [$conductor_id]"]);
    $stmtCheck->close();
    $conn->close();
    exit;
}

$viaje = $result->fetch_assoc();
$estado_actual = $viaje['estado'];
$stmtCheck->close();

// Determinar siguiente estado
$nuevo_estado = null;
$fecha_fin = null;

if ($estado_actual === 'Inicio_viaje') {
    $nuevo_estado = 'En_camino';
} elseif ($estado_actual === 'En_camino') {
    $nuevo_estado = 'Finalizado';
    $fecha_fin = $fecha_actual;
} elseif ($estado_actual === 'Finalizado') {
    $nuevo_estado = null; // Ya finalizado, no se actualiza
} else {
    echo json_encode(['success' => false, 'message' => "Estado actual '{$estado_actual}' no es válido para actualizar"]);
    $conn->close();
    exit;
}

// Actualizar en la base de datos si corresponde
if ($nuevo_estado !== null && $nuevo_estado !== $estado_actual) {
    if ($fecha_fin) {
        $sqlUpdate = "UPDATE viajes SET estado = ?, fecha_fin = ? WHERE viaje_id = ? AND conductor_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssii", $nuevo_estado, $fecha_fin, $viaje_id, $conductor_id);
    } else {
        $sqlUpdate = "UPDATE viajes SET estado = ? WHERE viaje_id = ? AND conductor_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sii", $nuevo_estado, $viaje_id, $conductor_id);
    }

    if (!$stmtUpdate->execute()) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado']);
        $stmtUpdate->close();
        $conn->close();
        exit;
    }
    $stmtUpdate->close();
}

// Obtener todos los viajes del conductor que NO estén finalizados
$sqlList = "SELECT * FROM viajes WHERE conductor_id = ? AND estado <> 'Finalizado'";
$stmtList = $conn->prepare($sqlList);
$stmtList->bind_param("i", $conductor_id);
$stmtList->execute();
$resultList = $stmtList->get_result();

$viajes = [];
while ($row = $resultList->fetch_assoc()) {
    $viajes[] = $row;
}
$stmtList->close();
$conn->close();

// Responder con mensaje y lista de viajes pendientes
echo json_encode([
    'success' => true,
    'message' => $nuevo_estado !== null 
        ? "Estado del viaje actualizado a '{$nuevo_estado}' correctamente" 
        : "No se actualizó el estado (ya finalizado o no aplicable)",
    'viajes_pendientes' => $viajes
]);
