<?php
	require('../../recursos/conexion.php');
    session_start();

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
		<div class="row" id="cards_row">
			<div class="col s12 m12 l12 xl12">
				<h5 class="rubik" >Nuestro catálogo de productos disponibles:</h5>
				<?php foreach ($result2 as $val): ?>
				<div class="row">
					<div class="col s12 center"><h4 class="lobster"><?php echo $val['nombre_categoria']; ?></h4></div>
					<!-- <hr style="color:aquamarine"> -->
					<?php foreach ($fila as $valor): ?>
						<?php if($val['cod_categoria'] == $valor['cod_categoria']): ?>
							<!-- antes era s12 m6 l6 xl6 -->
							<div class="col s6 m3" loading="lazy" onclick="cantidad_prod('<?php echo $valor['cod_producto'] ?>','<?php echo $valor['nombre_producto'] ?>','<?php echo $valor['precio_producto'] ?>','<?php echo $valor['foto_producto'] ?>', '<?php echo $valor['cantidad'] ?>', '<?php echo $valor['stock'] ?>', '<?php echo $valor['cod_categoria'] ?>')">
								<div class="card">
									<div class="card_title">
										<span style="font-size: 20px" class="card-title lobster"><small><?php echo $valor['nombre_producto'] ?></small></span>
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

		<div id="modal_cliente" class="modal  ubuntu" style="width:30%"> <!-- arreglar esta wea -->
			<div class="modal-content" id="modal_cliente_content">
				<h5><b>Confirmar pedido:</b></h5>
				
				<div class="row">
					<div class="col s12">
					  <form id="form_pedido">
						<input type="text" id="tot_ped" name="tot_ped" value="" hidden>
						
						<div id="fecha_hora">
							<div class="col s12">
								<label for="fecha_hora">Fecha y Hora en la que se recogerán los productos:</label>
							</div>
							<div class="input-field col s6" >
								<input type="date"  id="fecha" name="fecha"  placeholder="fecha" required>
								<!-- <label for="fecha">Fecha:</label> -->
							</div>
							<div class="input-field col s6" >
								<input type="time"  id="hora" name="hora"  placeholder="fecha" required>
								<!-- <label for="fecha">Hora:</label> -->
							</div>
						</div>


						<div id="torta_personalizada" hidden>
							<div class="input-field col s12" id="div_instrucciones_torta" style="margin-bottom:0px">
								<p>
									<label>
										<input type="checkbox" id="check_instrucciones" />
										<span>Instrucciones especiales (para la torta):</span>
									</label>
								</p>
							</div>
							<div class="input-field col s12" id="div_instrucciones" style="margin-top:0px" hidden>
								<textarea id="excepciones" name="excepciones" class="materialize-textarea"></textarea>
								<label for="excepciones">Sin azucar / sal / nuez / otros... :</label>
							</div>

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
								<label for="dedicatoria">"Feliz cumpleaños amiga", "Felicidades mamá":</label>
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
     

        <script>
	var total = 0;
	$(document).ready(function() {
		$('.modal').modal();
		$('.datepicker').datepicker();
		$('.timepicker').timepicker();
		$('.fixed-action-btn').floatingActionButton();
		$('input[type="number"]').niceNumber({
			autoSize: true,
			autoSizeBuffer: 1,
			buttonDecrement: "-",
			buttonIncrement: "+",
			buttonPosition: 'around'
		});
		var today = new Date().toISOString().split('T')[0];
		document.getElementById("fecha").setAttribute('min', today);
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
				M.toast({html: "Agregado al detalle de compra.", displayLength: 1500})
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

		let cod_cliente = "<?php echo $_SESSION['cod_cliente']; ?>";
		var formData = new FormData(document.getElementById('form_pedido')); //esto debe ser tomado desde formulario
		formData.append('cod_cliente', cod_cliente);

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
		if((document.getElementById('check_instrucciones').checked == true) && document.getElementById('excepciones').value == ""){
			return M.toast({html: 'Ingrese las instrucciones especiales de la torta.'});
		}

		formData.append('subtotal', subtotal);
		formData.append('json_detalle', json_detalle);

		let cliente = "<?php echo $_SESSION['nombre_cliente'].' '.$_SESSION['apellidos_cliente']; ?>"
        // let cliente = document.getElementById('nombre').value+" "+document.getElementById('apellidos').value;
        cliente = "```"+cliente+"```";
		

		let detalle = "";
		reg_pedidos.forEach(function(x) {
            // console.log(x);
			detalle = detalle+'*'+x[1]+'* x```'+x[2]+'``` %0A';
			// *${x[0]}*-${x[1]} *x${x[2]}*%0A
		})
        // return console.log(cliente);

		if(JSON.parse(json_detalle).length > 0){
			fetch("recursos/app/nuevo_pedido.php", {method:'post', body:formData})
			.then(response => response.text())
			.then(data => {
				// return console.log(data)
				if (data == '1') {
                    let texto = `*Hola, me llamo:*%0A${cliente}%0A*Quiero realizar un pedido:*%0A${detalle}*Monto a pagar:* ${subtotal} Bs.%0A`;
					M.toast({html:'<span style="color: #2ecc71">Pedido realizado, puedes ver tu pedido en la sección de Mi pedido</span>', displayLength: 5000, classes: 'rounded'})
					$("#modal_cliente").modal('close')
					document.getElementById('menu_triger').hidden = false
                    document.getElementById('cart_return').hidden = true
					$("#cuerpo").load('templates/app/catalogo.php')
                    window.location.href = "https://wa.me/59163757600?text="+texto;
                    
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
	document.getElementById('check_instrucciones').addEventListener('click', () => {
		let check = document.getElementById('check_instrucciones');
		if(check.checked){
			document.getElementById('div_instrucciones').hidden = false;
		}else{
			document.getElementById('excepciones').value ="";
			document.getElementById('div_instrucciones').hidden = true;
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
				document.getElementById('excepciones').value ="";
				// document.getElementById('check_fototorta').checked = false;
				// document.getElementById('check_mensaje_personalizado').checked = false;
			}else{
				document.getElementById('torta_personalizada').hidden = true;
				document.getElementById('imagen-nombre').value ="";
				document.getElementById('imagen-path').value ="";
				document.getElementById('dedicatoria').value ="";
				document.getElementById('excepciones').value ="";
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