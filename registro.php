<?php 

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="icon" type="image/x-icon" href="img/icono.ico" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>

	<title>Ingresa tus datos o registrate para poder ingresar a la página.</title>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap');
	body{
		background-color: #f8bbd0 ;
	}
	.fuente{
		/*font-family: 'Segoe UI Light'*/
		font-family: 'Roboto', sans-serif;
	}
	.centrar{
		display: flex;
		justify-content: center;
	}
	.tam{
		font-size: 1.3em !important;
	}
	@media only screen and (max-width : 992px) {
		#img_logo{
			max-height: 200px;
		}
	}
	@media only screen and (max-width : 1200px) {
		#img_logo{
			max-height: 200px;
		}
	}
</style>

<body id="cuerpo">
	<div id="section_1">
		<div class="container" style="margin-top: 1%;">
			<div class="row">
				<div class="center">
					<img id="img_logo" src="img/logo.png" alt="">
				</div>
			</div>
		</div>

		<div class="container" style="margin-top: 0%">
			<h3 class="fuente center">Ingresa tus datos de acceso</h3>

			<div class="row">
				<form id="form_ingreso">
					<div class="col s12 m6 offset-m3">
						<div class="input-field">
							<i class="material-icons-outlined prefix">person</i>
							<input class="tam" type="text" id="usuario" name="usuario" required />
							<label for="usuario" class="tam">Usuario</label>
						</div>
						<div class="input-field">
							<i class="material-icons-outlined prefix">lock</i>
							<input class="tam" type="text" id="pass" name="pass" required />
							<label for="pass" class="tam">Contraseña</label>
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="center">
					<button type="submit" form="form_ingreso" class="btn btn-large waves-effect waves-light pink lighten-2" id="btn_ingreso" ><i class="material-icons-outlined right">lock</i>Ingresar</button>
				</div>
			</div>	
			<div class="row">
				<div class="center">
					<a href="#!" id="registro" >Registrarse</a>
				</div>
			</div>

		</div>
	</div>

	<div id="section_2" hidden>
		<div class="" style="position:absolute; left:0px;top:0px;">
			<a href="registro.php" class="btn-large orange"><i class="material-icons-outlined">keyboard_return</i></a>
		</div>
		<div class="container">
			<h2 class="fuente center">Llena el formulario de registro</h2>
		</div>
		<div class="container">
			<div class="row">
				<form id="form_registro">
					<div class="col s12 m8 offset-m2">
						<div class="input-field">
							<i class="material-icons-outlined prefix">pin</i>
							<input class="tam" type="text" id="cedula" name="cedula">
							<label for="cedula" class="tam">Cédula de identidad</label>
						</div>
						<div class="input-field">
							<i class="material-icons-outlined prefix">face</i>
							<input class="tam" type="text" id="nombre" name="nombre">
							<label for="nombre" class="tam">Nombres</label>
						</div>
						<div class="input-field">
							<i class="material-icons-outlined prefix">person</i>
							<input class="tam" type="text" id="apellidos" name="apellidos">
							<label for="apellidos" class="tam">Apellidos</label>
						</div>
						<div class="input-field">
							<i class="material-icons-outlined prefix">call</i>
							<input class="tam" type="text" id="telf" name="telf">
							<label for="telf" class="tam">Celular</label>
						</div>
						<div class="input-field">
							<i class="material-icons-outlined prefix">lock</i>
							<input class="tam" type="text" id="pass_registro" name="pass_registro">
							<label for="pass_registro" class="tam">Contraseña</label>
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="center">
					<button type="submit" form="form_registro" class="btn-large waves-effect waves-light pink lighten-2" id="btn_registro" ><i class="material-icons-outlined left">how_to_reg</i>Registrarse</button>
				</div>
			</div>
		</div>
	</div>
</body>
<input type="text" id="existe" value="false" hidden>
<script>

	document.getElementById('registro').addEventListener('click', function (e) {
		document.getElementById('section_1').hidden = true;
		document.getElementById('section_2').hidden = false;
	});

	document.getElementById('form_registro').addEventListener('submit', function (e) {
		e.preventDefault();
		formData = new FormData(document.getElementById('form_registro'));
		fetch(`recursos/app/registro.php`, {method: 'post', body: formData})
		.then(response => response.text())
		.then(data => {
			console.log(data);
			if(data == 1){
				M.toast({html: 'Registro exitoso.'})
				document.getElementById('section_1').hidden = false;
				document.getElementById('section_2').hidden = true;
				document.getElementById('form_registro').reset();
			}
			if(data == '0'){
				return M.toast({html: 'Usuario registrado previamente.'});
			}else{
				console.log(data);
			}

		})
	});

</script>
<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
</html>