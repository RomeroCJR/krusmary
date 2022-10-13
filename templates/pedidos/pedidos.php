<?php
require('../../recursos/conexion.php');
session_start();
$Sql = "SELECT a.Codped, a.idcli, b.Ci as cedula, a.Total, a.Fecha, a.Lat, a.Lng, a.Estado, b.Nombre, b.Apellidos, a.Direccion,b.Telefono FROM pedido a, cliente b WHERE a.idcli = b.id;";
$Busq = $conexion->query($Sql);
while($arr = $Busq->fetch_array())
{
$fila[] = array('cod'=>$arr['Codped'], 'cliente'=>$arr['idcli'], 'cedula'=>$arr['cedula'],'total'=>$arr['Total'], 'fecha'=>$arr['Fecha'], 'lat'=>$arr['Lat'], 'lng'=>$arr['Lng'],'estado'=>$arr['Estado'], 'nombre'=>$arr['Nombre'], 'apellidos'=>$arr['Apellidos'], 'direccion'=>$arr['Direccion'],'telf'=>$arr['Telefono']);
}
$Sql2 = "SELECT a.Codped, a.Codpla, a.Cant, a.Precio, b.Nombre FROM det_ped a, plato b WHERE a.Codpla = b.Codpla;";
$Busq2 = $conexion->query($Sql2);
while($arr2 = $Busq2->fetch_array())
{
$fila2[] = array('cod'=>$arr2['Codped'], 'codpla'=>$arr2['Codpla'], 'cant'=>$arr2['Cant'], 'precio'=>$arr2['Precio'], 'nombre'=>$arr2['Nombre']);
}
$Sql3 = "SELECT * FROM talonario WHERE Estado = 1";
$Busq3 = $conexion->query($Sql3);
while($arr3 = $Busq3->fetch_array())
{
$fila3[] = array('aut'=>$arr3['Autorizacion'], 'llave'=>$arr3['Llave_dosif'], 'nit'=>$arr3['Nit'], 'fecha_lim'=>$arr3['Fecha_emision']);
}
?>

<style>
  .btn-bloquear_cliente{
    position: absolute;
    top: 15%;
    right: 5%;
  }
</style>
<div class="Rubik">

<span><h3>Pedidos
  <!-- Modal Trigger -->
  <!-- <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a> --></h3>
</span>
<div class="row">
  <div class="col s12 m12">
    <table id="tabla1" class="content-table">
      <thead>
        <tr>
          <th>Código</th>
          <!-- <th>Cliente</th> -->
          <th>Fecha</th>
          <th>Total Bs.</th>
          <th>Estado</th>
          <th class="center">Acciones</th>
          <!--        <th>Borrar</th>
          <th>Ver Usuario</th> -->
        </tr>
      </thead>
      <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
        <tr <?php if(($valor['estado'])==1) echo 'style="background-color: #ffeaa7"'; ?> <?php if(($valor['estado'])==0) echo 'style="background-color: #fff"'; ?>>
          
          <td align="center"><?php echo $valor["cod"]?></td>

          <td align="center"><?php echo date('d-m-Y H:m:s', strtotime($valor['fecha'])) ?></td>
          <td align="center"><?php echo $valor["total"] ?></td>
          <td align="center">
            <?php if ($valor["estado"] == 1) { ?> Pendiente <?php }else{if ($valor["estado"] == 2) { ?> Rechazado <?php }else{ ?> Enviado <?php }} ?>
          </td>
          <td class="center">
            <!-- <a onclick="" class="btn-floating modal-trigger"><i class="material-icons">build</i></a> -->
            <a href="#!" onclick="eliminar_pedido('<?php echo $valor['cod']?>')" class="btn-floating"><i class="material-icons">delete</i></a>
            <a onclick="vped('<?php echo $valor["cod"]?>', '<?php echo $valor["cliente"]?>', '<?php echo $valor["cedula"]?>', '<?php echo $valor["lat"]?>', '<?php echo $valor["lng"]?>','<?php echo $valor["nombre"]?>', '<?php echo $valor["apellidos"]?>', '<?php echo $valor["direccion"]?>','<?php echo $valor["telf"]?>','<?php echo $valor["estado"]?>');"  class="btn-floating"><i class="material-icons">search</i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL eliminar pedido -->
