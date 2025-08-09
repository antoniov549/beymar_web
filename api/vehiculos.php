<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');

require_once './../config/db.php';
require_once './../config/jwt_config.php';
require_once './../config/jwt_utils.php';

// Verificar token JWT
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token no proporcionado']);
    exit;
}

$authHeader = $headers['Authorization'];
if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Formato de token inválido']);
    exit;
}

$token = $matches[1];
$decoded = verificarToken($token);
if (!$decoded || !isset($decoded->correo)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido o sin información del usuario']);
    exit;
}

$correo = $decoded->correo;

// Conectar base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}
$conn->set_charset("utf8");

// Consulta JOIN para obtener los datos del vehículo del usuario autenticado
$sql = "
SELECT v.*
FROM usuarios u
JOIN conductores c ON u.usuario_id = c.usuario_id
JOIN vehiculos v ON c.vehiculo_id = v.vehiculo_id
WHERE u.correo = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'vehiculo' => [
            'vehiculo_id' => $row['vehiculo_id'],
            'modelo' => $row['modelo'],
            'color' => $row['color'],
            'placas' => $row['placas'],
            'capacidad' => $row['capacidad'],
            'tipo' => $row['tipo'],
            'documentacion_id' => $row['documentacion_id'],
            'estado' => $row['estado']
        ]
    ]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Vehículo no encontrado']);
}

$stmt->close();
$conn->close();
?>
