<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    echo "<script language='JavaScript'>location.href='pages/sign-in.php';</script>";
    exit;
}

header('Location: pages/home.php');
exit;
//phpinfo();
?>

