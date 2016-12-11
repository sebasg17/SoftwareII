
<?php

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
        $this->_sNombreBD = 'localhost/XE';
        $this->_sUsuario  = 'guty17';
        $this->_sClave    = 'admin123';
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

        $this->conexion = null;

        $this->conexion =
            oci_connect($this->_sUsuario, $this->_sClave, $this->_sNombreBD);

        if (is_resource($this->conexion)) {
            //self::$sMensaje = "Conexion exitosa!<br/>";
        } else {
            header('Location: error.php');

        }

        return $this->conexion;
    }

    public function login($usuario, $password){
        $result = oci_parse($this->conexion,"SELECT * FROM USUARIO WHERE USUARIO='$usuario' AND PASSWORD='$password'");
        oci_execute($result);
        return oci_fetch_row($result);
    }

    //insertar
    public function Insertar($tabla, $argumentos)
    {
        if ($tabla == "libro") {
            $stid = oci_parse($this->conexion, "insert into $tabla(libro,titulo,autor,numpag) values('$argumentos[0]','$argumentos[1]','$argumentos[2]','$argumentos[3]')");
        }
        if ($tabla == "socio") {
            $stid = oci_parse($this->conexion, "insert into $tabla(socio,nombre,telefono,ingreso) values ('$argumentos[0]','$argumentos[1]','$argumentos[2]',to_date('$argumentos[3]','dd/mm/yyyy'))");
        }
        if ($tabla == "prestamo") {
            $stid = oci_parse($this->conexion, "insert into $tabla(libro,socio,fprestamo,fdevolucion) 						   values('$argumentos[0]','$argumentos[1]',to_date('$argumentos[2]','dd/mm/yyyy'),to_date('$argumentos[3]','dd/mm/yyyy'))");
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
            $stid = oci_parse($this->conexion, "delete from libro where $tabla=$argumentos");
        }
        if ($tabla == "socio") {
            $stid = oci_parse($this->conexion, "delete from socio where $tabla=$argumentos");
        }
        if ($tabla == "prestamo") {
            $stid = oci_parse($this->conexion, "delete from prestamo where libro=$argumentos[0] and socio=$argumentos[1]");
        }
        $consulta = $this->Consulta($tabla);
        $mensaje  = $this->prueba($consulta, $argumentos, $stid);
        return "$tabla eliminado";

    }
    //Actualizar
    public function Actualizar($tabla, $argumentos)
    {

        if ($tabla == "libro") {
            $stid = oci_parse($this->conexion, "update $tabla set titulo='$argumentos[1]',autor='$argumentos[2]',numpag='$argumentos[3]' where libro=$argumentos[0] ");
        }
        if ($tabla == "socio") {
            $stid = oci_parse($this->conexion, "update $tabla set nombre='$argumentos[1]',telefono='$argumentos[2]',ingreso=to_date('$argumentos[3]','dd/mm/yyyy') where socio=$argumentos[0]");
        }
        if ($tabla == "prestamo") {
            $stid = oci_parse($this->conexion, "update $tabla set fprestamo=to_date('$argumentos[2]','dd/mm/yyyy'),fdevolucion=to_date('$argumentos[3]','dd/mm/yyyy') where libro=$argumentos[0] and socio=$argumentos[1]");
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
        $consulta = oci_parse($this->conexion, "select * from $NTabla");
        oci_execute($consulta);
        return $consulta;
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function getSocios(){
    	return oci_parse($this->conexion,'SELECT * FROM socio order by socio');
    }

    public function buscarSocios($busqueda) {
    	return oci_parse($this->conexion,"select * from socio where UPPER(nombre) LIKE UPPER('$busqueda')");
    }

}

$conn = Conexion::getInstance()->getConexion();
session_start();
$inactivo           = 60;
$_SESSION['tiempo'] = time();
if (isset($_SESSION['tiempo'])) {
    $vida_sesion = time() - $_SESSION['tiempo'];
    if ($vida_sesion > $inactivo) {
        session_destroy(oci_close($conn));
        header("Location: index.php");
    }
}

?>