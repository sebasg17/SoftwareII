<?php 
require ('ClaseConexion.php');
session_start();
$inactivo=10;
$_SESSION['tiempo']=time();
if(isset($_SESSION['tiempo'])){
	$vida_sesion = time() - $_SESSION['tiempo'];
	if($vida_sesion>$inactivo){
		session_destroy(oci_close($conn));
		header("Location: index.php");
	}
}
?>