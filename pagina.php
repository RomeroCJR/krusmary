<?php
require('recursos/conexion.php');
require('recursos/sesiones.php');
session_start();
//Comprobamos si el usario está logueado
//Si no lo está, se le redirecciona al index
//Si lo está, definimos el botón de cerrar sesión y la duración de la sesión
// $sp = $_GET['sp'];
if(!isset($_SESSION['user']) and $_SESSION['estado'] != 'Autenticado') {
  header('Location: index.php');
} else {
  $estado = $_SESSION['Nombre']." ".$_SESSION['Apellidos'];
  $ciactual = $_SESSION['Ci_Usuario'];
  $rol = $_SESSION['rol'];
  $salir = '<a href="recursos/salir.php" class="right" target="_self">Cerrar sesión</a>';
};

$Sql = "SELECT * FROM usuario";
$Busq = $conexion->query($Sql);
?>


<!DOCTYPE html>
<html lang="ES">
  <head>
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" type="text/css" href="css/index.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="css/datatable.css"> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="icon" type="image/x-icon" href="img/icono.ico" />
    <!-- <link rel="stylesheet" type="text/css" href="css/sidebar.css"> -->
    <link rel="stylesheet" type="text/css" href="css/style_sys.css">
    <link rel="stylesheet" href="css/jquery.nice-number.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="css/materialize.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <!-- Compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="js/jquery-3.0.0.min.js"></script> -->
    

    <!-- <script src="js/materialize.js"></script> -->
    <!-- <script src="js/datatable.js"></script> -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="css/buttons.dataTables.css"/>
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/dataTables.buttons.js"></script>

    <!-- <script type="text/javascript" src="js/jszip.js"></script> -->
    <!-- <script type="text/javascript" src="js/pdfmake.js"></script> -->
    <script type="text/javascript" src="js/vfs_fonts.js"></script>
    <script type="text/javascript" src="js/buttons.print.js"></script>
    <script type="text/javascript" src="js/buttons.html5.js"></script>
    <script src="js/num2text.js"></script>
    <script src="js/jsPDF.min.js"></script>
    <script src="js/jquery.nice-number.js"></script>
    
    <!-- <script async defer -->
    <!-- src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN0x9mkyg_9x41m82iSIQvJ8M9vo7fXm4"> -->
    <!-- </script> -->
    
    <title> RCR. Delicias Express., Número de teléfono(s): 76191403, E-mail: rcrdelex@hotmail.com</title>
    <style>
    .fuente{
    font-family: 'Segoe UI Light';

    }
    .close{
      position: relative; 
      color: #b2bec3; 
      text-decoration: none;
    }
    .close i{
      font-size: 2em;
    }

    nav ul a:hover {
    background-color: rgba(0, 0, 0, 0.2) !important;
    /*font-size: 120%;*/
    }
    .mg{
      /*margin-top: -20px;*/
      /*vertical-align: middle;*/

      /*padding-bottom: 10px;*/
    }
    
    /*#mobile-demo{*/
    /*width: 280px;*/
    /*}*/
    li a{
    color: white !important;
    /*font-size: 14px;*/
    }
    /*header, body, footer {*/
    /*padding-left: 280px;*/
    /*}*/
    /* @media only screen and (max-width : 992px) {
      .sidebar{
        visibility: hidden;
      }
    } */
    /* @media only screen and (max-width : 1500px) and (min-width : 992px){
      #cuerpo {
        margin-left:  250px;
      }
    } */
 /*   #mobile-demo{
    overflow-y: hidden;
    }*/
    .material-icons-outlined{
      display: inline-flex;
      vertical-align: top;
    }
    .width-modal{
      width: 25%;
    }
    .texto-blanco, .texto-blanco li>a{
      color: black !important;
      font-family: rubik;
      font-weight: bold;
    }
    .left_pos{
      position:absolute;
      left: 20px;
      top:20px;
      z-index: 9999;
    }
    .circle{
      height:64px;
      width:auto !important;
    }
    </style>
  </head>
  <body>
  <!-- <div class="left_pos"> -->
    <!-- </div>    -->
  <div class="nav_container ">
	<nav class="teal lighten-2">
		<div class="nav-wrapper">  
      <div id="div_regresar" hidden><a href="#!" id="regresar" style="margin-left:15px" class="brand-logo left" ><i class="material-icons">keyboard_return</i></a></div>
			<a href="#" id="menu" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
			<a href="#" id="titulo" class="brand-logo center fuente">Repostería Krusmary </a>
			<ul class="right hide-on-med-and-down">
          <li><?php echo $estado; ?></li>
          <li><?php echo $salir; ?></li>
        </ul>
		</div>
	</nav>

	<ul id="slide-out" class="sidenav sidenav-fixed roboto blue-grey lighten-4" >
	    <li>
	    	<div class="user-view">
		      <div class="background">
		        <img src="images/fondo1.jpg" height="100%" width="100%">
		      </div>
		      <div><center><a href="#user"><img class="circle" src="images/logo.png"></a></center></div>
              <a href="#name"><span class=" name"><b><?php echo $_SESSION['estado']?></b></span></a>
              <a href="#email"><span class=" email"><b><?php echo "CI: ".$_SESSION['Ci_Usuario']?></b></span></a>
        </div>
        
	  	</li>
	  	<div class="texto-blanco">
        <li><a href="#!" onclick="cargar('templates/inicio/inicio');" class="waves-effect waves-teal"><i class="material-icons-outlined">home</i>Inicio</a></li>
        <li><a href="#!" onclick="cargar('templates/ventas/ventas');" class="waves-effect waves-teal"><i class="material-icons-outlined">shopping_cart</i>Ventas</a></li>
		    <li><a href="#!" onclick="cargar('templates/productos/productos');" class="waves-effect waves-teal"><i class="material-icons-outlined">cake</i>Productos</a></li>
        <li><a href="#!" onclick="cargar('templates/categorias/categorias');" class="waves-effect waves-teal"><i class="material-icons-outlined">category</i>Categorias</a></li>
        <li><a href="#!" onclick="cargar('templates/pedidos/pedidos');" class="waves-effect waves-teal"><i class="material-icons-outlined">receipt</i>Pedidos</a></li>
        <li><div class="divider grey darken-3"></div></li>
        
        <ul class="collapsible">
            <li >
                <div class="collapsible-header waves-effect waves-teal texto-blanco" ><i class="material-icons-outlined" >admin_panel_settings</i>Administración</div>
                <div class="collapsible-body blue-grey lighten-5">
                  <ul>
                    <li><a href="#!" onclick="cargar('templates/usuarios/usuarios');"><i class="material-icons-outlined">people</i> Usuarios</a></li>
                    <li><a href="#!" onclick="cargar('templates/clientes/clientes');"><i class="material-icons-outlined">airline_seat_recline_normal</i> Clientes</a></li>
                    <li><a href="#!" onclick="cargar('templates/roles/roles');"><i class="material-icons-outlined">switch_account</i> Roles</a></li>
                    <li><a href="#!" onclick="cargar('templates/facturas/facturacion');"><i class="material-icons-outlined">receipt</i> Facturación</a></li>
                    <li><a href="#!" onclick="cargar('templates/reportes/reportes');"><i class="material-icons-outlined">assignment</i> Reportes</a></li>
                  </ul>
                </div>
            </li>
        </ul>
		    <!-- <li><a class="subheader"></a></li> -->
		    <li><a class="waves-effect" href="recursos/catalogos/salir.php"><i class="material-icons">logout</i>Cerrar sesión</a></li>
        <li>
          <a href="#modal_gasto" class="waves-effect waves-light btn modal-trigger light-blue darken-1"><i class=""><img width="50px" src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-money-finance-kiranshastry-lineal-kiranshastry-3.png"/></i>Nuevo gasto</a>
        </li>
      </div>
	</ul>

