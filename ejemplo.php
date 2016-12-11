
<?php
 
    /**
     * Clase de conexion
     * Implementada con patron de diseño singleton
     *
     * @author leswider
     */
    class Conexion {
 
        private $_oLinkId; //objeto resource que indicara si se ha conectado
        private $_sServidor;
        private $_sNombreBD;
        private $_sUsuario;
        private $_sClave;
        private $_sPuerto;
        public static $sMensaje;
        private static $_oSelf = null; //Almacenara un objeto de tipo Conexion
 
        /**
         *
         * @param string Nombre del usuario a conectarse.
         * @param string Password de conexión.
         * @param string Nombre de la base de datos.
         * @param string Nombre del servidor.
         */
 
        private function __construct() {
 
            
            $this->_sNombreBD ='localhost/XE';
            $this->_sUsuario = 'didier';
            $this->_sClave = 'unillanos';
            $this->_sPuerto = '1521'; // PUERTO QUE ESCUCHA ORACLE
        }
 
        /**
         * Este es el pseudo constructor singleton
         * Comprueba si la variable privada $_oSelf tiene un objeto
         * de esta misma clase, si no lo tiene lo crea y lo guarda
         * @static
         * @return resource
         */
        public static function getInstancia() {
 
            if (!self::$_oSelf instanceof self) {
                $instancia = new self(); //new self ejecuta __construct()
                self::$_oSelf = $instancia;
                if (!is_resource($instancia->conectar())) {
                    self::$_oSelf = null;
                }
            }
            $conex = self::$_oSelf;
            return $conex->_oLinkId; //Se devuelve el link a la conexion
        }
 
        /**
         * Realiza la conexion
         * @return link para exito, o false
         */
        private function conectar() {
 
            $this->_oLinkId = null;
            $intentos = 0;
            while (!is_resource($this->_oLinkId) && $intentos < 20) {
                $intentos++;
                $this->_oLinkId =
                        oci_connect($this->_sUsuario, $this->_sClave, $this->_sNombreBD);
            }
 
            if (is_resource($this->_oLinkId)) {
                self::$sMensaje = "Conexion exitosa!<br/>";
            } else {
                self::$sMensaje = "ERROR: No se puede conectar a la base de datos..!<br/>";
            }
            echo self::$sMensaje;
            return $this->_oLinkId;
        }
 
        /**
         * Este método verifica si había una conexión abierta anteriormenete. Si había la cierra.
         *
         * @static
         * @return boolean true si existía la conexión, false si no existía.
         */
        public static function desconectar() {
 
            $conexion_activa = false;
            if (self::$_oSelf instanceof self) {
                $bandera = true;
                $instancia = self::$_oSelf;
                oci_close($instancia->_oLinkId); //cierro la conexion activa
                self::$_oSelf = null; //destruyo el objeto
            }
            return $conexion_activa;
        }
 
    }
 
 ?>