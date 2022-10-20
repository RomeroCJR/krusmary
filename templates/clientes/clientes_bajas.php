
<?php
require('../../recursos/conexion.php');

$Sql = "SELECT cod_cliente AS id, ci_cliente AS ci, nombre_cliente AS nombre, CONCAT(ap_paterno_cliente,' ', ap_materno_cliente) AS apellidos, ap_paterno_cliente AS ap_paterno, ap_materno_cliente AS ap_materno,  nro_celular_cliente AS telefono FROM `cliente` where estado_cliente = 0;"; 
$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);

// var_dump($fila);
?>

<style>
  .fuente{
  	font-family: 'Segoe UI light';
  	color: red;
  }

  /* table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
  } */

  #tabla1_filter input{
    /* padding:0px; */
  }
</style>

<div class="row" style="margin-top:20px;">

  <div class="col s4 offset-s8">
    <div class="right">  
      <p>
        <label>
          <input name="group1" class="radios" value="1" type="radio"  />
          <span>Altas</span>
        </label>

        <label>
          <input name="group1"  class="radios" value="2" type="radio" checked />
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
              <a href="#" class="btn-small btn-floating" onclick="restore_client('<?php echo $valor['id'] ?>')"><i class="material-icons">restore_from_trash</i></a>
            </td>
         </tr>
         <?php } ?>	
      </tbody>
   </table> 



<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Dar de alta:</h4>
    <p>Se dará de alta al cliente seleccionado.</p>
    <input type="text" id="restore_id" hidden>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn" id="confirmar_restaurar">Aceptar</a>
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
});

function restore_client(id){
    document.getElementById('restore_id').value = id;
    $("#modal1").modal('open');
}

document.getElementById('confirmar_restaurar').addEventListener('click', ()=> {
    var id = document.getElementById('restore_id').value;
    fetch('recursos/clientes/restaurar_cliente.php?id='+id)
    .then(response => response.text())
    .then(data => {
        if(data == '1'){
            M.toast({html: 'Cliente dado de alta.'})
            $("#cuerpo").load("templates/clientes/clientes_bajas.php");
        }else{
            console.log(data);
        }
    })
})

document.getElementsByClassName('radios')[0].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[0].value)
  $("#cuerpo").load("templates/clientes/clientes.php");
})

</script>