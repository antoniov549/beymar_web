<?php

class Cls_inicio {

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
function cambioDesdeAyer($valorAyer, $valorHoy) {
    if ($valorAyer == 0) {
        return [
            'signo' => '-',
            'porcentaje' => 'No se puede calcular (ayer fue 0)',
            'clase_texto' => 'text-red-600'
        ];
    }
    
    $cambio = (($valorHoy - $valorAyer) / $valorAyer) * 100;
    $signo = $cambio >= 0 ? '+' : '';
    $clase_texto = ($signo === '+') ? 'text-emerald-500' : 'text-red-600';

    return [
        'signo' => $signo,
        'porcentaje' => number_format($cambio, 2) . '%',
        'clase_texto' => $clase_texto
    ];
}



public function Get_obtner_costos_por_dia ($cantidad_dias) {
    try {

        $filtro = [];
        // $filtro[] = "(cd.conductor_id = " . (int)$conductor_id . ")";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
            DATE(viaje.fecha_inicio) AS fecha,
            SUM(tarifa.costo) AS total_costo
        ';
        $tabla_principal = '
            viajes AS viaje
        ';
        $inner_tarifas = ' INNER JOIN tarifas AS tarifa ON viaje.tarifa_id = tarifa.tarifa_id ';
        $group='GROUP BY DATE(viaje.fecha_inicio)';
        $order='ORDER BY fecha DESC';

        if (!empty($cantidad_dias)) {
            $limit='limit '.$cantidad_dias.'';
        }else{
            $limit='';
        }


        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_tarifas
            $where
            $group
            $order
            $limit
        ";

    
        // Puedes comentar o quitar el echo cuando ya funcione
        // echo "<div class='alert alert-success' role='alert'>Get_obtner_costos_por_dia:<br>".$consulta."</div>";
       $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
            // La consulta falló, muestro error y dejo de procesar
             throw new Exception('Error en consulta SQL: ' . mysqli_error($this->cnx_db));
        }
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return false;
    }
}
// 



public function Get_obtner_usuarios_por_dia ($cantidad_dias = null, $rol_id = null) {
    try {

        $filtro = [];
        if (!empty($rol_id)) {
            $filtro[] = "(usuario.rol_id = " . (int)$rol_id . ")";
        }
       
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
            DATE(usuario.created_at) AS fecha, 
            COUNT(user_name) AS total_users 

        ';
        $tabla_principal = '
            usuarios AS usuario 
        ';
        
        $group='GROUP BY DATE(usuario.created_at)';
        $order='ORDER BY fecha DESC ';

        if (!empty($cantidad_dias)) {
            $limit='limit '.$cantidad_dias.'';
        }else{
            $limit='';
        }


        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
            $limit
        ";

    
        // Puedes comentar o quitar el echo cuando ya funcione
        // echo "<div class='alert alert-success' role='alert'>Get_obtner_usuarios_por_dia:<br>".$consulta."</div>";
       $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
            // La consulta falló, muestro error y dejo de procesar
             throw new Exception('Error en consulta SQL: ' . mysqli_error($this->cnx_db));
        }
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return false;
    }
}


public function Get_viajes_solicitadospor_dia($cantidad_dias = null, $estado = null) {
    try {

        $filtro = [];
        if (!empty($estado)) {
            $filtro[] = "(viaje.estado = '".$estado. "' )";
        }
       
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
            DATE(viaje.fecha_inicio) AS fecha, 
            COUNT(viaje_id) AS total_viajes 

        ';
        $tabla_principal = '
           viajes AS viaje
        ';
        
        $group='GROUP BY DATE(viaje.fecha_inicio)';
        $order='ORDER BY fecha DESC';

        if (!empty($cantidad_dias)) {
            $limit='limit '.$cantidad_dias.'';
        }else{
            $limit='';
        }


        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
            $limit
        ";

    
        // Puedes comentar o quitar el echo cuando ya funcione
        echo "<div class='alert alert-success' role='alert'>Get_viajes_solicitadospor_dia:<br>".$consulta."</div>";
       $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
            // La consulta falló, muestro error y dejo de procesar
             throw new Exception('Error en consulta SQL: ' . mysqli_error($this->cnx_db));
        }
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return false;
    }
}


public function Get_viajes_finalizados_dia($cantidad_dias = null, $estado = null) {
    try {

        $filtro = [];
        if (!empty($estado)) {
            $filtro[] = "(viaje.estado = '".$estado. "' )";
        }
       
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
            DATE(viaje.fecha_fin) AS fecha, 
            COUNT(viaje_id) AS total_viajes 

        ';
        $tabla_principal = '
           viajes AS viaje
        ';
        
        $group='GROUP BY DATE(viaje.fecha_fin)';
        $order='ORDER BY fecha DESC';

        if (!empty($cantidad_dias)) {
            $limit='limit '.$cantidad_dias.'';
        }else{
            $limit='';
        }


        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
            $limit
        ";

    
        // Puedes comentar o quitar el echo cuando ya funcione
        echo "<div class='alert alert-success' role='alert'>Get_viajes_solicitadospor_dia:<br>".$consulta."</div>";
       $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
            // La consulta falló, muestro error y dejo de procesar
             throw new Exception('Error en consulta SQL: ' . mysqli_error($this->cnx_db));
        }
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return false;
    }
}






///////////////////////////////
} ///FIN DEL CLASE