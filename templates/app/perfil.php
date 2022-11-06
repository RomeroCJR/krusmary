<?php 
	require("../../recursos/conexion.php");
	// require("../../recursos/sesiones.php");
	session_start();
	$id = $_SESSION['cod_cliente'];

	$res = $conexion->query("SELECT * FROM cliente WHERE cod_cliente = ".$id);
	$res = $res->fetch_all(MYSQLI_ASSOC);
	// echo var_dump($res)
?>

<style>
	.back-color{
		background-color: white;
		margin-top: 30px;
	}
	.bt{
		position: relative;
		bottom: 10px;
	}
</style>
<!-- <div class="container"> -->
	<div class="row">
	    <form class="col s12 back-color z-depth-4" id="form_client">
	    <h4 class="roboto">Mis datos</h4>
	      <div class="row">
	        <div class="input-field col s12">
	          <input id="cedula" name="cedula" type="text" minlength="1" maxlength="8" onkeypress="return checkIt(event)" class="validate" value="<?php echo $res[0]['ci_cliente']?>">
	          <label for="cedula">Cédula de identidad</label>
	        </div>

	        <div class="input-field col s12">
	          <input id="nombre" name="nombre" type="text" class="validate" onkeypress="return checkText(event)" minlength="3" maxlength="20" value="<?php echo $res[0]['nombre_cliente']?>">
	          <label for="nombre">Nombre</label>
	        </div>

	        <div class="input-field col s12">
	          <input id="apellidos" name="apellidos" type="text" class="validate" onkeypress="return checkText(event)" minlength="3" maxlength="20" value="<?php echo $res[0]['ap_paterno_cliente'].' '.$res[0]['ap_materno_cliente']?>">
	          <label for="apellidos">Apellidos</label>
	        </div>

	        <div class="input-field col s12">
	          <input id="telf" name="telf" type="text" class="validate" minlength="8" maxlength="8" onkeypress="return checkIt(event)" value="<?php echo$res[0]['nro_celular_cliente']?>">
	          <label for="telf">Celular</label>
	        </div>

			<div class="input-field col s10">
	          <input id="clave" name="clave" type="password" class="validate" minlength="4" maxlength="8" value="<?php echo$res[0]['clave_cliente']?>">
	          <label for="clave">Contraseña</label>
	        </div>
			<div class="input-field col s2">
				<a href="#!" id="visible" class="btn-small waves-effect waves-light red"><i class="material-icons-outlined">visibility</i></a>
			</div>
	    </div>
		<div class="bt row">
			<div class="col s12">
				<small style="color:red"><p>Los datos del formulario serán utilizados en la factura.</p></small>
			</div>
		</div>
		<div class="row">
		  	<div class="col s12">
				<button type="submit" form="form_client" class="btn waves-effect waves-light right">Guardar</button>
			</div>
		</div>
	    </form>
		
  	</div>
<!-- </div> -->

<script>
	$(document).ready(function() {
		M.updateTextFields();
	});

	function checkIt(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "Este campo acepta números solamente.";
        return false;
      }
      status = "";
      return true;
    }
    function checkText(e) {
      // console.log(e.key)
      var regex = /^[a-zA-Z áéíóúÁÉÍÓÚñ@]+$/;
      if (regex.test(e.key) !== true){
        // e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-Z áéíóúÁÉÍÓÚ@]+/, '');
        return false
      }
    }

	document.getElementById('form_client').addEventListener('submit', function (e) {
   		e.preventDefault();
		var data = new FormData(document.getElementById("form_client"));
		fetch("recursos/app/form_client.php", {method:'post', body: data})
   		.then(response => response.text())
		.then(data => {
			console.log(data)
			if (data == "1") {
				console.log(data)
				M.toast({html: "Datos guardados."})
			}
		})
    })

	document.getElementById('visible').addEventListener('click', function () {
		var tipo = document.getElementById('clave').type
		if(tipo == 'password'){
			document.getElementById('clave').type = 'text'
		}else{
			document.getElementById('clave').type = 'password'
		}
	});
</script>