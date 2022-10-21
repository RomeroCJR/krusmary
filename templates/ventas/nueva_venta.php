 <?php
require('../../recursos/conexion.php');
session_start();

$Sql0 = "SELECT a.cod_venta AS cod, a.cod_cliente AS idcli, a.total_venta AS total, b.nombre_cliente AS nombre, CONCAT(b.ap_paterno_cliente,' ',b.ap_materno_cliente) AS apellidos, b.nro_celular_cliente AS telf FROM venta a, cliente b WHERE a.cod_cliente = b.cod_cliente;";
$Busq0 = $conexion->query($Sql0);
$fila0 = $Busq0->fetch_all(MYSQLI_ASSOC);


$Sql = "SELECT a.cod_producto AS cod, a.nombre_producto AS nombre, a.precio_producto AS precio, a.descripcion_producto AS descripcion, a.foto_producto AS foto, b.stock FROM producto a, inventario b WHERE a.cod_producto = b.cod_producto AND a.estado_producto = 1"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);

// $Sqlb = "SELECT a.*, b.Stock FROM plato a, stock b WHERE a.Codpla = b.Codpla AND a.beb = 1 AND a.Estado = 1"; 
// $Busqb = $conexion->query($Sqlb); 
// while($arr = $Busqb->fetch_array()) 
//     { 
//         $filab[] = array('cod'=>$arr['Codpla'], 'nombre'=>$arr['Nombre'], 'precio'=>$arr['Precio'], 'descripcion'=>$arr['Descripcion'], 'foto'=>$arr['Foto'], 'stock'=>$arr['Stock']);
//     }


$Sql2 = "SELECT cod_cliente, ci_cliente AS cicli, nombre_cliente AS nombrecli, CONCAT(ap_paterno_cliente,' ',ap_materno_cliente) AS apcli, nro_celular_cliente AS telfcli FROM cliente WHERE estado_cliente = 1";
$Busq2 = $conexion->query($Sql2);
$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);

$Sql3 = "SELECT autorizacion as aut, llave_dosificacion as llave, nit, fecha_emision as fecha_lim FROM talonario WHERE estado_talonario = 1";
$Busq3 = $conexion->query($Sql3);
$fila3 = $Busq3->fetch_all(MYSQLI_ASSOC);


?>



<style>
  #modal_cant_plato{
    /*width: 15%;*/
    padding-left: 0px;
    padding-right: 0px;
  }
  #regresar{
    margin-left: 0;
  }

  .centrar_boton{
    position: absolute;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  }
  #div_form{
    width: calc(50% - 10px);
    margin-left: 10px;
  }
  #ventas_agregadas{
    margin-top: 0px;
  }
  .ui-autocomplete-row{
    padding:8px;
    background-color: #b2dfdb;
    border-bottom:1px solid #009688;
    font-weight:bold;
    font-family: rubik;
  }
  .ui-autocomplete-row:hover
  {
    background-color: #009688;
    /*font-family: "Segoe UI Light"*/
  }
  .ui-menu{
    font-size: 1rem !important;
    z-index: 9999;
  }
</style>


<!-- <a class="waves-effect waves-teal btn-large orange" id="regresar"><i class="material-icons left">arrow_back</i></a> -->

<div class="row">
  <div class="col s12 center">
    <h4 class="fuente">Detalle de venta</h4>
  </div>

</div>

