<?php 

require("../../recursos/conexion.php");


$ini = $_GET['ini'];
$fin = $_GET['fin'];


$check1 = "";
$check2 = "";
if(isset($_GET['local']) && isset($_GET['pedido'])){
	$check1 = "";
	$check2 = "";
}

if(isset($_GET['local']) && !(isset($_GET['pedido']))){
	$check1 = "checked";
	$check2 = "";
}
if(!(isset($_GET['local'])) && (isset($_GET['pedido']))){
	$check1 = "";
	$check2 = "checked";
}
if(!(isset($_GET['local'])) && !(isset($_GET['pedido']))){
	$check1 = "checked";
	$check2 = "checked";
}

$local = "";
$pedido = "";
if(isset($_GET['local'])){
	$local = "a.cod_pedido IS NULL AND ";
}
if(isset($_GET['pedido'])){
	$pedido = "a.cod_pedido IS NOT NULL AND ";
}


	$result = $conexion->query("SELECT a.cod_venta, a.fecha_venta, a.total_venta, a.cod_usuario, c.ci_usuario, CONCAT(c.nombre_usuario,' ',c.ap_paterno_usuario) as user,IF((IFNULL((a.cod_pedido),'local')) = 'local', 'local', 'pedido') as Tipo, CONCAT(b.nombre_cliente,' ',b.ap_paterno_cliente,' ', (SELECT IFNULL(b.ap_materno_cliente, ' '))) as cliente FROM venta a, cliente b, usuario c WHERE ".$local.$pedido." a.cod_usuario = c.cod_usuario AND a.cod_cliente = b.cod_cliente AND a.estado_venta = 1 AND (a.fecha_venta BETWEEN '".$ini."' AND '".$fin."')");
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
<title>reporte de compras</title>

	<div class="col s8">
		<h3 class="fuente">Reporte de ventas</h3>
	</div>
	<div class="col s1 offset-s1">
		<h3>
			<label>
				<input class="checks" id="local" type="checkbox" <?php echo $check1; ?>/>
				<span>Local</span>
			</label>
		</h3>
	</div>
	<div class="col s1">
		<h3>
			<label>
				<input class="checks" id="pedido" type="checkbox" <?php echo $check2; ?>/>
				<span>Pedidos</span>
			</label>
		</h3>
	</div>
	<br>


<!-- <div class="row"> -->
	<!-- <div class="col s12"> -->
		<table style="border-collapse: collapse; border: solid 3px;" id="tabla1" >
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
			<tbody >
				<?php foreach($fila as $a  => $valor){ ?>
				<tr >
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
	// let per = months[parseInt('<php echo $mes ?>')-1];
	// if (!per) {
	// 	per = "";
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
	        title: 		`Reporte de ventas del periodo: <?php echo $_GET['ini'].' - '.$_GET['fin']; ?> \n
							Total ventas: <?php echo mysqli_num_rows($result) ?> 
							Ventas locales: <?php echo $cant_local?> 
							Ventas por pedido: <?php echo $cant_pedido?> 
 							Ingresos totales: <?php echo $ingreso_total ?> 
						`
	      },
	      {
	        extend:     'pdfHtml5',
	        text:       '<i class="material-icons-outlined"><img src="https://img.icons8.com/material/24/000000/pdf-2--v1.png"/></i>',
	        titleAttr:  'Exportar a PDF',
	        className:  'btn-flat red',
	        title: 		`Reporte de ventas del periodo: <?php echo $_GET['ini'].' - '.$_GET['fin']; ?> \n
							Total ventas: <?php echo mysqli_num_rows($result) ?>\nVentas locales: <?php echo $cant_local?>\nVentas por pedido: <?php echo $cant_pedido?>\nIngresos totales: <?php echo $ingreso_total ?>	
						`
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
	        title: 		`<center><span style="font-size:25; line-height: 2.5em;">Reporte del ventas del periodo: <?php echo $_GET['ini'].' - '.$_GET['fin']; ?></span></center> 
						
						<div style="width: 40%">
							<table style="line-height: 0.3em;">
								<tr>
									<th >Total ventas:</th>
									<td ><?php echo mysqli_num_rows($result) ?></td>
								</tr>
								<tr>
									<th >Ventas locales:</th>
									<td ><?php echo $cant_local?></td>
								</tr>
								<tr>
									<th >Ventas por pedido:</th>
									<td ><?php echo $cant_pedido?></td>
								</tr>
								<tr>
									<th >Ingresos totales:</th>
									<td ><?php echo $ingreso_total ?></td>
								</tr>
							</table>
						</div>
						`
	      }
	    ]
	    });
})


document.getElementsByClassName('checks')[0].addEventListener('click', function (e) {
	var local = document.getElementById('local').checked;
	var pedido = document.getElementById('pedido').checked;
	let ini = `<?php echo $_GET['ini'];?>`;
	let fin = `<?php echo $_GET['fin'];?>`;

	if(local && pedido){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}`);
	}
	if(local && !pedido ){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}&local=1`);
	}
	if(!local && pedido){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}&pedido=1`);
	}
	if(!local && !pedido){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}&pedido=1&local=1`);
	}

});
document.getElementsByClassName('checks')[1].addEventListener('click', function (e) {
	var local = document.getElementById('local').checked;
	var pedido = document.getElementById('pedido').checked;
	let ini = `<?php echo $_GET['ini'];?>`;
	let fin = `<?php echo $_GET['fin'];?>`;

	if(local && pedido){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}`);
	}
	if(local && !pedido ){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}&local=1`);
	}
	if(!local && pedido){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}&pedido=1`);
	}
	if(!local && !pedido){
		$("#cuerpo").load(`templates/reportes/r_ventas.php?ini=${ini}&fin=${fin}&pedido=1&local=1`);
	}

});


</script>