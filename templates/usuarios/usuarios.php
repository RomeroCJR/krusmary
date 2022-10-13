<?php
require('../../recursos/conexion.php');

// $_SESSION['filas'] = array(); 
//CONSULTA OBTENER DATOS DE USUARIOS
$Sql = "SELECT a.ci_usuario as ci, a.nombre_usuario AS nombre, CONCAT(a.ap_paterno_usuario,' ',a.ap_materno_usuario) AS apellidos, a.nro_celular_usuario AS telefono, a.correo_usuario AS email, b.cod_rol AS codrol, c.nombre_rol AS rol, d.clave AS passw FROM `usuario` a, `usu_rol` b, `rol` c, `datos` d WHERE a.cod_usuario = b.cod_usuario AND c.cod_rol = b.cod_rol AND d.cod_usuario = a.cod_usuario AND a.estado_usuario = 1;"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);

//CONSULTA OBTENER ROLES
$Sql2 = "SELECT cod_rol AS codrol, nombre_rol AS nombre FROM `rol` WHERE estado_rol = 1"; 
$Busq2 = $conexion->query($Sql2); 
$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC)

?>

<style>
  .fuente{
  	font-family: 'Segoe UI light';
  	color: red;
  }


  table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
  }
  .centra_mod{
    width: 40%;
    overflow-x: hidden;
  }
  .width_modal{
    width: 30%
  }
  .width_modal_ver{
    width: 25%
  }
  #modal3{
    max-height: 90% !important;
    margin-top: -3%;
  }
  #perf_f{
    height: 20em;
  }
</style>

<span class="fuente"><h3>
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-large orange darken-4 modal-trigger rubik" id="modal_nuevo_usuario" href="#modal1"><i class="material-icons left">add</i><b>Usuario</b></a></h3> 
</span>
<div class="row">
  <div class="col s12 m12 l12">
   <table id="tabla1" class="content-table">
      <thead>
         <tr>
            <!-- <th>Foto</th> -->
            <th>Ci</th>
            <th>Nombre</th>
            <!-- <th>Dirección</th> -->
            <th>Teléfono</th>
            <th>Email</th>
            <th>Rol</th>
            <th class="center" width="15%">Acciones</th>

         </tr>          
      </thead>
      <tbody>
      	 <?php foreach($fila as $a  => $valor){ ?>
         <tr>
            <!-- <td><img src="<?php echo $valor['foto'] ?>" alt="" width="40px" height="40px"></td> -->
            <td><?php echo $valor["ci"] ?></td>
            <td><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
            <!-- <td><?php echo $valor["direccion"] ?></td> -->
            <td><?php echo $valor["telefono"] ?></td>
            <td><?php echo $valor["email"] ?></td>
            <td align="center"><?php echo $valor["rol"] ?></td>
            <td width="25%" class="center"><a href="#" onclick="mod_usuario('<?php echo $valor['ci'] ?>', '<?php echo $valor['nombre'] ?>', '<?php echo $valor['apellidos'] ?>', '<?php echo $valor['telefono'] ?>', '<?php echo $valor['email'] ?>', '<?php echo $valor['passw'] ?>', '<?php echo $valor['codrol'] ?>', '<?php echo $valor['rol'] ?>'" class="btn btn-small"><i class="material-icons">build</i></a>
	          <a href="#modal4" onclick="$('#eliminar_ci').val('<?php echo $valor['ci'] ?>')" class="btn btn-small modal-trigger"><i class="material-icons">delete</i></a>
	          <a href="#" onclick="vusu('<?php echo $valor['ci'] ?>');" class="btn btn-small"><i class="material-icons">search</i></a></td>
         </tr>
         <?php } ?>	
      </tbody>
   </table> 
