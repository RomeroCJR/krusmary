<?php
  require('../../recursos/conexion.php');

  // $_SESSION['filas'] = array(); 
  $Sql = "SELECT a.*, b.nombre_categoria  FROM producto a, categoria b WHERE a.cod_categoria = b.cod_categoria AND estado_producto = 0"; 
  $Busq = $conexion->query($Sql); 
  $fila = $Busq->fetch_all(MYSQLI_ASSOC);

 $result = $conexion->query("SELECT * FROM categoria WHERE estado_categoria = 1");
 $cat = $result->fetch_all(MYSQLI_ASSOC); 



?>


<style>
  .fuente{
  	font-family: 'Segoe UI light';
  	color: red;
  }

  h5 {
    font-family: 'Segoe UI light';
  }
  #modal1{
    /*width: 40%;*/
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
          <input name="group1"  class="radios" value="2" type="radio" checked/>
          <span>Bajas</span>
        </label>
      </p>
    </div>
  </div>
</div>






  <!-- Modal restaurar plato -->
  <div id="modal1" class="modal">
    <div class="modal-content rubik">
        
        <h4>Se dará de alta el producto:</h4>
        <div style="height:50%">
            <center><img style="width:45%; max-height: 240px; height:auto; "  id="restaurar_foto" src="" ></center>
        </div>
        <input type="text" id="restaurar_codp" hidden>
        <p id="restaurar_nombre" style="line-height:0.3;"></p>
        <p id="restaurar_precio" style="line-height:0.3;"></p>
    </div>

    <div class="modal-footer">
      <button class="btn waves-effect waves-light right" onclick="rest_producto()">Aceptar</button>
      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    </div>
  </div>

<div class="row">
  <div class="col s12 m12">
    <table id="tabla1" class="content-table">
      <thead>
         <tr>
            <th class="center">Foto</th>
            <th class="center">Nombre</th>
            <th class="center">Precio (Bs)</th>
            <th class="center">Descripción</th>
            <th class="center">Acciones</th>
         </tr>          
      </thead>
      <tbody>
      	 <?php foreach($fila as $a  => $valor){ ?>
         <tr>
            <td class="center"><img src="<?php echo $valor['foto_producto'] ?>" height="50px"></td>
            <td class="center"><?php echo $valor["nombre_producto"] ?></td>
            <td class="center"><?php echo $valor["precio_producto"] ?></td>
            <td class="center"><?php echo $valor["descripcion_producto"] ?></td>
            <td class="center">
                <a href="#!" class="btn-small btn-floating" onclick="restaurar_producto('<?php echo $valor['cod_producto'] ?>', '<?php echo $valor['nombre_producto'] ?>', '<?php echo $valor['precio_producto'] ?>', '<?php echo $valor['foto_producto'] ?>');"><i class="material-icons">restore_from_trash</i></a>
            </td>
         </tr>
         <?php } ?>	
      </tbody>
    </table> 
  </div>
</div>


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




function restaurar_producto (codpro, nombre, precio, foto){
  $("#restaurar_foto").attr('src', foto)
  $("#restaurar_codp").val(codpro)
  $("#restaurar_nombre").html('<b>Producto: </b>'+nombre)
  $("#restaurar_precio").html('<b>Precio: </b>'+precio)
  // $("#borr_foto")
  $("#modal1").modal('open')
}

function rest_producto() {

  let codpro = document.getElementById('restaurar_codp').value;
  fetch("recursos/productos/restaurar_producto.php?codpro="+codpro)
  .then(response => response.text())
  .then(data => {
    console.log(data)
    if (data == 1) {
      M.toast({html: 'Producto dado de alta.'})
      $("#cuerpo").load('templates/productos/productos_bajas.php')
    }
  })

}
document.getElementsByClassName('radios')[0].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[0].value)
  $("#cuerpo").load("templates/productos/productos.php");
})

</script>