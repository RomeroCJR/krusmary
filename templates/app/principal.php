<?php
	require('recursos/conexion.php');
    

	$mes_actual = date("Y-m");

    $Sql = "SELECT a.cod_producto, a.nombre_producto, a.precio_producto, a.descripcion_producto, a.foto_producto, d.stock, (SELECT IF (SUM(b.cant_producto)>0, SUM(b.cant_producto),0) FROM detalle_venta b, venta c WHERE a.cod_producto = b.cod_producto AND b.cod_venta = c.cod_venta AND c.fecha_venta LIKE '%".$mes_actual."%' AND b.estado_det_venta = 1) as cantidad, a.cod_categoria FROM producto a, inventario d WHERE a.cod_producto = d.cod_producto AND a.estado_producto = 1 GROUP BY a.cod_producto ORDER BY cantidad DESC";
    $Busq = $conexion->query($Sql);
	$fila = $Busq->fetch_all(MYSQLI_ASSOC);

	$result2 = $conexion->query("SELECT * FROM categoria WHERE estado_categoria = 1");
	$result2 = $result2->fetch_all(MYSQLI_ASSOC);

    $Sql2 = "SELECT cod_cliente, ci_cliente, nombre_cliente, ap_paterno_cliente, ap_materno_cliente, nro_celular_cliente FROM cliente WHERE estado_cliente = 1";
    $Busq2 = $conexion->query($Sql2);
	$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="ES">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="icon" type="image/x-icon" href="images/logo.png" />
		<link rel="stylesheet" type="text/css" href="css/style.css">
    	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    	<link rel="stylesheet" href="css/jquery.nice-number.css">
		<!-- <link rel="stylesheet" href="css/materialize.css"> -->
		<script src="js/jquery-3.0.0.min.js"></script>
		<!-- <script src="js/materialize.js"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<!-- <script src="js/maps.js"></script> -->
		<!-- <script async defer -->
		<!-- src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN0x9mkyg_9x41m82iSIQvJ8M9vo7fXm4&callback=initMap"> -->
		<!-- </script> -->
		<script src="js/jquery.nice-number.js"></script>
		<!-- <script src="js/firebase.js" ></script> -->
		
		<title>Bienvenido</title>
	</head>
	<style>
		#cont_foto{
			height:40%;
			width: 100%;
			/* display:flex; */
			/* flex-direction: column; */
		}
		#conf_foto{

		}
		.contenedor-detalles{
			/* margin-top:20px; */
			padding-top:20px;
			/* padding-bottom: 20px; */

			height:55%;
			width:100%;
			display: flex;
			flex-direction: column;
			justify-content: space-between;

		}
		.card_detalle{
			display:flex;
			flex-direction: column;
			justify-content: center;
			padding: 20px 10px 20px 10px;	
		}

		
.card__pad p {
    margin: 0;
    /* font-weight: bolder; */
}

.card__pad{
    padding:  12px;

}
.card__img{
    width: 96px ;
    height: 96px ;
}
.img__card{
    min-width: 100%;
    min-height: 100%;
    max-height: 100%;
    max-width: 100%;

}

.p_card__pad{
    padding:  12px;
    cursor: pointer;
}
.p_card__img{
    width: 96px ;
    height: 96px ;
}
.p_img__card{
    min-width: 100%;
    min-height: 100%;
    max-height: 100%;
    max-width: 100%;
    border-radius: 25%;
}

.img__card{
	max-height: 187.85px;
}
.card{
	max-height: 275px;
	height: 275px;
	min-height: 275px;
	cursor: pointer;
}

@media only screen and (max-width : 992px) {
	.modal{
		width:100% !important;
	}
	.img__card{
		max-height: 134.783px;
	}
	.card{
		max-height: 220.283px;
		height: 220.283px;
		min-height: 220.283px;
	}
	
}

