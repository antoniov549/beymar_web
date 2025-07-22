<?php

class Login
{
    private $db = null;
    public $errors = [];
    public $messages = [];

    public function __construct()
    {
        session_start();

        if (isset($_GET["logout"])) {
            $this->logout();
        } elseif (isset($_POST["login"])) {
            $this->loginWithPostData();
        }
    }

    private function loginWithPostData()
    {
        $username = $_POST['user_name'] ?? '';
        $password = $_POST['user_password'] ?? '';

        if (empty($username)) {
            $this->errors[] = "El campo de usuario está vacío.";
            return;
        }

        if (empty($password)) {
            $this->errors[] = "El campo de contraseña está vacío.";
            return;
        }

        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_errno) {
            $this->errors[] = "Error de conexión a la base de datos.";
            return;
        }

        if (!$this->db->set_charset("utf8")) {
            $this->errors[] = "Error al establecer codificación UTF-8: " . $this->db->error;
            return;
        }

        $stmt = $this->db->prepare("
            SELECT user_password_hash, user_id, firstname, lastname, user_name, user_email, 
                   nivel, area, role, subarea, foto, status
            FROM users_v2
            WHERE (user_name = ? OR user_email = ?) AND status = '0'
        ");

        if ($stmt === false) {
            $this->errors[] = "Error en la preparación de la consulta.";
            return;
        }

        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows !== 1) {
            $this->errors[] = "Usuario y/o contraseña no coinciden.";
            return;
        }

        $user = $result->fetch_object();

        if (!password_verify($password, $user->user_password_hash)) {
            $this->errors[] = "Usuario y/o contraseña no coinciden.";
            return;
        }

        $_SESSION = array_merge($_SESSION, [
            'user_id'       => $user->user_id,
            'firstname'     => $user->firstname,
            'lastname'      => $user->lastname,
            'user_name'     => $user->user_name,
            'user_email'    => $user->user_email,
            'nivel'         => $user->nivel,
            'area'          => $user->area,
            'role'          => $user->role,
            'subarea'       => $user->subarea,
            'foto_perfil'   => $user->foto,
            'status'        => $user->status,
            'user_login_status' => 1
        ]);

        $this->messages[] = "Inicio de sesión exitoso.";
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        $this->messages[] = "Has sido desconectado correctamente.";
    }

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] === 1;
    }
}
?>