<?php
/* Clase encargada de gestionar las conexiones a la base de datos */
class Conexion
{

//   private $servidor='localhost';
    private $usuario    = 'guty17';
    private $password   = 'admin123';
    private $base_datos = 'localhost/XE';
    private $link;
    private $stmt;
    private $array;

    static $_instance;

    /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
    private function __construct()
    {
        $this->conectar();
    }

    /*Evitamos el clonaje del objeto. Patrón Singleton*/
    private function __clone()
    {}

    /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*Realiza la conexión a la base de datos.*/
    private function conectar()
    {
        $this->link = oci_connect($this->usuario, $this->password, $this->base_datos);

    }

    /*Método para ejecutar una sentencia sql*/
    public function ejecutar($sql)
    {
        $this->stmt = mysql_query($sql, $this->link);
        return $this->stmt;
    }

    /*Método para obtener una fila de resultados de la sentencia sql*/
    public function obtener_fila($stmt, $fila)
    {
        if ($fila == 0) {
            $this->array = mysql_fetch_array($stmt);
        } else {
            mysql_data_seek($stmt, $fila);
            $this->array = mysql_fetch_array($stmt);
        }
        return $this->array;
    }

    //Devuelve el último id del insert introducido
    public function lastID()
    {
        return mysql_insert_id($this->link);
    }
    //insertar
    public function Insertar($conne, $tabla, $argumentos)
    {
        if ($tabla == "libro") {
            $stid = oci_parse($this->link, 'insert into "$tabla"(libro,titulo,autor,numpag) values("$argumentos[0]","$$argumentos[1]","$$argumentos[2]","$$argumentos[3]")');
            //oci_execute($stid);
            $consutal = Consulta($tabla);
            $cont     = 1;
            while ($cont != 0) {
                if ($row = oci_fetch_row($libros)) {
                    if ($row[0] == $libro) {
                        return 'libro ya existe';
                        break;
                    }
                } else {
                    oci_execute($stid);
                    return 'libro guardado';
                    break;
                }
            }

        }
    }
    //consulta
    private function Consulta($NTabla)
    {
        $consulta = oci_parse($this->link, 'select * from "$NTabla"');
        oci_execute($consulta);
        return $consulta;
    }

}