.card-content{
	padding-top: 5px !important;
	padding-left: 10px !important;
	padding-right: 10px !important;
	padding-bottom: 20px !important;
}
.card-title{
	/*padding-left: 0px !important;*/
	/*padding-right: 0px !important;*/
	margin-bottom: 0px !important;

}
.capit { 
	text-transform: capitalize;
} 
.card_title{
	background-color: #424242; 
	color: #FFF; 
	text-align: center; 
	line-height: 1;
}
.modal_title{
	background-color: #424242; 
	color:white; 
	text-align: center; 
	line-height: 1;
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
}
.modal_title h5{
	margin: 5px 0;
}
.card:hover{
	transform:  scale(1.03);
	box-shadow: 4px 4px 8px 2px rgba(0,0,0,0.4);
}
	</style>
	<body>
		<nav style="background: rgba(255, 255, 255, 0.5); ">
			<div class="nav-wrapper">
				<a href="#" id="menu_triger" data-target="slide-out" class="sidenav-trigger show-on-large" style="color:black"><i class="material-icons">menu</i></a>
				<a href="#" style="margin-left: 10px;" id="cart_return" class="black-text left" onclick="regresar_prod()" hidden><i class="material-icons">keyboard_return</i></a>
		    	<a href="#" class="brand-logo center ubuntu hide-on-med-and-down" style="color:#424242"><img src="images/logo.png" height="55" style="margin-top: 5px;" alt="Repostería KrusMary" class="left"><span>Repostería KRUS-MARY</span><img src="images/logo.png" height="55" style="margin-top: 5px;" alt="Repostería KrusMary" class="right"></a>
				<a href="#" class="brand-logo center ubuntu hide-on-large-only" ><img src="images/logo.png" height="55" style="margin-top: 5px;" alt="Repostería KrusMary" ></a>
		    
			</div>
		</nav>
		<div id="toggle_sidebar" class="get_out">
			<!-- <a href="#" data-target="slide-out" class="sidenav-trigger btn-large waves-effect waves-light"><i class="material-icons">menu</i></a> -->
		</div>

			

		<!-- <div class="hide-on-med-and-up center row" id="top-menu" style="padding: 5px; background-color: #6c5ce7; cursor: pointer" onclick="direrc();">
				<div class="col s4 offset-s4"><p>MIS PEDIDOS</p><i class="material-icons">assignment</i></div>
		</div> -->
			
		

		<!-- <div class="get_out hide-on-small-only"><a href="recursos/app/salir.php" style="background-color: #e74c3c;" class="btn-large waves-light">Salir<i class="material-icons right">logout</i></a></div> -->
		<!-- <div class="ver_ped hide-on-small-only"><a href="templates/app/rev_pedido.php" style="background-color: #6c5ce7;" class="btn-large waves-light">mi pedido<i class="material-icons right">assignment</i></a></div> -->



		<ul id="slide-out" class="sidenav rubik">
			<li>
				<div class="user-view">
					<div class="background">
						<img src="images/fondo2.png" width="100%">
					</div>
					<div><center><a href="#user"><img class="circle"  src="images/logo.png"></a></center></div>
					<div><center><a href="#name"><span class="black-text name"><b>Repostería KRUS-MARY</b></span></a></center></div>
					<div><center><a href="#email"><span class="black-text email"><b>krusmary@gmail.com</b></span></a></center></div>
				</div>
			</li>
				<li><a href="#!" onclick="location.reload()" class="waves-effect waves-purple"><i class="material-icons">home</i>Inicio</a></li>
				<li><a href="#!" onclick="sidenav_navi('templates/app/catalogo.php')" class="waves-effect waves-purple"><i class="material-icons">cake</i>Catálogo</a></li>
				<li><a href="#!" onclick="sidenav_navi('templates/app/perfil.php')" class="waves-effect waves-purple"><i class="material-icons">face</i>Mi perfil</a></li>
				<li><a href="#!" onclick="sidenav_navi('templates/app/rev_pedido.php')" class="waves-effect waves-purple"><i class="material-icons">assignment</i>Mi pedido</a></li>

				<li>
					<!-- <div class="divider"></div> -->
				</li>

			<li>
				<!-- <a class="waves-effect waves-red" href="recursos/app/salir.php"><i class="material-icons">logout</i>Salir</a> -->
			</li>
		</ul>

	<div id="cuerpo" class="container">



	</div>
	
	<div id="mensaje"></div>

	</body>
</html>

	<script>
	
	$(document).ready(function() {
		$('.modal').modal();
		

		$('.sidenav').sidenav();

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

	


	
		var mensaje = $("#mensaje");
		mensaje.hide();


	function sidenav_navi(link) {
		var elem = document.getElementById('slide-out')
		M.Sidenav.getInstance(elem).close()
		$('#cuerpo').load(link)

	}


	</script>


<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
