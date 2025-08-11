<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once './../config/db.php';         // Conexión BD
require_once './../vendor/autoload.php';   // JWT Composer
require_once './../config/jwt_config.php'; // Clave secreta

use Firebase\JWT\JWT;

// Leer datos recibidos
$data = json_decode(file_get_contents("php://input"), true);

// Validar que vengan usuario, contraseña y token de notificación
if (
    !isset($data['user_name']) || 
    !isset($data['contrasena']) || 
    (!isset($data['expoPushToken']) && !isset($data['push_token']))
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan credenciales o token de notificación']);
    exit;
}

$user = trim($data['user_name']);
$pass = trim($data['contrasena']);

// Aceptar token en ambos nombres de campo
$expoToken = isset($data['expoPushToken']) ? trim($data['expoPushToken']) : trim($data['push_token']);

// Debug opcional para verificar que llegue el token
// error_log("TOKEN RECIBIDO: " . $expoToken);

// Conexión BD
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Buscar usuario
$sql = "SELECT usuario_id, user_name, nombre, apellido, correo, contrasena, rol_id, estado 
        FROM usuarios 
        WHERE (user_name = ? OR correo = ?) AND estado = 1 LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
    exit;
}

$usuario = $result->fetch_assoc();

// Validar contraseña
if (!password_verify($pass, $usuario['contrasena'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
    exit;
}

// Verificar rol de conductor
if ($usuario['rol_id'] != 3) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'El usuario debe de ser un conductor']);
    exit;
}

// Guardar/actualizar token en notificaciones
$sqlNotif = "INSERT INTO notificaciones (usuario_id, expo_token) 
             VALUES (?, ?) 
             ON DUPLICATE KEY UPDATE expo_token = VALUES(expo_token), updated_at = CURRENT_TIMESTAMP";
$stmtNotif = $conn->prepare($sqlNotif);
$stmtNotif->bind_param("is", $usuario['usuario_id'], $expoToken);
if (!$stmtNotif->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al registrar token de notificación']);
    $stmtNotif->close();
    $conn->close();
    exit;
}
$stmtNotif->close();

// Generar JWT
$payload = [
    'iss' => JWT_ISSUER,
    'aud' => JWT_AUDIENCE,
    'iat' => time(),
    'data' => [
        'usuario_id' => $usuario['usuario_id'],
        'user_name'  => $usuario['user_name'],
        'correo'     => $usuario['correo'],
        'rol_id'     => $usuario['rol_id']
    ]
];
$jwt = JWT::encode($payload, JWT_SECRET_KEY, 'HS256');

// Respuesta
echo json_encode([
    'success' => true,
    'message' => 'Inicio de sesión exitoso y token de notificación registrado',
    'token'   => $jwt,
    'data' => [
        'usuario_id'    => $usuario['usuario_id'],
        'user_name'     => $usuario['user_name'],
        'nombre'        => $usuario['nombre'],
        'apellido'      => $usuario['apellido'],
        'correo'        => $usuario['correo'],
        'rol_id'        => $usuario['rol_id'],
        
    ]
]);

$stmt->close();
$conn->close();
?>
