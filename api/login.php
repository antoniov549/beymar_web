<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once './../config/db.php';         // tu conexión a la BD
require_once './../vendor/autoload.php';   // carga JWT con Composer
require_once './../config/jwt_config.php'; // clave secreta

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_name']) || !isset($data['contrasena'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan credenciales']);
    exit;
}

$user = $data['user_name'];
$pass = $data['contrasena'];

// Conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}
$conn->set_charset("utf8");

// Consulta segura
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

if (!password_verify($pass, $usuario['contrasena'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
    exit;
}

if ($usuario['rol_id'] != 3) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'El usuario debe de ser un conductor']);
    exit;
}

// ✅ Generar JWT
$issuedAt = time();

$payload = [
    'iss' => JWT_ISSUER,
    'aud' => JWT_AUDIENCE,
    'iat' => $issuedAt,
    'data' => [
        'usuario_id' => $usuario['usuario_id'],
        'user_name'  => $usuario['user_name'],
        'correo'     => $usuario['correo'],
        'rol_id'     => $usuario['rol_id']
    ]
];

$jwt = JWT::encode($payload, JWT_SECRET_KEY, 'HS256');

// 🔁 Responder con el token
echo json_encode([
    'success' => true,
    'message' => 'Inicio de sesión exitoso',
    'token'   => $jwt,
    'data' => [
        'usuario_id' => $usuario['usuario_id'],
        'user_name'  => $usuario['user_name'],
        'nombre'     => $usuario['nombre'],
        'apellido'   => $usuario['apellido'],
        'correo'     => $usuario['correo'],
        'rol_id'     => $usuario['rol_id']
    ]
]);

$stmt->close();
$conn->close();
?>
