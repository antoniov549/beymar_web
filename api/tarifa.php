<?php
// Mostrar errores durante desarrollo (puedes desactivarlos en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Encabezados HTTP
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');

// Requiere configuración
require_once './../config/db.php';
require_once './../config/jwt_config.php';
require_once './../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Función para validar token JWT
function verificarToken($token) {
    try {
        return JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
    } catch (Exception $e) {
        return false;
    }
}


// Verificar token JWT
$headers = array_change_key_case(getallheaders(), CASE_LOWER);

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

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Consulta de tarifas
$sql = "SELECT tarifa_id, tipo_vehiculo, tipo_viaje, zona, cantidad_personas, costo FROM tarifas ORDER BY tarifa_id";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta']);
    exit;
}

// Procesar resultados
$tarifas = [];
while ($row = $result->fetch_assoc()) {
    $tarifas[] = $row;
}

// Enviar respuesta JSON
echo json_encode([
    'success' => true,
    'message' => 'Tarifas obtenidas correctamente',
    'data' => $tarifas
]);

$conn->close();
?>
