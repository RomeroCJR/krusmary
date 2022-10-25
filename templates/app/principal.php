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

			<div class="row" id="cards_row">
				<div class="col s12 m12 l12 xl12">
					<h5 class="ubuntu" >Nuestro catálogo de productos disponibles:</h5>
					<?php foreach ($result2 as $val): ?>
					<div class="row">
						<div class="col s12 center"><h4 class="ubuntu"><?php echo $val['nombre_categoria']; ?></h4></div>
						<!-- <hr style="color:aquamarine"> -->
						<?php foreach ($fila as $valor): ?>
							<?php if($val['cod_categoria'] == $valor['cod_categoria']): ?>
								<!-- antes era s12 m6 l6 xl6 -->
								<div class="col s6 m3" loading="lazy" onclick="cantidad_prod('<?php echo $valor['cod_producto'] ?>','<?php echo $valor['nombre_producto'] ?>','<?php echo $valor['precio_producto'] ?>','<?php echo $valor['foto_producto'] ?>', '<?php echo $valor['cantidad'] ?>', '<?php echo $valor['stock'] ?>', '<?php echo $valor['cod_categoria'] ?>')">
									<div class="card">
										<div class="card_title">
											<span class="card-title ubuntu"><small><?php echo $valor['nombre_producto'] ?></small></span>
										</div>
										<div class="card-image" >
											<img loading="lazy" class="img__card" src="<?php echo $valor['foto_producto'] ?>" >
											
										</div>
										<div class="card-content">
											<small><p class="ubuntu" style="line-height: 1;"><?php echo ucfirst(strtolower($valor['descripcion_producto']))?></p></small>
											<span style="position: absolute; bottom: 0px;" class="rubik"><small><b><?php echo $valor['precio_producto']." Bs."?></b></small></span>
										</div>
									</div>
								</div>

							<?php endif ?>
						<?php endforeach ?>  
					</div>
					<?php endforeach ?>			
				</div>

			</div>

			<div class="row roboto" id="cart_row" hidden>
				<div class="row get_out">
					<div class="left">
						<!-- <a href="#!" class="btn-large red" onclick="regresar_prod()"><i class="material-icons">keyboard_return</i></a> -->
					</div>
				</div>
				<!-- antes era col s12 m12 l4 xl5 -->
				<div class="col s12 m12 l12" id="div_tabla_pedidos">
					<!-- <div class="col l6 m10 offset-m1 s12"> -->
						<div class="center" style="font-size: 1em;"><span style='font-size:40px;'>&#128722;</span></div>
						<table id="pedidos_cliente" class="content-table centered z-depth-4">
							<thead>
								<tr>
									<th>Producto</th>
									<th>Cantidad</th>
									<th>Precio (Bs.)</th>
									<th>Borrar</th>
								</tr>
							</thead>
							<tbody>
								<td colspan="4">Aún no has agregado ningún producto.</td>
							</tbody>
						</table>

						<hr>
						<div class="row" align="right">
							<!-- <div class="col m6 offset-m6 s4 offset-s6"> -->
								<div class="ubuntu col s12" >
									Subtotal: <label id="total_ped" class="ubuntu" style="color:black;">0.00 Bs</label>
								</div>
							<!-- </div> -->
						</div>
					<!-- </div> -->
				</div>

				<div class="center">
					<a class="waves-effect waves-light btn btn-large pink accent-2" id="btn_modal_cliente">PEDIR</a>
				</div>
			</div>

		<div id="modal2" class="modal modal-fixed-footer" style="width:35%">
			<div id="modal_pedidos" class="modal-content">
				<div class="" id="cont_foto">
					<img id="foto_plato" src="" >
				</div>
				
				<div class="black-text contenedor-detalles" >
					<input type="text" id="current_sell" hidden>
					<input type="text" id="current_stock" hidden>

					<div class="rubik z-depth-1 card_detalle" style="height:30%">
						<div>
							<b>Producto:</b> <span class="right" id="nombre_p" ></span>
						</div>
					</div>
					<div class="rubik z-depth-1 card_detalle" style="height:30%">
						<div>
							<b>Precio:</b><span class="right" id="precio_p" ></span>
						</div>
					</div>

					<div class="rubik z-depth-1 card_detalle" style="height:30%">
						<div>
							<b>Cantidad:</b>	
							<div class="number-container right">
								<!-- <label for="">Cantidad</label> -->
								<input class="browser-default" type="number" name="" id="__cantidad" min="1" max="15" disabled>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="__datosplato" hidden></div>

			<div class="modal-footer">
				<a href="#!" class="left modal-action modal-close waves-effect waves-light btn btn red"><i class="material-icons">close</i></a>
				<a class="waves-effect waves-light btn btn right" onclick="datos_producto();" >Agregar<i class="material-icons right">add_shopping_cart</i></a>
			</div>
		</div>

		<div id="modal_cliente" class="modal ubuntu" style="width:35%"> <!-- arreglar esta wea -->
			<div class="modal-content" id="modal_cliente_content">
				<h5>Por favor ingresa tus datos</h5>
				
				<div class="row">
					<div class="col s12">
					  <form id="form_pedido">
					  	<div class="input-field col s12">
						  <input type="text" id="tot_ped" name="tot_ped" value="" hidden>
						  <input type="text" id="ci" onKeyPress="return checkIt(event)" name="ci" class="validate" required>
						  <label for="ci">Cédula de identidad:</label>
						</div>

						<div class="input-field col s12">
						  <input type="text" id="nombre" name="nombre" class="validate" required>
						  <label for="nombre">Nombre:</label>
						</div>

						<div class="input-field col s12">
						  <input type="text" id="apellidos" name="apellidos" class="validate" required>
						  <label for="apellidos">Apellidos:</label>
						</div>

						<div class="input-field col s12">
						  <input type="text" id="celular" name="celular" onKeyPress="return checkIt(event)" class="validate" required>
						  <label for="celular">Celular:</label>
						</div>

						<div id="torta_personalizada" hidden>

							<div class="input-field col s12" id="div_fototorta" style="margin-bottom:0px">
								<p>
									<label>
										<input type="checkbox" id="check_fototorta" />
										<span>Foto torta (Costo adicional: 30 Bs.)</span>
									</label>
								</p>
							</div>
							<div class="file-field input-field col s12" id="div_imagen" style="margin-top:0px" hidden>
								<div class="btn">
									<span>Foto</span>
									<input type="file" id="imagen-nombre" name="imagen">
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" id="imagen-path" type="text">
								</div>
							</div>

							<div class="input-field col s12" id="div_descripcion_torta" style="margin-bottom:0px">
								<p>
									<label>
										<input type="checkbox" id="check_mensaje_personalizado" />
										<span>Mensaje personalizado en torta:</span>
									</label>
								</p>
							</div>
							<div class="input-field col s12" id="div_mensaje" style="margin-top:0px" hidden>
								<textarea id="dedicatoria" name="dedicatoria" class="materialize-textarea"></textarea>
								<label for="dedicatoria">Ingrese una dedicatoria (Sea explícito por favor):</label>
							</div>

						</div>

					  </form>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="footer_ubi">
				<a href="#!" class="modal-close waves-effect waves-green btn red left">Cancelar</a>
				<button type="submit" form="form_pedido" class="btn waves-effect waves-purple">Aceptar</button>
			</div>
		</div>
	<!-- </div> -->

		

	<!-- PULSE BUTTON SHOP -->
		<div class="fixed-action-btn" id="shop_section">
		  <a id="shop_button" class="btn-floating btn-large red" onclick="shop_modal()">
		    <i class="large material-icons">shopping_cart</i>
		  </a>
		</div>
     
	<!-- MODAL SHOP CART -->
	  <div id="modal3" class="modal">
	    <div class="modal-content">
	      <h4>Modal Header</h4>
	      <p>A bunch of text</p>
	    </div>
	    <div class="modal-footer">
	      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
	    </div>
	  </div>

	</div>
	
	<div id="mensaje"></div>

	</body>
