 <?php
require('../../recursos/conexion.php');
session_start();
$Sql = "SELECT a.cod_venta, c.nombre_usuario, a.cod_usuario, b.ci_cliente, a.cod_cliente, a.fecha_venta, a.total_venta, b.nombre_cliente, CONCAT(b.ap_paterno_cliente,' ',(SELECT IFNULL(b.ap_materno_cliente, ''))) AS apellidos FROM venta a, cliente b, usuario c WHERE a.cod_usuario = c.cod_usuario AND a.cod_cliente = b.cod_cliente AND a.estado_venta = 1"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);

$Sql2 = "SELECT a.cod_venta, a.cod_producto, a.cant_producto, a.precio_det_venta, b.nombre_producto FROM detalle_venta a, producto b WHERE a.cod_producto = b.cod_producto;";
$Busq2 = $conexion->query($Sql2);
$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);

$res = $conexion->query("SELECT * FROM talonario WHERE estado_talonario = 1");
$res = $res->fetch_all();

?>


<style>
  .fuente{
  	font-family: 'Segoe UI light';
  	color: red;
  }

/*  table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
  }*/

#tab_det{
border: 1px solid black;
}

#modal2{
/*width: 40%;
overflow-x: hidden;*/
}
._modal3{
  width: 104.775mm;

}
</style>
<div class="row" style="margin-top:20px;">
  <div class="col s4">
        <a class="waves-effect waves-light btn-large orange darken-4 rubik" id="nv_venta"><i class="material-icons left">add</i><b>Venta</b></a>
  </div>
</div>

<div class="row">
  <div class="col s12 m12 l12">
 <table id="tabla1" class="highlight content-table">
  <thead>
     <tr>
        <th width="15%">Código de venta</th>
        <th>Usuario</th>
        <th>Cliente</th>
        <th>Total</th>
        <th>Fecha</th>
        <th>Acciones</th>
     </tr>          
  </thead>
  <tbody>
  	 <?php foreach($fila as $a  => $valor){ ?>
     <tr>
        <td align="center"><?php echo $valor["cod_venta"] ?></td>
        <td align="center"><?php echo $valor["nombre_usuario"] ?></td>
        <td align="center"><?php echo $valor["nombre_cliente"]." ".$valor["apellidos"] ?></td>
        <td align="center"><?php echo $valor["total_venta"] ?> Bs.</td>
        <td align="center"><?php echo date('d-m-Y', strtotime($valor['fecha_venta'])) ?></td>
        <td align="center"> 
          <a href="#!" onclick="eliminar_venta('<?php echo $valor['cod_venta'] ?>')" class="btn-floating"><i class="material-icons">delete</i></a>
          <a href="#" class="btn-floating" onclick="ver_ped('<?php echo $valor['cod_venta'] ?>','<?php echo $valor['cod_cliente'] ?>','<?php echo $valor['ci_cliente'] ?>','<?php echo $valor['nombre_cliente'] ?>', '<?php echo $valor['apellidos'] ?>');"><i class="material-icons">search</i></a>
        </td>
     </tr>
     <?php } ?>	
  </tbody>
</table> 
</div>
</div>

<!-- Modal Ver Venta -->
<div id="modal2" class="modal">
  <input type="text" id="cod_ven" hidden>
  <div class="modal-content">
    <h4 class="center roboto">Detalle de venta</h4>
    <p id="__ci" class="rubik"></p>
    <p id="__cli" class="rubik"></p>
    <!-- <h5><p id="__telf"></p></h5> -->
    
    <table id="tab_det" class="rubik">
      <tr>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio</th>
      </tr>
      <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
      </tr>
    </table><br>  
    <div class="container rubik"><b><span id="total_ped" class="right"></span></b></div>
  </div>

  <div class="modal-footer">
    <a href="#!" class="left waves-effect waves-light btn-large orange" onclick="crear_html()">Ver factura</a>
    <a href="#!" class="right modal-action modal-close waves-effect waves-light btn-large">Aceptar</a>
  </div>
</div>

<!-- MODAL eliminar pedido -->
<div id="modal_elim" class="modal">

  <div class="modal-content">
    <h4 class="roboto">Se eliminaran los datos de la venta seleccionada.</h4>
    <p class="rubik">Se anulará la factura y se dará de baja la venta.</p>
    <input type="text" id="id_ped" hidden>

  </div>

  <div class="modal-footer">
    <a href="#!" class="left modal-action modal-close waves-effect waves-light btn red">Cancelar</a>
    <button class="waves-effect waves-light btn right" id="elimped">Confirmar</button>
  </div>
</div>

<!-- Modal Ver Venta -->
<div id="modal3" class="modal _modal3" >

  <div class="modal-content">
    <!-- <h4 class="center"><b>Factura de venta</b></h4> -->
    <div id="myhtml"></div>

  </div>

  <div class="modal-footer">
    <a href="#!" class="right modal-action modal-close waves-effect waves-light btn-large">cerrar</a>
  </div>
</div>


<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
      "order": [[ 0, "desc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_ ",
        "zeroRecords": "Lo siento, no se encontraron datos",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay datos disponibles",
        "infoFiltered": "(filtrado de _MAX_ resultados)",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });
    $('.modal').modal();
    document.getElementById('div_regresar').hidden = true;
});
$( "#nv_venta" ).click(function() {
  document.getElementById('div_regresar').hidden = false;
  $("#cuerpo").load("templates/ventas/nueva_venta.php");
});


