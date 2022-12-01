<!-- FOTO, NOMBRE PROD., STOCK PREVIO, STOCK NUEVO, DIFERENCIA ENTRE STOCKS. -->
<?php 
    require("../../recursos/conexion.php");
    $result = $conexion->query('SELECT a.foto_producto, a.nombre_producto, b.stock_previo, b.stock, (b.stock - b.stock_previo) as diferencia FROM producto a, inventario b WHERE a.cod_producto = b.cod_producto; ');
    $fila = $result->fetch_all(MYSQLI_ASSOC);

?>

<br>
<div class="row">
  <div class="col s12 m12">
    <table id="tabla1" class="content-table">
      <thead>
         <tr>
            <th width="5%" class="center">Foto</th>
            <th width="15%" class="center">Nombre</th>
            <!-- <th class="center">Precio (Bs)</th> -->
            <th class="center">Stock Previo</th> 
            <th class="center">Stock Actual</th> 
            <th class="center">Incremento</th>
            <!-- <th width="20%" class="center">Acciones</th> -->
         </tr>          
      </thead>
      <tbody>
      	 <?php foreach($fila as $a  => $valor){ ?>
         <tr loadin="lazy">
            <td class="center"><img loading="lazy" src="<?php echo $valor['foto_producto'] ?>" height="30px"></td>
            <td class="center"><?php echo $valor["nombre_producto"] ?></td>
            <td class="center"><?php echo $valor["stock_previo"] ?></td>
            <td class="center"><?php echo $valor["stock"] ?></td>
            <td class="center"><?php if(((int)$valor['diferencia']) < 0){echo '<b style="color:red">'.$valor["diferencia"].'</b>';}else{echo '<b style="color:green">'.$valor["diferencia"].'</b>';}   ?></td>
        </tr>
         <?php } ?>	
      </tbody>
    </table> 
  </div>
</div>


<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
      "order": [[ 1, "desc" ]],
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
});
</script>