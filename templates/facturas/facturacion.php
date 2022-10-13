<?php 
	require("../../recursos/conexion.php");
	$result = $conexion->query("SELECT * FROM empresa WHERE estado = 1");
	$result = $result->fetch_all(MYSQLI_ASSOC);

	$res = $conexion->query("SELECT * FROM `talonario` WHERE Estado = 1");
	$res = $res->fetch_all(MYSQLI_ASSOC);

?>
<br>
<div class="container">
	<button class="btn-large waves-effect waves-light orange" id="btn-empresa">DATOS DE EMPRESA</button>
	<button class="btn-large waves-effect waves-light orange" id="btn-factura">DATOS DE FACTURA</button>

	<div class="row" id="datos_empresa" hidden>
		<center><h5>DATOS DE EMPRESA</h5></center>
		<div class="col s12">
			<form id="form_empresa">
				<div class="row">
					<div class="input-field col s12" >
			          <input id="NIT" name="NIT" type="text" onkeypress="return checkIt(event)" class="validate" minlength="8" maxlength="8" value="<?php echo $result[0]['NIT'] ?>" required>
			          <label for="NIT">N° NIT (*)</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="direccion" name="direccion" type="text" class="validate" value="<?php echo $result[0]['direccion'] ?>" required>
			          <label for="direccion">Dirección (*)</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="actividad" name="actividad" type="text" class="validate" value="<?php echo $result[0]['actividad'] ?>" required>
			          <label for="actividad">Actividad económica (*)</label>
			        </div>
			        <div class="input-field col s12">
			          <textarea name="leyenda" id="leyenda" cols="30" rows="10" class="materialize-textarea validate" required><?php echo $result[0]['leyenda'] ?></textarea>
			          <label for="leyenda">Leyenda (*)</label>
			        </div>

			        <div class="input-field col s12">
			          <input id="telf" name="telf" type="text" class="validate" onkeypress="return checkIt(event)" minlength="8" maxlength="8" value="<?php echo $result[0]['telefono'] ?>" required>
			          <label for="telf">Número de teléfono (*)</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="email" name="email" type="email" class="validate" value="<?php echo $result[0]['email'] ?>">
			          <label for="email">Email</label>
			        </div>
		      </div>
			</form>
			<button type="submit" class="btn-large waves-effect waves-light right" form="form_empresa">ACEPTAR</button>
		</div>
	</div>

	<div class="row" id="datos_factura" hidden>
		<center><h5>DATOS DE FACTURA</h5></center>
		<div class="col s12">
			<form id="form_factura">
				<div class="row">
					<div class="input-field col s12" >
			          <input id="autorizacion" name="autorizacion" type="text" onkeypress="return checkIt(event)" class="validate" minlength="8" maxlength="8" value="<?php echo $res[0]['Autorizacion'] ?>">
			          <label for="autorizacion">N° autorización</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="llave" name="llave" type="text" class="validate" value="<?php echo $res[0]['Llave_dosif'] ?>">
			          <label for="llave">Llave de dosificación</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="num_inicial" name="num_inicial" type="text" class="validate" value="<?php echo $res[0]['Num_inicio'] ?>">
			          <label for="num_inicial">Número de factura inicial</label>
			        </div>
			        <div class="input-field col s12">
			        	<input id="limite" name="limite" type="date" class="validate" value="<?php echo $res[0]['Fecha_emision'] ?>">
			          	<label for="limite">Fecha límite de emisión</label>
			        </div>
		      </div>
			</form>
			<button type="submit" class="btn-large waves-effect waves-light right" form="form_factura">ACEPTAR</button>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		M.updateTextFields()
    });

	$("#btn-empresa").click(function () {
		document.getElementById("datos_empresa").hidden = false;
		document.getElementById("datos_factura").hidden = true;
	})
	$("#btn-factura").click(function () {
		document.getElementById("datos_empresa").hidden = true;
		document.getElementById("datos_factura").hidden = false;
	})

	$("#form_empresa").on("submit", function(e){
	  e.preventDefault();
	  var formData = new FormData(document.getElementById("form_empresa"));
	  $.ajax({
	    url: "recursos/factura/datos_empresa.php",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false
	  }).done(function(echo){
	    // console.log(echo)
	    if (echo == '1') {
	      M.toast({html: "Datos de empresa modificados."})
	      $("#cuerpo").load("templates/facturas/facturacion.php")
	    }else{
	      console.log(echo)
	    }
	  });
	});

	$("#form_factura").on("submit", function(e){
	  e.preventDefault();
	  var formData = new FormData(document.getElementById("form_factura"));
	  $.ajax({
	    url: "recursos/factura/datos_factura.php",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false
	  }).done(function(echo){
	    // console.log(echo)
	    if (echo == '1') {
	      M.toast({html: "Datos de factura modificados."})
	      $("#cuerpo").load("templates/facturas/facturacion.php")
	    }else{
	      console.log(echo)
	    }
	  });
	});
</script>