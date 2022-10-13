 <?php
require('recursos/conexion.php');

$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM bebida"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('nombre'=>$arr['Nombre'], 'precio'=>$arr['Precio'], 'cantidad'=>$arr['Cantidad']); 
    } 
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

<span class="fuente"><h3>Bebidas
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a></h3> 
</span>
<div class="row">
  <div class="col s12 m12">
    <table id="tabla1" class="highlight">
      <thead>
         <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
         </tr>          
      </thead>
      <tbody>
      	 <?php foreach($fila as $a  => $valor){ ?>
         <tr>
            <td><?php echo $valor["nombre"] ?></td>
            <td align="center"><?php echo $valor["precio"] ?></td>
            <td align="center"><?php echo $valor["cantidad"] ?></td>
         </tr>
         <?php } ?>	
      </tbody>
    </table> 
  </div>
</div>


<!-- Modal Agregar Proveedor -->
<div id="modal1" class="modal col m12 l4 offset-l4">
  <div class="modal-content">
    <h5>Nueva Bebida</h5>
    <div class="row">
      <form action="#" id="nueva_beb" method="POST">
        <div class="input-field col s12">
          <input id="__nombre" name="__nombre" type="text" class="validate" required>
          <label for="__nombre">Nombre</label>
        </div>

        <div class="input-field col s12">
          <input id="__precio" name="__precio" type="number" class="validate" required>
          <label for="__precio">Precio</label>
        </div>

        <div class="input-field col s12">
          <input id="__cant" name="__cant" onKeyPress="return checkIt(event)" type="number" class="validate" required>
          <label for="__cant">Cantidad</label>
        </div>
      </form>
    </div>
  </div>
  <div class="modal-footer">
          <button class="btn waves-effect waves-light right" type="submit" form="nueva_beb" name="acceso">Agregar</button>
          <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
  </div>
</div>

<!--MODAL PARA RECIBIR MENSAJES DESDE PHP-->  
<div class="row">
  <div id="modal2" class="modal col s4 offset-s4">
    <div id="mensaje" class="modal-content">
      
    </div>
    <div class="modal-footer row">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#tabla1').dataTable();
    $('#modal').leanModal();
});
var mensaje = $("#mensaje");
mensaje.hide();

$("#nueva_beb").on("submit", function(e){
  e.preventDefault();

  var formData = new FormData(document.getElementById("nueva_beb"));
  $.ajax({
    url: "recursos/nueva_bebida.php",
    type: "POST",
    dataType: "HTML",
    data: formData,
    cache: false,
    contentType: false,
    processData: false
  }).done(function(echo){
    mensaje.html(echo);
    $("#cuerpo").load("bebidas.php");
  });
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
</script>