</div></div>



  <div id="modal1" class="modal width_modal">
    <div class="modal-content">
      <h4 style="font-family: 'Segoe UI light';">Nuevo Usuario</h4>
      <form id="form_nuevo_usuario" accept-charset="utf-8">

        <div class="input-field col s12">
          <input id="ci" name="ci" type="text" onKeyPress="return checkIt(event)" minlength="7" maxlength="7" class="validate" required>
          <label for="ci"># Cédula (*)</label>
        </div>
        
        <div class="input-field col s12">
          <input id="nombre" name="nombre" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="25" class="validate" required>
          <label for="nombre">Nombre (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="apellido_p" name="apellido_p" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="25" class="validate" required>
          <label for="apellido_p">Apellido paterno (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="apellido_m" name="apellido_m" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="25" class="validate" >
          <label for="apellido_m">Apellido materno (*)</label>
        </div>

        <div class="input-field col s12">
          <input id="telefono" name="telefono" type="text" onKeyPress="return checkIt(event)" minlength="8" maxlength="8" class="validate" required>
          <label for="telefono">Celular (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="email" name="email" type="email" minlength="12" maxlength="40" class="validate">
          <label for="email">E-mail</label>
        </div>
        <div class="input-field col s12">
          <input id="login" name="login" type="text" minlength="4" maxlength="15">
          <label for="login">Login de acceso al sistema (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="passw" name="passw" type="text" minlength="4" maxlength="15">
          <label for="passw">Contraseña de acceso al sistema (*)</label>
        </div>
        <div class="input-field col s12">
          <select name="rol">
            <!-- <option value="" disabled selected>Choose your option</option> -->
            <?php foreach($fila2 as $a  => $valor){ ?>
              <option value="<?php echo $valor['codrol'] ?>"><?php echo $valor["nombre"] ?></option>
            <?php } ?>
          </select>
          <label>Selecciona un rol</label>
        </div>

     
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn waves-effect waves-light right" type="submit" form="form_nuevo_usuario">Agregar</button>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
      </div>
      
  </div>

<!-- Modal modificar usuario -->
  <div id="modal2" class="modal width_modal">
    <div class="modal-content">
      <h4 style="font-family: 'Segoe UI light';">Modificar Usuario</h4>
      <form id="form_mod_usuario" accept-charset="utf-8">

        <div class="file-field input-field col s12">
          <div class="btn">
            <span>Foto</span>
            <input type="file" id="mod_imagen" name="mod_imagen">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
          <input type="text" id="old_pic" name="old_pic" hidden>
        </div>
        <div class="input-field col s12">
          <input type="text" id="old_ci" name="old_ci" hidden>
          <input id="mod_ci" name="mod_ci" type="text" onKeyPress="return checkIt(event)" class="validate" required>
          <label for="mod_ci"># Cédula (*)</label>
        </div>
        
        <div class="input-field col s12">
          <input id="mod_nombre" name="mod_nombre" type="text" onKeyPress="return checkText(event)" class="validate" required>
          <label for="mod_nombre">Nombre (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="mod_apellidos" name="mod_apellidos" type="text" onKeyPress="return checkText(event)" class="validate" required>
          <label for="mod_apellidos">Apellidos (*)</label>
        </div>

        <div class="input-field col s12">
          <input id="mod_direccion" name="mod_direccion" type="text" class="validate" required>
          <label for="mod_direccion">Dirección (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="mod_telefono" name="mod_telefono" type="text" onKeyPress="return checkIt(event)" class="validate" required>
          <label for="mod_telefono">Teléfono (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="mod_email" name="mod_email" type="email" class="validate">
          <label for="mod_email">E-mail</label>
        </div>

        <div class="input-field col s12">
          <input id="mod_passw" name="mod_passw" type="text">
          <label for="mod_passw">Contraseña de acceso al sistema (*)</label>
        </div>

        <div class="col s12">
          <label>Selecciona un rol</label>
          <select id="mod_rol" name="mod_rol" class="browser-default">
          </select>
        </div>

        <div class="input-field col s12">
          <input id="mod_fnac" name="mod_fnac" type="date" class="validate" required>
          <label for="mod_fnac" class="active">Fecha nacimiento (*)</label>
        </div>

        <div class="left">
          <label style="color: red;">*La C.I. será Usada como Login para el acceso al sistema.</label>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn waves-effect waves-light right" type="submit" form="form_mod_usuario">Agregar</button>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
      </div>
      
  </div>

<!-- Modal eliminar usuario -->
<div class="modal centra_mod" id="modal4">
  <div class="modal-content">
    <h4>Se dará de baja del sistema al usuario seleccionado</h4>
    <input type="text" id="eliminar_ci" hidden>
  </div>
  <div class="modal-footer">
    <a class="waves-effect modal-action modal-close waves-light btn left red" href="#">Cancelar</a>
    <a class="waves-effect modal-action modal-close waves-light btn right" onclick="eliminar_usuario();" >Confirmar</a>
  </div>
</div>


<!-- Modal Ver Usuario -->
<!-- <div id="modal3" class="modal modal-fixed-footer col m12 s8 offset-s2 l4 offset-l4"> -->
  <div class="modal width_modal_ver" id="modal3">
  <div class="modal-content">

    <div class="center" id="perf_f">
      <img src="" id="foto_perf" class="card-image center" height="100%" width="100%;">
    </div>

    <div class="container">
      <h6><p id="__ci"></p></h6>
      <h6><p id="__nombre"></p></h6>
      <h6><p id="__ap"></p></h6>
      <h6><p id="__fnac"></p></h6>
      <h6><p id="__dir"></p></h6>
      <h6><p id="__telf"></p></h6>
      <h6><p id="__email"></p></h6>
      <h6><p id="__rol"></p></h6>
    </div>
    
  </div>
  <div class="modal-footer">
    <a class="waves-effect modal-action modal-close waves-light btn right" onclick="datos_plato();" >Aceptar</a>
  </div>
</div>


<!-- PARA RECIBIR MENSAJES DESDE PHP-->  
    <div id="mensaje" hidden>




<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
      "order": [[ 4, "asc" ]],
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
    $('select').formSelect();
});

var mensaje = $("#mensaje");
mensaje.hide();

function eliminar_usuario() {
  let ci = $("#eliminar_ci").val()

  $.ajax({
    url: "recursos/usuarios/eliminar_usuario.php?ci="+ci,
    method: "GET",
    success: function(response) {
        console.log(response)
        if (response == 1) {
          M.toast({html: "¡Usuario eliminado!"});
          $("#cuerpo").load("templates/usuarios/usuarios.php");
        }
    },
    error: function(error) {
        console.log(error)
    }
  })

}

function mod_usuario(ci, nombre, apellidos, direccion, telefono, email, passw, fnac, codrol, nomrol, foto) {
  $("#mod_ci").val(ci)
  $("#mod_nombre").val(nombre)
  $("#mod_apellidos").val(apellidos)
  $("#mod_direccion").val(direccion)
  $("#mod_telefono").val(telefono)
  $("#mod_email").val(email)
  $("#mod_passw").val(passw)
  $("#mod_fnac").val(fnac)
  $("#old_ci").val(ci)
  $("#old_pic").val(foto)

  var myHtml = `<option value="${codrol}" selected>${nomrol}</option><?php foreach($fila2 as $a  => $valor){ ?><option value="<?php echo $valor['codrol'] ?>" ><?php echo $valor["nombre"] ?></option><?php } ?>`;

  document.getElementById("mod_rol").innerHTML = myHtml;

  M.updateTextFields()
  $("#modal2").modal('open')
}


document.getElementById('form_nuevo_usuario').addEventListener('submit', function(e){
  e.preventDefault();
  var formData = new FormData(document.getElementById("form_nuevo_usuario"));

  fetch('recursos/usuarios/nuevo_usuario.php', {method:'post', body:formData})
  .then(respuesta => respuesta.text())
  .then(data => {
    if (data == "existe_ci") {
      M.toast({html: "Ya existe otro usuario con la misma C.I."})
    }
    if (data == "existe_login") {
      M.toast({html: "Ya existe otro usuario con el mismo Login."})
    }
    if (data == '1') {
      M.toast({html: "Usuario agregado."})
      $("#modal1").modal('close');
      $("#cuerpo").load("templates/usuarios/usuarios.php");
    } else {
        console.log(data)
    }
  })

});

$("#form_mod_usuario").on("submit", function(e){
  e.preventDefault();
  var formData = new FormData(document.getElementById("form_mod_usuario"));

  fetch('recursos/usuarios/mod_usuario.php', {method:'post', body:formData})
  .then(respuesta => respuesta.text())
  .then(data => {
    if (data == "existe") {
      M.toast({html: "Ya existe otro usuario con la misma C.I."})
    }
    if (data == '1') {
      M.toast({html: "Usuario modificado."});
      $("#modal2").modal('close');
      $("#cuerpo").load("templates/usuarios/usuarios.php");
    } else {
        console.log(data)
    }
  })

});

function vusu (ci) {
  '<?php foreach($fila as $a  => $valor){ ?>';
    if (ci == "<?php echo $valor['ci'] ?>") {
      $("#__ci").html(`<b>Cédula: </b>`+ci);
      $("#__nombre").html(`<b>Nombre: </b><?php echo $valor['nombre'] ?>`);
      $("#__ap").html(`<b>Apellidos: </b><?php echo $valor['apellidos'] ?>`);
      $("#__email").html(`<b>Email: </b><?php echo $valor['email'] ?>`);
      $("#__telf").html(`<b>Teléfono: </b><?php echo $valor['telefono'] ?>`);
      $("#__rol").html(`<b>ROL: </b><?php echo $valor['rol'] ?>`);

    }

  '<?php } ?>';
  $("#modal3").modal('open');
}


</script>