<?php 
	require("../../recursos/conexion.php");
	// require("../../recursos/sesiones.php");
	session_start();
	$id = $_SESSION['id_cliente'];

	$res = $conexion->query("SELECT * FROM cliente WHERE id = ".$id);
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
<div class="container">
	<div class="row">
	    <form class="col s12 back-color z-depth-4" id="form_client">
	    <h4 class="roboto">Mi perfil</h4>
	      <div class="row">
	        <div class="input-field col s12">
	          <input id="cedula" name="cedula" type="text" minlength="1" maxlength="8" onkeypress="return checkIt(event)" class="validate" value="<?php echo $res[0]['Ci']?>">
	          <label for="cedula">Cédula</label>
	        </div>

	        <div class="input-field col s12">
	          <input id="nombre" name="nombre" type="text" class="validate" onkeypress="return checkText(event)" minlength="3" maxlength="20" value="<?php echo $res[0]['Nombre']?>">
	          <label for="nombre">Nombre</label>
	        </div>

	        <div class="input-field col s12">
	          <input id="apellidos" name="apellidos" type="text" class="validate" onkeypress="return checkText(event)" minlength="3" maxlength="20" value="<?php echo $res[0]['Apellidos']?>">
	          <label for="apellidos">Apellidos</label>
	        </div>

	        <div class="input-field col s12">
	          <input id="telf" name="telf" type="text" class="validate" minlength="8" maxlength="8" onkeypress="return checkIt(event)" value="<?php echo substr($res[0]['Telefono'], 4)?>">
	          <label for="telf">Teléfono/Celular</label>
	        </div>
	      </div>
	      <div class="bt row">
	      	<div class="col s7">
	      		<small style="color:red"><p>Los datos del ingresados serán utilizados en la factura.</p></small>
	      	</div>
	      	<div class="col s4 offset-s1">
	      		<button type="submit" class="btn waves-effect waves-light right">Guardar</button>
	      	</div>
	      </div>
	    </form>
  	</div>
</div>

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

   	$("#form_client").on("submit", function(e){
   		e.preventDefault();
   		var data = new FormData(document.getElementById("form_client"));
   		$.ajax({
			url: "recursos/app/form_client.php",
			method: "post",
			data: data,
			contentType: false,
    		processData: false
		}).done(function(echo){
			console.log(echo)
			if (echo == "1") {
				console.log(echo)
				M.toast({html: "Datos de perfil modificados."})
			}
		});
    })
</script>