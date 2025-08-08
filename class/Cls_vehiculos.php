<?php

class Cls_vehiculos {

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
public function Get_tabla_vehiculos() {
    try {
        // $rol_id = mysqli_real_escape_string($this->cnx_db, strip_tags($rol_id, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        $filtro[]="( estado = '1')";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='vehiculo.*';
        $tabla_principal = ' vehiculos  as vehiculo ';
        $group = '';
        $order = 'ORDER BY vehiculo_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
        ";
        
         // echo "<div class='alert alert-success' role='alert'>Get_tabla_vehiculos:<br>".$consulta."</div>";
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




// FUNCIONES
public function insertarVehiculo($data) {
    try {
        $sql = "INSERT INTO vehiculos 
            (marca, modelo, anio, color, numero_serie, numero_motor, placas, capacidad, tipo, estado, estado_vehiculo, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->cnx_db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en prepare: " . $this->cnx_db->error);
        }

        $stmt->bind_param(
            "ssissssssssss",
            $data['marca'], $data['modelo'], $data['anio'], $data['color'],
            $data['numero_serie'], $data['numero_motor'], $data['placas'],
            $data['capacidad'], $data['tipo'], $data['estado'],
            $data['estado_vehiculo'], $data['created_at'], $data['updated_at']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar: " . $stmt->error);
        }

        return $stmt->insert_id;
    } catch (Exception $e) {
        // Puedes logear el error o devolverlo a la vista
        throw new Exception("insertarVehiculo() falló: " . $e->getMessage());
    }
}


public function guardarArchivo($tipo_doc, $file) {
    try {
        if (!isset($file['name']) || !isset($file['tmp_name'])) {
            throw new Exception("Archivo inválido o no recibido para el documento: $tipo_doc.");
        }

        $nombre_archivo = $file['name'];
        $tmp_path = $file['tmp_name'];

        $nombre_unico = uniqid($tipo_doc . '_') . '_' . basename($nombre_archivo);
        $ruta_destino = 'uploads/documentos/' . $nombre_unico;

        // Crear directorio si no existe
        $directorio = dirname($ruta_destino);
        if (!file_exists($directorio)) {
            if (!mkdir($directorio, 0777, true)) {
                throw new Exception("No se pudo crear el directorio: $directorio");
            }
        }

        // Mover archivo
        if (!move_uploaded_file($tmp_path, $ruta_destino)) {
            throw new Exception("No se pudo mover el archivo $nombre_archivo al destino final.");
        }

        return $ruta_destino;

    } catch (Exception $e) {
        throw new Exception("guardarArchivo() falló para $tipo_doc: " . $e->getMessage());
    }
}


public function insertarDocumentoLegal($vehiculo_id, $tipo_documento, $ruta, $fecha_inicio, $fecha_fin) {
    try {
        $sql = "INSERT INTO documentos_legales 
                (vehiculo_id, tipo_documento, fecha_vigencia_inicio, fecha_vigencia_fin, archivo_url)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->cnx_db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en prepare al insertar documento $tipo_documento: " . $this->cnx_db->error);
        }

        $stmt->bind_param("issss", $vehiculo_id, $tipo_documento, $fecha_inicio, $fecha_fin, $ruta);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar inserción del documento $tipo_documento: " . $stmt->error);
        }

        return true; // Puedes retornar true si fue exitoso

    } catch (Exception $e) {
        throw new Exception("insertarDocumentoLegal() falló: " . $e->getMessage());
    }
}
// 

///////////////////////////////////////
public function Get_vahiculo_por_id($vehiculo_id) {
    try {
        $vehiculo_id = mysqli_real_escape_string($this->cnx_db, strip_tags($vehiculo_id, ENT_QUOTES));
    
        $filtro = [];
        $filtro[]="( estado = '1')";
        $filtro[]="( vehiculo.vehiculo_id = '".$vehiculo_id."')";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='vehiculo.*';
        $tabla_principal = ' vehiculos  as vehiculo ';
        $group = '';
        $order = 'ORDER BY vehiculo_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
        ";
        
        //echo "<div class='alert alert-success' role='alert'>Get_vahiculo_por_id:<br>".$consulta."</div>";
        $result=mysqli_fetch_assoc(mysqli_query($this->cnx_db,$consulta));
        // $result=mysqli_query($this->cnx_db,$consulta);
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
public function Get_documentos_legales_vehiculos($vehiculo_id) {
    try {
        $vehiculo_id = mysqli_real_escape_string($this->cnx_db, strip_tags($vehiculo_id, ENT_QUOTES));
    
        $filtro = [];
        $filtro[] = "(documento.vehiculo_id = '" . $vehiculo_id . "')";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = 'documento.*';
        $tabla_principal = 'documentos_legales AS documento';
        $group = '';
        $order = 'ORDER BY vehiculo_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $where
            $group
            $order
        ";

        $result = mysqli_query($this->cnx_db, $consulta);

        //Convertir a array asociativo
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return []; // Devuelve un array vacío si hay error
    }
}

////////////////////////////////////////////////////////////


///////////////////////////////////////
public function Get_documentos_por_vencer() {
    try {
        // $vehiculo_id = mysqli_real_escape_string($this->cnx_db, strip_tags($vehiculo_id, ENT_QUOTES));
    
        $filtro = [];
        $filtro[] = "( fecha_vigencia_fin <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) )";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = '
            vehiculo.*,
            documento_id,
            tipo_documento,
            fecha_vigencia_inicio,
            fecha_vigencia_fin,
            archivo_url,
            DATEDIFF(fecha_vigencia_fin, CURDATE()) AS dias_restantes
        ';
        $tabla_principal = 'vehiculos as vehiculo';
        $inner_documentos='INNER JOIN documentos_legales as docuemnto ON vehiculo.vehiculo_id = docuemnto.vehiculo_id';
        $group = '';
        $order = 'ORDER BY fecha_vigencia_fin ASC';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_documentos
            $where
            $group
            $order
        ";

        // echo "<div class='alert alert-success' role='alert'>Get_documentos_por_vencer:<br>".$consulta."</div>";
        $result = mysqli_query($this->cnx_db, $consulta);
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return []; // Devuelve un array vacío si hay error
    }
}
////////////////////////////////////////////////////////////

///////////////////////////////////////
public function Get_vehiculos_sin_conductor() {
    try {
        // $vehiculo_id = mysqli_real_escape_string($this->cnx_db, strip_tags($vehiculo_id, ENT_QUOTES));
    
        $filtro = [];
        $filtro[] = "( vc.conductor_id IS NULL )";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = ' v.* ';
        $tabla_principal = 'vehiculos v ';
        $left_conductor='LEFT JOIN vehiculo_conductor vc  ON v.vehiculo_id = vc.vehiculo_id AND vc.fecha_desasignacion IS NULL';
        $group = '';
        $order = 'ORDER BY vehiculo_id ASC';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $left_conductor
            $where
            $group
            $order
        ";

        // echo "<div class='alert alert-success' role='alert'>Get_documentos_por_vencer:<br>".$consulta."</div>";
        $result = mysqli_query($this->cnx_db, $consulta);
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return []; // Devuelve un array vacío si hay error
    }
}
////////////////////////////////////////////////////////////

///////////////////////////////////////
public function Get_vehiculos_disponibles() {
    try {
        // $vehiculo_id = mysqli_real_escape_string($this->cnx_db, strip_tags($vehiculo_id, ENT_QUOTES));
    
        $filtro = [];
        $filtro[] = "( vc.conductor_id IS NULL )";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';

        $campos_select = ' v.* ';
        $tabla_principal = 'vehiculos v ';
        $left_conductor='LEFT JOIN vehiculo_conductor vc  ON v.vehiculo_id = vc.vehiculo_id AND vc.fecha_desasignacion IS NULL';
        $group = '';
        $order = 'ORDER BY vehiculo_id ASC';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $left_conductor
            $where
            $group
            $order
        ";

        // echo "<div class='alert alert-success' role='alert'>Get_vehiculos_disponibles:<br>".$consulta."</div>";
        $result = mysqli_query($this->cnx_db, $consulta);
        return $result;

    } catch (Exception $e) {
        $mensaje = htmlentities($e->getMessage(), ENT_QUOTES, 'UTF-8');
        $this->errors[] = "
            <div class='alert alert-danger' role='alert'>
                ERROR!! ($mensaje)
            </div>
        ";
        return []; // Devuelve un array vacío si hay error
    }
}
////////////////////////////////////////////////////////////


///////////////////////////////
} ///FIN DEL CLASE