<div class="row">
  <div id="div_form" class="col s12 m6  z-depth-4">
    <div class="col s12">
      <p>Seleccione el producto:</p>
    </div>
    <div class="col s12">
      <form id="form_agregar_producto">
        <div class="input-field col s12">
          <input type="text" id="cod_producto" name="cod_producto" hidden>
          <input type="text" id="stock_producto" name="stock_producto" hidden>
          <input type="text" id="nombre_producto" name="nombre_producto" class="validate" required>
          <label for="nombre_producto">Producto</label>
        </div>
        <div class="input-field col s12">
          <input type="number" id="precio_producto"  onKeyPress="return checkIt(event)" name="precio_producto" class="validate" required>
          <label for="precio_producto">Precio (Bs.)</label>
        </div>
        <div class="input-field col s12 center number-container">
              <label for="" class="rubik" style="font-weight: lighter">Cantidad</label>
              <input class="browser-default" onKeyPress="return checkIt(event)" autocomplete="off" type="number" name="cantidad_producto" id="__cantidad" min="1" max="50" required>
        </div>
      </form>
    </div>
    <div class="col s12 center" style="padding-bottom: 10px">
      <button form="form_agregar_producto" type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Agregar al detalle</button>
    </div>
  </div>

  <div id="detalle_venta" class="col s12 m6">
    <div >
        <table border="1" class="content-table" id="ventas_agregadas">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Borrar</th>
            </tr>
          </thead>
          <tbody>
            <tr >
              <td colspan = "4">No se ha seleccionado ningún producto...</td>
            </tr>
          </tbody>
        </table>
        <hr>
        <div class="row" align="right">
          <div class="col m4 offset-m6 s3 offset-s7">
            Total: <span id="total_ped">0.00 Bs</span>
            <input type="text" id="subtotal" hidden>
          </div>
        </div>
    </div>

  </div>
</div>
<br><br>
<div class="row">
  <div class="center">
      <button class="waves-effect waves-light btn-large modal-trigger" data-target="modal-cliente"><i class="material-icons right">shopping_cart</i>Registrar</button>
  </div>
</div>
<!-- onclick="reg_venta()" -->

  <!-- Modal Cliente -->
  <div id="modal-cliente" class="modal" style="width:45%">
    <div class="modal-content">
      <div class="container">
        <h4>Registrar venta e imprimir factura:</h4><br>
        <p>
          <span id="reg_total"></span>
        </p>
        <p>
          <label>
            <input type="checkbox" id="datos_cliente"/>
            <span>Registrar datos de cliente</span>
          </label>
        </p>
      </div>

      <!-- <div id="tipo_cliente_radios" class="container" hidden>
        <form action="radio_clientes">
          <label>
            <input class="with-gap" name="rad_client" value="0" type="radio" />
            <span>Persona natural</span>
          </label>
          <label>
            <input class="with-gap" name="rad_client" value="1" type="radio" />
            <span>Persona jurídica</span>
          </label>
        </form>
      </div> -->

      <div id="form_registro_venta_fisica" class="container" hidden>
        <form >
          <div class="row">
            <div class="input-field col s12">
              <input id="reg_cedula" type="text" onKeyPress="return checkIt(event)" minlength="7" maxlength="7" class="validate">
              <label for="reg_cedula">Cédula de identidad (*)</label>
            </div>
            <div class="input-field col s12">
              <input id="reg_nombres" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="20" class="validate">
              <label for="reg_nombres">Nombre (*)</label>
            </div>
            <div class="input-field col s12">
              <input id="reg_apellido_p" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="20" class="validate">
              <label for="reg_apellido_p">Apellidos paterno</label>
            </div>
            <div class="input-field col s12">
              <input id="reg_apellido_m" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="20" class="validate">
              <label for="reg_apellido_m">Apellido materno</label>
            </div>
            <div class="input-field col s12">
              <input id="f_reg_telf" name="f_reg_telf" type="text" onKeyPress="return checkIt(event)" minlength="8" maxlength="8" class="validate">
              <label for="f_reg_telf">Teléfono/Celular</label>
            </div>

            <p><small class="helperx">Los campos de texto marcados con un (*) son obligatorios.</small></p>
          </div>
        </form>
      </div>

      <div id="form_registro_venta_juridica" class="container" hidden>
        <form >
          <div class="row">
            <div class="input-field col s12">
              <input id="j_reg_nit" name="j_reg_nit" type="text" onKeyPress="return checkIt(event)" minlength="9" maxlength="11" onpaste="return false" class="validate" required>
              <label for="j_reg_nit">NIT (*)</label>
            </div>
            <div class="input-field col s12">
              <input id="reg_razon" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="25" class="validate" required>
              <label for="reg_razon">Razón social / nombre comercial (*)</label>
            </div>
