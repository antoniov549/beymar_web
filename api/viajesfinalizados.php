<?php
// Mostrar errores (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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

// Función para verificar el token JWT
function verificarToken($token) {
    try {
        return JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
    } catch (Exception $e) {
        return false;
    }
}

// Obtener token del encabezado Authorization
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

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Consulta con JOIN para traer datos de tarifas
$sql = "SELECT v.*, t.costo, t.tipo_vehiculo, t.zona, t.cantidad_personas
        FROM viajes v
        INNER JOIN tarifas t ON v.tarifa_id = t.tarifa_id
        WHERE v.estado = 'Finalizado'
        ORDER BY v.fecha_inicio DESC";

$result = $conn->query($sql);

// Comprobación de la consulta
if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la consulta SQL']);
    $conn->close();
    exit;
}

// Procesar resultados y calcular total
$viajes = [];
$total_costo = 0;

while ($row = $result->fetch_assoc()) {
    $viajes[] = $row;
    $total_costo += floatval($row['costo']); // suma de los costos
}

// Enviar respuesta
echo json_encode([
    'success' => true,
    'message' => 'Viajes finalizados obtenidos correctamente',
    'viajes' => $viajes,
    'total_costo' => $total_costo
]);

$conn->close();
?>
