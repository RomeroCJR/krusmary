<?php 
	require("../../recursos/conexion.php");
	// $per = $_GET['per'];
	// $gestion = $_GET['ges'];
	// if ($per == '0') {
	// 	$per = "";
	// }

    date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d");

	$result = $conexion->query("SELECT a.cod_producto, a.nombre_producto, a.descripcion_producto, a.precio_producto, (b.stock - (SELECT IFNULL(SUM(d.cant_producto), 0) FROM detalle_venta d, venta c WHERE d.cod_producto = a.cod_producto AND d.cod_venta = c.cod_venta AND c.fecha_venta LIKE '".$fecha."%')) AS Stock FROM producto a, inventario b WHERE a.cod_producto = b.cod_producto AND a.estado_producto = 1");
	$res = $result->fetch_all();

?>
<style>
	@media print{
		header, main, body, footer { 
			padding-left:0px;
		}
	}
	table.bordered {
		border: 3px solid black;
		border-right: 5px solid black !important;
		border-bottom: 3px solid black !important;
		border-collapse: collapse;
	}
	table.bordered td,
	table.bordered th {
		border: 2px solid black;
	}
</style>

<title>reporte de PRODUCTOS</title>
<h3 class="fuente">Reporte de Almacen</h3><br>
<div class="row">
	<div class="col s11">
		<table style="border-collapse: collapse; border: solid 3px;" id="tabla1">
			<thead>
				<tr>
					<th>Código</th>
					<th>Producto</th>
					<th>Precio</th>
					<!-- <th>Descripción</th> -->
					<th>Stock</th>
					<!-- <th>Ingreso total (Bs.)</th> -->
				</tr>
			</thead>
			<tbody>
				<?php foreach($res as $a){ ?>
				<tr>
					
					<td><?php echo $a[0]?></td>
					<td><?php echo $a[1]?></td>
					<td><?php echo $a[3]?></td>
					<td><?php echo $a[4]?></td>
				</tr>
			    <?php } ?>
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
	        title: 			'Reporte de ventas del periodo: <?php echo $fecha; ?>'
	      },
	      {
	        extend:     'pdfHtml5',
	        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
	        titleAttr:  'Exportar a PDF',
	        className:  'btn-flat red',
	        title: 		'Reporte de ventas del periodo: <?php echo $fecha; ?>'
	      },
	      {
	        extend:     'print',
	        text:       '<i class="material-icons-outlined">print</i>',
	        titleAttr:  'Imprimir',
			customize: function (win) {
				var logoUrl = window.location.origin + '/krusmary/img/logo.png';
				// Personaliza la página de impresión
				$(win.document.body)
				.prepend('Repostería Krus-Mary <img src="'+logoUrl+'" alt="Logo" style="width: auto; max-height: 50px; float: right; margin: 0 0 0 10px;">')
				.find('table')
          		.addClass('bordered');				
			},
	        className:  'btn-flat blue',
	        title: 		`<center><span style="font-size:30; line-height: 100%;">Reporte de almacén</span> </center>
	        						<p style="font-size:18; line-height: 25%;">Fecha: <?php echo $fecha; ?></p>`
	      }
	    ]
	    });
})
</script>