<!--             <div class="input-field col s12">
              <input id="reg_apellidos" type="text" class="validate">
              <label for="reg_apellidos">Apellidos (*)</label>
            </div> -->
            <div class="input-field col s12">
              <input id="reg_telf" type="text" onKeyPress="return checkIt(event)" minlength="8" maxlength="8" class="validate">
              <label for="reg_telf">Teléfono/Celular</label>
            </div>

            <p><small class="helperx">Los campos de texto marcados con un (*) son obligatorios.</small></p>
          </div>
        </form>
      </div>

    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light red btn-large left">Cancelar</a>
      <button class="btn-large" onclick="reg_venta()">Confirmar</button>
    </div>
  </div>



<div id="modal_plato" class="modal">
  <a href="#!" class="modal-close close right"><i class="material-icons">close</i></a>
    <div class="modal-content">
      <h4 class="fuente">Agregar plato</h4>
      <div class="col s12">
         <table id="tabla_platos" class="highlight">
          <thead>
             <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Precio</th>
             </tr>          
          </thead>
          <tbody>
             <?php foreach($fila as $a  => $valor){ ?>
             <tr style="cursor: pointer;" onclick="agregar_plato('<?php echo $valor['cod'] ?>', '<?php echo $valor['nombre'] ?>', '<?php echo $valor['precio'] ?>', '<?php echo $valor['stock'] ?>')">
                <td align="center"><img src="<?php echo $valor['foto'] ?>" width="50px" alt=""></td>
                <td align="center"><?php echo $valor["nombre"] ?></td>
                <td align="center"><?php echo $valor["precio"]." Bs." ?> </td>
             </tr>
             <?php } ?> 
          </tbody>
        </table> 
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn waves-effect waves-light modal-close right">Aceptar</button> 
      <button class="btn red waves-effect waves-red modal-close left"><i class="material-icons left">close</i>Cancelar</button>
      
    </div>
</div>


<div class="row">
  <div id="modal_cant_plato" class="modal fuente col s12 m2 offset-m3">
      <a href="#!" class="modal-close close right"><i class="material-icons">close</i></a>
      <div class="modal-content">
        <div>
          <input type="text" id="current_sell" hidden>
          <input type="text" id="current_stock" hidden>
        </div>
        <div class="number-container">
              <label for="">Cantidad</label>
              <input class="browser-default" onKeyPress="return checkIt(event)" autocomplete="off" type="number" id="__cantidad" min="1" max="15">
        </div>

        
      </div><br>
      <div class="modal-footer centrar_boton_div">
        <button class="btn waves-effect waves-light centrar_boton" onclick="agregar_fila_plato();">Aceptar</button> 
        <!-- <button class="btn red waves-effect waves-red modal-close left"><i class="material-icons">close</i></button> -->
      </div>
  </div>
</div>

<!-- Mensaje -->
<div id="mensaje"></div>
<div id="__datosplato" hidden></div>

<script>
 
  $(document).ready(function() {
     $('.modal').modal();
     $('#__cantidad').niceNumber({
      autoSize: true,
      autoSizeBuffer: 1,
      buttonDecrement: "-",
      buttonIncrement: "+",
      buttonPosition: 'around'
    });

    $('#nombre_producto').autocomplete({
        source: "recursos/ventas/buscar_producto.php",
        minLength: 1,
        select: function(event, ui){
          
          document.getElementById('cod_producto').value = ui.item.id;
          document.getElementById('precio_producto').value = ui.item.precio;
          document.getElementById('stock_producto').value = ui.item.stock;
          M.updateTextFields();
        }
      }).data('ui-autocomplete')._renderItem = function(ul, item){
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
      };
  });

$("#datos_cliente").click(function () {

  if (!$('#datos_cliente').is(":checked")){
    // document.getElementById('form_registro_venta').hidden = true
    // document.getElementById('tipo_cliente_radios').hidden = true
    document.getElementById('form_registro_venta_fisica').hidden = true
    // document.getElementById('form_registro_venta_juridica').hidden = true
  }else{
    document.getElementById('form_registro_venta_fisica').hidden = false
    // document.getElementById('tipo_cliente_radios').hidden = false

  }
})

// $('input[name="rad_client"]').click(function(){
//   let value = $('input[name="rad_client"]:checked').val();

//   if (value == '0') {
//     document.getElementById('form_registro_venta_fisica').hidden = false
//     document.getElementById('form_registro_venta_juridica').hidden = true
//   }else{
//     document.getElementById('form_registro_venta_fisica').hidden = true
//     document.getElementById('form_registro_venta_juridica').hidden = false
//   }