</div>

    <div id="modal_gasto" class="modal width-modal" >
      <div class="modal-content">
        <center><h5 class="roboto">Gasto diario:</h5></center>
        <p id="title_spend" class="roboto"></p>
        <div class="input-field">
          <input type="text" mame="gasto" maxlength="5" minlength="1" onkeypress="return checkIt(event)" id="gasto" value="" >
          <label for="gasto">Gasto diario</label>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" id="enviar_gasto" class="waves-effect waves-green btn">Aceptar</a>
      </div>
    </div>

    <!-- <div class="container"> -->
      <div class="row">
        <div id="cuerpo" class="col s12">
          
        </div>
      </div>
    <!-- </div> -->



  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var options = {preventScrolling: true}
      var elems = document.querySelectorAll('.sidenav');
      var instances = M.Sidenav.init(elems, options);

      var elems = document.querySelectorAll('.collapsible');
      var instances = M.Collapsible.init(elems);
    });

    $(document).ready(function() {
      let fecha = new Date();
      
      $('.modal').modal();
      $("#modal_gasto").modal({'dismissible':false});

      $.ajax({
        url: "recursos/stock/check_spend.php",
        method: "GET",
        success: function(response) {
            if (response == '0') {
              $("#modal_gasto").modal('open');
            }else{
              $("#gasto").val(response)
            }
        },
        error: function(error) {
            console.log(error)
        }
      })

      
      $("#title_spend").html("Fecha: "+fecha.getDate()+"-"+(fecha.getMonth()+1)+"-"+fecha.getFullYear())

      // DAILY_STOCK
      const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
      let actual = fecha.getFullYear()+"-"+(fecha.getMonth()+1);
      let year = fecha.getFullYear();
      let per = months[fecha.getMonth()];
      $("#cuerpo").load("templates/inicio/daily_stock.php?mes="+actual+"&year="+year+"&per="+per);
      //END DAILY_STOCK

    });
    

    $("#enviar_gasto").click(function (e) {
      let gasto = $("#gasto").val()
      if( !$("#gasto").val() ) {
        return M.toast({html: "Inserte un monto válido."})
      }
      $.ajax({
        url: "recursos/stock/daily_spend.php?spend="+gasto,
        method: "GET",
        success: function(response) {
            if (response == '1') {
              M.toast({html: "Gasto diario agregado."})
              $("#modal_gasto").modal('close')
            }
        },
        error: function(error) {
            console.log(error)
        }
      })
    })

      //controlar overflow de la sidenav
    function overhid () {$("#mobile-demo").css('overflow', 'auto');}
    function overshow () {$("#mobile-demo").css('overflow', 'hidden');}

    function cargar(x){
      var y=".php";
      $("#cuerpo").load(x+y);
    }

    function check(e){
      if ((e.charCode >= 48 && e.charCode <= 57) || e.charCode == 46) {
        return true
      }else{
        return false
      }
    }

    //Funcion para validación de solo números.
    function checkIt(evt) {
      // console.log(evt.keyCode)
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      
      if(charCode == 46){
        status = "";
        return true;
      }
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {

        status = "Este campo acepta números solamente.";
        return false;
      }
      status = "";
      return true;
    }

    function checkText(e) {
      // console.log(e.key)
      var regex = /^[a-zA-Z áéíóúÁÉÍÓÚñ@]+$/;
      if (regex.test(e.key) !== true){
        // e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-Z áéíóúÁÉÍÓÚ@]+/, '');
        return false
      }
    }
  </script>
      
  </body>
</html>
