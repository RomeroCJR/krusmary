<?php
require('../../recursos/conexion.php');

$sql ="SELECT cod_categoria AS cod, nombre_categoria AS nombre  FROM categoria WHERE estado_categoria = 1";
$busq = $conexion->query($sql);
$fila = $busq->fetch_all(MYSQLI_ASSOC);

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
      <a class="waves-effect waves-light btn-large orange darken-4 modal-trigger rubik" id="modal_nuevo_categoria" href="#modal1"><i class="material-icons left">add</i><b>Categoria</b></a>
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
  </div>
<table id="tabla1" class="content-table">
      <thead>
         <tr>
         	<th class="center">Cod</th>
            <th class="center">Nombre</th>
            <th class="center">Acciones</th>
         </tr>          
      </thead>
      <tbody>
      	<?php foreach($fila as $a  => $valor){ ?> 
         <tr>
            <td class="center"><?php echo $valor["cod"] ?></td>
            <td class="center"><?php echo $valor["nombre"]?></td>
           

            <td class="center">
              <a href="#!" class="btn-small btn-floating" onclick="mod_categ('<?php echo $valor['cod'] ?>', '<?php echo $valor['nombre'] ?>')"><i class="material-icons">build</i></a>
  	          <a href="#!" class="btn-small btn-floating" onclick="delete_categ('<?php echo $valor['cod'] ?>')"><i class="material-icons">delete</i></a>
            </td>
         </tr>
         <?php } ?>	
      </tbody>
   </table> 

   <!-- Modal formulario agregar cliente -->
   <div id="modal1" class="modal" style="width: 30%;">
    <div class="modal-content">
      <h4>Nuevo Categoria</h4>
      <form id="form_nuevo_categoria" accept-charset="utf-8">
        <div class="input-field col s12 m12">
          <input id="nombre" name="nombre" type="text" onKeyPress="return checkText(event)" minlength="3" maxlength="30" onpaste="return false" class="validate" required>
          <label for="nombre">Nombre</label>
        </div>  
      </form>
    </div>

    <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" form="form_nuevo_categoria" name="acceso">Agregar</button>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    </div>
  </div>

   <!-- Modal formulario modificar cliente -->
  <div id="modal2" class="modal" style="width: 40%;">
    <div class="modal-content">
      <h4>Modificar Categoria</h4>
      <form id="form_mod_categ" accept-charset="utf-8">
    
        <div class="input-field col s12 m12">
          <input type="text" id="mod_id" name="mod_id" hidden>
          <input id="mod_nombre" name="mod_nombre" type="text" autocomplete="off" onKeyPress="return checkText(event)" minlength="3" maxlength="30" onpaste="return false" class="validate" required>
          <label for="mod_nombre">Nombre</label>
        </div>  
    </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
      <button class="btn waves-effect waves-light" type="submit" form="form_mod_categ">Agregar</button>
    </div>
  </div>


  <!-- Modal Structure -->
  <div id="modal3" class="modal">
    <div class="modal-content">
      <h4>Eliminar categoría</h4>
      <p>Se eliminará la categoría seleccionada.</p>
      <input type="text" id="cod_categoria" hidden>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
      <a href="#!" onclick="borrar_categoria()" class="waves-effect waves-green btn">Aceptar</a>
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

document.getElementById('form_nuevo_categoria').addEventListener('submit', function(e){
  e.preventDefault();

  var formData = new FormData(document.getElementById("form_nuevo_categoria"));
  fetch('recursos/categorias/nuevo_categoria.php',{method:'post', body:formData})
  .then(response => response.text())
  .then(data => {
    $("#modal1").modal("close");
    M.toast({html: "Categoria agregada exitosamente."});
    $("#cuerpo").load("templates/categorias/categorias.php");
  })

});

function mod_categ(id, nombre) {
   document.getElementById('mod_nombre').value = nombre;
   document.getElementById('mod_id').value = id;
   M.updateTextFields();
   $("#modal2").modal('open');
}

document.getElementById('form_mod_categ').addEventListener('submit', function (e) {
   e.preventDefault();
   var formData = new FormData(document.getElementById('form_mod_categ'));
   fetch('recursos/categorias/mod_categoria.php', {method:'post', body: formData})
   .then(response => response.text())
   .then(data => {
      console.log(data)
      $("#modal2").modal("close");
      M.toast({html: "Categoria modificada exitosamente."});
      $("#cuerpo").load("templates/categorias/categorias.php");
   })
});

function delete_categ(cod){
  document.getElementById('cod_categoria').value = cod;
  $("#modal3").modal('open');
}
function borrar_categoria(){
  var cod = document.getElementById('cod_categoria').value;
  fetch(`recursos/categorias/borrar_categoria.php?cod=${cod}`)
  .then(response => response.text())
  .then(data => {
    if(data == '1'){
      M.toast({html: '<b>Categoría dada de baja.</b>', displayLength: 4000})
      $("#modal3").modal('close');
      $("#cuerpo").load('templates/categorias/categorias.php');
    }else{
      console.log(data);
    }
  })
}


document.getElementsByClassName('radios')[1].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[1].value)
  $("#cuerpo").load("templates/categorias/categorias_bajas.php");
})

   </script>