// });


// function confirm_client() {
//   let nombre = $("#nombre_c").val()
//   let ap = $("#ap_c").val()

//   if (nombre == "" || ap == "") {
//     M.toast({html: 'Debe ingresar datos válidos.'})
//     return false;
//   }
//   $("#detalle_venta").removeAttr('hidden')
// }

var total = 0;
// var mensaje = $("#mensaje");
// mensaje.hide();
$( "#regresar" ).click(function() {
  $("#cuerpo").load("templates/ventas/ventas.php");
});

// $('#tabla_platos').dataTable({
//   bInfo: false,
//   "lengthMenu": [[5, 10], [5, 10]],
//   "order": [[ 0, "desc" ]],
//   "language": {
//     "lengthMenu": "_MENU_ Mostrar",
//     "zeroRecords": "Lo siento, no se encontraron datos",
//     "info": "Página _PAGE_ de _PAGES_",
//     "infoEmpty": "No hay datos disponibles",
//     "infoFiltered": "(filtrado de _MAX_ resultados)",
//     "paginate": {
//       "next": "Siguiente",
//       "previous": "Anterior"
//     }
//   }
// });
// $('#tabla_bebidas').dataTable({
//   bInfo: false,
//   "lengthMenu": [[5, 10], [5, 10]],
//   "order": [[ 0, "desc" ]],
//     "language": {
//     "lengthMenu": "_MENU_ Mostrar",
//     "zeroRecords": "Lo siento, no se encontraron datos",
//     "info": "Página _PAGE_ de _PAGES_",
//     "infoEmpty": "No hay datos disponibles",
//     "infoFiltered": "(filtrado de _MAX_ resultados)",
//     "paginate": {
//       "next": "Siguiente",
//       "previous": "Anterior"
//     }
//   }
// });

var reg_pedidos = new Array();
document.getElementById('form_agregar_producto').addEventListener('submit', function(e){
  e.preventDefault();
  var formulario = document.getElementById("form_agregar_producto");
  formData = new FormData(formulario)
  // console.log(parseFloat(formData.get('precio_producto')));
  if(parseFloat(formData.get('precio_producto')) < 1){
    return M.toast({html: 'Por favor, ingrese un precio válido.'})
  }
  // return console.log(formData.get('stock_producto'));

  let json_productos = {
    "cod_producto": formData.get('cod_producto'),
    "nombre_producto": formData.get('nombre_producto'),
    "precio_producto": formData.get('precio_producto'),
    "stock_producto": formData.get('stock_producto'),
    "cantidad_producto": formData.get('cantidad_producto')
  }

  let json_prod = JSON.stringify(json_productos);
  // console.log(json_prod)

  $("#__datosplato").html(`<input id='__datosp' value='${json_prod}'  />`);

  fetch("recursos/app/check_stock.php?id="+formData.get('cod_producto'))
  .then(response => response.text())
  .then(data => {
    let disp = parseInt(json_productos.stock_producto) - parseInt(data)
    // console.log('stock actual: '+json_productos.stock_producto+' cantidad vendidos hoy: '+data+ ' cantidad disponible: '+disp+ 'cantidad pedida por cliente: '+json_productos.cantidad_producto);
    if (parseInt(json_productos.cantidad_producto) > disp) {
      return M.toast({html: "Cantidad solicitada insuficiente en stock, "+disp+" disponible."})
    }else{
      M.toast({html: "Agregado al detalle de venta."})
    }
    if (parseInt(json_productos.cantidad_producto) > 35 || json_productos.cantidad_producto == "") {return M.toast({html: "El pedido no puede superar las 35 unidades"})}
    if (parseInt(json_productos.cantidad_producto) < 1 || json_productos.cantidad_producto == "") {return M.toast({html: "Ingresa una cantidad válida."}); }
    // let subtotal = parseInt(json_productos.precio_producto) * parseInt(json_productos.cantidad_producto)

    reg_pedidos[json_productos.cod_producto] = [json_productos.cod_producto, json_productos.nombre_producto, json_productos.cantidad_producto, json_productos.precio_producto];
    //reg_pedidos[codigo] = [codigo, nombre, cantidad, precio]
    // console.log(reg_pedidos);
    
    $('#ventas_agregadas tbody tr').empty();
    var table = $("#ventas_agregadas")[0];
    total =  0;
    subtotal = 0;
    //llenando tabla
    reg_pedidos.forEach(function (valor) {
      var row = table.insertRow(-1);
      row.insertCell(0).innerHTML = valor[1];
      row.insertCell(1).innerHTML = valor[2];
      row.insertCell(2).innerHTML = valor[3];
      row.insertCell(3).innerHTML = "<a href='#' onclick='borrar_producto("+valor[0]+")'><i class='material-icons prefix'>delete</i></a>";
      subtotal = parseFloat(valor[3])*parseInt(valor[2]);
      total  = parseFloat(total) + parseFloat(subtotal);
    });
    document.getElementById('total_ped').innerHTML = total+" Bs.";
    document.getElementById('subtotal').value = total;
    formulario.reset();
    document.getElementById('__cantidad').value = 1;
  })
})

