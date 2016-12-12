
<?php
error_reporting(E_ALL ^ E_NOTICE);
class Conexion
{

    private $conexion; //objeto resource que indicara si se ha conectado
    private $_sNombreBD;
    private $_sUsuario;
    private $_sClave;
    public static $sMensaje;
    private static $_oSelf = null; //Almacenara un objeto de tipo Conexion
    // Contenedor Instancia de la clase
    private static $instance = null;

    //Constructor privado
    private function __construct()
    {
        //guty17 admin123
        $this->_sNombreBD = 'localhost/XE';
    }

    // Clone no permitido
    public function __clone()
    {}


    // Método singleton
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Conexion();
            self::$instance->conectar();
        }

        return self::$instance;
    }

    private function conectar()
    {
        session_start(); 
        if (!is_null($_SESSION['usuario']) && !is_null($_SESSION['password'])){
                $this->_sUsuario  = $_SESSION['usuario'];
                $this->_sClave    = $_SESSION['password'];
        }

        $this->conexion = null;

        $this->conexion = oci_connect($this->_sUsuario, $this->_sClave, $this->_sNombreBD);

        if (is_resource($this->conexion)) {
            //self::$sMensaje = "Conexion exitosa!<br/>";
        } else {
            $this->conexion = null;
        }

        return $this->conexion;
    }

    public function login($usuario, $password){
        $this->_sUsuario  = $usuario;
        $this->_sClave    = $password;
        $this->conectar();
        return $this->conexion !== null;
    }

    // public function login($usuario, $password){
    //     $result = oci_parse($this->conexion,"SELECT * FROM USUARIO WHERE USUARIO='$usuario' AND PASSWORD='$password'");
    //     oci_execute($result);
    //     return oci_fetch_row($result);
    // }

    //insertar
    public function Insertar($tabla, $argumentos)
    {
        if ($tabla == "libro") {
            $stid = oci_parse($this->conexion, "insert into GUTY17.$tabla(libro,titulo,autor,numpag) values('$argumentos[0]','$argumentos[1]','$argumentos[2]','$argumentos[3]')");
        }
        if ($tabla == "socio") {
            $stid = oci_parse($this->conexion, "insert into GUTY17.$tabla(socio,nombre,telefono,ingreso) values ('$argumentos[0]','$argumentos[1]','$argumentos[2]',to_date('$argumentos[3]','dd/mm/yyyy'))");
        }
        if ($tabla == "prestamo") {
            $stid = oci_parse($this->conexion, "insert into GUTY17.$tabla(libro,socio,fprestamo,fdevolucion) 						   values('$argumentos[0]','$argumentos[1]',to_date('$argumentos[2]','dd/mm/yyyy'),to_date('$argumentos[3]','dd/mm/yyyy'))");
        }
        if (!oci_execute($stid)) {
            return "$tabla ya existe";
        } else {
            return "$tabla guardado";
        }

    }
    //Eliminar
    public function Eliminar($tabla, $argumentos)
    {
        if ($tabla == "libro") {
            $stid = oci_parse($this->conexion, "delete from GUTY17.libro where $tabla=$argumentos");
        }
        if ($tabla == "socio") {
            $stid = oci_parse($this->conexion, "delete from GUTY17.socio where $tabla=$argumentos");
        }
        if ($tabla == "prestamo") {
            $stid = oci_parse($this->conexion, "delete from GUTY17.prestamo where libro=$argumentos[0] and socio=$argumentos[1]");
        }
        $consulta = $this->Consulta($tabla);
        $mensaje  = $this->prueba($consulta, $argumentos, $stid);
        return "$tabla eliminado";

    }
    //Actualizar
    public function Actualizar($tabla, $argumentos)
    {

        if ($tabla == "libro") {
            $stid = oci_parse($this->conexion, "update GUTY17.$tabla set titulo='$argumentos[1]',autor='$argumentos[2]',numpag='$argumentos[3]' where libro=$argumentos[0] ");
        }
        if ($tabla == "socio") {
            $stid = oci_parse($this->conexion, "update GUTY17.$tabla set nombre='$argumentos[1]',telefono='$argumentos[2]',ingreso=to_date('$argumentos[3]','dd/mm/yyyy') where socio=$argumentos[0]");
        }
        if ($tabla == "prestamo") {
            $stid = oci_parse($this->conexion, "update GUTY17.$tabla set fprestamo=to_date('$argumentos[2]','dd/mm/yyyy'),fdevolucion=to_date('$argumentos[3]','dd/mm/yyyy') where libro=$argumentos[0] and socio=$argumentos[1]");
        }

        $consulta = $this->Consulta($tabla);
        $mensaje  = $this->prueba($consulta, $argumentos, $stid);
        return "$tabla actualizado";

    }

    private function prueba($consulta, $argumentos, $stid)
    {
        $cont = 1;
        while ($cont != 0) {
            if ($row = oci_fetch_row($consulta)) {
                if ($row[0] == $argumentos[0]) {
                    oci_execute($stid);
                    return "";
                    break;
                }
            } else {
                return "no existe...";
                break;
            }
        }
    }
    //consulta
    private function Consulta($NTabla)
    {
        $consulta = oci_parse($this->conexion, "select * from GUTY17.$NTabla");
        oci_execute($consulta);
        return $consulta;
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function getSocios(){
    	return oci_parse($this->conexion,'SELECT * FROM GUTY17.socio order by socio');
    }

    public function buscarSocios($busqueda) {
    	return oci_parse($this->conexion,"select * from GUTY17.socio where UPPER(nombre) LIKE UPPER('$busqueda')");
    }

}

$conn = Conexion::getInstance()->getConexion();
$inactivo           = 10;
$_SESSION['tiempo'] = time();
if (isset($_SESSION['tiempo'])) {
    $vida_sesion = time() - $_SESSION['tiempo'];
    if ($vida_sesion > $inactivo) {
        session_destroy(oci_close($conn));
        header("Location: login.php");
    }
}

?>