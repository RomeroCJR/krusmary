<?php 
	require("../../recursos/conexion.php");
	$per = $_GET['per'];
	$gestion = $_GET['ges'];
	if ($per == '0') {
		$per = "";
	}

	// $result = $conexion->query("SELECT SUM(a.Total)as ingreso, a.Fecha FROM venta a WHERE a.Fecha LIKE '".$gestion."-".$per."%' AND a.Estado = 1 GROUP BY a.Fecha");
	// $result = $result->fetch_all();

	// $res = $conexion->query("SELECT b.Monto, b.Fecha FROM gastos b WHERE b.Fecha LIKE '".$gestion."-".$per."%' AND b.Estado = 1 GROUP BY b.Fecha");
	// $res = $res->fetch_all();

	$result = $conexion->query("SELECT SUM(a.Total) as ingreso, b.Monto, b.Fecha FROM venta a, gastos b WHERE b.Fecha LIKE '".$gestion."-".$per."%' AND a.Fecha LIKE b.Fecha AND a.Estado = 1 GROUP BY b.Fecha");
	$res = $result->fetch_all();
	$total = 0;
	$total_g = 0;
	$total_ing = 0;
?>



<title>reporte de ingresos y gastos</title>
<h3 class="fuente">Reporte de ingresos y gastos</h3><br>
<div class="row">
	<div class="col s11">
		<table id="tabla1">
			<thead>
				<tr>
					<th class="center">Gasto</th>
					<th class="center">Ventas</th>
					<th class="center">Ingreso</th>
					<th class="center">Fecha</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($res as $a): ?>
					<?php $total = $total + $a[0] ?>
					<?php $total_g = $total_g + $a[1] ?>
					<?php $total_ing = $total_ing + ($a[0]-$a[1]) ?>
								<tr>
									<td class="center"><?php echo $a[1]." Bs."?></td>
									<td class="center"><?php echo $a[0]." Bs."?></td>
									<td class="center"><?php echo $a[0]-$a[1]." Bs."?></td>
									<td class="center"><?php echo date("d-m-Y", strtotime($a[2]))?></td>
								</tr>
			    <?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	    
$(document).ready(function() {

	const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	let per = months[parseInt('<?php echo $per ?>')-1];

	if (!per) {
		per = ""
	}

	$('#tabla1').dataTable({
      "order": [[ 3, "desc" ]],
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
	        title: 			'Reporte de ventas del periodo: <?php echo $_GET["ges"] ?>'
	      },
	      {
	        extend:     'pdfHtml5',
	        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
	        titleAttr:  'Exportar a PDF',
	        className:  'btn-flat red',
	        title: 			'Reporte de ventas del periodo: <?php echo $_GET["ges"] ?>'
	      },
	      {
	        extend:     'print',
	        text:       '<i class="material-icons-outlined">print</i>',
	        titleAttr:  'Imprimir',
	        className:  'btn-flat blue',
	        title: 			`<span style="font-size:30; line-height: 100%;">Reporte de gastos del periodo: <?php echo $_GET["ges"] ?> - `+per+`</span> 
	        						<p style="font-size:20; font-weight: bold; line-height: 25%;">Totales:</p>
	        						<p style="font-size:18; line-height: 25%;">Días: <?php echo mysqli_num_rows($result) ?></p>
	        						<p style="font-size:18; line-height: 25%;">Ventas: <?php echo $total ?> Bs.</p>
	        						<p style="font-size:18; line-height: 25%;">Gastos: <?php echo $total_g ?> Bs.</p>
	        						<p style="font-size:18; line-height: 25%;">Ingresos: <?php echo $total_ing ?> Bs.</p>`
	      }
	    ]
	    });
})
</script>