// var reg_pedidos = new Array();
function agregar_fila_plato() {
      console.log(reg_pedidos)

      let c_sell = $("#current_sell").val()
      let c_stock = $("#current_stock").val()
      var cantp = $("#__cantidad").val();

      let disp = parseInt(c_stock) - parseInt(c_sell)
      if (disp < cantp) {
        return M.toast({html: "Cantidad solicitada insuficiente en stock, "+disp+" disponible."})
      }else{
        M.toast({html: "Agregado al detalle de venta."})
      }

      var cp = $("#__datosp").attr("cp");
      var np = $("#__datosp").attr("np");
      var pp = $("#__datosp").attr("pp");
      // var fp = $("#__datosp").attr("fp");
      
      if (parseInt(cantp) > 35 || cantp == "") {M.toast({html: "El pedido no puede superar las 35 unidades"})}
        else{
      if (parseInt(cantp) < 1 || cantp == "") { M.toast({html: "Ingresa una cantidad válida."}); }
      else{
        pp = parseFloat(pp)*parseInt(cantp);
        
        reg_pedidos[cp] = [cp, np, cantp, pp];
        //borrando tabla
        // $('#ventas_agregadas tr:not(:first-child)').slice(0).remove();
        $('#ventas_agregadas tbody tr').empty();
        var table = $("#ventas_agregadas")[0];
        total =  0;
        //llenando tabla
        reg_pedidos.forEach(function (valor) {
          var row = table.insertRow(-1);
          row.insertCell(0).innerHTML = valor[1];
          row.insertCell(1).innerHTML = valor[2];
          row.insertCell(2).innerHTML = valor[3];
          row.insertCell(3).innerHTML = "<a href='#' onclick='borr_pla("+valor[0]+")'><i class='material-icons prefix'>delete</i></a>";
          
          
          
          total  = parseInt(total) + parseInt(valor[3]);
        });
        $("#total_ped").html(total +" Bs.");
        $("#subtotal").val(total);
        $("#modal_cant_plato").modal('close');
        // $("#modal_plato").modal('close');
      }}
}

    function borrar_producto(x) {
      delete reg_pedidos[x];
      console.log(reg_pedidos);
        //borrando tabla
        $('#ventas_agregadas tbody tr').empty();
        var table = $("#ventas_agregadas")[0];
        total =  0;
        subtotal = 0;
        //llenando tabla
        reg_pedidos.forEach(function (valor) {
          console.log(valor);
          var row = table.insertRow(-1);
          row.insertCell(0).innerHTML = valor[1];
          row.insertCell(1).innerHTML = valor[2];
          row.insertCell(2).innerHTML = valor[3];
          row.insertCell(3).innerHTML = `<a href='#' onclick='borrar_producto("${valor[0]}")'><i class='material-icons prefix'>delete</i></a>`;

          subtotal = parseFloat(valor[3])*parseFloat(valor[2]);
          total  = parseFloat(total) + subtotal;
        });
        $("#total_ped").html(total +" Bs.");
        $("#subtotal").val(total);
    }


