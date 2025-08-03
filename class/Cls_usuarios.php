<?php

class Cls_usuarios {

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
        $user_name     = mysqli_real_escape_string($this->cnx_db, strip_tags($user_name, ENT_QUOTES));
        $nombre     = mysqli_real_escape_string($this->cnx_db, strip_tags($nombre, ENT_QUOTES));
        $apellido   = mysqli_real_escape_string($this->cnx_db, strip_tags($apellido, ENT_QUOTES));
        $correo     = mysqli_real_escape_string($this->cnx_db, strip_tags($correo, ENT_QUOTES));
        $contrasena = mysqli_real_escape_string($this->cnx_db, strip_tags($contrasena, ENT_QUOTES));
        $rol_id     = (int)$rol_id;
        $estado     = (int)$estado;

        // Validar si el correo ya existe
        $query = "SELECT COUNT(*) as total FROM usuarios WHERE correo = ? OR user_name = ?";
        $stmt = $this->cnx_db->prepare($query);
        $stmt->bind_param("ss", $correo,$user_name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result['total'] > 0) {
            return ['success' => false, 'message' => '<div class="alert alert-danger" role="alert">El correo ya está registrado.</div>'];
        }

        // Insertar usuario
        $query = "INSERT INTO usuarios (user_name, nombre, apellido, correo, contrasena, rol_id, estado)
                  VALUES (?, ?, ?, ?, ?, ?,?)";
        $stmt = $this->cnx_db->prepare($query);
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("sssssii", $user_name, $nombre, $apellido, $correo, $contrasena_hash, $rol_id, $estado);
        $stmt->execute();

        return ['success' => true, 'message' => '<div class="alert alert-success" role="alert">Usuario insertado correctamente.</div>'];

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
        $where = count($filtro) ? 'WHERE ' . implode(' AND ', $filtro) : '';
        /////////////////////////////////////
         $campos_select='*';
        $tabla_principal = ' usuarios  as usr ';
      
        $group = '';
        $order = 'ORDER BY usuario_id';

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



///////////////////////////////
} ///FIN DEL CLASE