<div id="modal_elimped" class="modal">

  <div class="modal-content">
    <h4 class="roboto">Se eliminaran los datos del pedido seleccionado.</h4>
    <p class="rubik">Se anulará la factura y se dará de baja la venta en caso de haber sido realizada.</p>
    <input type="text" id="id_ped" hidden>

  </div>

  <div class="modal-footer">
    <a href="#!" class="left modal-action modal-close waves-effect waves-light btn red">Cancelar</a>
    <button class="waves-effect waves-light btn right" id="elimped">Confirmar</button>
  </div>
</div>


<!-- Modal Ver Pedidos -->
<div id="modal2" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4 class="center"><b>Detalle de pedido</b></h4>
    <input type="text" id="__idcli" hidden>
    <input type="text" id="__status" hidden>
    <p class="marginless" id="__telf"></p>
    <p class="marginless" id="__ci"></p>
    <p class="marginless" id="__cli"></p>
    <p class="marginless" id="__dir"></p>
    
    <div class="btn-bloquear_cliente">
      <a href="#modal_confirmar_bloqueo" id="bloquear_cliente" class="btn-large waves-effect red waves-light modal-trigger">BLOQUEAR CLIENTE</a>
    </div>

    <h5 class="">Detalle del pedido:</h5>
    <table id="tab_det" class="content-table" >
      <thead>
          <tr>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Precio</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>2</td>
          <td>3</td>
        </tr>
      </tbody>
    </table>
    <div class="container">
      <div class="row">
        <b><p id="total_ped" class="right"></p></b>
      </div>
    </div>
 
          <h5>Ubicación</h5>
          <div id="map"></div>
          <input type="text" id="__lat" value="-21.5201" hidden>
          <input type="text" id="__lng" value="-64.7522" hidden>

  </div>



  <form id="codiped">
    <input type="text" id="__codiped" name="__codiped" value="" hidden>
  </form>
  <div class="modal-footer row" style="padding: 1rem !important">
      <div class="col s3">
      <a href="#!" class="left modal-action modal-close waves-effect waves-light btn red">Cerrar</a>
      </div>
      <div class="col s3 offset-s3">
      <button class="waves-effect orange waves-light btn right" id="rechazar_ped">Rechazar Pedido</button>
      </div>
      <div class="col s3">
      <button  class="waves-effect waves-light btn right" type="submit" form="codiped">Aceptar Pedido</button>
      </div>
  </div>
</div>

<div id="modal_confirmar_bloqueo" class="modal">

  <div class="modal-content">
    <h5>Se procederá a bloquear al cliente del servicio:</h5>
    <p>El cliente no podrá realizar pedidos mediante la aplicación web.</p>

    <p id="block_ci"></p>
    <p id="block_name"></p>
    <p id="block_telf"></p>
  </div>

  <div class="modal-footer">
    <a href="#!" class="left modal-action modal-close waves-effect waves-light btn red">Cancelar</a>
    <button class="waves-effect waves-light btn right" onclick="confirmar_bloqueo()">Confirmar</button>
  </div>
</div>

</div>
<!-- Mensaje -->
<div id="mensaje"></div>

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

});

var mensaje = $("#mensaje");
mensaje.hide();


function initMap() {
  const myLatLng = { lat: parseFloat($("#__lat").val()), lng: parseFloat($("#__lng").val())};
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 17,
    center: myLatLng,
  });

  new google.maps.Marker({
    position: myLatLng,
    map,
    // title: "Hello World!",
  });
}
  
$("#rechazar_ped").click(function () {
  let status = $("#__status").val()
  if (status == '0') {
    return M.toast({html: "Este pedido ya ha sido aceptado previamente."})
  }
  if (status == '2') {
    return M.toast({html: "Este pedido ya ha sido rechazado previamente."})
  }

  let id = $("#__codiped").val()
  $.ajax({
    url: "recursos/pedidos/rechazar_ped.php?id="+id,
    method: "get",
    success: function(response){
      console.log(response)
      if (response == '1') {
        M.toast({html: 'Pedido cancelado.'})
        $("#modal2").modal('close')
        $("#cuerpo").load("templates/pedidos/pedidos.php");
      }
    },
    error: function(error, data, response){
      console.log(error)
    }
  });

})



function eliminar_pedido(id) {
  $("#id_ped").val(id);
  $("#modal_elimped").modal('open');
}

