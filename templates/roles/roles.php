
<?php
require('../../recursos/conexion.php');

$Sql = "SELECT cod_rol AS cod, nombre_rol AS nombre, descripcion_rol AS des FROM `rol` where estado_rol = 1"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);
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
            <a class="waves-effect waves-light btn-large orange darken-4 modal-trigger rubik" id="modal_nuevo_usuario" href="#modal1"><i class="material-icons left">add</i><b>Rol</b></a>
      </div>
   </div>

<div class="row">
  <div class="col s12 m12">
     <table id="tabla1" class="content-table">
        <thead>
           <tr>
           	<th>Código</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Acciones</th>
  <!--        <th>Borrar</th>
            	<th>Ver Usuario</th> -->
           </tr>          
        </thead>
        <tbody>
        	 <?php foreach($fila as $a  => $valor){ ?>
           <tr>
              
              <td align="center"><?php echo $valor["cod"]?></td>
              <td align="center"><?php echo $valor["nombre"] ?></td>
              <td align="center"><?php echo $valor["des"] ?></td>

              <td><a href="#" onclick="mod_rol(`<?php echo $valor['cod']?>`, `<?php echo $valor['nombre']?>`, `<?php echo $valor['des']?>`)" class="btn-floating btn-small"><i class="material-icons">build</i></a>
  	          <!-- <a href="#"><i class="material-icons">delete</i></a> -->
  	          <!-- <a href="#" class="btn-floating btn-small"><i class="material-icons">search</i></a></td> -->
           </tr>
           <?php } ?>	
        </tbody>
     </table> 
   </div>
</div>



<div id="modal1" class="modal" style="width: 40%;">
   <div class="modal-content">
   <h4>Nuevo Rol</h4>
   <form id="form_nuevo_rol" accept-charset="utf-8">
   
      <div class="input-field col s12 m12">
         <input id="nombre" name="nombre" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="30" onpaste="return false" class="validate" required>
         <label for="nombre">Nombre</label>
      </div>
      <div class="input-field col s12 m12">
         <input id="des" name="des" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="100" onpaste="return false" class="validate" required>
         <label for="des">Descripción</label>
      </div>    
   </form>
   </div>

   <div class="modal-footer">
      <button class="btn waves-effect waves-light" type="submit" form="form_nuevo_rol" name="acceso">Agregar</button>
      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
   </div>
</div>


<!-- Modal modificar -->
<div id="modal2" class="modal" style="width: 40%;">
  <div class="modal-content">
    <h4>Modificar rol</h4>
    <form id="form_mod_rol" accept-charset="utf-8">
   
      <div class="input-field col s12 m12">
         <input type="text" id="mod_id" name="mod_id" hidden>
         <input id="mod_nombre" name="mod_nombre" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="30" onpaste="return false" class="validate" required>
         <label for="mod_nombre">Nombre</label>
      </div>
      <div class="input-field col s12 m12">
         <input id="mod_des" name="mod_des" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="100" onpaste="return false" class="validate" required>
         <label for="mod_des">Descripción</label>
      </div>    
   </form>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    <button class="btn waves-effect waves-light" type="submit" form="form_mod_rol">Agregar</button>
  </div>
</div>

<script>
$(document).ready(function() {
   $('#tabla1').dataTable({
      "order": [[ 0, "asc" ]],
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


document.getElementById('form_nuevo_rol').addEventListener('submit', function (e){
   console.log('entra a la funcion')
   e.preventDefault();
   var formData = new FormData(document.getElementById('form_nuevo_rol'));
   fetch('recursos/roles/nuevo_rol.php', {method:'post', body: formData})
   .then(response => response.text())
   .then(data => {
      console.log(data)
      $("#modal1").modal("close");
      M.toast({html: "Rol agregado exitosamente."});
      $("#cuerpo").load("templates/roles/roles.php");
   })
});

function mod_rol(id, nombre, des) {
   document.getElementById('mod_nombre').value = nombre;
   document.getElementById('mod_des').value = des;
   document.getElementById('mod_id').value = id;
   M.updateTextFields();
   $("#modal2").modal('open');
}

document.getElementById('form_mod_rol').addEventListener('submit', function (e) {
   console.log('funcion')
   e.preventDefault();
   var formData = new FormData(document.getElementById('form_mod_rol'));
   fetch('recursos/roles/modificar_rol.php', {method:'post', body: formData})
   .then(response => response.text())
   .then(data => {
      console.log(data)
      $("#modal2").modal("close");
      M.toast({html: "Rol modificado exitosamente."});
      $("#cuerpo").load("templates/roles/roles.php");
   })
});

</script>