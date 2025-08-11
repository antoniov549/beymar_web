<?php

class Cls_conductores {

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


///////////////////////////////////////
public function Get_conductores_activos() {
    try {
        // $rol_id = mysqli_real_escape_string($this->cnx_db, strip_tags($rol_id, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        $filtro[]="( usr.estado = '1')";
        $filtro[]="( rol.rol_id = '3')";

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
        $campos_select='
            conductor.*,
            rol.nombre as rol_nombre, IF(usr.estado = 1, "activo", "borrado" ) AS estado_usuario,
            usr.user_name
        ';
        $tabla_principal = ' usuarios  as usr ';
        $inner_roles='INNER JOIN  roles as rol ON usr.rol_id = rol.rol_id';
        $inner_conductores='INNER JOIN conductores as conductor ON usr.usuario_id = conductor.usuario_id';
       
      
        $group = '';
        $order = 'ORDER BY usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_roles
            $inner_conductores
            $where
            $group
            $order
        ";
        
         // echo "<div class='alert alert-success' role='alert'>Get_conductores_activos:<br>".$consulta."</div>";
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

// 
public function asignarConductorAVehiculo($vehiculo_id, $conductor_id) {
  try {
    if (empty($vehiculo_id) || empty($conductor_id)) {
      return ['success' => false, 'message' => 'Faltan datos'];
    }

    // Verificar si ya hay un conductor asignado al vehículo
    $query = "SELECT 1 FROM vehiculo_conductor WHERE vehiculo_id = ? AND fecha_desasignacion IS NULL LIMIT 1";
    $stmt = $this->cnx_db->prepare($query);
    if (!$stmt) {
      throw new Exception("Error al preparar verificación: " . $this->cnx_db->error);
    }

    $stmt->bind_param("i", $vehiculo_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      return ['success' => false, 'message' => 'Este vehículo ya tiene conductor asignado.'];
    }

    // Insertar nueva asignación
    $insert = $this->cnx_db->prepare("INSERT INTO vehiculo_conductor (vehiculo_id, conductor_id, fecha_asignacion) VALUES (?, ?, NOW())");
    if (!$insert) {
      throw new Exception("Error al preparar inserción: " . $this->cnx_db->error);
    }

    $insert->bind_param("ii", $vehiculo_id, $conductor_id);
    if (!$insert->execute()) {
      throw new Exception("Error al ejecutar inserción: " . $insert->error);
    }

    return ['success' => true, 'message' => 'Conductor asignado correctamente.'];

  } catch (Exception $e) {
    return ['success' => false, 'message' => 'Excepción: ' . $e->getMessage()];
  }
}

// 


public function obtenerConductoresAsignados() {
  try {
    $sql = "
      SELECT 
        vc.*, 
        v.placas, 
        c.licencia, 
        u.nombre AS conductor_nombre,
        v.tipo as vehiculo_tipo
      FROM vehiculo_conductor vc
      JOIN vehiculos v ON vc.vehiculo_id = v.vehiculo_id
      JOIN conductores c ON vc.conductor_id = c.conductor_id
      JOIN usuarios u ON c.usuario_id = u.usuario_id
      WHERE vc.fecha_desasignacion IS NULL
    ";

    $resultado = $this->cnx_db->query($sql);

    if (!$resultado) {
      throw new Exception("Error en la consulta: " . $this->cnx_db->error);
    }

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
      $datos[] = $fila;
    }

    // echo "<div class='alert alert-success' role='alert'>obtenerConductoresAsignados:<br>".$consulta."</div>";
    return ['success' => true, 'data' => $datos];

  } catch (Exception $e) {
    return ['success' => false, 'message' => $e->getMessage()];
  }
}
// 

public function desasignarConductor($vehiculo_id, $conductor_id) {
  try {
    $vehiculo_id = (int) $vehiculo_id;
    $conductor_id = (int) $conductor_id;

    $sql = "
      UPDATE vehiculo_conductor
      SET fecha_desasignacion = NOW()
      WHERE vehiculo_id = ? AND conductor_id = ? AND fecha_desasignacion IS NULL
    ";

    $stmt = $this->cnx_db->prepare($sql);
    $stmt->bind_param('ii', $vehiculo_id, $conductor_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      return ['success' => true, 'message' => 'Conductor desasignado correctamente.'];
    } else {
      return ['success' => false, 'message' => 'No se pudo desasignar (ya podría estar desasignado).'];
    }

  } catch (Exception $e) {
    return ['success' => false, 'message' => $e->getMessage()];
  }
}
// 


public function Get_conductores_sin_vehiculo() {
    try {
        $filtro = [];
        $filtro[] = "(usr.estado = '1')";
        $filtro[] = "(rol.rol_id = '3')";

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
            conductor.*,
            rol.nombre as rol_nombre,
            IF(usr.estado = 1, "activo", "borrado") AS estado_usuario,
            usr.user_name
        ';
        $tabla_principal = 'usuarios as usr';
        $inner_roles = 'INNER JOIN roles as rol ON usr.rol_id = rol.rol_id';
        $inner_conductores = 'INNER JOIN conductores as conductor ON usr.usuario_id = conductor.usuario_id';

        // LEFT JOIN con vehiculo_conductor para detectar asignaciones activas
        $left_join_vehiculo_conductor = "
            LEFT JOIN vehiculo_conductor vc ON conductor.conductor_id = vc.conductor_id AND vc.fecha_desasignacion IS NULL
        ";

        // Solo conductores sin vehículo asignado, es decir, sin registro activo en vehiculo_conductor
        $where .= ($where ? " AND " : "WHERE ") . "vc.conductor_id IS NULL";

        $group = '';
        $order = 'ORDER BY usr.usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_roles
            $inner_conductores
            $left_join_vehiculo_conductor
            $where
            $group
            $order
        ";

        $result = mysqli_query($this->cnx_db, $consulta);
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
///


// 
public function Get_conductores_por_estado_vehiculo($estado, $tipo_vehiculo, $campasidad_maxima ) {
    try {
        $estado = mysqli_real_escape_string($this->cnx_db, strip_tags($estado, ENT_QUOTES));
        $tipo_vehiculo = mysqli_real_escape_string($this->cnx_db, strip_tags($tipo_vehiculo, ENT_QUOTES));
        
        $filtro = [];
        $filtro[] = "(vc.fecha_desasignacion IS NULL)";
        $filtro[] = "(conductor.estado = '$estado')";
        $filtro[] = "(vehiculo.tipo = '$tipo_vehiculo')";
        $filtro[] = "(vehiculo.capacidad >= '$campasidad_maxima')";

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
                conductor.conductor_id,
                vehiculo.vehiculo_id,
                usuario.usuario_id,
                usuario.user_name,
                usuario.nombre,
                usuario.apellido,
                vehiculo.tipo as tipo_vehiculo,
                vehiculo.capacidad,
                conductor.estado as conductor_estado
        ';
        $tabla_principal = 'vehiculo_conductor as vc';
        $inner_conductores = 'INNER JOIN conductores as conductor ON vc.conductor_id = conductor.conductor_id';
        $inner_usuarios = 'INNER JOIN usuarios as usuario ON conductor.usuario_id = usuario.usuario_id';
        $inner_vehiculos = 'INNER JOIN vehiculos as vehiculo ON vc.vehiculo_id = vehiculo.vehiculo_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_conductores
            $inner_usuarios
            $inner_vehiculos
            $where
        ";

        // Puedes comentar o quitar el echo cuando ya funcione
        echo "<div class='alert alert-success' role='alert'>Get_conductores_por_estado_vehiculo:<br>".$consulta."</div>";

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


public function Update_estado_conductor($estado, $conductor_id) {
  try {
    
    $estado = mysqli_real_escape_string($this->cnx_db, strip_tags($estado, ENT_QUOTES));
    $conductor_id = (int) $conductor_id;
    
    $sql = "
      UPDATE conductores
      SET estado = ?
      WHERE conductor_id = ? 
    ";

    $stmt = $this->cnx_db->prepare($sql);
    $stmt->bind_param('si', $estado, $conductor_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      return ['success' => true, 'message' => '<div class="alert alert-success" role="alert">Conductor asignado correctamente.</div>'];
    } else {
      return ['success' => false, 'message' => 'No se pudo asignado (ya podría estar asignado).'];
    }

  } catch (Exception $e) {
    return ['success' => false, 'message' => $e->getMessage()];
  }
}
// 






///////////////////////////////
} ///FIN DEL CLASE