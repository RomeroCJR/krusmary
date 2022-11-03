<?php
require('../../recursos/conexion.php');
session_start();
$Sql = "SELECT a.cod_pedido, a.cod_cliente, b.ci_cliente as cedula, a.total_pedido, a.fecha_pedido, a.dedicatoria, a.excepciones, a.foto_personalizada, a.estado_pedido, b.nombre_cliente, CONCAT(b.ap_paterno_cliente,' ',b.ap_materno_cliente) AS apellidos,b.nro_celular_cliente, a.dedicatoria, a.foto_personalizada, b.estado_cliente FROM pedido a, cliente b WHERE a.cod_cliente = b.cod_cliente ;";
$Busq = $conexion->query($Sql);
$fila = $Busq->fetch_all(MYSQLI_ASSOC);
// while($arr = $Busq->fetch_array())
// {
// $fila[] = array('cod'=>$arr['Codped'], 'cliente'=>$arr['idcli'], 'cedula'=>$arr['cedula'],'total'=>$arr['Total'], 'fecha'=>$arr['Fecha'], 'lat'=>$arr['Lat'], 'lng'=>$arr['Lng'],'estado'=>$arr['Estado'], 'nombre'=>$arr['Nombre'], 'apellidos'=>$arr['Apellidos'], 'direccion'=>$arr['Direccion'],'telf'=>$arr['Telefono']);
// }
$Sql2 = "SELECT a.cod_pedido, a.cod_producto, a.cant_producto, a.precio_det_pedido, b.nombre_producto FROM detalle_pedido a, producto b WHERE a.cod_producto = b.cod_producto;";
$Busq2 = $conexion->query($Sql2);
$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);
// while($arr2 = $Busq2->fetch_array())
// {
// $fila2[] = array('cod'=>$arr2['Codped'], 'codpla'=>$arr2['Codpla'], 'cant'=>$arr2['Cant'], 'precio'=>$arr2['Precio'], 'nombre'=>$arr2['Nombre']);
// }
$Sql3 = "SELECT * FROM talonario WHERE estado_talonario = 1";
$Busq3 = $conexion->query($Sql3);
$fila3 = $Busq3->fetch_all(MYSQLI_ASSOC);
// echo $fila3[0]['autorizacion'];
// while($arr3 = $Busq3->fetch_array())
// {
// $fila3[] = array('aut'=>$arr3['Autorizacion'], 'llave'=>$arr3['Llave_dosif'], 'nit'=>$arr3['Nit'], 'fecha_lim'=>$arr3['Fecha_emision']);
// }
?>

<style>
  .btn-bloquear_cliente{
    position: absolute;
    top: 15%;
    right: 5%;
  }
</style>
<div class="rubik">

