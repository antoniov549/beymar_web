<?php

class Cls_tarifas {

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


///////////////////////////////////////
public function Get_rango_de_tarifas_por($zona) {
    try {
        
        $zona = mysqli_real_escape_string($this->cnx_db, strip_tags($zona, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        if (!empty($zona)) {
            // code...
            $filtro[]="( zona = '".$zona."')";
        }
        

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='tipo_vehiculo,tipo_viaje,zona,MIN(cantidad_personas) minimo,MAX(cantidad_personas) maximo,costo';
        $tabla_principal = ' tarifas as tarifa ';
        $group = 'group by tipo_vehiculo,tipo_viaje,zona,costo';
        $order = 'ORDER BY zona';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
        ";
        
         // echo "<div class='alert alert-success' role='alert'>Get_rango_de_tarifas_por:<br>".$consulta."</div>";
        //$result=mysqli_fetch_assoc(mysqli_query($this->cnx_db,$consulta));
        $result=mysqli_query($this->cnx_db,$consulta);
        return $result;
        
    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
    }
}
////////////////////////////////////////////////////////////


///////////////////////////////////////
public function Get_zonas_disponibles( ) {
    try {
        
        // $zona = mysqli_real_escape_string($this->cnx_db, strip_tags($zona, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        // $filtro[]="( zona = '".$zona."')";

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='zona,min(costo) costo_minimo ,MAX(costo) costo_max';
        $tabla_principal = ' tarifas as tarifa ';
        $group = 'group by zona';
        $order = 'ORDER BY zona';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
        ";
        
         // echo "<div class='alert alert-success' role='alert'>Get_zonas_disponibles:<br>".$consulta."</div>";
        //$result=mysqli_fetch_assoc(mysqli_query($this->cnx_db,$consulta));
        $result=mysqli_query($this->cnx_db,$consulta);
        return $result;
        
    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
    }
}
////////////////////////////////////////////////////////////

function obtenerPorId($idBuscado) {
    $array = [
        ["id" => "Area Cancun (centro)",    "imagen" => "area cancun (centro).png",    "direccion" => "Blvd. Kukulcan Km. 4-5, Kukulcan Boulevard, Zona Hotelera, 77500 Cancún, Q.R.",
        "calificacion" => "⭐⭐⭐⭐☆"],

        ["id" => "Area Zona Hotelera",      "imagen" => "area zona hotelera.png",      "direccion" => "Zona Hotelera Cancún, Q.R.",
        "calificacion" => "⭐⭐⭐☆☆"],

        ["id" => "Costa Mujeres",           "imagen" => "costa mujeres.png",           "direccion" => "Costa Mujeres 77420 Q.R.",
        "calificacion" => "⭐⭐☆☆☆"],

        ["id" => "dorado royale-maroma",    "imagen" => "dorado_royale_maroma.png",    "direccion" => "Hotel Dorado Maroma & Spa",
        "calificacion" => "⭐☆☆☆☆"],

        ["id" => "Playa del Carmen",        "imagen" => "playa del carmen.png",        "direccion" => "Playa del Carmen Quintana Roo",
        "calificacion" => "⭐⭐⭐☆☆"],

        ["id" => "Playa Mujeres",           "imagen" => "playa mujeres.png",           "direccion" => "Cancún - Punta Cancún, Kukulcan Boulevard, Zona Hotelera, 77500 Cancún, Q.R.",
        "calificacion" => "⭐⭐☆☆☆"],

        ["id" => "puerto juarez",           "imagen" => "puerto juarez.png",           "direccion" => "Puerto Cancun Puerto Juarez 77500 Q.R.",
        "calificacion" => "⭐☆☆☆☆"],

        ["id" => "puerto morelos",          "imagen" => "puerto morelos.png",          "direccion" => "Puerto Morelos Quintana Roo",
        "calificacion" => "⭐☆☆☆☆"],

        ["id" => "pto aventuras",           "imagen" => "punta venado.png",            "direccion" => "Carr. Cancún - Tulum, 77735 Chacalal, Q.R.",
        "calificacion" => "⭐⭐☆☆☆"],

        ["id" => "pto aventuras",           "imagen" => "pto aventuras.png",           "direccion" => "Puerto Aventuras Hotel & Beach Club",
        "calificacion" => "⭐⭐⭐☆☆"],

        ["id" => "catalonia royal",         "imagen" => "catalonia royal.png",         "direccion" => "Hotel Catalonia Royal Tulum - Adults Only",
        "calificacion" => "⭐⭐⭐⭐☆"],

        ["id" => "tulum centro",            "imagen" => "tulum centro.png",            "direccion" => "Tulum Centro Col Huracanes 77760 Tulum, Q.R.",
        "calificacion" => "⭐⭐⭐⭐⭐"],

        ["id" => "tulum zona hotelera",     "imagen" => "tulum zona hotelera.png",     "direccion" => " Zona Hotelera Tulum Quintana Roo ",
        "calificacion" => "⭐⭐⭐⭐⭐"],
    ];

    foreach ($array as $elemento) {
        if (strcasecmp($elemento['id'], $idBuscado) == 0) { // comparación case-insensitive
            return $elemento;
        }
    }
    return null; // No encontrado
}




///////////////////////////////////////
public function Get_informacion_tarifas($zona, $vehiculo, $viaje, $minimo, $maximo ) {
    try {
        
        $zona = mysqli_real_escape_string($this->cnx_db, strip_tags($zona, ENT_QUOTES));
        $vehiculo = mysqli_real_escape_string($this->cnx_db, strip_tags($vehiculo, ENT_QUOTES));
        $viaje = mysqli_real_escape_string($this->cnx_db, strip_tags($viaje, ENT_QUOTES));
        $minimo = mysqli_real_escape_string($this->cnx_db, strip_tags($minimo, ENT_QUOTES));
        $maximo = mysqli_real_escape_string($this->cnx_db, strip_tags($maximo, ENT_QUOTES));
        
        
        $filtro = [];
        if (!empty($zona)) { $filtro[]="( zona = '".$zona."')";  }

        if (!empty($vehiculo)) { $filtro[]="( tipo_vehiculo = '".$vehiculo."')";  }

        if (!empty($viaje)) { $filtro[]="( tipo_viaje = '".$viaje."')";  }

       if (!empty($minimo) && !empty($maximo) && is_numeric($minimo) && is_numeric($maximo)) {
            $filtro[] = "(cantidad_personas BETWEEN '".$minimo."' AND '".$maximo."')";
        }elseif (!empty($minimo)) {
             $filtro[] = "(cantidad_personas = '".$minimo."')";
        }elseif (!empty($maximo)) {
            $filtro[] = "(cantidad_personas = '".$maximo."')";
        }


        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='*';
        $tabla_principal = ' tarifas as tarifa ';
        $group = '';
        $order = 'ORDER BY cantidad_personas';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
        ";
        
         echo "<div class='alert alert-success' role='alert'>Get_informacion_tarifas:<br>".$consulta."</div>";
        //$result=mysqli_fetch_assoc(mysqli_query($this->cnx_db,$consulta));
        $result=mysqli_query($this->cnx_db,$consulta);
        return $result;
        
    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
    }
}
////////////////////////////////////////////////////////////




///////////////////////////////
} ///FIN DEL CLASE