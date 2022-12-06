<?php 
	require("../../recursos/conexion.php");
	$ini = $_GET['ini'];
	$fin = $_GET['fin'];
	// SELECT SUM(a.total_venta) as ingreso, SUM(b.monto_caja) AS gasto , DATE(a.fecha_venta) FROM venta a, caja b WHERE b.fecha_caja LIKE '2022-%' AND DATE(a.fecha_venta) = DATE(b.fecha_caja) AND a.estado_venta = 1 AND b.estado_caja = 1 GROUP BY DATE(a.fecha_caja)
	// $result = $conexion->query("SELECT SUM(a.Total)as ingreso, a.Fecha FROM venta a WHERE a.Fecha LIKE '".$gestion."-".$per."%' AND a.Estado = 1 GROUP BY a.Fecha");
	// $result = $result->fetch_all();

	// $res = $conexion->query("SELECT b.Monto, b.Fecha FROM gastos b WHERE b.Fecha LIKE '".$gestion."-".$per."%' AND b.Estado = 1 GROUP BY b.Fecha");
	// $res = $res->fetch_all();
	//consulta de ingresos
	$ingresos = $conexion->query("SELECT SUM(a.total_venta) AS ingreso, DATE(a.fecha_venta) as fecha FROM venta a WHERE (a.fecha_venta BETWEEN '".$ini."' AND '".$fin."') AND a.estado_venta = 1 GROUP BY DATE(a.fecha_venta)");
	$ingreso = $ingresos->fetch_all(MYSQLI_ASSOC);


	//consulta de gastos
	$gastos_ = $conexion->query("SELECT SUM(a.monto_caja) AS gasto, DATE(a.fecha_caja) as fecha FROM caja a WHERE (a.fecha_caja BETWEEN '".$ini."' AND '".$fin."') AND a.estado_caja = 1 GROUP BY DATE(a.fecha_caja)");
	$gastos = $gastos_->fetch_all(MYSQLI_ASSOC);
	// $result = $conexion->query("SELECT * FROM caja b WHERE b.fecha_caja LIKE '".$gestion."-".$per."%' AND b.estado_caja = 1 GROUP BY b.fecha_caja");
	// $res = $result->fetch_all();

	// $result2 = $conexion->query("SELECT SUM(total_venta) FROM venta WHERE estado_venta = 1 AND fecha_venta LIKE '".$gestion."-".$per."%'");
	// $res2 = $result2->fetch_all();
	// $total_venta = $res2[0][0];
	foreach($ingreso as $key => $a){
		if(mysqli_num_rows($gastos_) > 0){
			foreach($gastos as $b){
				if($a['fecha'] == $b['fecha']){
					$ingreso[$key]['gasto'] =  $b['gasto'];
				}else{
					// $ingresos[$key]['fecha'] = $b['fecha'];
					if(!isset($ingreso[$key]['gasto'])){
						$ingreso[$key]['gasto'] = 0;
					}
				}
			}
		}else{
			$ingreso[$key]['gasto'] = 0;
		}
	}

	$x = true;
	if(mysqli_num_rows($gastos_)>0){
		foreach($gastos as $key => $a){
			foreach($ingreso as $b){
				if($a['fecha'] == $b['fecha']){
					$x = false;
					// $ingresos[$key]['gasto'] =  $b['gasto'];
				}
			}
			if($x){
				$arr = array(
					"ingreso" => 0,
					"gasto" => $a['gasto'],
					"fecha" => $a['fecha']
				);
				array_push($ingreso, $arr);
				$x = false;
			}
		}
	}

	// echo var_dump($ingresos);

	// foreach($gastos as $key => $a){
	// 	foreach($ingresos as $b){
	// 		if($a['fecha'] != $b['fecha']){
	// 			$ingresos[$key]['ingreso'] = 0;
	// 			$ingresos[$key]['gasto'] = $a['gasto'];
	// 			$ingresos[$key]['fecha'] = $a['fecha'];
	// 		}
	// 	}
	// }

	// echo var_dump($ingreso);

	$total = 0;	
	$total_g = 0;
	$total_ing = 0;

	foreach ($ingreso as $key => $a) {
		$total = $total + (float)$a['ingreso'];
		$total_g = $total_g + (float)$a['gasto'];
	}
	$total_ing = $total - $total_g;

?>


<style>
	@media print{
		header, main, body, footer { 
			padding-left:0px;
		}
	}
</style>

<title>reporte de ingresos y gastos</title>
<h3 class="fuente">Reporte de Relacion de Ganancia</h3><br>
<div class="row">
	<div class="col s11">
		<table style="border-collapse: collapse; border: solid 3px;" id="tabla1">
			<thead>
				<tr>
					<th class="center">Fecha</th>
					<th class="center">Gastos (Bs.)</th>
					<th class="center">Ingresos (Bs.)</th>
					<th class="center">Ganancia (Bs.)</th>
				</tr>
			</thead>
			<tbody>
				<!-- ingreso, monto, fecha,  -->
				<?php foreach($ingreso as $a): ?>

					<tr>
						<td class="center"><?php echo date("Y-m-d", strtotime($a['fecha']))?></td>
						<td class="center"><?php echo $a['gasto'] ?></td>
						<td class="center"><?php echo $a['ingreso'] ?></td>
						<td class="center"><?php echo (float)$a['ingreso'] - (float)$a['gasto']?></td>
					</tr>

			    <?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	    
$(document).ready(function() {

	const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	// let per = months[parseInt('<php echo $per ?>')-1];

	// if (!per) {
	// 	per = ""
	// }

	$('#tabla1').dataTable({
      "order": [[ 0, "desc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "Lo siento, no se encontraron datos",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay datos disponibles",
        "infoFiltered": "(filtrado de _MAX_ resultados)",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
       },
			"dom": 'Bfrtip',
	    "buttons":[
	      {
	        extend:     'excelHtml5',
	        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/ms-excel--v1.png"/></i>',
	        titleAttr:  'Exportar a Excel',
	        className:  'btn-flat green',
	        title: 		'Reporte de ventas del periodo: <?php echo $_GET['ini'].' - '.$_GET['fin']; ?>'
	      },
	      {
	        extend:     'pdfHtml5',
	        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
	        titleAttr:  'Exportar a PDF',
	        className:  'btn-flat red',
	        title: 		'Reporte de ventas del periodo: <?php echo $_GET['ini'].' - '.$_GET['fin']; ?>'
	      },
	      {
	        extend:     'print',
	        text:       '<i class="material-icons-outlined">print</i>',
	        titleAttr:  'Imprimir',
	        className:  'btn-flat blue',
	        title: 			`<span style="font-size:30; line-height: 100%;">Reporte de Relacion de Ganancia del periodo: <?php echo $_GET['ini'].' - '.$_GET['fin']; ?></span> 
	        						<p style="font-size:20; font-weight: bold; line-height: 25%;">Totales:</p>
	        						<p style="font-size:18; line-height: 25%;">Días: <?php echo mysqli_num_rows($ingresos) ?></p>
	        						<p style="font-size:18; line-height: 25%;">Ingresos: <?php echo $total ?> Bs.</p>
	        						<p style="font-size:18; line-height: 25%;">Gastos: <?php echo $total_g ?> Bs.</p>
	        						<p style="font-size:18; line-height: 25%;">Ganancias: <?php echo $total_ing ?> Bs.</p>`
	      }
	    ]
	    });
})
</script>