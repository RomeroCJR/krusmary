 <?php
  require('../../recursos/conexion.php');

  // $_SESSION['filas'] = array(); 
  $Sql = "SELECT a.*, b.nombre_categoria, c.stock FROM producto a, categoria b, inventario c WHERE a.cod_producto = c.cod_producto AND a.cod_categoria = b.cod_categoria AND estado_producto = 1"; 
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
  <div class="col s4">
      <a class="waves-effect waves-light btn-large orange darken-4 modal-trigger rubik" id="modal_nuevo_producto" href="#modal1"><i class="material-icons left">add</i><b>Producto</b></a>
  </div>

  <div class="col s4 offset-s4">
    <div class="right">  
      <p>
        <label>
          <input name="group1" class="radios" value="1" type="radio" checked />
          <span>Altas</span>
        </label>

        <label>
          <input name="group1"  class="radios" value="2" type="radio" />
          <span>Bajas</span>
        </label>
      </p>
    </div>
  </div>
</div>



<!-- Modal nuevo plato -->
  <div id="modal1" class="modal roboto" style="width: 40%">
    <div class="modal-content">
      <h4>Nuevo producto</h4>
      <form id="form_nuevo_producto" action="" method="POST" accept-charset="utf-8">
        
        <div class="file-field input-field col s12">
          <div class="btn">
            <span>Foto</span>
            <input type="file" name="imagen" required>
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>

        <div class="input-field col s7">
          <input id="nombre" name="nombre" type="text" minlength="5" maxlength="25" class="validate" required>
          <label for="nombre">Nombre del plato (*)</label>
        </div>
        <div class="input-field col s4 offset-s1">
          <input id="precio" name="precio" type="text" onkeypress="return checkIt(event)" class="validate" required>
          <label for="precio">Precio (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="descripcion" name="descripcion" type="text" minlength="5" maxlength="50" class="validate" required>
          <label for="descripcion">Descripción </label>
        </div>
        <div class="input-field col s12">
          <!-- <label>Browser Select</label> -->
          <select class="browser-default" name="categoria" required>
            <option value="" disabled selected>Selecciona una categoría</option>
            <?php foreach ($cat as $key => $x) { ?>
              <option value="<?php echo $x['cod_categoria']; ?>"><?php echo $x['nombre_categoria']; ?></option>;
            <?php } ?>
          </select>
        </div>
      </form>
    </div>

    <div class="modal-footer">
      <button class="btn waves-effect waves-light" form="form_nuevo_producto" type="submit" name="acceso">Guardar</button>
      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    </div>
  </div>


  <!-- Modal modificar plato -->
  <div id="modal2" class="modal" style="width: 30%">
    <div class="modal-content">
      <h5><b>Modificar plato</b></h5>
      <form id="form_mod_producto" action="" method="POST" accept-charset="utf-8">
        
        <div class="file-field input-field col s12">
          <div class="btn">
            <span>Foto</span>
            <input type="file" name="imagen">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
          <input type="text" id="old_pic" name="old_pic" hidden>
        </div>

        <div class="input-field col s7">
          <input type="text" id="mod_codpro" name="mod_codpro" hidden>
          <input id="mod_nombre" name="mod_nombre" type="text" minlength="5" maxlength="25" class="validate" required>
          <label for="mod_nombre">Nombre del plato (*)</label>
        </div>
        <div class="input-field col s4 offset-s1">
          <input id="mod_precio" name="mod_precio" type="text" onkeypress="return checkIt(event)" class="validate" required>
          <label for="mod_precio">Precio (*)</label>
        </div>
        <div class="input-field col s12">
          <input id="mod_descripcion" name="mod_descripcion" type="text" minlength="5" maxlength="100" class="validate" required>
          <label for="mod_descripcion">Descripción </label>
        </div>
        <div class="input-field col s12">
          <select class="browser-default" id="mod_categoria" name="mod_categoria" required>

          </select>
        </div>

      </form>
    </div>

    <div class="modal-footer">
      <button class="btn waves-effect waves-light" form="form_mod_producto" type="submit" name="acceso">Guardar</button>
      <a href="#!" class=" modal-action modal-close waves-effect waves-red btn red left">Cancelar</a>
    </div>
  </div>

  <!-- Modal borrar plato -->
  <div id="modal3" class="modal">
    <div class="modal-content">
      <input type="text" id="borr_codp" hidden>
      <h5><b>Se dará de baja el producto:</b></h5>
      <p id="borr_nombre" class="marginless"></p>
      <p id="borr_precio" class="marginless"></p>
    </div>

    <div class="modal-footer">
      <button class="btn waves-effect waves-light right" onclick="eliminar_producto()">Eliminar</button>
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
            <th class="center">Stock</th> 
            <th class="center">Descripción</th>
            <th class="center">Acciones</th>
         </tr>          
      </thead>
      <tbody>
      	 <?php foreach($fila as $a  => $valor){ ?>
         <tr loadin="lazy">
            <td class="center"><img loading="lazy" src="<?php echo $valor['foto_producto'] ?>" height="50px"></td>
            <td class="center"><?php echo $valor["nombre_producto"] ?></td>
            <td class="center"><?php echo $valor["precio_producto"] ?></td>
            <td class="center"><?php echo $valor["stock"] ?></td>
            <td class="center"><?php echo $valor["descripcion_producto"] ?></td>
            <td class="center"><a href="#!" class="btn-small btn-floating " onclick="mod_producto(`<?php echo $valor['cod_producto']?>`, `<?php echo $valor['nombre_producto']?>`, `<?php echo $valor['precio_producto']?>`, `<?php echo $valor['descripcion_producto']?>`, `<?php echo $valor['foto_producto']?>`, `<?php echo $valor['cod_categoria']?>`, `<?php echo $valor['nombre_categoria']?>`)"><i class="material-icons">build</i></a>
            <a href="#!" class="btn-small btn-floating" onclick="borrar_producto('<?php echo $valor['cod_producto'] ?>', '<?php echo $valor['nombre_producto'] ?>', '<?php echo $valor['precio_producto'] ?>', '<?php echo $valor['foto_producto'] ?>');"><i class="material-icons">delete</i></a>
            <a href="#" onclick="vpro('<?php echo $valor['nombre_producto'] ?>', '<?php echo $valor['precio_producto'] ?>', '<?php echo $valor['descripcion_producto'] ?>', '<?php echo $valor['foto_producto'] ?>');" class="btn-small btn-floating"><i class="material-icons">search</i></a></td>
         </tr>
         <?php } ?>	
      </tbody>
    </table> 
  </div>
</div>

<div class="modal width_modal_ver" id="modal4">
  <div class="modal-content">
        <div >
            <center><img style="width:45%;"  id="_foto" src="" ></center>
        </div>

    <div class="row">
      <div class="col s12" >
        <h6 style="line-height: 0.3;"><p id="__nombre"></p></h6>
        <h6 style="line-height: 0.3;"><p id="__precio"></p></h6>
        <h6 style="line-height: 0.3;"><p id="__descripcion"></p></h6>
        
      </div>
    </div>
    
  </div>
  <div class="modal-footer">
    <a class="waves-effect modal-action modal-close waves-light btn right">Aceptar</a>
  </div>
</div>


<!--MODAL PARA RECIBIR MENSAJES DESDE PHP-->  
    <div id="mensaje" ></div>

<script>
var mensaje = $("#mensaje");
mensaje.hide();

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
    document.getElementById('div_regresar').hidden = true;
});

