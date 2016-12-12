<!DOCTYPE html>
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
		</header>
		<section>
			<div id="textoPr">
				<div class="loginBox">
					<b>
					<?php 
						session_start(); 
						if (isset($_SESSION['mensaje'])){
							echo $_SESSION['mensaje']; 
						}
					?>
					</b>
					<br>
					<b>
					<?php 
						if (isset($_SESSION['mensaje2'])){
							echo $_SESSION['mensaje2']; 
						}
					?>
					</b>
					<form method="POST" action="ControlUsuarios.php">
						<label for="usuario">Usuario:</label>
						<input type="text" name="usuario" placeholder="Usuario">
						<label for"password">Contraseña:</label>
						<input type="password" name="password" placeholder="Contraseña"><br><br>
						<input type="submit" value="Iniciar Sesión">
					</form>
				</div>
			</div>
		</section>
		</div>
	</body>
</html>