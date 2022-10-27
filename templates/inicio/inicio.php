<?php 
	require("../../recursos/conexion.php");
	date_default_timezone_set("America/La_Paz");
	$daily = date("Y-m-d");

	$mes = $_GET['mes'];
	$year = $_GET['year'];
	$per = $_GET['per'];

	$actual = explode('-',$mes);

	$text = "hoy";
	$text2 = "Selecciona el periodo";
	if((isset($_GET['actual_mes']))){
		$text2 = $per;
		if( (((int)$_GET['actual_mes']) + 1 ) != ((int)$actual[1])){
			$text = $per;
		}
	}
	
	
	// echo $year." ".$per;
	// $result = $conexion->query("SELECT a.Codpla, a.Nombre, a.Precio, a.Descripcion, a.Foto, d.Stock, (SELECT IF (SUM(b.Cantidad)>0, SUM(b.Cantidad),0) FROM det_plato b, venta c WHERE a.Codpla = b.Codpla AND b.Codv = c.Codv AND c.Fecha LIKE '%".$mes."%' AND b.Estado = 1) as Cantidad FROM plato a, stock d WHERE a.Codpla = d.Codpla AND a.Estado = 1 GROUP BY a.Codpla ORDER BY Cantidad DESC");
	$result = $conexion->query("SELECT a.cod_producto, a.nombre_producto, a.precio_producto, a.descripcion_producto, a.foto_producto, d.stock, (SELECT IF (SUM(b.cant_producto)>0, SUM(b.cant_producto),0) FROM detalle_venta b, venta c WHERE a.cod_producto = b.cod_producto AND b.cod_venta = c.cod_venta AND c.fecha_venta LIKE '%".$mes."%' AND b.estado_det_venta = 1) as cantidad, (SELECT IF (SUM(b.cant_producto)>0, SUM(b.cant_producto),0) FROM detalle_venta b, venta c WHERE a.cod_producto = b.cod_producto AND b.cod_venta = c.cod_venta AND c.fecha_venta LIKE '%".$daily."%' AND b.estado_det_venta = 1) as daily, a.cod_categoria FROM producto a, inventario d WHERE a.cod_producto = d.cod_producto AND a.estado_producto = 1 GROUP BY a.cod_producto ORDER BY cantidad DESC");
	$result = $result->fetch_all();

	$result2 = $conexion->query("SELECT * FROM categoria WHERE estado_categoria = 1");
	$result2 = $result2->fetch_all(MYSQLI_ASSOC);

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

			  <option value="00" disabled selected><?php echo $text2; ?></option>
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
			<h5 class="rubik">Productos más vendidos para el periodo: <b><?php echo $per." ".$year ?></b></h5>
		</div>	
		</div>
		<?php foreach ($result2 as $val): ?>

		<div class="row">
			<div class="col s12 center"><h4 class="rubik"><?php echo $val['nombre_categoria']; ?></h4></div>
			<hr style="color:aquamarine">
			<?php foreach ($result as $key): ?>

				<?php if($val['cod_categoria'] == $key[8]): ?>
				
				<div class="col s3">
					<div class="card">
					    <div class="card-image waves-effect waves-block waves-light">
					      <img class="activator img-height" width="100%" src="<?php echo $key[4] ?>">
					    </div>
					    <div class="card-content">
					      <span class="card-title activator grey-text text-darken-4"><?php echo $key[1]?><i class="material-icons right">more_vert</i></span>
					      <div class="" > 
					      	<!-- <p class="trunc"><?php echo $key[3] ?></p> -->
					      	<?php if($text != "hoy"){?>
					      		<span class="trunc rubik" >Cantidad vendida en <?php echo $text; ?>: <?php echo $key[6]?></span>
					      	<?php }else{ ?>
								<span class="trunc rubik" >Cantidad vendida  hoy: <?php echo $key[7]?></span>
							<?php }?>
					      </div>

					      <div>
					      	<small>
					      		<span class="rubik" style="position: absolute; bottom: 20px; color:red;">
					      			<?php if ((int)(((int)$key[5]) - ((int)$key[7])) <= 3): ?>
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
				<?php endif ?>
			<?php endforeach ?>  
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
		fetch("recursos/stock/inicio.php?cant="+cant+"&id="+id)
		.then(response => response.text())
		.then(data => {
			console.log(data);
		})

	})
	document.getElementById('periodo').addEventListener('change', () => {

		let mes = $("#periodo").val();
		let fecha = new Date();
        const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        let actual = fecha.getFullYear()+"-"+mes;
        let year = fecha.getFullYear();
        let per = months[parseInt(mes)-1];

		let actual_mes = fecha.getMonth()
		
		$("#periodo").val()
		$("#cuerpo").load("templates/inicio/inicio.php?mes="+actual+"&year="+year+"&per="+per+"&actual_mes="+actual_mes)
	})
</script>