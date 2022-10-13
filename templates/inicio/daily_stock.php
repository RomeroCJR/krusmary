<?php 
	require("../../recursos/conexion.php");
	$mes = $_GET['mes'];
	$year = $_GET['year'];
	$per = $_GET['per'];
	date_default_timezone_set("America/La_Paz");
	$daily = date("Y-m-d");
	// echo $year." ".$per;
	// $result = $conexion->query("SELECT a.Codpla, a.Nombre, a.Precio, a.Descripcion, a.Foto, d.Stock, (SELECT IF (SUM(b.Cantidad)>0, SUM(b.Cantidad),0) FROM det_plato b, venta c WHERE a.Codpla = b.Codpla AND b.Codv = c.Codv AND c.Fecha LIKE '%".$mes."%' AND b.Estado = 1) as Cantidad FROM plato a, stock d WHERE a.Codpla = d.Codpla AND a.Estado = 1 GROUP BY a.Codpla ORDER BY Cantidad DESC");
	$result = $conexion->query("SELECT a.Codpla, a.Nombre, a.Precio, a.Descripcion, a.Foto, d.Stock, (SELECT IF (SUM(b.Cantidad)>0, SUM(b.Cantidad),0) FROM det_plato b, venta c WHERE a.Codpla = b.Codpla AND b.Codv = c.Codv AND c.Fecha LIKE '%".$mes."%' AND b.Estado = 1) as Cantidad, (SELECT IF (SUM(b.Cantidad)>0, SUM(b.Cantidad),0) FROM det_plato b, venta c WHERE a.Codpla = b.Codpla AND b.Codv = c.Codv AND c.Fecha LIKE '%".$daily."%' AND b.Estado = 1) as daily FROM plato a, stock d WHERE a.Codpla = d.Codpla AND a.Estado = 1 GROUP BY a.Codpla ORDER BY Cantidad DESC");
	$result = $result->fetch_all();

?>
<style>
	.container-fluid{
		/*padding-top: 20px;*/
	}
	.card{
		height: 330px;

	}
	.trunc{
		/*text-overflow: ellipsis;
	  	white-space: pre-line;
	  	overflow: hidden;*/
	  	overflow: hidden;
	  	text-overflow: ellipsis;
	  	display: -webkit-box;
	  	-webkit-line-clamp: 3;
	  	-webkit-box-orient: vertical;
	}

	.img-height{
		max-height: 180px;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="input-field col s3">
			<select id="periodo">
			  <option value="00" disabled selected>Selecciona el periodo</option>
			  <option value="01">Enero</option>
			  <option value="02">Febrero</option>
			  <option value="03">Marzo</option>
			  <option value="04">Abril</option>
			  <option value="05">Mayo</option>
			  <option value="06">Junio</option>
			  <option value="07">Julio</option>
			  <option value="08">Agosto</option>
			  <option value="09">Septiembre</option>
			  <option value="10">Octubre</option>
			  <option value="11">Noviembre</option>
			  <option value="12">Diciembre</option>
			</select>
			<!-- <label>Selecciona el periodo</label> -->
		</div>
		<div class="col s9">
			<h4 class="roboto">Productos más vendidos para el periodo: <?php echo $per." ".$year ?></h4>
		</div>	
		</div>
		<?php foreach ($result as $key): ?>

				<div class="col s3">
					<div class="card">
					    <div class="card-image waves-effect waves-block waves-light">
					      <img class="activator img-height" width="100%" src="<?php echo $key[4] ?>">
					    </div>
					    <div class="card-content">
					      <span class="card-title activator grey-text text-darken-4"><?php echo $key[1]?><i class="material-icons right">more_vert</i></span>
					      <div class="" > 
					      	<!-- <p class="trunc"><?php echo $key[3] ?></p> -->
					      	
					      	<span class="trunc rubik" >Cantidad vendida hoy: <?php echo $key[7]?></span>
					      	
					      </div>

					      <div>
					      	<small>
					      		<span class="rubik" style="position: absolute; bottom: 20px; color:red;">
					      			<?php if ((((int)$key[5])-((int)$key[7])) <= 5): ?>
					      				Producto escaso.
					      			<?php endif ?>
					      		</span>
					      	</small>
					      </div>

					    </div>

					    <div class="card-reveal">
					      <span class="card-title grey-text text-darken-4"><?php echo $key[1]?><i class="material-icons right">close</i></span>
					      <div class="input-field">
					      	<input type="text" class="cod" value="<?php echo $key[0] ?>" hidden>
					      	<input type="text" class="stock" onkeypress="return checkIt(event)" minlength="1" maxlength="3" name="stock" value="<?php echo $key[5]?>">
					      	<label for="stock">Stock diario:</label>

					      </div>
					      <div>
					      		<span>Cantidad total vendida para el periodo <?php echo $per." ".$year?>: <b><?php echo $key[6]?></b></span>
					      </div>
					    </div>
				    </div>
			  	</div>

	 	<?php endforeach ?>

</div>
<script>
	
	$(document).ready(function() {
		$('select').formSelect();
		M.updateTextFields();
	})
	$(".stock").on('input', function() {
		let cant = this.value

		let id = this.parentNode.children[0].value
		$.ajax({
        url: "recursos/stock/daily_stock.php?cant="+cant+"&id="+id,
        method: "GET",
        success: function(response) {
 			console.log(response)
        },
        error: function(error) {
            console.log(error)
        }
      })
	})
	$("#periodo").on('change', function() {
		let mes = $("#periodo").val();
		let fecha = new Date();
        const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        let actual = fecha.getFullYear()+"-"+mes;
        let year = fecha.getFullYear();
        let per = months[parseInt(mes)-1];

		$("#periodo").val()
		$("#cuerpo").load("templates/inicio/daily_stock.php?mes="+actual+"&year="+year+"&per="+per)
	})
</script>