<?php 
	require("../../recursos/conexion.php");
	$per = $_GET['per'];
	$gestion = $_GET['ges'];
	if ($per == '0') {
		$per = "";
	}
	// echo $per." ".$gestion;
	$result = $conexion->query("SELECT a.Codpla, a.Nombre, a.Precio, a.Descripcion, a.Foto, (SELECT IF (SUM(b.Cantidad)>0, SUM(b.Cantidad),0) FROM det_plato b, venta c WHERE a.Codpla = b.Codpla AND b.Codv = c.Codv AND c.Fecha LIKE '%".$gestion."-".$per."%' AND b.Estado = 1) as Cantidad FROM plato a WHERE a.Estado = 1 GROUP BY a.Codpla ORDER BY Cantidad DESC");

	$res = $result->fetch_all();
	$total = 0;
?>


<title>reporte de PRODUCTOS</title>
<h3 class="fuente">Reporte de productos</h3><br>
<div class="row">
	<div class="col s11">
		<table id="tabla1">
			<thead>
				<tr>
					<th>Código</th>
					<th>Producto</th>
					<th>Precio</th>
					<th>Descripción</th>
					<th>Cantidad vendida</th>
					<th>Ingreso total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($res as $a){ ?>
				<tr>
					<?php $total = $total + $a[5]*$a[2] ?>
					<td><?php echo $a[0]?></td>
					<td><?php echo $a[1]?></td>
					<td><?php echo $a[2]?></td>
					<td><?php echo $a[3]?></td>
					<td><?php echo $a[5]?></td>
					<td><?php echo $a[5]*$a[2]." Bs."?></td>
				</tr>
			    <?php } ?>
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
      "order": [[ 4, "desc" ]],
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
	        title: 			`<span style="font-size:30; line-height: 100%;">Reporte de productos del periodo: <?php echo $_GET["ges"] ?> - `+per+`</span> 
	        						<p style="font-size:18; line-height: 25%;">Total productos: <?php echo mysqli_num_rows($result) ?></p>
	        						<p style="font-size:18; line-height: 25%;">Ingresos totales: <?php echo $total ?> Bs.</p>`
	      }
	    ]
	    });
})
</script>