<?php 

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="icon" type="image/x-icon" href="img/icono.ico" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
	<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>

	<title>Ingresa o Registra tu número de celular</title>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap');
	body{
		background-color: #eccc68;
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
</style>

<body id="cuerpo">
	<div id="section_1">
		<div class="container" style="margin-top: 10%;">
			<div class="row">
				<div class="center">
					<img src="img/sidelex_sf.png" alt="">
				</div>
			</div>
		</div>

		<div class="container" style="margin-top: 5%">
			<h3 class="fuente center">Ingresa tu número de celular</h3>

			<div class="row">
				<div class="col s4 m3 l2 offset-l3 xl2 offset-xl3">
					<div class="input-field">
						<i class="material-icons-outlined prefix">phone</i>
						<input class="tam" type="text" id="phoneCode" name="phoneCode" value="+591" disabled>
					</div>
				</div>
				<div class="col s8 m9 l4 xl4">
					<div class="input-field">
						<input class="tam" type="tel" id="phoneNumber" name="phoneNumber" />
						<label for="phoneNumber" class="tam">Número celular</label>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="center centrar">
					<div id="recaptcha-container"></div>
				</div>
			</div>
			<div class="row">
				<div class="center">
					<button class="btn btn-large waves-effect waves-light orange" id="getCodeButton" ><i class="material-icons-outlined right">lock</i>Ingresar</button>
				</div>
			</div>	
		</div>
	</div>

	<div id="section_2" hidden>
		<div class="row">
			<a href="registro.php" class="btn-large orange"><i class="material-icons-outlined">keyboard_return</i></a>
		</div>
		<div class="container">
			<h1 class="fuente center">Ingresa el código de confirmación</h1>
		</div>
		<div class="container">
			<div class="row">
				<div class="col s12 l4 offset-l4">
					<div class="input-field">
						<i class="material-icons-outlined prefix">lock_open</i>
						<input class="tam" type="text" id="codeField" name="codeField">
						<label for="codeField" class="tam">Código de confirmación</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="center">
					<button class="btn btn-large waves-effect waves-light" id="signInWithPhone" ><i class="material-icons-outlined right">login</i>Ingresar</button>
				</div>
			</div>
		</div>
	</div>
</body>
<input type="text" id="existe" value="false" hidden>
<script type="module">
	// Import the functions you need from the SDKs you need
	import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js";
	import { getAuth, RecaptchaVerifier, signInWithPhoneNumber } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-auth.js";

	// TODO: Add SDKs for Firebase products that you want to use
	// https://firebase.google.com/docs/web/setup#available-libraries

	// Your web app's Firebase configuration
	const firebaseConfig = {
	  apiKey: "AIzaSyDfxxhh67Q_f8Ebry1WOaGn_1tVprnVCLM",
	  authDomain: "sidelex-e4f5a.firebaseapp.com",
	  projectId: "sidelex-e4f5a",
	  storageBucket: "sidelex-e4f5a.appspot.com",
	  messagingSenderId: "297438529846",
	  appId: "1:297438529846:web:4171cb321434beb92fcb97"

	};
	// Initialize Firebase
	const firebase = initializeApp(firebaseConfig);
	const auth = getAuth();
	var recaptchaStatus = false;
	auth.languageCode = 'es';

	const getCodeButton = document.getElementById("getCodeButton")
	const signInWithPhoneButton = document.getElementById('signInWithPhone')
	// var signInWithPhoneButton = document.getElementById("signInWithPhone")
	var codeField = document.getElementById("codeField")

	window.recaptchaVerifier = new RecaptchaVerifier('recaptcha-container', {
	  'size': 'normal',
	  'callback': (response) => {
	  	recaptchaStatus = true;
	    // reCAPTCHA solved, allow signInWithPhoneNumber.
	  },
	  'expired-callback': () => {
	    // Response expired. Ask user to solve reCAPTCHA again.
	    recaptchaStatus = false;
	  }
	}, auth);

	recaptchaVerifier.render().then((widgetId) => {
	  window.recaptchaWidgetId = widgetId;
	});

	getCodeButton.addEventListener('click', () => {
		const phoneNumber = "+591"+document.getElementById("phoneNumber").value
		const appVerifier = window.recaptchaVerifier;
		// var existe = false;
		$("#existe").val('false')
		if (phoneNumber.length!=12) {
			console.log(phoneNumber.length)
			return M.toast({html: 'Debes ingresar un número válido!'})
		}
		if(!recaptchaStatus){
			return M.toast({html: 'Resuelve el reCaptcha!'})
		}

		$.ajax({
            url: "recursos/app/comprobar.php?telf="+phoneNumber,
            method: "GET",
            success: function(response) {
            	console.log(response+" <----- Respuesta de comprobar.php")
            	if (response == 'ban') {
            		return M.toast({html: 'El número ingresado está bloqueado del servicio.'})
            	}

                if (response == 1) {
                	// existe = true
                	$("#existe").val('true')
                    return window.location.replace('pedidos.php')
                }else{
                	signInWithPhoneNumber(auth, phoneNumber, appVerifier)
				    .then((confirmationResult) => {

				      window.confirmationResult = confirmationResult;
				      console.log(confirmationResult)
				      console.log("confirmationResult")

				      document.querySelector("#section_1").setAttribute('hidden', true);
				      document.querySelector("#section_2").removeAttribute('hidden');
				      M.toast({html: 'Se envió el código al número ingresado.'})

				    }).catch((error) => {
				    	grecaptcha.reset(window.recaptchaWidgetId);
				    	console.log(error)
				    	console.log("error")

				    });
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
	})

	signInWithPhoneButton.addEventListener('click', () => {
		console.log("recogiendo evento click")
		if ($("#existe").val() == 'true') {return console.log("proceder con login...")}
		codeField = document.getElementById("codeField")
		const code = codeField.value
		confirmationResult.confirm(code).then((result) => {
		  // User signed in successfully.
		  const user = result.user;
		  console.log(result.user)
		  console.log('success')

		  let phoneNumber = "591"+document.getElementById("phoneNumber").value
		  $.ajax({
                url: "recursos/app/acceder.php?telf="+phoneNumber,
                method: "GET",
                success: function(response) {
                	console.log(response)
                    if (response == 1) {
                        window.location.replace('pedidos.php')
                    }else{
                       console.log(response)
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });



		  // window.location.replace('principal.php')
		  // ...
		}).catch((error) => {
			console.log(error)
			console.log('error')
		  // User couldn't sign in (bad verification code?)
		  // ...
		});
	})


</script>
<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
</html>