<?php
require_once('ClaseConexion.php');
//session_start();

$usuario = $_POST['usuario'];
$password = $_POST['password'];
$ctrlUsuarios = ControlUsuarios::getInstance();
if (!$ctrlUsuarios->isEmpty($usuario) && !$ctrlUsuarios->isEmpty($password)){
	if ($ctrlUsuarios->login($usuario, $password)){
		$_SESSION['mensaje'] = 'Sesión Iniciada';
        header("Location: index.php");
	}
	else {
		$_SESSION['mensaje'] = 'Usuario o Contraseña Incorrecta';
        header("Location: login.php");
	}
	
}
else {
	$_SESSION['mensaje'] = 'Por favor ingrese el usuario y la contraseña';
	header("Location: login.php");
}

/**
* 
*/
class ControlUsuarios
{
	private static $instance = null;
	private static $estaLogueado = false;
	private static $usuarioLogueado = null;
    //Constructor privado
    private function __construct()
    {
    }

    // Clone no permitido
    public function __clone()
    {}

    // Método singleton
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ControlUsuarios();
        }

        return self::$instance;
    }

    public function login($usuario, $password){
    	$conexion = Conexion::getInstance();
    	if ($conexion->login($usuario, $password)){
    		self::$estaLogueado = true;
    		self::$usuarioLogueado = $usuario;
    		return true;
    	}
    	else {
    		self::$estaLogueado = false;
    		self::$usuarioLogueado = null;
    		return false;
    	}
    }

    public function estaLogueado(){
    	return self::$estaLogueado;
    }

    public function getUsuarioLogueado(){
        return self::$usuarioLogueado;
    }

    public function isEmpty($value){
    	return !isset($value) || empty($value);
    }
}
?>
