<?php
// Mostrar errores (solo en desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Encabezados
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');

// Configuración y librerías
require_once './../config/db.php';
require_once './../config/jwt_config.php';
require_once './../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// -------------------------
// Función para verificar JWT
// -------------------------
function verificarToken($token) {
    try {
        return JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
    } catch (Exception $e) {
        return false;
    }
}

// -------------------------
// Verificación de token
// -------------------------
$headers = array_change_key_case(getallheaders(), CASE_LOWER);

if (empty($headers['authorization']) || !preg_match('/Bearer\s(\S+)/', $headers['authorization'], $matches)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token no proporcionado o formato inválido']);
    exit;
}

$decoded = verificarToken($matches[1]);
if (!$decoded || !isset($decoded->data->usuario_id)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido o expirado']);
    exit;
}

$usuario_id = (int) $decoded->data->usuario_id;

// -------------------------
// Conexión a la base de datos
// -------------------------
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// -------------------------
// Obtener conductor_id
// -------------------------
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

$conductor_id = (int) $resultConductor->fetch_assoc()['conductor_id'];
$stmtConductor->close();

// -------------------------
// Obtener viajes activos
// -------------------------
$sqlViajes = "SELECT * 
              FROM viajes 
              WHERE estado IN ('Inicio_viaje', 'En_camino') 
              AND conductor_id = ? 
              ORDER BY fecha_inicio DESC";
$stmtViajes = $conn->prepare($sqlViajes);
$stmtViajes->bind_param("i", $conductor_id);
$stmtViajes->execute();
$resultViajes = $stmtViajes->get_result();

$viajes = $resultViajes->fetch_all(MYSQLI_ASSOC);
$stmtViajes->close();

// -------------------------
// Respuesta JSON
// -------------------------
echo json_encode([
    'success' => true,
    'message' => 'Viajes obtenidos correctamente',
    'viajes' => $viajes
]);

$conn->close();
