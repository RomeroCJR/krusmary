
<?php
require('../../recursos/conexion.php');

$Sql = "SELECT cod_cliente AS id, ci_cliente AS ci, nombre_cliente AS nombre, CONCAT(ap_paterno_cliente,' ', ap_materno_cliente) AS apellidos, ap_paterno_cliente AS ap_paterno, ap_materno_cliente AS ap_materno,  nro_celular_cliente AS telefono FROM `cliente` where estado_cliente = 1;"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);

// var_dump($fila);
?>

<style>
  .fuente{
  	font-family: 'Segoe UI light';
  	color: red;
  }
  table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
  }

</style>

<div class="row" style="margin-top:20px;">
  <div class="col s4">
      <a class="waves-effect waves-light btn-large orange darken-4 modal-trigger rubik" id="modal_nuevo_cliente" href="#modal1"><i class="material-icons left">add</i><b>Cliente</b></a>
  </div>

  <div class="col s4 offset-s4">
    <div class="right">  
      <p>
        <label>
          <input name="group1" class="radios" value="1" type="radio" checked/>
          <span>Altas</span>
        </label>

        <label>
          <input name="group1"  class="radios" value="2" type="radio"/>
          <span>Bajas</span>
        </label>
      </p>
    </div>
  </div>
</div>


   <table id="tabla1" class="content-table">
      <thead>
         <tr>
         	<th class="center">Ci</th>
            <th class="center">Nombre</th>
            <th class="center">Teléfono</th>
            <th class="center">Acciones</th>
         </tr>          
      </thead>
      <tbody>
      	<?php foreach($fila as $a  => $valor){ ?> 
         <tr>
            <td class="center"><?php echo $valor["ci"] ?></td>
            <td class="center"><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
            <td class="center"><?php echo $valor["telefono"] ?></td>

            <td class="center">
              <a href="#" class="btn-small btn-floating" onclick="mod_cliente('<?php echo $valor['id'] ?>', '<?php echo $valor['ci'] ?>', '<?php echo $valor['nombre'] ?>', '<?php echo $valor['ap_paterno'] ?>', '<?php echo $valor['ap_materno'] ?>', '<?php echo $valor['telefono'] ?>')"><i class="material-icons">build</i></a>
  	          <a href="#" class="btn-small btn-floating" onclick="delete_client('<?php echo $valor['id'] ?>')"><i class="material-icons">delete</i></a>
  	          <a href="#" onclick="vcli('<?php echo $valor['ci'] ?>', '<?php echo $valor['nombre'] ?>', '<?php echo $valor['apellidos'] ?>', '<?php echo $valor['telefono'] ?>');" class="btn-small btn-floating"><i class="material-icons">search</i></a></td>
            </td>
         </tr>
         <?php } ?>	
      </tbody>
   </table> 


<!-- Modal formulario agregar cliente -->
  <div id="modal1" class="modal" style="width: 30%;">
    <div class="modal-content">
      <h4>Nuevo Cliente</h4>
      <form id="form_nuevo_cliente" accept-charset="utf-8">
        <div class="input-field col s12 m12">
          <input id="ci" name="ci" type="text" onKeyPress="return checkIt(event)" onpaste="return false" class="validate" minlength="7" maxlength="7" required>
          <label for="ci"># Cédula</label>
        </div>
        <div class="input-field col s12 m12">
          <input id="nombre" name="nombre" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="17" onpaste="return false" class="validate" required>
          <label for="nombre">Nombre</label>
        </div>
        <div class="input-field col s12 m12">
          <input id="ap_paterno" name="ap_paterno" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="17" onpaste="return false" class="validate" required>
          <label for="ap_paterno">Apellido paterno</label>
        </div>
        <div class="input-field col s12 m12">
          <input id="ap_materno" name="ap_materno" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="17" onpaste="return false" class="validate" >
          <label for="ap_materno">Apellido materno</label>
        </div>

        <div class="input-field col s12 m12">
          <input id="telefono" onKeyPress="return checkIt(event)" name="telefono" type="text" minlength="8" maxlength="8" onpaste="return false" class="validate">
          <label for="telefono">Teléfono</label>
        </div>    
      </form>
    </div>

    <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" form="form_nuevo_cliente" name="acceso">Agregar</button>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    </div>
  </div>


