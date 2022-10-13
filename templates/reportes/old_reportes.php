<?php

require('../../recursos/conexion.php');

// $Sql = "SELECT * FROM insumo WHERE Estado = 1"; 
// $Busq = $conexion->query($Sql); 
// while($arr = $Busq->fetch_array()) 
//     { 
//         $fila[] = array('nombre'=>$arr['Nombre'], 'costo'=>$arr['Costo'], 'cantidad'=>$arr['Cantidad'], 'fechac'=>$arr['Fecha_compra']); 
//     } 

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
	</head>
	<style>

	</style>
	<body>
		<div class="row"><div class="col s6 offset-s3"><h4>SELECCIONA EL TIPO DE REPORTE</h4></div></div>
		<div class="row">
			<div class="col s12 m2">
				<a href="#" onclick="report_insumos()">
					<div class="card-panel teal">
						<span class="white-text">
							<h4>INSUMOS</h4>
						</span>
					</div>
				</a>
			</div>
			<div class="col s12 m2">
				<a href="#" onclick="report_insumos()">
					<div class="card-panel teal">
						<span class="white-text">
							<h4>VENTAS</h4>
						</span>
					</div>
				</a>
			</div>
		</div>
		<!-- Modal REPORTE INSUMOS -->
		<div id="modal_insumos" class="modal">
			<div class="modal-content">
				<h4>Reporte de Insumos</h4>
				Fecha:
				<form>
					<div class="row">
						<div class="input-field col m5 l4 s12">
							<input type="number" name="anio" id="anio"  value="2019" autocomplete="off" required>
							<label for="anio" class="active">Año</label>
						</div>
						<div class="input-field col m5 l4 s12">
							<input type="number" name="mes" id="mes" value="" autocomplete="off" min="1" max="12" required>
							<label for="mes" >Mes</label>
						</div>
						<div class="col m5 l4 s12">
							<a href="#" class="btn-large waves-effect waves-light" onclick="generar_reporte_insumos()"><i class="material-icons">assignment</i></a>
						</div>
					</div>
				</form>

				<b>Inversión total en insumos para la fecha: </b><span id="inv_fecha"></span> Bs.
				<table id="tab_det" >
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Costo</th>
						<th>Cantidad</th>
						<th>Fecha</th>
					</tr>
					</thead>
					<tbody id="cuerpo_tabla_insumo">

				     </tbody>
				</table>
				
			</div>
			<br>
			<div class="row">
				<div class="modal-footer col s12">
					<a href="#!" class="right modal-action modal-close waves-effect waves-light btn-large">Aceptar</a>
				</div>
			</div>
			
		</div>
	</body>
	<script>
		function report_insumos() {
			$("#modal_insumos").openModal();
		}
		function generar_reporte_insumos() {
			let anio = $("#anio").val()
			let mes = $("#mes").val() 
			let c = anio+"-"+mes+"-"
			if (mes > 12 || mes < 1){
				Materialize.toast("Ingrese un mes válido")
			}
			else{

				

				var cuerpo_tabin = ``;
				let total = 0 ;
				"<?php foreach($fila as $a  => $valor){ ?>"
					if (("<?php echo $valor['fechac']?>").includes(c)) {
						cuerpo_tabin = cuerpo_tabin + `<tr><td><?php echo $valor['nombre'] ?></td><td><?php echo $valor['costo'] ?></td><td><?php echo $valor['cantidad'] ?></td><td><?php echo $valor['fechac'] ?></td></tr>`
						total = total + ((parseInt("<?php echo $valor['costo'] ?>")) * (parseInt("<?php echo $valor['cantidad'] ?>")))
						console.log(total)
					}

				"<?php } ?>"


				console.log(total)
				$("#inv_fecha").html(total)
				$("#cuerpo_tabla_insumo").html(cuerpo_tabin)

			}
		}

	</script>
</html>