</html>

	<script>
	var total = 0;
	$(document).ready(function() {
		$('.modal').modal();
		$('.fixed-action-btn').floatingActionButton();
		$('input[type="number"]').niceNumber({
			autoSize: true,
			autoSizeBuffer: 1,
			buttonDecrement: "-",
			buttonIncrement: "+",
			buttonPosition: 'around'
		});
		$('.sidenav').sidenav();
		document.getElementById('form_pedido').reset();
	});
	function direrc(){
		window.location.replace("templates/app/rev_pedido.php");
	}
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

	var reg_pedidos = new Array();

	function cantidad_prod(cod, nombre, precio, foto, cantidad, stock, categoria) {
		$("#foto_plato").attr("src", foto);
		$("#nombre_p").html(nombre);
		$("#precio_p").html(precio+" Bs.");
		
		$("#__datosplato").html("<input id='__datosp' cp='"+cod+"' np='"+nombre+"' pp='"+precio+"' fp='"+foto+"' cat='"+categoria+"' hidden/>");


		fetch("recursos/app/check_stock.php?id="+cod)
		.then(response => response.text())
		.then(response => {
			$("#current_sell").val(response)
        	$("#current_stock").val(stock)
        	// console.log(stock, response)
        	if (parseInt(stock) > parseInt(response)) {
        		$("#modal2").modal('open');
        	}else{
        		M.toast({html: "Producto agotado."})
        	}
		})

	}

	function borr_pla(x) {
		delete reg_pedidos[x];
				//borrando tabla
			// $('#pedidos_cliente tr:not(:first-child)').slice(0).remove();
			// var table = $("#pedidos_cliente")[0];
			$("#pedidos_cliente tbody").html("") //limpiar tabla
			var table = $("#pedidos_cliente tbody")[0]; //obtener tabla
			
			total =  0;
			//llenando tabla
			// console.log(reg_pedidos.length, "tamaño del array reg pedidos") // REVISANDO EL ARRAY
			// var json_ped = JSON.parse(JSON.stringify(reg_pedidos))
			// console.log(json_ped)
			reg_pedidos.forEach(function (valor) {
				var row = table.insertRow(-1);
				row.insertCell(0).innerHTML = "<a style='text-decotarion: none; cursor: pointer; color: red' onclick='borr_pla("+valor[0]+")'><i class='material-icons prefix'>delete</i></a>";
				row.insertCell(0).innerHTML = valor[3];
				row.insertCell(0).innerHTML = valor[2];
				row.insertCell(0).innerHTML = valor[1];
				total  = parseFloat(total) + (parseFloat(valor[3])*parseFloat(valor[2]));
			});
			$("#total_ped").html(total +" Bs.");
	}
		
		function datos_producto(){

			// console.log(reg_pedidos.length)

			let c_sell = $("#current_sell").val()
			let c_stock = $("#current_stock").val()
			var cantp = $("#__cantidad").val();
			let disp = parseInt(c_stock) - parseInt(c_sell)

			if (disp < cantp) {
				return M.toast({html: "Cantidad solicitada insuficiente en stock, "+disp+" disponible."})
			}else{
				M.toast({html: "Agregado al detalle de compra."})
			}

			var cp = $("#__datosp").attr("cp");
			var np = $("#__datosp").attr("np");
			var pp = $("#__datosp").attr("pp");
			var fp = $("#__datosp").attr("fp");
			var cat = $("#__datosp").attr("cat");
			
			if (parseInt(cantp) > 20 || cantp == "") {M.toast({html: "El pedido no puede superar las 20 unidades"})}
				else{
			if (parseInt(cantp) < 1 || cantp == "") { M.toast({html: "Ingresa una cantidad válida."})}
			else{
				// pp = parseFloat(pp)*parseInt(cantp);
				
				reg_pedidos[cp] = [cp, np, cantp, pp, fp, cat];
				//borrando tabla
				// $('#pedidos_cliente tr:not(:first-child)').slice(0).remove();
				// var table = $("#pedidos_cliente")[0];
				// console.log($("#pedidos_cliente tbody"))
				$("#pedidos_cliente tbody").html("")
				var table = $("#pedidos_cliente tbody")[0];

				total =  0;
				//llenando tabla
				// reg_pedidos = reg_pedidos.filter(Boolean)
				// let json_pedi = JSON.stringify(reg_pedidos)
				// console.log(json_pedi)
				// console.log(reg_pedidos.length)

				reg_pedidos.forEach(function (valor) {
					var row = table.insertRow(-1);
					row.insertCell(0).innerHTML = "<a style='text-decotarion: none; cursor: pointer; color: red;' onclick='borr_pla("+valor[0]+")'><i class='material-icons prefix'>delete</i></a>";
					row.insertCell(0).innerHTML = valor[3];
					row.insertCell(0).innerHTML = valor[2];
					row.insertCell(0).innerHTML = valor[1];
					total  = parseFloat(total) + (parseFloat(valor[3])*parseFloat(valor[2]));
				});
				$("#total_ped").html(total +" Bs.");
				$("#shop_button").addClass('pulse');
				$("#modal2").modal('close');
			}}
		}
		var mensaje = $("#mensaje");
		mensaje.hide();
		// $("#acceso").on("submit", function(e){
		// 	e.preventDefault();
		// 	var formData = new FormData(document.getElementById("acceso"));
		// 	$.ajax({
		// 		url: "recursos/acceder.php",
		// 		type: "POST",
		// 		dataType: "HTML",
		// 		data: formData,
		// 		cache: false,
		// 		contentType: false,
		// 		processData: false
		// 	}).done(function(echo){
		// 		if (echo !== "") {
		// 			mensaje.html(echo);
		// 			mensaje.show();
		// 		} else {
		// 			window.location.replace("index.php");
		// 		}
		// 	});
		// });
	function buscar_ci() {
		valor = $("#ci_c").val();
		encontrado = false;
		// return console.log(valor);

		if (!encontrado) {
		M.toast({html: "<b class='fz'>Cliente no encontrado, ingrese sus datos.</b>"});
		}
	}
	//ENVIO CON AJAX --
	// function enviar() {

	$("#form_pedido").on("submit", function(e) {
		e.preventDefault()
		// let dir = $("#direccion").val();
		// if (dir.length < 5) {
		// 	return M.toast({html: 'Escribe una dirección válida.'})
		// }

		// let telf = "echo $_SESSION['telf']; ";
		var formData = new FormData(document.getElementById('form_pedido')); //esto debe ser tomado desde formulario

		let subtotal = total;
		// colat = $("#coordLat").val()
		// colng = $("#coordLng").val()
		let json_detalle = reg_pedidos.filter(Boolean)
		json_detalle = JSON.stringify(json_detalle)

		
		// return console.log(formData);
		if((document.getElementById('check_fototorta').checked == true) && document.getElementById('imagen-nombre').value == ""){
			return M.toast({html: 'Ingrese una imagen para la torta.'});
		}
		if((document.getElementById('check_fototorta').checked == true) && document.getElementById('imagen-nombre').value != ""){
			subtotal = parseFloat(subtotal) + 30;
		}
		if((document.getElementById('check_mensaje_personalizado').checked == true) && document.getElementById('dedicatoria').value == ""){
			return M.toast({html: 'Ingrese una dedicatoria.'});
		}

		formData.append('subtotal', subtotal);
		formData.append('json_detalle', json_detalle);

		if(JSON.parse(json_detalle).length > 0){
			fetch("recursos/app/nuevo_pedido.php", {method:'post', body:formData})
			.then(response => response.text())
			.then(data => {
				console.log(data)
				if (data == '1') {
					M.toast({html:'<span style="color: #2ecc71">Pedido realizado, puedes ver tu pedido en la sección de Mi pedido</span>', displayLength: 5000, classes: 'rounded'})
					$("#modal_cliente").modal('close')
					// window.location.reload();
				}else{
					$("#mensaje").html(data);
				}

			})
		   
		}else{
			M.toast({html: "No se ha seleccionado ningún producto..."});
		}
	})


	document.getElementById('check_fototorta').addEventListener('click', () => {
		let check = document.getElementById('check_fototorta');
		if(check.checked){
			document.getElementById('div_imagen').hidden = false;
		}else{
			document.getElementById('imagen-nombre').value ="";
			document.getElementById('imagen-path').value ="";
			document.getElementById('div_imagen').hidden = true;
		}
		
	});
	document.getElementById('check_mensaje_personalizado').addEventListener('click', () => {
		let check = document.getElementById('check_mensaje_personalizado');
		if(check.checked){
			document.getElementById('div_mensaje').hidden = false;
		}else{
			document.getElementById('dedicatoria').value ="";
			document.getElementById('div_mensaje').hidden = true;
		}
	});

	document.getElementById('btn_modal_cliente').addEventListener('click', ()=>{
		let x = false;
		reg_pedidos.forEach(function (valor) {
			if(valor[5] == "1"){
				x = true;
			}
			if(x){
				document.getElementById('torta_personalizada').hidden = false;
				document.getElementById('imagen-nombre').value ="";
				document.getElementById('imagen-path').value ="";
				document.getElementById('dedicatoria').value ="";
				// document.getElementById('check_fototorta').checked = false;
				// document.getElementById('check_mensaje_personalizado').checked = false;
			}else{
				document.getElementById('torta_personalizada').hidden = true;
				document.getElementById('imagen-nombre').value ="";
				document.getElementById('imagen-path').value ="";
				document.getElementById('dedicatoria').value ="";
				// document.getElementById('check_fototorta').checked = false;
				// document.getElementById('check_mensaje_personalizado').checked = false;
			}
			$("#modal_cliente").modal('open');
		})

	});

	function sidenav_navi(link) {
		var elem = document.getElementById('slide-out')
		M.Sidenav.getInstance(elem).close()
		$('#cuerpo').load(link)

	}

	function shop_modal(argument) {
		$("#shop_button").removeClass('pulse')
		document.getElementById('menu_triger').hidden = true
		document.getElementById('cart_return').hidden = false
		document.getElementById('shop_section').hidden = true
		document.getElementById('cards_row').hidden = true
		document.getElementById('cart_row').hidden = false
		document.getElementById('toggle_sidebar').hidden = true
		// $("#modal3").modal('open')
	}

	function regresar_prod() {
		document.getElementById('menu_triger').hidden = false
		document.getElementById('cart_return').hidden = true
		document.getElementById('shop_section').hidden = false
		document.getElementById('cards_row').hidden = false
		document.getElementById('cart_row').hidden = true
		document.getElementById('toggle_sidebar').hidden = false
	}

	</script>


<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
