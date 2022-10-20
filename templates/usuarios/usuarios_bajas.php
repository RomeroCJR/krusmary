<?php
require('../../recursos/conexion.php');

// $_SESSION['filas'] = array(); 
//CONSULTA OBTENER DATOS DE USUARIOS
$Sql = "SELECT a.cod_usuario AS id, a.ci_usuario as ci, a.nombre_usuario AS nombre, a.ap_paterno_usuario AS ap_paterno, a.ap_materno_usuario AS ap_materno, CONCAT(a.ap_paterno_usuario,' ',a.ap_materno_usuario) AS apellidos, a.nro_celular_usuario AS telefono, a.correo_usuario AS email, b.cod_rol AS codrol, c.nombre_rol AS rol, d.login, d.clave AS passw FROM `usuario` a, `usu_rol` b, `rol` c, `datos` d WHERE a.cod_usuario = b.cod_usuario AND c.cod_rol = b.cod_rol AND d.cod_usuario = a.cod_usuario AND a.estado_usuario = 0;"; 
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
    width: 35%
  }
  #modal3{
    max-height: 90% !important;
    margin-top: -3%;
  }
  #perf_f{
    height: 20em;
  }
</style>


<div class="row" style="margin-top:20px;">
  <div class="col s4 offset-s8">
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



<div class="row">
    <div class="col s12 m12 l12">
        <table id="tabla1" class="content-table">
            <thead>
                <tr>
                    <th>Ci</th>
                    <th>Nombre</th>
                    <th>Nro Celular</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="center" width="15%">Dar de alta</th>

                </tr>          
            </thead>
            <tbody>
                <?php foreach($fila as $a  => $valor){ ?>
                <tr>
                    <td><?php echo $valor["ci"] ?></td>
                    <td><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
                    <td><?php echo $valor["telefono"] ?></td>
                    <td><?php echo $valor["email"] ?></td>
                    <td align="center"><?php echo $valor["rol"] ?></td>
                    <td width="25%" class="center">
                        <a href="#modal1" onclick="$('#restaurar_id').val('<?php echo $valor['id'] ?>')" class="btn-small btn-floating modal-trigger"><i class="material-icons">restore_from_trash</i></a>
                    </td>
                </tr>
                <?php } ?>	
            </tbody>
        </table> 
    </div>
</div>


<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Dar de alta usuario:</h4>
    <p>Se dará de alta al usuario seleccionado.</p>
    <input type="text" id="restaurar_id" hidden>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
    <a href="#!" onclick ="restaurar_id()" class="waves-effect waves-green btn-flat">Aceptar</a>
  </div>
</div>




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

function restaurar_id() {
    var id = document.getElementById("restaurar_id").value
    fetch('recursos/usuarios/restaurar_usuario.php?id='+id)
    .then(response => response.text())
    .then(data => {
        if(data == '1'){
            M.toast({html: 'Usuario dado de alta con éxito.'})
            $("#cuerpo").load("templates/usuarios/usuarios_bajas.php");
        }
        console.log(data);
    })
}


document.getElementsByClassName('radios')[0].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[0].value)
  $("#cuerpo").load("templates/usuarios/usuarios.php");
})


</script>