<span class="roboto"><h3>Pedidos
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
        <tr >
          
          <td align="center"><?php echo $valor["cod_pedido"]?></td>

          <td align="center"><?php echo date('d-m-Y H:m:s', strtotime($valor['fecha_pedido'])) ?></td>
          <td align="center"><?php echo $valor["total_pedido"] ?></td>
          <td align="center">
            <?php if ($valor["estado_pedido"] == 1) { ?><span style="color:#aa9900"><b>Pendiente</b></span><?php }else{if ($valor["estado_pedido"] == 2) { ?><span style="color:red"></b>Rechazado</b></span><?php }else{ ?> <span style="color:green"><b>Aceptado</b></span> <?php }} ?>
          </td>
          <td class="center">
            <!-- <a onclick="" class="btn-floating modal-trigger"><i class="material-icons">build</i></a> -->
            <a href="#!" onclick="eliminar_pedido('<?php echo $valor['cod_pedido']?>')" class="btn-floating"><i class="material-icons">delete</i></a>
            <a onclick="vped('<?php echo $valor["cod_pedido"]?>', '<?php echo $valor["cod_cliente"]?>', '<?php echo $valor["cedula"]?>','<?php echo $valor["nombre_cliente"]?>', '<?php echo $valor["apellidos"]?>','<?php echo $valor["nro_celular_cliente"]?>','<?php echo $valor["estado_pedido"]?>',`<?php echo $valor["dedicatoria"]?>`,`<?php echo $valor["excepciones"]?>`,'<?php echo $valor["foto_personalizada"]?>', '<?php echo $valor["estado_cliente"]?>');"  class="btn-floating"><i class="material-icons">search</i></a>
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
<div id="modal2" class="modal modal-fixed-footer" style="width:70%">
    <div style="position:absolute; top:1px;right:1px;">
      <a href="#!" class=" modal-action modal-close waves-effect btn-floating waves-light red" ><i class="material-icons">close</i></a>
    </div>
  <div class="modal-content">
    <h4 class="center"><b>Detalle de pedido</b></h4>
    <input type="text" id="__idcli" hidden>
    <input type="text" id="__status" hidden>
    <p class="marginless" id="__telf"></p>
    <p class="marginless" id="__ci"></p>
    <p class="marginless" id="__cli"></p>
    <p class="marginless" id="__dir"></p>
    
    <div class="btn-bloquear_cliente">
      <a id="bloquear_cliente" class="btn-large waves-effect red waves-light">BLOQUEAR CLIENTE</a>
    </div>
    <br>
    <hr>
    <div class="row">
      <!-- <h5>Extras:</h5> -->
      <div class="col s4">
        <h6><b>Foto personalizada:</b></h6>
        <div class="center">
          <div id="foto_detalle1"><center><img id="foto_personalizada" width="50%" src="" alt=""></center></div>
          <div id="foto_detalle2"><center><span class="red-text">Sin foto...</span></center></div>
        </div>
      </div>
      <div class="col s4">
        <h6><b>Dedicatoria:</b></h6>
        <span class="dedicatoria" id="dedicatoria"></span>
      </div>
      <div class="col s4">
        <h6><b>Instrucciones especiales:</b></h6>
        <span class="excepciones" id="excepciones"></span>
      </div>
    </div>
    <hr>
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
 
  </div>



  <form id="codiped">
    <input type="text" id="__codiped" name="__codiped" value="" hidden>
  </form>
  <div class="modal-footer">
      <!-- <div class="col s3">
        <a href="#!" class="left modal-action modal-close waves-effect waves-light btn red">Cerrar</a>
      </div> -->

        <button class="waves-effect orange waves-light btn left" id="rechazar_ped">Rechazar Pedido</button>


        <button  class="waves-effect waves-light btn right" type="submit" form="codiped">Aceptar Pedido</button>

  </div>
</div>

<div id="modal_confirmar_bloqueo" class="modal">

  <div class="modal-content">
    <h5>Se procederá a bloquear al cliente del servicio:</h5>
    <p>El cliente no podrá realizar pedidos mediante la página web.</p>

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


document.getElementById('rechazar_ped').addEventListener('click', ()=> {

  let status = $("#__status").val()
  if (status == '0') {
    return M.toast({html: "Este pedido ya ha sido aceptado previamente."})
  }
  if (status == '2') {
    return M.toast({html: "Este pedido ya ha sido rechazado previamente."})
  }
  let id = $("#__codiped").val()
  fetch("recursos/pedidos/rechazar_ped.php?id="+id)
  .then(response => response.text())
  .then(data => {
    console.log(data)
    if (data == '1') {
      M.toast({html: 'Pedido cancelado.'})
      $("#modal2").modal('close')
      $("#cuerpo").load("templates/pedidos/pedidos.php");
    }
  })
  
})



function eliminar_pedido(id) {
  $("#id_ped").val(id);
  $("#modal_elimped").modal('open');
}

document.getElementById('elimped').addEventListener('click', () => {

  let id = $("#id_ped").val();
  fetch("recursos/pedidos/eliminar_pedido.php?id="+id)
  .then(response => response.text())
  .then(data => {
    console.log(data)
    if (data == '1') {
      M.toast({html: 'El pedido y sus detalles han sido eliminados.'})
      $("#modal_elimped").modal('close')
      $("#cuerpo").load("templates/pedidos/pedidos.php");
    }
  })

})


document.getElementById('bloquear_cliente').addEventListener('click', ()=> {

  let idcli = $("#__idcli").val();
  let codped = $("#__codiped").val();
  // return console.log(idcli, codped);

  fetch("recursos/pedidos/bloquear_cliente.php?idcli="+idcli+"&codped="+codped)
  .then(response => response.text())
  .then(data => {
    if (data.includes('Desbloquear')) {
      M.toast({html: 'Cliente bloqueado del servicio.'})
      let element = document.getElementById('bloquear_cliente');
      element.innerHTML = 'Desbloquear cliente';
      element.classList.remove('red');
      element.classList.add('green');
      // $("#modal_confirmar_bloqueo").modal('close')
      // $("#cuerpo").load("templates/pedidos/pedidos.php");
    }else{
      M.toast({html: 'Cliente desbloqueado del servicio.'})
      let element = document.getElementById('bloquear_cliente');
      element.innerHTML = 'Bloquear cliente';
      element.classList.remove('green');
      element.classList.add('red');
    }
  })

})

