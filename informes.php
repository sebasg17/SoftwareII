<!DOCTYPE html>
<?php
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
    <a href="<?=$_SERVER['HTTP_REFERER']?>">Volver</a>
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
					<hgroup>
						<h1> INFORME</h1>
					</hgroup>
                    <form method='POST' action='operacionesI.php'>
                        <select  id="lista" name="lista">
                            <option value="0">seleccione una opcion...</option>
                            <option value="1">Listado de socios y la fecha de ingreso</option>
                            <option value="2">Listado de libros</option>
                            <option value="3">cantidad de socios</option>
                            <option value="4">cantidad de libros</option>
                            <option value="5">Listado de libros prestados por socio</option>
                            <option value="6">Total de libros prestados a cada socio</option>
                            <option value="7">Libro mas solicitado</option>
                            <option value="8">Libros menos solicitado</option>
                            <option value="9">Libros prestados y devueltos</option>
                            <option value="10">Total de libros prestados</option>
                            <option value="11">Toral de libros prestados y devueltos</option>
                            <option value="12">Libros prestados y no devueltos</option>
                            <option value="13">Socio que mas libros a solicitado</option>
                            <option value="14">Listado de las personas que le fue prestado un libro en el mes de marzo, ademas mostrar el libro</option>
                            <option value="15">Total de libros prestados en el mes de enero</option>
                            <option value="16">Libros prestados y tiempo que demoraron en devolverlo, aplica solo a los libros devueltos</option>
                            <option value="17">Promedio de tiempo prestado por cada libro, aplica solo a los libros devueltos</option>
                            <option value="18">Listado de libros prestados que no han sido devueltos y el tiempo(en dias) que llevan de esta prestados</option>
                            <option value="19">Los tres libros mas solicitados</option>
                            <option value="20">los dos socios que mas solicitan libros</option>
                            <option value="21">Listado de socios que han tenido un libro por mas de 2 dias, aplica solo para los libros devueltos</option>
                            <option value="22">Funcion</option>
                            <option value="23">Procedimiento</option>
                        
                        </select>
                        <br>
                        <br>
                        <input id="btnConsultar" class="btnConsultar" name="btnConsultar" type="submit" value="Consultar"/>
					</form>
				</div>
						
			
			</section>
		</div>	
		
	</body>
</html>