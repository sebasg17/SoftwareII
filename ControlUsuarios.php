<?php
require_once('ClaseConexion.php');

$ctrlUsuarios = ControlUsuarios::getInstance();
if (!$ctrlUsuarios->isEmpty($_POST['usuario']) && !$ctrlUsuarios->isEmpty($_POST['password'])){
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
	if ($ctrlUsuarios->login($usuario, $password)){
		$_SESSION['mensaje'] = "";
        header("Location: index.php");
	}
	else {
		$_SESSION['mensaje'] = 'Usuario o Contraseña Incorrecta';
        header("Location: login.php");
	}
	
}
else {
	$_SESSION['mensaje'] = 'Por favor ingrese el usuario y la contraseña';
}

/**
* 
*/
class ControlUsuarios
{
	private static $instance = null;
	private $estaLogueado = false;
	private $usuarioLogueado = null;
    private $passUsuario = null;
    //Constructor privado
    private function __construct()
    {
    }

    // Clone no permitido
    public function __clone()
    {}

    public function toString(){
        return $this->estaLogueado.",".$this->usuarioLogueado;
    }

    // Método singleton
    public static function getInstance()
    {
        if (is_null($_SESSION['ControlUsuarios'])) {
            self::$instance = new ControlUsuarios();
            $_SESSION['ControlUsuarios'] = serialize(self::$instance);
        }

        return unserialize($_SESSION['ControlUsuarios']);
    }

    public function login($usuario, $password){
    	$conexion = Conexion::getInstance();
        $ctrlUsuarios = ControlUsuarios::getInstance();
    	if ($conexion->login($usuario, $password)){
    		$ctrlUsuarios->estaLogueado = true;
    		$ctrlUsuarios->usuarioLogueado = $usuario;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['password'] = $password;
            $ctrlUsuarios->passUsuario = $password;
            $_SESSION['ControlUsuarios'] = serialize($ctrlUsuarios);
    		return true;
    	}
    	else {
    		$ctrlUsuarios->estaLogueado = false;
    		$ctrlUsuarios->usuarioLogueado = null;
            $ctrlUsuarios->passUsuario = null;
            $_SESSION['ControlUsuarios'] = serialize($ctrlUsuarios);
    		return false;
    	}
    }

    public function isLogueado(){
    	return $this->estaLogueado;
    }

    public function getUsuarioLogueado(){
        return $this->usuarioLogueado;
    }

    public function getPass(){
        return $this->passUsuario;
    }

    public function isEmpty($value){
        return !isset($value) || empty($value);
    }

}
?>
