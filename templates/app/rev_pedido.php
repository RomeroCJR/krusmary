<?php
require('../../recursos/conexion.php');
$Sql = "SELECT a.Codped, b.Nombre as nompla, a.Cant, b.Precio, c.idcli, d.Nombre, d.Apellidos FROM det_ped a, plato b, pedido c, cliente d WHERE a.Estado = 1 AND a.Codpla = b.Codpla AND a.Codped = c.Codped AND c.idcli = d.id";
$Busq = $conexion->query($Sql);
while($arr = $Busq->fetch_array())
{
$fila[] = array('cod'=>$arr['Codped'], 'nombre'=>$arr['nompla'], 'cant'=>$arr['Cant'], 'precio'=>$arr['Precio'], 'idcli'=>$arr['idcli'], 'nombrecli'=>$arr['Nombre'], 'apcli'=>$arr['Apellidos']);
}
?>



<style>
	body{
		/*font-family: 'Segoe UI Light';*/
		background-color: #ffbb00;
	}
	.textrev{
		color: #eeee00;
	}
	.det{
		/*border: 3px solid black;*/
		background-color: white;
	}
</style>

<!-- <div class="col s12"> -->
	<!-- <a href="../../pedidos.php" class="btn-large orange"><i class="material-icons">keyboard_return</i></a> -->
<!-- </div> -->
<div class="center roboto"><h4>Estado de tu pedido</h4></div> <!-- ESTADO -->
<!-- <div class="row">
	<form id="rev_pedido" class="col s12 m12 l4 offset-l4">
		<div class="row">
			<div class="input-field col s9">
				<input id="ci" name="ci" type="text">
				<label for="ci">Tu cédula de identidad</label>
			</div>
			<div class="col s2 offset-s1"><button id="envio_form" class="btn-large waves-effect waves-light right" type="submit" name="acceso"><i class="material-icons">search</i></button></div>
		</div>
	</form>
	
</div> -->
	

<div class="row roboto" >
	<div class="col s12">
		<table class="det rubik z-depth-4">
			<tr>
				<th>Estado: </th>
				<td><span id="actped"></span></td>
			</tr>
			<tr>
				<th>Fecha: </th>
				<td><span id="fecha_ped"></span></td>
			</tr>
			<tr>
				<th>Hora: </th>
				<td><span id="hora_ped"></span></td>
			</tr>
		</table>
		<!-- <p class="rubik">Estado del pedido: <span id="actped"></span></p> -->
		<!-- <span id="fecha_ped"></span> -->

	</div>
	<div class="col s12 m12 l12">
		<table id="pedidos_cliente" class="content-table z-depth-4">
			<thead>
				<tr>
					<th>PRODUCTO</th>
					<th>CANTIDAD</th>
					<th>PRECIO</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="3">Sin pedidos activos...</td>
				</tr>
			</tbody>
		</table>
		<span class="right" id="totped"></span>
	</div>


</div>


<a class="btn-large red btn-cancelar" id="boton-cancelar">CANCELAR MI PEDIDO</a>

<!-- Modal cancelar_pedido -->
<div class="row">
	<div id="modal_cancelar_pedido" class="modal">
		<div id="cont_cancelar_pedido" class="modal-content">
			<p><h4>Se cancelará su pedido.</h4></p>
			<input type="text" id="codigo_ped" hidden>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-light btn-large green left">Cerrar</a>
			<a href="#!" class="waves-effect waves-light btn-large red right" onclick="confirmar_cancel()">Confirmar</a>
		</div>
	</div>
</div>


<script>
	var mensaje = $("#mensaje");
	mensaje.hide();
	$(document).ready(function() {
		$(".modal").modal();
	    $.ajax({
            url: "recursos/app/ver_pedido.php",
            // method: "GET",
            success: function(echo) {
            	// mensaje.html(echo)
                console.log(echo)
				var arr = echo.split(",");
				
				if (echo == "sinpedidos") {
					$('#actped').css('color', 'red');
					$('#actped').html("No tienes pedidos activos.");
					$('#totped').html("");
					$('#fecha_ped').html("");
					$("#boton-cancelar").hide();
					// document.getElementById("boton-cancelar").hidden = true;
				}

				if (arr[3] == "PENDIENTE") {
					// $('#actped').css('color', '#f6e58d');
					$('#actped').html('Tienes 1 pedido pendiente, tu pedido aun no ha sido aceptado.');
					$('#totped').html('<b>Total:</b> '+arr[0]+'Bs.');
					$('#fecha_ped').html(arr[4]);
					$("#hora_ped").html(arr[5]);
					// $("#boton-cancelar").html("<a class='btn-large red' onclick='cancelar_pedido("+arr[2]+")'>CANCELAR MI PEDIDO</a>");
					$("#boton-cancelar").show();
					$("#boton-cancelar").attr("onclick","cancelar_pedido("+arr[2]+")");
					tabla_llenar(arr[2]);
				}
				if (arr[3] == "ACEPTADO"){
					$('#actped').css('color', '#329f21');
					$('#actped').html('Tu pedido ha sido aceptado, y enviado.');
					$('#totped').html('<b>Total:</b> '+arr[0]+'Bs.');
					$('#fecha_ped').html(arr[4]);
					$("#hora_ped").html(arr[5]);
					// $("#boton-cancelar").html("");
					$("#boton-cancelar").hide();
					tabla_llenar(arr[2]);
				}

				if (arr[3] == "RECHAZADO") {
					$('#actped').css('color', 'orange');
					$('#actped').html('Tu pedido fue rechazado.');
					$('#totped').html('<b>Total:</b> '+arr[0]+'Bs.');
					$('#fecha_ped').html(arr[4]);
					$("#hora_ped").html(arr[5]);
					// $("#boton-cancelar").html("<a class='btn-large red' onclick='cancelar_pedido("+arr[2]+")'>CANCELAR MI PEDIDO</a>");
					// $("#boton-cancelar").show();
					// $("#boton-cancelar").attr("onclick","cancelar_pedido("+arr[2]+")");
					$("#boton-cancelar").hide();
					tabla_llenar(arr[2]);
				}
            },
            error: function(error) {
                console.log(error)
            }
	    })

	});

		

	function tabla_llenar (cod){
		$("#pedidos_cliente tbody").html("")
		var table = $("#pedidos_cliente tbody")[0];

		"<?php foreach($fila as $a  => $valor){ ?>";
			if(cod == "<?php echo $valor['cod'] ?>"){
				var row = table.insertRow(-1);
				row.insertCell(0).innerHTML = "<?php echo $valor['nombre'] ?>";
				row.insertCell(1).innerHTML = "<?php echo $valor['cant'] ?>";
				row.insertCell(2).innerHTML = "<?php echo $valor['precio'] ?>";
			}
		"<?php } ?>";
	}

	function cancelar_pedido(cod) {
		console.log(cod)
		$("#codigo_ped").val(cod);
		$("#modal_cancelar_pedido").modal('open');

	}

	function confirmar_cancel() {

		let cod = $("#codigo_ped").val();
		$.ajax({
            url: "recursos/app/cancel_ped.php?cod="+cod,
            method: "GET",
            success: function(response) {
                console.log(response)
                if (response == '11') {
                	M.toast({html:'Su pedido ha sido cancelado.'}); 
					$('#modal_cancelar_pedido').modal('close');
					$('#actped').css('color', 'red');
					$('#actped').html("Pedido cancelado, no tienes pedidos activos.");
					$('#totped').html("");
					$('#fecha_ped').html("");
					$('#boton-cancelar').hide();
                }
            },
            error: function(error) {
                console.log(error)
            }
	    })

	}


</script>