//AGREGAR VENTA A BD
  function reg_venta() {

    // $("#tot_ped").val(total);
    // let cic = $("#ci_c").val();
    // let nombrec = $("#nombre_c").val();
    // let apc = $("#ap_c").val();
    // let totped = $("#tot_ped").val();
    // let telf = $("#telf").val();
    // let value = $('input[name="rad_client"]:checked').val(); // para venta juridica

    let datos_cli = "";
    let sw = 0;
    if ($('#datos_cliente').is(":checked")) {
        sw = 1;
      // if (value == '0') {
        let reg_cedula = $("#reg_cedula").val()
        let reg_nombres = $("#reg_nombres").val();
        let reg_apellido_p = $("#reg_apellido_p").val();
        let reg_apellido_m = $("#reg_apellido_m").val();
        let telf = $("#f_reg_telf").val();
        datos_cli = "&ci="+reg_cedula+"&nombre="+reg_nombres+"&apellido_p="+reg_apellido_p+"&apellido_m="+reg_apellido_m+"&telf="+telf;
        // console.log(reg_cedula, reg_nombres, reg_apellidos)
        if (reg_cedula.length < 6 || reg_nombres.length < 3 || reg_apellido_p < 3) {
          return M.toast({html: 'Ingrese datos válidos.'})
        }
      // }
      // else{
        // let reg_nit = $("#reg_nit").val()
        // let reg_razon = $("#reg_razon").val();
        // let telf = $("#j_reg_nit").val();
        // datos_cli = "&ci="+reg_nit+"&nombre="+reg_razon+"&telf="+telf+"&value="+value;
        // console.log(reg_nit, reg_razon)
        // if (reg_cedula.length < 9 || reg_razon.length < 4 ) {
        //   return M.toast({html: 'Ingrese datos válidos.'})
        // }
      // }
    }
    let bdtotal = total

    var x="";
    var y="";

    let json_detalle = reg_pedidos.filter(Boolean)
    json_detalle = JSON.stringify(json_detalle)

    // return console.log(json_detalle);
    // console.log(JSON.parse(json_detalle).length)

    // cont = 0;
    if(JSON.parse(json_detalle).length > 0){
      // reg_pedidos.forEach(function (valor) {
      //   x=x+"&"+cont+"="+valor[0];
      //   y=y+"&"+cont+"c="+valor[2];
      //   cont++;
      // });
      // misdatos="ci_cliente="+cic+"&nombre_cliente="+nombrec+"&ap_cliente="+apc+"&telf="+telf+"&tot_ped="+totped+x+y+"&cont="+cont;

      let subtotal = $("#subtotal").val()
      // return console.log(subtotal+"<<<");
      fetch("recursos/ventas/agregar_venta.php?subtotal="+subtotal+"&sw="+sw+"&json="+json_detalle+datos_cli)
      .then(response => response.text())
      .then(data => {

        // return console.log(data);
        // if(!data.includes('error')){
          M.toast({html: "Venta Realizada!"});
          // console.log(data)
          obtenerElem(data);
          // $("#cuerpo").load("templates/ventas/ventas.php");
        // }else{
          // console.log(data);
        // }
      })

    }else{
      M.toast({html: "No se ha seleccionado ningún producto..."});
    }
}


function obtenerElem(cod){

  var datos_venta = "";
  // var data = {codx: cod}
  fetch("recursos/ventas/datos_fyc.php?codx="+cod)
  .then(response => response.json())
  .then(data => {
    // console.log(data);
    // response = JSON.parse(response)
    // console.log(response.Codv, response.idcli, response.Total, response.Nombre, response.Apellidos);
    imprimirElemento(data); 
  })
}
function imprimirElemento(response){

// var data_fac = response.split(",")
var cod = response.cod_venta;
var ci = response.ci_cliente;
var nombres = response.nombre_cliente+" "+response.apellidos
var usuario = "<?php echo $_SESSION['Nombre'].' '.$_SESSION['Apellidos']; ?>"
var total = response.total_venta

// return console.log(nombres, total, usuario);

var date = new Date();

var fecha = ("0"+date.getDate()).slice(-2)+"-"+("0"+(date.getMonth()+1)).slice(-2)+"-"+date.getFullYear() //2 DIGITOS
var hora = ("0"+(date.getHours())).slice(-2)+":"+("0"+(date.getMinutes())).slice(-2)+":"+("0"+(date.getSeconds())).slice(-2)

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



var filas = "";

// var data = {codxv: cod}
fetch("recursos/ventas/filas_fac_ven.php?codxv="+cod)
.then(response => response.text())
.then(data => {
  // console.log(data);
  filas = data;
  var data_arr = {
    autx: aut, 
    llavex: llave, 
    nitx: nit, 
    cix: ci, 
    fechax: (fecha.split("-").reverse().join("-")), 
    montox: total, 
    codped: cod, 
    horax: hora
  }
  data_arr = JSON.stringify(data_arr)
  fetch("recursos/ventas/datos_fac_ven.php?data_arr="+data_arr)
  .then(response => response.text())
  .then(data => {
    // console.log(data);
    crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, data, fecha_lim, usuario);
  })
})

