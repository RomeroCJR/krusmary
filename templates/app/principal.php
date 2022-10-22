<?php
	require('recursos/conexion.php');
    
    $Sql = "SELECT a.*, b.stock FROM producto a, inventario b WHERE a.cod_producto = b.cod_producto AND a.estado_producto = 1";
    $Busq = $conexion->query($Sql);
	$fila = $Busq->fetch_all(MYSQLI_ASSOC);

    $Sql2 = "SELECT cod_cliente, ci_cliente, nombre_cliente, ap_paterno_cliente, ap_materno_cliente, nro_celular_cliente FROM cliente WHERE estado_cliente = 1";
    $Busq2 = $conexion->query($Sql2);
	$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="icon" type="image/x-icon" href="img/icono.ico" />
		<link rel="stylesheet" type="text/css" href="css/style.css">
    	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    	<link rel="stylesheet" href="css/jquery.nice-number.css">
		<!-- <link rel="stylesheet" href="css/materialize.css"> -->
		<script src="js/jquery-3.0.0.min.js"></script>
		<!-- <script src="js/materialize.js"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="js/maps.js"></script>
		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN0x9mkyg_9x41m82iSIQvJ8M9vo7fXm4&callback=initMap">
		</script>
		<script src="js/jquery.nice-number.js"></script>
		<!-- <script src="js/firebase.js" ></script> -->
		
		<title>Bienvenido, Pedidos Delicias Express</title>
	</head>
	<body>
		<nav style="background: rgba(255, 255, 255, 0.5);">
			<div class="nav-wrapper">
		      <a href="#" class="brand-logo center"><img src="img/sidelex_sf.png" height="40" style="margin-top: 5px;" alt="Delicias Express"></a>
		    </div>
		</nav>
		<div id="toggle_sidebar" class="get_out">
			<a href="#" data-target="slide-out" class="sidenav-trigger btn-large waves-effect waves-light"><i class="material-icons">menu</i></a>
		</div>

			

		<!-- <div class="hide-on-med-and-up center row" id="top-menu" style="padding: 5px; background-color: #6c5ce7; cursor: pointer" onclick="direrc();">
				<div class="col s4 offset-s4"><p>MIS PEDIDOS</p><i class="material-icons">assignment</i></div>
		</div> -->
			
		

		<!-- <div class="get_out hide-on-small-only"><a href="recursos/app/salir.php" style="background-color: #e74c3c;" class="btn-large waves-light">Salir<i class="material-icons right">logout</i></a></div> -->
		<!-- <div class="ver_ped hide-on-small-only"><a href="templates/app/rev_pedido.php" style="background-color: #6c5ce7;" class="btn-large waves-light">mi pedido<i class="material-icons right">assignment</i></a></div> -->


		<ul id="slide-out" class="sidenav">
			<li><div class="user-view">
			<div class="background">
				<img src="images/fondo2.png" width="100%">
			</div>
			<a href="#user"><img class="circle" src="images/logo.png"></a>
			<a href="#name"><span class="white-text name"><?php $_SESSION['nombre']?></span></a>
			<a href="#email"><span class="white-text email"><?php $_SESSION['correo'] ?></span></a>
			</div></li>
			<li><a href="#!" onclick="location.reload()" class="waves-effect waves-purple"><i class="material-icons">home</i>Inicio</a></li>
			<li><a href="#!" onclick="sidenav_navi('templates/app/perfil.php')" class="waves-effect waves-purple"><i class="material-icons">face</i>Mi perfil</a></li>
			<li><a href="#!" onclick="sidenav_navi('templates/app/rev_pedido.php')" class="waves-effect waves-purple"><i class="material-icons">assignment</i>Mi pedido</a></li>

			<li><div class="divider"></div></li>

			<li><a class="waves-effect waves-red" href="recursos/app/salir.php"><i class="material-icons">logout</i>Salir</a></li>
		</ul>

		<div id="cuerpo" class="container">
		<h3 id="titulo_pedidos" class="center roboto">Realiza tu pedido</h3>
	

		<div class="row" id="cards_row">
			
			<div class="col s12 m12 l12 xl12">
				<h5>Productos disponibles:</h5>
				<?php foreach($fila as $a  => $valor){ ?>
					<!-- antes era s12 m6 l6 xl6 -->
				<div class="col s12 m6 l6 xl4 rubik" onclick="cantidad_plato('<?php echo $valor['cod_producto'] ?>','<?php echo $valor['nombre_producto'] ?>','<?php echo $valor['precio_producto'] ?>','<?php echo $valor['foto_producto'] ?>', '<?php echo $valor['stock'] ?>')">
					<div class="z-depth-3 card horizontal card__pad">
					  <div class="card-stacked">
					    <div class="">
					    	<p><?php echo $valor['nombre_producto']; ?></p>
					      	<small><?php echo $valor['descripcion_producto'] ?></small>
					      	<p style="position: absolute; bottom: 0px;"><?php echo 'Bs. '.$valor['precio_producto']; ?></p>
					    </div>
					  </div>
					  <div class="card__img">    
					    	<img class=" img__card" src="<?php echo $valor['foto_producto'] ?>">
					  </div>
					</div>
				</div>
				<?php } ?>
			</div>



		</div>

		<div class="row roboto" id="cart_row" hidden>
			<div class="row get_out">
				<div class="left">
					<a href="#!" class="btn-large red" onclick="regresar_prod()"><i class="material-icons">keyboard_return</i></a>
				</div>
			</div>
			<!-- antes era col s12 m12 l4 xl5 -->
			<div class="col s12 m12 l12" id="div_tabla_pedidos">
				<!-- <div class="col l6 m10 offset-m1 s12"> -->
					<div class="center"><h4>Tu pedido</h4></div>
					<table id="pedidos_cliente" class="content-table centered z-depth-4">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Precio</th>
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
							<div class="neon" >Subtotal: <label id="total_ped" class="neon">0.00 Bs</label></div>
						<!-- </div> -->
					</div>
				<!-- </div> -->
			</div>

			<div class="center">
				<a class="waves-effect waves-light btn btn-large modal-trigger" id="mod_ubi" href="#modal_ubi">PEDIR!</a>
			</div>
		</div>
		<div id="modal2" class="modal ">
			<div id="modal_pedidos" class="modal-content row">
				<div class="col s12" id="cont_foto">
					<img id="foto_plato" src="" >
				</div>
				<div class="col s8 black-text">
					<input type="text" id="current_sell" hidden>
					<input type="text" id="current_stock" hidden>
					<h5 id="nombre_p"> </h5>
					<h5 id="precio_p"> </h5>
				</div>
				<div class="col s4">
					<div class="number-container">
						<label for="">Cantidad</label>
						<input class="browser-default" type="number" name="" id="__cantidad" min="1" max="15" disabled>
					</div>
				</div>
			</div>
			<div id="__datosplato" hidden></div>
			<hr>
			<div class="modal-footer row ">
				<a href="#!" class="left modal-action modal-close waves-effect waves-light btn btn-large red"><i class="material-icons">close</i></a>
				<a class="waves-effect waves-light btn btn-large right" onclick="datos_plato();" >Agregar<i class="material-icons right">add_shopping_cart</i></a>
			</div>
		</div>

		<form id="form_pedido" hidden> <!-- onKeyPress="return checkIt(event)" SOLO NÚMEROS -->
			<input type="text" id="coordLat" name="coordLat" >
			<input type="text" id="coordLng" name="coordLng" >
			<input type="text" id="tot_ped" name="tot_ped" value="" >
		</form>

		<div id="modal_ubi" class="modal"> <!-- arreglar esta wea -->
			<div class="modal-content" id="modal_ubi_content">
				<h4>Dirección</h4>
				
				<div class="row">
					<div class="col s12">
					  
					  <div class="input-field">
					    <input id="direccion" type="text" class="validate">
					    <label for="direccion">Escribe aquí tu dirección</label>
					    <!-- <span class="helper-text" data-error="wrong" data-success="right">Helper text</span> -->
					  </div>
					</div>
				</div>

				<!-- <div class="container"> -->
					<!-- <input type="text" id="direccion" placeholder="Escribe tu dirección"> -->
				<!-- </div> -->
				<div id="map"></div>

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

	function cantidad_plato(cod, nombre, precio, foto, stock) {
		$("#foto_plato").attr("src", foto);
		$("#nombre_p").html(nombre);
		$("#precio_p").html(precio+" Bs.");
		
		$("#__datosplato").html("<input id='__datosp' cp='"+cod+"' np='"+nombre+"' pp='"+precio+"' fp='"+foto+"' hidden/>");


		fetch("recursos/app/check_stock.php?id="+cod)
		.then(response => response.text())
		.then(response => {
			$("#current_sell").val(response)
        	$("#current_stock").val(stock)
        	console.log(stock, response)
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
				total  = parseInt(total) + parseInt(valor[3]);
			});
			$("#total_ped").html(total +" Bs.");
	}
		
		function datos_plato(){

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
			
			if (parseInt(cantp) > 15 || cantp == "") {M.toast({html: "El pedido no puede superar las 15 unidades"})}
				else{
			if (parseInt(cantp) < 1 || cantp == "") { M.toast({html: "Ingresa una cantidad válida."})}
			else{
				pp = parseInt(pp)*parseInt(cantp);
				
				reg_pedidos[cp] = [cp, np, cantp, pp, fp];
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
					total  = parseInt(total) + parseInt(valor[3]);
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
		"<?php foreach($fila2 as $a  => $valor){ ?>";
		if (valor == ("<?php echo $valor['ci'] ?>")) {
			$("#nombre_c").val("<?php echo $valor['nombre'] ?>");
			$("#ap_c").val("<?php echo $valor['apellidos'] ?>");
			$("#telf").val("<?php echo $valor['telf'] ?>");
			M.updateTextFields();
			encontrado = true;
		}
		"<?php } ?>";
		if (!encontrado) {
		M.toast("<b class='fz'>Cliente no encontrado, ingrese sus datos.</b>", 4000);
		}
	}
	//ENVIO CON AJAX --
	// function enviar() {

	$("#form_pedido").on("submit", function(e) {
		e.preventDefault()
		let dir = $("#direccion").val();
		if (dir.length < 5) {
			return M.toast({html: 'Escribe una dirección válida.'})
		}

		let telf = "<?php echo $_SESSION['telf']?>"
		let subtotal = total
		colat = $("#coordLat").val()
		colng = $("#coordLng").val()
		let json_detalle = reg_pedidos.filter(Boolean)
		json_detalle = JSON.stringify(json_detalle)

		if(JSON.parse(json_detalle).length > 0){
		    $.ajax({
	            url: "recursos/app/nuevo_pedido.php?telf="+telf+"&dir="+dir+"&subtotal="+subtotal+"&colat="+colat+"&colng="+colng+"&json="+json_detalle,
	            method: "GET",
	            success: function(response) {
	            	mensaje.html(response)
	                console.log(response)
	                if (response) {
	                	M.toast({html:'<span style="color: #2ecc71">Pedido realizado, puedes ver tu pedido en la sección de Mi pedido</span>', displayLength: 8000, classes: 'rounded'})
	                	$("#modal_ubi").modal('close')
	                	regresar_prod()
	                }
	            },
	            error: function(error) {
	                console.log(error)
	            }
		    })
		}else{
			M.toast({html: "No se ha seleccionado ningún producto..."});
		}
	})

	function sidenav_navi(link) {
		var elem = document.getElementById('slide-out')
		M.Sidenav.getInstance(elem).close()
		$('#cuerpo').load(link)

	}

	function shop_modal(argument) {
		$("#shop_button").removeClass('pulse')
		document.getElementById('titulo_pedidos').hidden = true
		document.getElementById('shop_section').hidden = true
		document.getElementById('cards_row').hidden = true
		document.getElementById('cart_row').hidden = false
		document.getElementById('toggle_sidebar').hidden = true
		// $("#modal3").modal('open')
	}

	function regresar_prod() {
		document.getElementById('titulo_pedidos').hidden = false
		document.getElementById('shop_section').hidden = false
		document.getElementById('cards_row').hidden = false
		document.getElementById('cart_row').hidden = true
		document.getElementById('toggle_sidebar').hidden = false
	}

	</script>


<!-- <script type="module" src="https://www.gstatic.com/firebasejs/9.0.1/firebase-auth.js"></script> -->
