<?php 
if (!isset($_SESSION)) { 
    session_start();
} 

// Verificamos si la persona se había autenticado o no
if (!(isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1)) {
    // No está autenticado, redireccionamos a la autenticación
    echo "<script language='JavaScript'>location.href='/meta/login.php?logout'</script>";
    return;
}

// // Verificamos el nivel del usuario
if (!($_SESSION['nivel'] == 1)) {
    // Redireccionamos si no tiene el nivel adecuado
    echo "<script language='JavaScript'>location.href='/meta/'</script>";
    return;
}

    // Asignamos las variables de sesión
    $user_id = $_SESSION['user_id'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $nivel = $_SESSION['nivel'];
    $area = $_SESSION['area'];
    $role = $_SESSION['role'];
    $subarea = $_SESSION['subarea'];
    $foto_perfil = $_SESSION['foto_perfil'];
    $status = $_SESSION['status'];
    $user_login_status = $_SESSION['user_login_status'];
 

//var_dump($_SESSION);
?>