// $.ajax({
//   url: "recursos/ventas/filas_fac_ven.php",
//   data: data,
//   method: "post",
//   success: function(response){
//     console.log(response)
//     filas = response;
//     //ENVIO CON AJAX --
//     var data = {autx: aut, llavex: llave, nitx: nit, cix: ci, fechax: (fecha.split("-").reverse().join("-")), montox: total, codped: cod, horax: hora}

//     $.ajax({
//       url: "recursos/ventas/datos_fac_ven.php",
//       data: data,
//       method: "post",
//       success: function(response){
//         console.log(response)
//         crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, response, fecha_lim, usuario);
//       },
//       error: function(error, data, response){
//         console.log(error)
//       }
//     });

//   },
//   error: function(error, data, response){
//     console.log(error)
//   }
// });
//FIN ENVIO AJAX

}
// let qrcod = "";
function crear_factura(nit, aut, fecha, hora, ci, nombres, filas, total, monto, cod_control, fecha_lim, usuario) {

  var cad = cod_control.split(",");

  let cntdo = nit+"|"+cad[1]+"|"+aut+"|"+fecha+"|"+total+"|"+cad[0]+"|"+ci+"|"+"0"
  // var data = {numfac: cad[1], contenido: cntdo }
  fetch("recursos/ventas/obtener_codigo.php?contenido="+cntdo+"&numfac="+cad[1])
  .then(response => response.text())
  .then(data => {
    // return console.log(data);
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
  
    <center>Repostería "KRUS-MARY".</center>
    <center>Calle Independencia esq Cochabamba #395</center>
    <center>Telf.: 71819635-67673738 </center>
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
    <small>Fecha Límite de emisión: ${(fecha_lim)}</small><br>
    Usuario: ${usuario}
    <div> <center><img src="${qrcod}" alt="" height="120px" /></center></div>
    <center><p>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ESTA SERÁ SANCIONADO DE ACUERDO A LEY</p></center>
    <center>*****************************************</center>
    <center><p>Ley Nro. 453: Los servicios deben suministrarse en condiciones de inocuidad, calidad y seguridad.</p></center>
  </body>
</html> `;

$("#modal-cliente").modal('close');
$("#cuerpo").load("templates/ventas/nueva_venta.php");

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


var ventana = window.open("about:blank","_blank");
ventana.document.write(miHtml);
// ventana.document.close();
// ventana.focus();
$(ventana.document).ready(function (){
ventana.print();
ventana.close();

return true;
});
}


// function buscar_cliente() {

//   let ci_cliente = $("#ci_c").val();

//   if(!ci_cliente){
//     M.toast({html: "Ingresa una cédula de identidad válida."});
//   }
//   else{
//     "<?php foreach($fila2 as $a  => $valor){ ?>"
//     if ("<?php echo $valor['cicli']; ?>" == ci_cliente) {
//       $("#nombre_c").val("<?php echo $valor['nombrecli'] ?>")
//       $("#ap_c").val("<?php echo $valor['apcli'] ?>")
//       $("#telf").val("<?php echo $valor['telfcli'] ?>")
//       $(".dis").attr("disabled", true);
//       return true;
//     }else{
//       $(".dis").removeAttr("disabled");
//       $(".dis").val('');
//     }
//     "<?php } ?>"
//   }
// }

document.getElementById('regresar').addEventListener('click', ()=> {
  document.getElementById('div_regresar').hidden = true;
})

</script>