$("#elimped").click(function (argument) {
  let id = $("#id_ped").val();
  $.ajax({
    url: "recursos/pedidos/eliminar_pedido.php?id="+id,
    method: "get",
    success: function(response){
      console.log(response)
      if (response == '1') {
        M.toast({html: 'El pedido y sus detalles han sido eliminados.'})
        $("#modal_elimped").modal('close')
        $("#cuerpo").load("templates/pedidos/pedidos.php");
      }
    },
    error: function(error, data, response){
      console.log(error)
    }
  });
})



function confirmar_bloqueo() {
  let idcli = $("#__idcli").val();
  let codped = $("#__codiped").val();

  $.ajax({
    url: "recursos/pedidos/bloquear_cliente.php?idcli="+idcli+"&codped="+codped,
    method: "get",
    success: function(response){
      console.log(response)
      if (response == '1') {
        M.toast({html: 'Cliente bloqueado del servicio.'})
        $("#modal_confirmar_bloqueo").modal('close')
        $("#cuerpo").load("templates/pedidos/pedidos.php");
      }
    },
    error: function(error, data, response){
      console.log(error)
    }
  });

}

function vped(cod, cliente, cedula, lat, lng, nombre, apellidos, direccion, telf, estado) {
  $("#__idcli").val(cliente);
  $("#__status").val(estado)
  $("#block_ci").html('<b>Cédula de identidad:</b> '+cedula)
  $("#block_name").html('<b>Nombre y apellidos:</b> '+nombre+' '+apellidos)
  $("#block_telf").html('<b>Teléfono:</b> '+telf)

  $("#__ci").html("<b>Cédula: </b>"+cedula);
  $("#__telf").html("<b>Teléfono: </b>"+telf);
  $("#__cli").html("<b>Nombres: </b>"+nombre+" "+apellidos);
  $("#__dir").html("<b>Dirección: </b>"+direccion);
  $("#__codiped").val(cod);

  //PARA EL MAPA
  $("#__lat").val(lat)
  $("#__lng").val(lng)

  initMap();

  $('#tab_det tbody tr').empty();
  var table = $("#tab_det")[0];
  total =  0;
  //llenando tabla
  "<?php foreach($fila2 as $a  => $valor){ ?>";
  if(cod == "<?php echo $valor['cod'] ?>"){
  var row = table.insertRow(-1);
  row.insertCell(0).innerHTML = "<?php echo $valor['nombre'] ?>";
  row.insertCell(1).innerHTML = "<?php echo $valor['cant'] ?>";
  row.insertCell(2).innerHTML = "<?php echo $valor['precio'] ?>";
  

  total  = parseInt(total) + (parseInt("<?php echo $valor['precio'] ?>")*(parseInt("<?php echo $valor['cant'] ?>")));
  }
  "<?php } ?>";
  $("#total_ped").html("Total: "+total +" Bs.");
  $("#modal2").modal('open');
}


$("#codiped").on("submit", function(e){
  e.preventDefault();

  let codip = $("#__codiped").val();
  var data = {__codiped: codip}

  $.ajax({
  url: "recursos/pedidos/agregar_pedven.php",
  method: "post",
  data: data
  }).done(function(echo){
    console.log(echo)
    if (echo == "aceptado") {
      // console.log(echo)
      $("#modal2").modal('close');
      M.toast({html: 'Pedido aceptado.'});
      $("#cuerpo").load("templates/pedidos/pedidos.php");
      imprimirElemento($("#__codiped").val());
    }
    if (echo == 'rechazado') {
      M.toast({html: "Este pedido fué rechazado previamente."});
    }
    if(echo == "already"){
      M.toast({html:'Este pedido ya ha sido aceptado previamente.'});
    }
  });
});



