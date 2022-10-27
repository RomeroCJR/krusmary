<?php
require('../../recursos/conexion.php');

$sql ="SELECT cod_categoria AS cod, nombre_categoria AS nombre  FROM categoria WHERE estado_categoria = 0";
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
          <input name="group1" class="radios" value="1" type="radio" />
          <span>Altas</span>
        </label>

        <label>
          <input name="group1"  class="radios" value="2" type="radio" checked/>
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
              <a href="#" class="btn-small btn-floating" onclick="recuperar_categ('<?php echo $valor['cod'] ?>')"><i class="material-icons">restore_from_trash</i></a>
            </td>
         </tr>
         <?php } ?>	
      </tbody>
   </table> 

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
      <div class="modal-content">
        <h4>Recuperar categoría</h4>
        <p>Se dará de alta la categoría seleccionada.</p>
        <input type="text" id="cod_categoria" hidden>
      </div>
      <div class="modal-footer">
        <a href="#!" class="left modal-action modal-close waves-effect waves-red btn red">Cancelar</a>
        <a href="#!" onclick="recuperar_categoria()" class="waves-effect waves-green btn">Aceptar</a>
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

function recuperar_categ(cod) {
    document.getElementById('cod_categoria').value = cod;
    $("#modal1").modal('open');
}
function recuperar_categoria(){
    var cod = document.getElementById('cod_categoria').value;
    fetch('recursos/categorias/recuperar_categoria.php?cod='+cod)
    .then(response => response.text())
    .then(data => {
        if(data == '1'){
            M.toast({html: '<b>Categoría restaurada.</b>'})
            $("#modal1").modal('close');
            $("#cuerpo").load('templates/categorias/categorias_bajas.php');
        }
    })
}


document.getElementsByClassName('radios')[0].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[0].value)
  $("#cuerpo").load("templates/categorias/categorias.php");
})

   </script>