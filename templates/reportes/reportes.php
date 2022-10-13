<?php 
  date_default_timezone_set("America/La_Paz");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }

  /*.fijo{
    border-style: solid;
    border-color: red;
  }*/
  .auto-imagen{
    padding:  1px;
    border: 4px solid transparent;
    background: linear-gradient(60deg, #afafaf 10%, #4e4e4e 100%);
    width: 80%;
    height:  250px;
  }
  .vert{
    /*vertical-align: center;*/
/*    position: relative;
    top: 100%;*/
    padding-top: 150px;
  }

  </style>
</head>
<body>

<div class="container vert">
  <div class="row">
    <div class="col s8 offset-s2">

      <div class="col s12">
          <div class="input-field">
              <select name="tipo_reporte" id="tipo_reporte">
                <option value="r_ventas.php" selected><b>Reportes de ventas</b></option>
                <!-- <option value="r_compras.php" ><b>Reportes de pedidos</b></option> -->
                <option value="r_productos.php"><b>Reporte de productos</b></option>
                <option value="r_gastos.php"><b>Reporte de ingresos y gastos</b></option>
                <!-- <option value="r_le.php"><b>Reportes de Lider/Experta</b></option> -->
                <!-- <option value="r_dev.php" ><b>Reportes de devoluciones</b></option> -->
              </select>
              <label><b>Seleccione el tipo de reporte</b></label>
          </div>
      </div>

      <div class="col s12">
        <!-- <form action="recursos/redireccionador.php" method="post" class="col s12" id="ffecha"> -->
            <div class="input-field">
                <select name="gestion" id="gestion">
                  <option value="2021"  '<?php if(date("Y") == "2021"){echo "selected";} ?>'><b>2021</b></option>
                  <option value="2022"  '<?php if(date("Y") == "2022"){echo "selected";} ?>'><b>2022</b></option>
                  <option value="2023"  '<?php if(date("Y") == "2023"){echo "selected";} ?>'><b>2023</b></option>
                  <option value="2024"  '<?php if(date("Y") == "2024"){echo "selected";} ?>'><b>2024</b></option>
                  <option value="2025"  '<?php if(date("Y") == "2025"){echo "selected";} ?>'><b>2025</b></option>
                </select>
                <label><b>Seleccione la gestión</b></label>
            </div>
            <!-- <input type="text" name="mes" id="mes" value="" hidden> -->
        <!-- </form> -->
      </div>

      <div class="col s12">
            <div class="input-field">
                <select name="mes" id="mes">
                  <option value="0" selected>Reporte anual</option>
                  <option value="01"><b>Enero</b></option>
                  <option value="02"><b>Febrero</b></option>
                  <option value="03"><b>Marzo</b></option>
                  <option value="04"><b>Abril</b></option>
                  <option value="05"><b>Mayo</b></option>
                  <option value="06"><b>Junio</b></option>
                  <option value="07"><b>Julio</b></option>
                  <option value="08"><b>Agosto</b></option>
                  <option value="09"><b>Septiembre</b></option>
                  <option value="10"><b>Octubre</b></option>
                  <option value="11"><b>Noviembre</b></option>
                  <option value="12"><b>Diciembre</b></option>
                </select>
                <label><b>Seleccione el mes</b></label>
            </div>
      </div>

      <div class="col s12">
        <!-- <a href="#" onclick="reporte_mes()" class="btn-large blue">Reporte por mes</a> -->
        <a href="#" onclick="reporte_ges()" class="btn-large pink right">Generar reporte</a>
      </div>
    </div>
  </div>
</div>
<!-- <div class="row center">
  <div class="fijo col s4" >
    <a href="#" onclick="reporte('1');" >
          
            <img class="z-depth-5 auto-imagen" src="img/periodos/1.png" >

    </a>
  </div>

  <div class="fijo col s4" >
    <a href="#" onclick="reporte('2');" >

            <img class="z-depth-5 auto-imagen" src="img/periodos/2.png" >

    </a>
  </div>


  <div class="fijo col s4" >
    <a href="#" onclick="reporte('3');" >

            <img class="z-depth-5 auto-imagen" src="img/periodos/3.png" >

    </a>
  </div>
</div>

<div class="row center">
  <div class="fijo col s4" >
    <a href="#" onclick="reporte('4');" >

          <img class="z-depth-5 auto-imagen" src="img/periodos/4.png" >

    </a>
  </div>

  <div class="fijo col s4" >
    <a href="#" onclick="reporte('5');" >

          <img class="z-depth-5 auto-imagen" src="img/periodos/5.png" >

    </a>
  </div>

  <div class="fijo col s4" >
    <a href="#" onclick="reporte('6');" >

          <img class="z-depth-5 auto-imagen" src="img/periodos/6.png" >

    </a>
  </div>
</div> -->


<!--            <div class="modal-footer">
                <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
            -->


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

var mensaje = $("#mensaje");
mensaje.hide();


  $(document).ready(function() {
    // $('select').material_select();
    $('select').formSelect();
  });

//reporte por periodo y gestión
function reporte(periodo) {
   gestion = document.getElementById('gestion').value
   tipo = document.getElementById('tipo_reporte').value
   console.log("templates/reportes/"+tipo+"?ges="+gestion+"&per="+periodo)
   $("#cuerpo").load("templates/reportes/"+tipo+"?ges="+gestion+"&per="+periodo)
}
//reporte anual
function reporte_ges(){
  let per = $("#mes").val()
  gestion = document.getElementById('gestion').value
  tipo = document.getElementById('tipo_reporte').value

  // console.log(per, gestion, tipo)
  $("#cuerpo").load("templates/reportes/"+tipo+"?ges="+gestion+"&per="+per)
}

</script>
</body>
</html>