function imprimirElemento(cod){
  "<?php foreach($fila as $a  => $valor){ ?>"
    if (<?php echo $valor['cod']; ?> == cod) {
    date = new Date("<?php echo $valor['fecha']; ?>")

    // var fecha = date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate();
    // var hora = date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();

    var fecha = ("0"+date.getDate()).slice(-2)+"-"+("0"+(date.getMonth()+1)).slice(-2)+"-"+date.getFullYear() //2 DIGITOS
    var hora = ("0"+(date.getHours())).slice(-2)+":"+("0"+(date.getMinutes())).slice(-2)+":"+("0"+(date.getSeconds())).slice(-2)


    var ci = "<?php echo $valor['cedula']; ?>"
    var nombres ="<?php echo $valor['nombre']; ?>"+" "+"<?php echo $valor['apellidos']; ?>"
    var usuario = "<?php echo $_SESSION['Nombre'] ; echo ' '.$_SESSION['Apellidos']; ?>"
    var total = "<?php echo $valor['total']; ?>"
  }
  "<?php } ?>"
  // NUMEROS A LETRAS
  var monto = numeroALetras(total, {
  plural: 'BS.',
  singular: 'BS.',
  centPlural: 'CTVS.',
  centSingular: 'CTVS.'
  });
  "<?php foreach($fila3 as $a  => $valor){ ?>"
  var aut = "<?php echo $valor['aut']; ?>"
  var llave = "<?php echo $valor['llave']; ?>"
  var nit = "<?php echo $valor['nit']; ?>"
  var fecha_lim = "<?php echo $valor['fecha_lim']; ?>"
  "<?php } ?>"
  var celdas = "";
  var filas = "";
  "<?php foreach($fila2 as $a  => $valor){ ?>"
  if( cod == <?php echo $valor['cod'] ?> ){
  celdas = `
  <tr>
    <td><?php echo $valor['nombre'] ?></td>
    <td style="text-align:center"><?php echo $valor['cant'] ?></td>
    <td style="text-align:center"><?php echo $valor['precio'] ?></td>
  </tr>
  `
  filas = filas + celdas;
  }
  "<?php } ?>"


  //ENVIO CON AJAX --


  var data = {autx: aut, llavex: llave, nitx: nit, cix: ci, fechax: (fecha.split("-").reverse().join("-")), montox: total, codped: cod, horax: hora}
  $.ajax({
    url: "recursos/pedidos/datos_fac.php",
    data: data,
    method: "post",
    success: function(response){
      crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, response, fecha_lim, usuario);
    },
    error: function(error, data, response){
      console.log(error)
    }
  });


  //FIN ENVIO AJAX

}
// let qrcod = "";
function crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, cod_control, fecha_lim, usuario) {

 var cad = cod_control.split(",");

let cntdo = nit+"|"+cad[1]+"|"+aut+"|"+fecha+"|"+total+"|"+cad[0]+"|"+ci+"|"+"0"
var data = {numfac: cad[1], contenido: cntdo }
// console.log(data)

$.ajax({
  url: "recursos/pedidos/obtener_codigo.php",
  data: data,
  method: "post",
  success: function(response){
    crear_html(nit, cad[1], aut, fecha, hora, ci, nombres, filas, total, monto, cad[0], fecha_lim, usuario, response );
  },
  error: function(error){
    console.log(error)
  }
});

}


function crear_html(nit, numfac, aut, fecha, hora, ci, nombres, filas, total, monto, codctrl, fecha_lim, usuario, qrcod  ) {




var miHtml = `
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
  
    <center>Restaurante de comida rápida Delicias Express</center>
    <center>B. La Loma, Calle Cbba. Esq. Nuñez del prado</center>
    <center>Telf.: 76191403 </center>
    <center>TARIJA - BOLIVIA</center>
    <center>FACTURA</center>
    <center>----------------------------------------</center>
    <span style="float: left">NIT: ${nit}</span><span style="float: right">Factura N° ${numfac}</span><br>
    
    N° Autorización: ${aut}
    <center>----------------------------------------</center>
    <span>CI/NIT: ${ci}</span><span style="float: right"> Fecha: ${fecha}</span><br>
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
    <div> <center><img src="${qrcod}" alt="" height="120px" /></center></div>
    <center><p>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ESTA SERÁ SANCIONADO DE ACUERDO A LEY</p></center>
    <center>*****************************************</center>
    <center><p>Ley Nro. 453: Los servicios deben suministrarse en condiciones de inocuidad, calidad y seguridad.</p></center>
  </body>
</html> `;

var pdf = new jsPDF('p', 'pt', 'letter');
specialElementHandlers = {
    // element with id of "bypass" - jQuery style selector
    '#bypassme': function (element, renderer) {
        // true = "handled elsewhere, bypass text extraction"
        return false
    }
};

margins = {
    top: 80,
    bottom: 60,
    left: 40,
    width: 522
};  




var ventana = window.open("about:blank","_blank");
ventana.document.write(miHtml);
// ventana.document.close();
// ventana.focus();
$(ventana.document).ready(function (){
ventana.print();
ventana.close();

pdf.fromHTML(
  miHtml, 
  margins.left, 
  margins.top, { 
      'width': margins.width, 
      'elementHandlers': specialElementHandlers
  },

  function (dispose) {

      pdf.save("fac_"+numfac+'.pdf');
  }, margins
);


return true;
});
}


</script>
