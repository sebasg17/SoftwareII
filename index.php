<!DOCTYPE html>
<?php
require ('ClaseConexion.php');
require ('ControlUsuarios.php');
$ctrlUsuarios = ControlUsuarios::getInstance();
$isL = $ctrlUsuarios->isLogueado();
if (!$isL){
	$_SESSION['mensaje'] = 'Inicie sesión para ver esta página';
	header("Location: login.php");
}
?>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<link href="CSS/estilo.css" rel="stylesheet" >
	</head>
	<body>
		<div id="principal">
			<header>
				<hgroup>
					<h1> SOFTWARE2 </h1>
				</hgroup>
				<nav>
					<ul>
						<li><a href='index.php'>INICIO</a></li>
						<li><a href='libros.php'>LIBROS</a></li>
						<li><a href='socios.php'>SOCIOS</a></li>
						<li><a href='prestamos.php'>PRESTAMOS</a></li>
						<li><a href='informes.php'>INFORMES</a></li>
						<li><a href='cerrar_sesion.php'>Cerrar Sesión</a></li>
					</ul>
				</nav>
			</header>
			<section>
				<div id="textoPr">
					<article>
						<p>BIENVENIDOS</p>
					</article>
					
				</div>
			</section>
		</div>
	</body>
</html>