function eliminar_venta(id) {
  $("#id_ped").val(id);
  $("#modal_elim").modal('open');
}
document.getElementById('elimped').addEventListener('click', function (e) {
  let id = document.getElementById('id_ped').value;
  fetch("recursos/ventas/eliminar_venta.php?id="+id)
  .then(response => response.text())
  .then(data => {
    console.log(data)
    if (data == '1') {
      M.toast({html: 'La venta y su detalle han sido eliminados.'})
      $("#modal_elim").modal('close')
      $("#cuerpo").load("templates/ventas/ventas.php");
    }
  })

})

function ver_ped(cod, idcli, cicli, nombrecli, apcli) {

  document.getElementById('cod_ven').value = cod;
  $("#__ci").html("<b>Cédula: </b>"+cicli);
  $("#__cli").html("<b>Cliente: </b>"+nombrecli+" "+apcli);


  
  $('#tab_det tr:not(:first-child)').slice(0).remove();
  var table = $("#tab_det")[0];

  total =  0;
  //llenando tabla
  fetch("recursos/ventas/get_detalle.php?cod_venta="+cod)
  .then(response => response.json())
  .then(data => {
    // console.log(data);
    data.forEach(element => {
      var row = table.insertRow(-1);
      row.insertCell(0).innerHTML = element.nombre_producto;
      row.insertCell(1).innerHTML = element.cant_producto;
      row.insertCell(2).innerHTML = element.precio_det_venta;
      
      total  = parseInt(total) + (parseInt(element.precio_det_venta)*(parseInt(element.cant_producto)));
    });
    $("#total_ped").html("Total: "+total +" Bs.");
    $("#modal2").modal('open');
  })



  
}


function crear_html() {
// nit, numfac, aut, fecha, hora, ci, nombres, filas, total, monto, codctrl, fecha_lim, usuario, qrcod 
let cod = $("#cod_ven").val();
let nit = '<?php echo $res[0][7]?>'
let aut = '<?php echo $res[0][1]?>'
let llave = '<?php echo $res[0][4]?>'
let fecha_lim = '<?php echo $res[0][3]?>'
var usuario = "<?php echo $_SESSION['Nombre']; echo ' '.$_SESSION['Apellidos']; ?>"

// return console.log(cod, nit, aut, llave, fecha_lim, usuario);

let numfac; let ci; let nombres; let fecha; let hora; let total; let codctrl; let qrcod; let monto; var miHtml; let filas;

  fetch("recursos/ventas/get_fac_data.php?cod="+cod)
  .then(response => response.text())
  .then(data => {
// console.log(response)
    // return console.log(data);
      data = JSON.parse(data)
      // console.log(response[0])
      numfac = data[0];
      qrcod = numfac+".png";
      ci = data[1];
      nombres = data[2];
      fecha = data[3];
      total = data[5];
      hora = data[4];
      filas = data[6];
      //NUMEROS A LETRAS
      monto = numeroALetras(total, {
        plural: 'BS.',
        singular: 'BS.',
        centPlural: 'CTVS.',
        centSingular: 'CTVS.'
      });
      $.ajax({
        url: "recursos/ventas/get_control_code.php?aut="+aut+"&numfac="+numfac+"&nit="+ci+"&fecha="+fecha+"&total="+total+"&llave="+llave,
        method: "GET",
        success: function(response) {
          console.log(response)
          codctrl = response;

          miHtml = `
          <!DOCTYPE html>
          <html lang="en">

            <head>
              <meta charset="UTF-8" />
              <title>Document</title>
              
            </head>
            <style>
              body{
                font-family: 'Consolas';
              }
            </style>
            <body>
            
              <center>Reposteria "KRUS-MARY"</center>
              <center>Calle Independencia esq. Cochabamba. #395</center>
              <center>Telf.: 7189635-67673738 </center>
              <center>VILLAZON - BOLIVIA</center>
              <center>FACTURA</center>
              <center>----------------------------------------</center>
              <span style="float: left">NIT: ${nit}</span><span style="float: right">Factura N° ${numfac}</span><br>
              
              N° Autorización: ${aut}
              <center>----------------------------------------</center>
              
              <span>CI/NIT: ${ci}</span><span style="float: right"> Fecha: ${(fecha.split("-").reverse().join("-"))}</span><br>
              <span>Señor/a: ${nombres}</span><span style="float: right">Hora: ${hora}</span><br>
              <table style="font-size: 14px;">
                <tr>
                  <th width="70%" align="left">Artículo</th>
                  <th width="15%">Cantidad</th>
                  <th width="15%">Importe</th>
                </tr>
                `+filas+`
                
              </table><br>
              <span style="float: right">Total Bs. ${total}</span><br>
              <!-- <span style="float: right">Pagado:</span><br>
              <span style="float: right">Cambio:</span><br> -->
              Son: ${monto}
              <center>----------------------------------------</center>
              Código de Control: ${codctrl}<br>
              Fecha Límite de emisión: ${(fecha_lim.split("-").reverse().join("-"))}<br>
              Usuario: ${usuario}
              <div> <center><img src="images/qrcodes/${qrcod}" alt="" height="120px" /></center></div>
              <center><p>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ESTA SERÁ SANCIONADO DE ACUERDO A LEY</p></center>
              <center>*****************************************</center>
              <center><p>Ley Nro. 453: Los servicios deben suministrarse en condiciones de inocuidad, calidad y seguridad.</p></center>
            </body>
          </html> `;
          // var ventana = window.open("about:blank","_blank");
          // ventana.document.write(miHtml);
          // $(ventana.document).ready(function (){
          //   ventana.print();
          //   ventana.close();
          //   return true;
          // });
          $("#myhtml").html(miHtml)
          $("#modal3").modal({endingTop: '5%'})
          $("#modal3").modal('open')
        }
      })
  })


}

</script>