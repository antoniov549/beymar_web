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

        $title = 'Tienes un nuevo viaje';
        $message = 'Conductor insertado correctamente.';

        $token=$this->sendNotification($conductor_id, $message, $title);

        return [
            'success' => true,
            'message' => '<div class="alert alert-success" role="alert">Conductor insertado correctamente. '.$token.' </div>',
            'id_insertado' => $nuevo_id
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>'
        ];
    }
}

// --------------------------------------------------

function sendNotification($conductor_id, $message, $title) {

    $tokenData = $this->Get_token_usuario_movil($conductor_id);
    if (!$tokenData || empty($tokenData['token'])) {
        // No token disponible, abortar o manejar el error
        return ['success' => false, 'error' => 'Token de dispositivo no encontrado'];
    }

    $token = $tokenData['token'];

    $body = [
        'to'    => $token, // Ejemplo: 'ExponentPushToken[z-vjh5MGLhswMs8t_Xnj1c]'
        'sound' => 'default',
        'title' => $title,
        'body'  => $message,
        'data'  => ['extraData' => 'Información extra']
    ];

    $ch = curl_init('https://exp.host/--/api/v2/push/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'error' => $error];
    }

    return ['success' => true, 'response' => json_decode($response, true)];
}

// --------------------------------------------------

public function Get_token_usuario_movil($conductor_id) {
    try {

        $usuario = $this->Get_usuario_conductor($conductor_id);

        if (!$usuario || !isset($usuario['usuario_id'])) {
            throw new Exception('No se encontró usuario para el conductor.');
        }

        $usuario_id = (int)$usuario['usuario_id'];

        $filtro = [];
        $filtro[] = "(tk.usuario_id = $usuario_id)";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '*';
        $tabla_principal = 'notificaciones as tk';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
        ";

        $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
            throw new Exception('Error en consulta SQL: ' . mysqli_error($this->cnx_db));
        }

        $fila = mysqli_fetch_assoc($result);

        if (!$fila) {
            throw new Exception('No se encontró token de notificación.');
        }

        return $fila;

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

// --------------------------------------------------

public function Get_usuario_conductor($conductor_id) {
    try {

        $filtro = [];
        $filtro[] = "(cd.conductor_id = " . (int)$conductor_id . ")";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = 'us.usuario_id';
        $tabla_principal = 'conductores as cd';
        $inner_usuarios = 'INNER JOIN usuarios as us ON cd.usuario_id = us.usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_usuarios
            $where
        ";

        $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
            throw new Exception('Error en consulta SQL: ' . mysqli_error($this->cnx_db));
        }

        $fila = mysqli_fetch_assoc($result);

        if (!$fila) {
            throw new Exception('No se encontró usuario para el conductor.');
        }

        return $fila;

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






////////////
// 
public function Get_tabla_viajes() {
    try {
       
        $filtro = [];
        // $filtro[] = "(vc.fecha_desasignacion IS NULL)";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        // 
        $campos_select = '
            vj.*,
            vh.*,
            cd.*,
            us.*,
            vj.estado as viaje_estado
        ';

        $tabla_principal = '( SELECT * from vehiculo_conductor WHERE fecha_desasignacion IS NULL ) AS vc';
        $inner_viajes = 'INNER JOIN viajes AS vj ON vc.conductor_id = vj.conductor_id';
        $inner_vehiculos = 'INNER JOIN vehiculos AS vh ON vc.vehiculo_id = vh.vehiculo_id';
        $inner_conductores = 'INNER JOIN conductores AS cd ON vc.conductor_id = cd.conductor_id';
        $inner_usuarios = 'INNER JOIN usuarios AS us ON cd.usuario_id = us.usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_viajes
            $inner_vehiculos
            $inner_conductores
            $inner_usuarios 
            $where
        ";

        // Puedes comentar o quitar el echo cuando ya funcione
        echo "<div class='alert alert-success' role='alert'>Get_tabla_viajes:<br>".$consulta."</div>";
        $result = mysqli_query($this->cnx_db, $consulta);

        if (!$result) {
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
        return false; // O null según convenga
    }
}
// 

/////////

//







///////////////////////////////
} ///FIN DEL CLASE