document.getElementById("form_nuevo_producto").addEventListener('submit', function(e) {
  e.preventDefault();
  var formData = new FormData(document.getElementById("form_nuevo_producto"));

  fetch("recursos/productos/nuevo_producto.php", {method:'post', body:formData})
  .then(response => response.text())
  .then(data => {
    console.log(data);
    if (data == '1') {
      $("#modal1").modal("close"); 
      M.toast({html: "Nuevo producto agregado."});
      $("#cuerpo").load("templates/productos/productos.php");
    }else{
      console.log(data);
    }
  })
  
});

function mod_producto (id, nombre, precio, descripcion, foto, categoria, nombre_categoria){
  // console.log(id, nombre, precio, descripcion)
  $("#mod_codpro").val(id)
  $("#mod_nombre").val(nombre)
  $("#mod_precio").val(precio)
  $("#mod_descripcion").val(descripcion)
  $("#old_pic").val(foto)

  fetch(`recursos/productos/get_categoria.php?id=${categoria}`)
  .then(response => response.json())
  .then(data => {
    var myhtml = "";
    data.forEach(element => {
      myhtml = myhtml+`<option value="${element.cod_categoria}">${element.nombre_categoria}</option>`
    });

    document.getElementById('mod_categoria').innerHTML = `<option value="${categoria}" selected>${nombre_categoria}</option>`+myhtml;
    M.updateTextFields()
    $("#modal2").modal('open')
  })
 
}




document.getElementById('form_mod_producto').addEventListener('submit', function(e) {
  e.preventDefault();
  var formData = new FormData(document.getElementById("form_mod_producto"));

  fetch("recursos/productos/mod_producto.php", {method:'post', body:formData})
  .then(response => response.text())
  .then(data => {
    if (data == '1') {
      $("#modal2").modal("close"); 
      M.toast({html: "Datos de plato modificados."});
      $("#cuerpo").load("templates/productos/productos.php");
    }else{
      console.log(data);
    }
  })

});

function vpro ( nombre, precio, descripcion, foto) {

$("#_foto").attr('src', foto)
$("#__nombre").html(`<b>Nombre: </b>${nombre}`);
$("#__precio").html(`<b>Precio(Bs): </b>${precio}`);
$("#__descripcion").html(`<b>Descripcion: </b>${descripcion}`);
$("#__foto").html(`<b>Foto: </b>${foto}`);
$("#modal4").modal('open');
}

function borrar_producto (codpro, nombre, precio){
  $("#borr_codp").val(codpro)
  $("#borr_nombre").html('<b>Producto: </b>'+nombre)
  $("#borr_precio").html('<b>Precio: </b>'+precio)
  // $("#borr_foto")
  $("#modal3").modal('open')
}

function eliminar_producto() {

  let codpro = document.getElementById('borr_codp').value;
  fetch("recursos/productos/eliminar_producto.php?codpro="+codpro)
  .then(response => response.text())
  .then(data => {
    console.log(data)
    if (data == 1) {
      M.toast({html: 'Producto dado de baja.'})
      $("#cuerpo").load('templates/productos/productos.php')
    }
  })

}

document.getElementsByClassName('radios')[1].addEventListener('click', ()=> {
  console.log(document.getElementsByName('group1')[1].value)
  $("#cuerpo").load("templates/productos/productos_bajas.php");
})

</script>