function vped(cod, cliente, cedula, nombre, apellidos, telf, estado, dedicatoria, excepciones,foto, estado_cliente) {
  // return console.log(excepciones);
  if(foto.length !== 0){
    document.getElementById('foto_personalizada').src = foto;
    document.getElementById('foto_detalle1').hidden = false;
    document.getElementById('foto_detalle2').hidden = true;
  }else{
    document.getElementById('foto_detalle1').hidden = true;
    document.getElementById('foto_detalle2').hidden = false;
  }
  if(dedicatoria.length === 0){
    document.getElementById('dedicatoria').innerHTML = `<center><span class="red-text">Sin dedicatoria...</span></center>`;
  }else{
    document.getElementById('dedicatoria').innerHTML = `<span>${dedicatoria}</span>`;
  }
  if(excepciones.length === 0){
    document.getElementById('excepciones').innerHTML = `<center><span class="red-text">Sin instrucciones...</span></center>`;
  }else{
    document.getElementById('excepciones').innerHTML = `<span>${excepciones}</span>`;
  }

  let element = document.getElementById('bloquear_cliente');
  if(estado_cliente == '1'){
    element.classList.remove('green');
    element.classList.add('red');
    element.innerHTML = 'Bloquear cliente';
  }else{
    element.classList.remove('red');
    element.classList.add('green');
    element.innerHTML = 'Desloquear cliente';
  }

  $("#__idcli").val(cliente);
  $("#__status").val(estado)
  $("#block_ci").html('<b>Cédula de identidad:</b> '+cedula)
  $("#block_name").html('<b>Nombre y apellidos:</b> '+nombre+' '+apellidos)
  $("#block_telf").html('<b>Teléfono:</b> '+telf)

  $("#__ci").html("<b>Cédula: </b>"+cedula);
  $("#__telf").html("<b>Teléfono: </b>"+telf);
  $("#__cli").html("<b>Nombres: </b>"+nombre+" "+apellidos);

  $("#__codiped").val(cod);

  //PARA EL MAPA


  $('#tab_det tbody tr').empty();
  var table = $("#tab_det")[0];
  total =  0;
  fetch(`recursos/pedidos/get_detalle_pedido.php?cod=${cod}`)
  .then(response => response.json())
  .then(data => {
    // data = JSON.parse(data)
    // return console.log(data);
    data.forEach(element => {

      var row = table.insertRow(-1);
      row.insertCell(0).innerHTML = element.nombre_producto;
      row.insertCell(1).innerHTML = element.cant_producto;
      row.insertCell(2).innerHTML = element.precio_det_pedido;
      
      total  = parseInt(total) + (parseFloat(element.precio_det_pedido)*(parseInt(element.cant_producto)));

    });
    $("#total_ped").html("Total: "+total +" Bs.");
    $("#modal2").modal('open');
  })



  //llenando tabla
  // "< foreach($fila2 as $a  => $valor){ ?>";
  // if(cod == "< echo $valor['cod'] ?>"){
  // var row = table.insertRow(-1);
  // row.insertCell(0).innerHTML = "< echo $valor['nombre'] ?>";
  // row.insertCell(1).innerHTML = "< echo $valor['cant'] ?>";
  // row.insertCell(2).innerHTML = "< echo $valor['precio'] ?>";
  

  // total  = parseInt(total) + (parseInt("< echo $valor['precio'] ?>")*(parseInt("< echo $valor['cant'] ?>")));
  // }
  // "< } ?>";
  
}


$("#codiped").on("submit", function(e){
  e.preventDefault();

  let codip = $("#__codiped").val();
  var formData = new FormData();
  formData.append('__codiped', codip)
// return imprimirElemento($("#__codiped").val());

  fetch("recursos/pedidos/agregar_pedven.php",{method: 'post', body: formData})
  .then(response => response.text())
  .then(data => {
    console.log(data)
    if (data == "aceptado") {
      // console.log(echo)
      $("#modal2").modal('close');
      M.toast({html: 'Pedido aceptado.'});
      $("#cuerpo").load("templates/pedidos/pedidos.php");
      imprimirElemento($("#__codiped").val());
    }
    if (data == 'rechazado') {
      M.toast({html: "Este pedido fué rechazado previamente."});
    }
    if(data == "already"){
      M.toast({html:'Este pedido ya ha sido aceptado previamente.'});
    }
  })
  

});



