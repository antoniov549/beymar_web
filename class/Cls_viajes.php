<?php

class Cls_viajes {

public $errors = array();
public $messages = array();
//////////////////////////////////////////////////////////
///////////////////////////////////////

private $cnx_db;


public function __construct() {
    $this->cnx_db = mysqli_connect("localhost:3306", "www-data", "b3ym4rTravel", "beymar_travel");

    if (!$this->cnx_db) {
        throw new Exception("Conexión fallida: " . mysqli_connect_error());
    }
}

public function __destruct() {
    if ($this->cnx_db) {
        mysqli_close($this->cnx_db);
    }
}



//
function checkRole($allowed_roles) {
    if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_id'], $allowed_roles)) {
        // Redirige a una página que hayas creado, por ejemplo "acceso_denegado.php"
        
         echo "<script language='JavaScript'>location.href='../includes/acceso_denegado.php';</script>";
        return;
    }
}
// 
//////////////////////////////////////////////////////////////






///////////////////////////////
} ///FIN DEL CLASE