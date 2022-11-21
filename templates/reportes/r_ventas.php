<?php 

require("../../recursos/conexion.php");


$gestion = $_GET['ges'];
$mes = $_GET['per'];

if ($mes == 0) {
	$result = $conexion->query("SELECT a.cod_venta, a.fecha_venta, a.total_venta, a.cod_usuario, c.ci_usuario, CONCAT(c.nombre_usuario,' ',c.ap_paterno_usuario) as user,IF((IFNULL((a.cod_pedido),'local')) = 'local', 'local', 'pedido') as Tipo, CONCAT(b.nombre_cliente,' ',b.ap_paterno_cliente,' ', (SELECT IFNULL(b.ap_materno_cliente, ' '))) as cliente FROM venta a, cliente b, usuario c WHERE a.cod_usuario = c.cod_usuario AND a.cod_cliente = b.cod_cliente AND a.estado_venta = 1 AND a.fecha_venta LIKE '".$gestion."%'");
}else{
	$result = $conexion->query("SELECT a.cod_venta, a.fecha_venta, a.total_venta, a.cod_usuario, c.ci_usuario, CONCAT(c.nombre_usuario,' ',c.ap_paterno_usuario) as user,IF((IFNULL((a.cod_pedido),'local')) = 'local', 'local', 'pedido') as Tipo, CONCAT(b.nombre_cliente,' ',b.ap_paterno_cliente,' ', (SELECT IFNULL(b.ap_materno_cliente, ' '))) as cliente FROM venta a, cliente b, usuario c WHERE a.cod_usuario = c.cod_usuario AND a.cod_cliente = b.cod_cliente AND a.estado_venta = 1 AND a.fecha_venta LIKE '".$gestion."-".$mes."%'");
}
	$cant_local = 0;
	$cant_pedido = 0;
	$ingreso_total = 0;
	if((mysqli_num_rows($result))>0){
	  while($arr = $result->fetch_array()){ 
	        $fila[] = array('codv'=>$arr['cod_venta'], 'cliente'=>$arr['cliente'], 'fecha'=>$arr['fecha_venta'], 'tipo'=>$arr['Tipo'], 'total'=>$arr['total_venta'], 'ciusu'=>$arr['ci_usuario'], 'user'=>$arr['user']); 
	        $ingreso_total = $ingreso_total + (int)$arr['total_venta'];
	        if ($arr['Tipo'] == 'local') {
	        	$cant_local++;
	        }else{
	        	$cant_pedido++;
	        }
	  }
	}else{
	        $fila[] = array('codv'=>'---', 'cliente'=>'---', 'fecha'=>'---', 'tipo'=>'---','total'=>'---', 'ciusu'=>'---', 'user'=>'---');
	}

?>
<style>
	/* .dataTables_wrapper .dataTables_filter input {
    border: 1px solid #aaa;
    border-top-width: 1px;
    border-right-width: 1px;
    border-left-width: 1px;
    border-radius: 3px;
    padding: 5px;
    background-color: transparent;
    margin-bottom: 0px;
		margin-left: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
		padding-top: 0px;
		padding-right: 0px;
		border-top-width: 0px;
		border-left-width: 0px;
		border-right-width: 0px;
  } */

	@media print{
		header, main, body, footer { 
			padding-left:0px;
		}
	}
</style>
<title>reporte de compras</title>
<div class="row">
	<div class="col s8">
		<h3 class="fuente">Reporte de ventas</h3><br>
	</div>
	<div class="col s4">
		
	</div>
</div>

<!-- <div class="row"> -->
	<!-- <div class="col s12"> -->
		<table id="tabla1" >
			<thead>
				<tr>
					<th>Código</th>
					<th>Fecha de <br>venta</th>
					<th>Vendedor</th>
					<th>Cliente</th>
					<th>Tipo de venta</th>
					<th>Total (Bs.)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($fila as $a  => $valor){ ?>
				<tr>
					<td><?php echo $valor['codv']?></td>
					<td><?php echo date('d-m-Y', strtotime($valor['fecha']))?></td>
					<td><?php echo $valor['user']?></td>
					<td><?php echo $valor['cliente']?></td>
					<td><?php echo $valor['tipo']?></td>
					<td class="total"><?php echo $valor['total']	?></td>
				</tr>
			    <?php } ?>
			</tbody>
		</table>
	<!-- </div> -->
<!-- </div> -->

<script>
var totales = {
	"total_ventas": '<?php echo mysqli_num_rows($result) ?>',
	"ventas_locales": '<?php echo $cant_local?>',
	"ventas_pedido": '<?php echo $cant_pedido?>',
	"ingreso_total": '<?php echo $ingreso_total ?>'
}
$(document).ready(function() {
	const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	let per = months[parseInt('<?php echo $mes ?>')-1];
	if (!per) {
		per = "";
	}

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
	        title: 		'Reporte de ventas del periodo: <?php echo $_GET["ges"] ?>'
	      },
	      {
	        extend:     'pdfHtml5',
	        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
	        titleAttr:  'Exportar a PDF',
	        className:  'btn-flat red',
	        title: 		'Reporte de ventas del periodo: <?php echo $_GET["ges"] ?>'
	      },
	      {
	        extend:     'print',
	        text:       '<i class="material-icons-outlined">print</i>',
	        titleAttr:  'Imprimir',
	        className:  'btn-flat blue',
	        title: 		`<center><span style="font-size:30; line-height: 2.5em;">Reporte del ventas del periodo: <?php echo $_GET["ges"] ?> - ${per}</span></center> 
						
						<div style="width: 40%">
							<table style="border: 1px solid black;border-collapse: collapse; line-height: 0.3em;">
								<tr>
									<th style="border: 1.5px solid black;border-collapse: collapse;">Total ventas:</th>
									<td style="border: 1px solid black;border-collapse: collapse;"><?php echo mysqli_num_rows($result) ?></td>
								</tr>
								<tr>
									<th style="border: 1.5px solid black;border-collapse: collapse;">Ventas locales:</th>
									<td style="border: 1.5px solid black;border-collapse: collapse;"><?php echo $cant_local?></td>
								</tr>
								<tr>
									<th style="border: 1.5px solid black;border-collapse: collapse;">Ventas por pedido:</th>
									<td style="border: 1.5px solid black;border-collapse: collapse;"><?php echo $cant_pedido?></td>
								</tr>
								<tr>
									<th style="border: 1.5px solid black;border-collapse: collapse;">Ingresos totales:</th>
									<td style="border: 1.5px solid black;border-collapse: collapse;"><?php echo $ingreso_total ?></td>
								</tr>
							</table>
						</div>
						`
	      }
	    ]
	    });
})

// document.querySelectorAll('input[type="search"]')[0].addEventListener('input', ()=> {
// 	console.log(totales.ingreso_total);
// 	total = 0;
// 	let elems = document.querySelectorAll('.total');
// 	elems.forEach(element => {
// 		total += parseFloat(element.innerText);
// 	});

// 	console.log(total);
// 	totales.ingreso_total = ""+total;
// 	console.log(totales.ingreso_total);
// })




</script>