function imprimirElemento(cod){

    fetch('recursos/pedidos/datos_pedido.php?cod='+cod)
    .then(response => response.json())
    .then(data => {

      var date = new Date(data[0].fecha_pedido);
      // var fecha = date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate();
      // var hora = date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();

      var fecha = ("0"+date.getDate()).slice(-2)+"-"+("0"+(date.getMonth()+1)).slice(-2)+"-"+date.getFullYear() //2 DIGITOS
      var hora = ("0"+(date.getHours())).slice(-2)+":"+("0"+(date.getMinutes())).slice(-2)+":"+("0"+(date.getSeconds())).slice(-2)


      var ci = data[0].cedula;
      var nombres = data[0].nombre_cliente+' '+data[0].apellidos;
      var usuario = "<?php echo $_SESSION['Nombre'].' '.$_SESSION['Apellidos']; ?>";
      var total = data[0].total_pedido;
      

  // NUMEROS A LETRAS
  var monto = numeroALetras(total, {
  plural: 'BS.',
  singular: 'BS.',
  centPlural: 'CTVS.',
  centSingular: 'CTVS.'
  });
  // "< foreach($fila3 as $a  => $valor){ ?>"
  var aut = "<?php echo $fila3[0]['autorizacion']; ?>"
  var llave = "<?php echo $fila3[0]['llave_dosificacion']; ?>"
  var nit = "<?php echo $fila3[0]['nit']; ?>"
  var fecha_lim = "<?php echo $fila3[0]['fecha_emision']; ?>"



  // "< } ?>"
  var celdas = "";
  var filas = "";
  "<?php foreach($fila2 as $a  => $valor){ ?>"
  if( cod == "<?php echo $valor['cod_pedido']; ?>" ){
  celdas = `
  <tr>
    <td><?php echo $valor['nombre_producto'] ?></td>
    <td style="text-align:center"><?php echo $valor['cant_producto'] ?></td>
    <td style="text-align:center"><?php echo $valor['precio_det_pedido'] ?></td>
  </tr>
  `
  filas = filas + celdas;
  }
  "<?php } ?>"

  //ENVIO CON AJAX --

  var formData = new FormData()
  // var data = {autx: aut, llavex: llave, nitx: nit, cix: ci, fechax: (fecha.split("-").reverse().join("-")), montox: total, codped: cod, horax: hora}
  formData.append('autx', aut);
  formData.append('llavex', llave);
  formData.append('nitx', nit);
  formData.append('cix', ci);
  formData.append('fechax', (fecha.split("-").reverse().join("-")));
  formData.append('montox', total);
  formData.append('codped', cod);
  formData.append('horax', hora);
  fetch("recursos/pedidos/datos_fac.php", {method:'post', body: formData})
  .then(response => response.text())
  .then(data => {
    // return console.log(data);
    crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, data, fecha_lim, usuario);
  })
  //FIN ENVIO AJAX
  })
}

// let qrcod = "";
function crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, cod_control, fecha_lim, usuario) {

 var cad = cod_control.split(",");

  let cntdo = nit+"|"+cad[1]+"|"+aut+"|"+fecha+"|"+total+"|"+cad[0]+"|"+ci+"|"+"0"
  var data = {numfac: cad[1], contenido: cntdo }
  // console.log(data)
  var formData = new FormData()
  formData.append('numfac', cad[1]);
  formData.append('contenido', cntdo);
  fetch("recursos/pedidos/obtener_codigo.php", {method:'post', body: formData})
  .then(response => response.text())
  .then(data => {
    crear_html(nit, cad[1], aut, fecha, hora, ci, nombres, filas, total, monto, cad[0], fecha_lim, usuario, data );
  })


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
  
    <center>Repostería KRUS-MARY</center>
    <center>Calle Independencia esq. Cochabamba. #395</center>
    <center>Telf.: 7189635-67673738 </center>
    <center>VILLAZON - BOLIVIA</center>
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

      // pdf.save("fac_"+numfac+'.pdf');
  }, margins
);


return true;
});
}


</script>