<!-- Modal formulario modificar cliente -->
  <div id="modal2" class="modal" style="width: 30%;">
    <div class="modal-content">
      <h4>Modificar Cliente</h4>
      <form id="form_mod_cliente" action="" method="POST" accept-charset="utf-8">
        <div class="input-field col s12 m12">
          <input type="text" id="mod_id" name="mod_id" hidden>
          <input id="mod_ci" name="mod_ci" type="text" onKeyPress="return checkIt(event)" onpaste="return false" class="validate" minlength="7" maxlength="7" required>
          <label for="mod_ci"># Cédula</label>
        </div>
        <div class="input-field col s12 m12">
          <input id="mod_nombre" name="mod_nombre" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="17" onpaste="return false" class="validate" required>
          <label for="mod_nombre">Nombre</label>
        </div>
        <div class="input-field col s12 m12">
          <input id="mod_ap_paterno" name="mod_ap_paterno" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="17" onpaste="return false" class="validate" required>
          <label for="mod_ap_paterno">Apellido paterno</label>
        </div>
        <div class="input-field col s12 m12">
          <input id="mod_ap_materno" name="mod_ap_materno" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="17" onpaste="return false" class="validate" >
          <label for="mod_ap_materno">Apellido materno</label>
        </div>

        <div class="input-field col s12 m12">
          <input id="mod_telefono" onKeyPress="return checkIt(event)" name="mod_telefono" type="text" minlength="8" maxlength="8" onpaste="return false" class="validate">
          <label for="mod_telefono">Teléfono</label>
        </div>    
      </form>
    </div>

    <div class="modal-footer col s12">
        <button class="btn waves-effect waves-light right" type="submit" form="form_mod_cliente" name="acceso">Modificar</button>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    </div>
  </div>

  <!-- Modal ver cliente -->


<div class="modal width_modal_ver" id="modal4" style="width:35%">
  <div class="modal-content">
    <h4>Ver cliente</h4>
      <div class="row">
        <div class="col s12">
          <h6><p id="__ci"></p></h6>
          <h6><p id="__nombre"></p></h6>
          <h6><p id="__ap"></p></h6>
          <h6><p id="__telf"></p></h6>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a class="waves-effect modal-action modal-close waves-light btn right">Aceptar</a>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="modal3" class="modal">
  <div class="modal-content">
    <h4>Dar de baja cliente:</h4>
    <p>Se dará de baja al cliente seleccionado.</p>
    <input type="text" id="del_id" hidden>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn" id="delete_client">Aceptar</a>
  </div>
</div>



<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
      "order": [[ 0, "desc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_",
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


function delete_client(id) {
  $("#del_id").val(id)
  $("#modal3").modal('open')
}

document.getElementById('delete_client').addEventListener('click', ()=> {
  let id = $("#del_id").val()

  fetch("recursos/clientes/delete_client.php?id="+id)
  .then(response => response.text())
  .then(data => {
    if(data == '1'){
      M.toast({html: "¡Cliente dado de baja!"});
      $("#cuerpo").load("templates/clientes/clientes.php");
    }else{
      console.log(data);
    }
  })

})

function mod_cliente(id, ci, nombre, ap_paterno, ap_materno, telf) {
  $("#mod_id").val(id)
  $("#mod_ci").val(ci)
  $("#mod_nombre").val(nombre)
  $("#mod_ap_paterno").val(ap_paterno)
  $("#mod_ap_materno").val(ap_materno)
  $("#mod_telefono").val(telf)
  M.updateTextFields()
  $("#modal2").modal('open')
}

document.getElementById('form_mod_cliente').addEventListener('submit', function(e){
  e.preventDefault();

  var formData = new FormData(document.getElementById("form_mod_cliente"));
  fetch("recursos/clientes/mod_cliente.php", {method:'post', body: formData})
  .then(response => response.text())
  .then(data => {
    if (data == '1') {
      $("#modal2").modal('close')
      M.toast({html: "Datos de cliente modificados."})
      $("#cuerpo").load("templates/clientes/clientes.php")
    }else{
      console.log(echo)
    }
  })
});


document.getElementById('form_nuevo_cliente').addEventListener('submit', function(e){
  e.preventDefault();

  var formData = new FormData(document.getElementById("form_nuevo_cliente"));
  fetch('recursos/clientes/nuevo_cliente.php',{method:'post', body:formData})
  .then(response => response.text())
  .then(data => {
    $("#modal1").modal("close");
    M.toast({html: "Cliente agregado exitosamente."});
    $("#cuerpo").load("templates/clientes/clientes.php");
  })

});

function checkIt(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  status = "Este campo acepta números solamente.";
  return false;
  }
  status = "";
  return true;
}

function vcli(ci, nombre, apellidos, telefono) {

  $("#__ci").html(`<b>Cédula: </b>${ci}`);
  $("#__nombre").html(`<b>Nombre: </b>${nombre}`);
  $("#__ap").html(`<b>Apellidos: </b>${apellidos}`);
  $("#__telf").html(`<b>Teléfono: </b>${telefono}`);
  $("#modal4").modal('open');
}


document.getElementsByClassName('radios')[1].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[1].value)
  $("#cuerpo").load("templates/clientes/clientes_bajas.php");
})
</script>