<?php
session_start(); 
unset($_SESSION['ControlUsuarios']);
unset($_SESSION['usuario']);
unset($_SESSION['password']);
$_SESSION['mensaje'] = 'Sesión cerrada exitosamente';
header("Location: login.php");
?>