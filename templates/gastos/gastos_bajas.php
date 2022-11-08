<?php
require('../../recursos/conexion.php');

$Sql = "SELECT * FROM caja WHERE estado_caja = 0"; 
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
         	<th class="center">Código</th>
            <th class="center">Monto de gasto</th>
            <th class="center">Descripción del gasto</th>
            <th class="center">Fecha del gasto</th>
            <th class="center">Acciones</th>
         </tr>          
      </thead>
      <tbody>
      	<?php foreach($fila as $a  => $valor){ ?> 
         <tr>
            <td class="center"><?php echo $valor["cod_caja"] ?></td>
            <td class="center"><?php echo $valor["monto_caja"] ?></td>
            <td class="center"><?php echo $valor["descripcion_caja"] ?></td>
            <td class="center"><?php echo $valor["fecha_caja"] ?></td>
            <td class="center">
              <a href="#" class="btn-small btn-floating" onclick="restore_gasto('<?php echo $valor['cod_caja']; ?>')"><i class="material-icons">restore_from_trash</i></a>
            </td>
         </tr>
         <?php } ?>	
      </tbody>
   </table> 



<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Dar de alta:</h4>
    <p>Se restaurará el gasto seleccionado.</p>
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

function restore_gasto(id){
    document.getElementById('restore_id').value = id;
    $("#modal1").modal('open');
}

document.getElementById('confirmar_restaurar').addEventListener('click', ()=> {
    var id = document.getElementById('restore_id').value;
    fetch('recursos/gastos/restaurar_gasto.php?id='+id)
    .then(response => response.text())
    .then(data => {
        if(data == '1'){
            M.toast({html: '<b>Gasto restaurado.</b>'})
            $("#cuerpo").load("templates/gastos/gastos_bajas.php");
        }else{
            console.log(data);
        }
    })
})

document.getElementsByClassName('radios')[0].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[0].value)
  $("#cuerpo").load("templates/gastos/gastos.php");
})

</script>