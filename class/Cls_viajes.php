<?php

class Cls_viajes {

public $errors = array();
public $messages = array();
//////////////////////////////////////////////////////////
///////////////////////////////////////

private $cnx_db;


public function __construct() {
    // Incluir configuración de base de datos
    require_once(__DIR__ . '/../config/db.php');
    
    $this->cnx_db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

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


public function insertar_viaje($conductor_id, $tarifa_id, $pasajero, $fecha_inicio, $estado) {
    try {
        $conductor_id = (int)$conductor_id;
        $tarifa_id = (int)$tarifa_id;
        $pasajero = mysqli_real_escape_string($this->cnx_db, strip_tags($pasajero, ENT_QUOTES));
        $fecha_inicio = mysqli_real_escape_string($this->cnx_db, strip_tags($fecha_inicio, ENT_QUOTES));
        $estado = mysqli_real_escape_string($this->cnx_db, strip_tags($estado, ENT_QUOTES));

        $query = "INSERT INTO viajes (conductor_id, tarifa_id, pasajero, fecha_inicio, estado)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->cnx_db->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en prepare: " . $this->cnx_db->error);
        }

        $stmt->bind_param("iisss", $conductor_id, $tarifa_id, $pasajero, $fecha_inicio, $estado);

        if (!$stmt->execute()) {
            throw new Exception("Error en execute: " . $stmt->error);
        }

        $nuevo_id = $this->cnx_db->insert_id;

        return [
            'success' => true,
            'message' => '<div class="alert alert-success" role="alert">Conductor insertado correctamente.</div>',
            'id_insertado' => $nuevo_id
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>'
        ];
    }
}




///////////////////////////////
} ///FIN DEL CLASE