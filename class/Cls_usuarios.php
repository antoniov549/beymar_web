<?php

class Cls_usuarios {

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
public function Get_roles_usuarios() {
    try {
        // $Part_Type = mysqli_real_escape_string($this->cnx_db, strip_tags($Part_Type, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='*';
        $tabla_principal = ' roles  as rol ';
      
        $group = '';
        $order = 'ORDER BY rol_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
          
            $where
            $group
            $order
        ";
        
        // echo "<div class='alert alert-success' role='alert'>Get_tbody_tabla_wip_meta:<br>".$consulta."</div>";
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

/////////////////////////////////////////////////////////////
function Set_archivo_csv($file) {
    // Directorio donde se guardará el archivo
    $targetDirectory = __DIR__ . '/uploads/';
    // Crear el directorio si no existe
    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    // Generar un nombre único para el archivo
    $uniqueName = uniqid('csv_', true) . '_' . date('Ymd_His') . '.csv';

    // Ruta completa para guardar el archivo
    $targetPath = $targetDirectory . $uniqueName;

    // Mover el archivo al directorio
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return [
            'success' => true,
            'message' => "Archivo guardado exitosamente como: $uniqueName",
            'path' => $targetPath,
        ];
    } else {
        return [
            'success' => false,
            'message' => "Error al guardar el archivo.",
        ];
    }
}
//////////////////////////////////////////////////////////
public function Set_new_usuarios($user_name, $nombre, $apellido, $correo, $contrasena, $rol_id, $estado = 1) {
    try {
        // Sanitización
        $user_name   = mysqli_real_escape_string($this->cnx_db, strip_tags($user_name, ENT_QUOTES));
        $nombre      = mysqli_real_escape_string($this->cnx_db, strip_tags($nombre, ENT_QUOTES));
        $apellido    = mysqli_real_escape_string($this->cnx_db, strip_tags($apellido, ENT_QUOTES));
        $correo      = mysqli_real_escape_string($this->cnx_db, strip_tags($correo, ENT_QUOTES));
        $contrasena  = mysqli_real_escape_string($this->cnx_db, strip_tags($contrasena, ENT_QUOTES));
        $rol_id      = (int)$rol_id;
        $estado      = (int)$estado;

        // Validar si el correo o el user_name ya existe
        $query = "SELECT COUNT(*) as total FROM usuarios WHERE correo = ? OR user_name = ?";
        $stmt = $this->cnx_db->prepare($query);
        $stmt->bind_param("ss", $correo, $user_name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result['total'] > 0) {
            return [
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">El correo o el nombre de usuario ya están registrados.</div>'
            ];
        }

        // Insertar usuario
        $query = "INSERT INTO usuarios (user_name, nombre, apellido, correo, contrasena, rol_id, estado)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->cnx_db->prepare($query);
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("sssssii", $user_name, $nombre, $apellido, $correo, $contrasena_hash, $rol_id, $estado);
        $stmt->execute();

        // Obtener el ID insertado
        $nuevo_id = $this->cnx_db->insert_id;

        return [
            'success' => true,
            'message' => '<div class="alert alert-success" role="alert">Usuario insertado correctamente.</div>',
            'id_insertado' => $nuevo_id
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>'
        ];
    }
}

// 
// 
public function insertar_conductor($usuario_id, $licencia, $telefono, $estado = 'activo') {
    try {
        // Sanitización y cast
        $usuario_id = (int)$usuario_id;
        $licencia = mysqli_real_escape_string($this->cnx_db, strip_tags($licencia, ENT_QUOTES));
        $telefono = mysqli_real_escape_string($this->cnx_db, strip_tags($telefono, ENT_QUOTES));
        $estado = ($estado === 'inactivo') ? 'inactivo' : 'activo'; // Validar enum

        // Insertar datos
        $query = "INSERT INTO conductores (usuario_id, licencia, telefono, estado, fecha_creacion)
                  VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->cnx_db->prepare($query);
        $stmt->bind_param("isss", $usuario_id, $licencia, $telefono, $estado);
        $stmt->execute();

        // Obtener ID insertado
        $nuevo_id = $this->cnx_db->insert_id;

        return [
            'success' => true,
            'message' => '<div class="alert alert-success" role="alert">Conductor insertado correctamente.</div>',
            'id_insertado' => $nuevo_id
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage(). '</div>'
        ];
    }
}

// 

// 
public function Update_password($user_id, $nueva_contrasena) {
    try {
        // Sanitizar entradas
        $user_id          = (int)$user_id;
        $nueva_contrasena = mysqli_real_escape_string($this->cnx_db, strip_tags($nueva_contrasena, ENT_QUOTES));
        

        // Hash de la nueva contraseña
        $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        // Actualizar contraseña
        $query = "UPDATE usuarios SET contrasena = ?, updated_at = NOW() WHERE usuario_id = ?";
        $stmt = $this->cnx_db->prepare($query);
        $stmt->bind_param("si", $contrasena_hash, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ['success' => true, 'message' => '<div class="alert alert-success" role="alert">Contraseña actualizada correctamente.</div>'];
        } else {
            return ['success' => false, 'message' => '<div class="alert alert-warning" role="alert">No se realizó ningún cambio.</div>'];
        }

    } catch (Exception $e) {
        return ['success' => false, 'message' => '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>'];
    }
}

//

// 
public function Update_estado($user_id, $nuevo_estado) {
    try {
        // Sanitizar entradas
        $user_id          = (int)$user_id;
        $nuevo_estado     = (int)$nuevo_estado;

        // Actualizar contraseña y estado
        $query = "UPDATE usuarios SET  estado = ?, updated_at = NOW() WHERE usuario_id = ?";
        $stmt = $this->cnx_db->prepare($query);
        $stmt->bind_param("ii",  $nuevo_estado, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ['success' => true, 'message' => '<div class="alert alert-success" role="alert">Usuario Eliminado correctamente.</div>'];
        } else {
            return ['success' => false, 'message' => '<div class="alert alert-warning" role="alert">No se realizó ningún cambio.</div>'];
        }

    } catch (Exception $e) {
        return ['success' => false, 'message' => '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>'];
    }
}

// 


///////////////////////////////////////
public function Get_tabla_usuarios() {
    try {
        // $Part_Type = mysqli_real_escape_string($this->cnx_db, strip_tags($Part_Type, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        $filtro[]="( estado = '1')";
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='usr.*,rol.nombre as rol_nombre,  IF(estado = 1, "activo", "borrado" ) AS estado_usuario';
        $tabla_principal = ' usuarios  as usr ';
        $inner_roles='INNER JOIN  roles as rol ON usr.rol_id = rol.rol_id';
      
        $group = '';
        $order = 'ORDER BY usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_roles
            $where
            $group
            $order
        ";
        
        // echo "<div class='alert alert-success' role='alert'>Get_tbody_tabla_wip_meta:<br>".$consulta."</div>";
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
public function Get_usuario_por_id($usuario_id) {
    try {
        
        $usuario_id = mysqli_real_escape_string($this->cnx_db, strip_tags($usuario_id, ENT_QUOTES));
        
        $filtro = [];
         $filtro[]="( usuario_id ='".$usuario_id."'  )";

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
        $campos_select='usr.*,rol.nombre as rol_nombre';
        $tabla_principal = ' usuarios  as usr';
        $inner_roles='INNER JOIN  roles as rol ON usr.rol_id = rol.rol_id';
        $group = '';
        $order = 'ORDER BY usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_roles
            $where
            $group
            $order
        ";
        
        // echo "<div class='alert alert-success' role='alert'>Get_tbody_tabla_wip_meta:<br>".$consulta."</div>";
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
public function Get_tabla_usuarios_roles($rol_id) {
    try {
         $rol_id = mysqli_real_escape_string($this->cnx_db, strip_tags($rol_id, ENT_QUOTES));
        // $LINE_NAME = mysqli_real_escape_string($this->cnx_db, strip_tags($LINE_NAME, ENT_QUOTES));
        // $product_Family = mysqli_real_escape_string($this->cnx_db, strip_tags($product_Family, ENT_QUOTES));
        
        $filtro = [];
        $filtro[]="( estado = '1')";
        $filtro[]="( rol.rol_id = '".$rol_id."')";

        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='usr.*,rol.nombre as rol_nombre,  IF(estado = 1, "activo", "borrado" ) AS estado_usuario';
        $tabla_principal = ' usuarios  as usr ';
        $inner_roles='INNER JOIN  roles as rol ON usr.rol_id = rol.rol_id';
      
        $group = '';
        $order = 'ORDER BY usuario_id';

        $consulta = "
            SELECT $campos_select
            FROM $tabla_principal
            $inner_roles
            $where
            $group
            $order
        ";
        
        // echo "<div class='alert alert-success' role='alert'>Get_tbody_tabla_wip_meta:<br>".$consulta."</div>";
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