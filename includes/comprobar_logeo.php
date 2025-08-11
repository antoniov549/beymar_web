<?php 
if (!isset($_SESSION)) { 
    session_start();
} 

// Verificamos si la persona se había autenticado o no
if (!(isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1)) {
    // No está autenticado, redireccionamos a la autenticación
      echo "<script language='JavaScript'>location.href='/pages/sign-in.php';</script>";
    return;
}

// Asignamos las variables de sesión
$usuario_id = $_SESSION['usuario_id'];
$user_name = $_SESSION['user_name'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$correo = $_SESSION['correo'];
$rol_id = $_SESSION['rol_id'];
$estado = $_SESSION['estado'];
$user_login_status = $_SESSION['user_login_status'];
 

//var_dump($_SESSION);
?>