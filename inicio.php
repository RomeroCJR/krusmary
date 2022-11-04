<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/logo.png" />
    <link rel="stylesheet" href="css/style.css">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">    
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   
    <title>Repostería KRUS-MARY</title>
</head>
<style>
    @media only screen and (min-width : 992px) {
        .slider{
            height: 100vh !important;
        }
        .slides{
            height: 100% !important;
        }
        .indicators{
            z-index:999;
        }
	}
    #logo{
        max-height: 100%;
        width: auto;
    }
    .brand-logo{
        height:100%;
    }
    body{
        font-family: rubik;
        background-color: #ffcdd2;

    }

   /* footer{
        position:absolute;
        width:100%;
        bottom:0px;
        z-index:9999;
   } */
   .footer_redes{
        display:flex;
        flex-direction: row;
        align-items: center;
        
   }
</style>
<body>
    <div class="" style="position:fixed; z-index:9999; width:100%;">
        <nav style="background: rgba(255,255,255, 0.6); ">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo center"><img id="logo" src="img/logo.png" alt=""></a>
                <ul class="right">
                    <li><a href="registro.php" class="roboto" style="color:black;">Ingresa o Regístrate</a></li>
                </ul>
            </div>
        </nav>  
    </div>  

    <div class="slider" >
        <ul class="slides" >
            <li >
                <img src="images/fondo1.png"> <!-- random image -->
                <div class="caption left-align black-text ">
                    <h3>Repostería KRUS-MARY!</h3>
                    <h5 class=""><b>Las mejores tortas para cumpleaños...</b></h5>
                </div>
            </li>
            <li>
                <img src="images/fondo1.jpg"> <!-- random image -->
                <div class="caption center-align ">
                <!-- <h3>Repostería KRUS-MARY!</h3> -->
                <h5 class=""><b>Tortas y Pasteles, preparados a gusto y necesidad del cliente.</b></h5>
                </div>
            </li>
            <li>
                <img src="images/fondo2.png"> <!-- random image -->
                <div class="caption right-align black-text">
                <!-- <h3>Repostería KRUS-MARY!</h3> -->
                <h5 class="light black-text text-lighten-3">Gran variedad de postres, para tú elección.</h5>
                </div>
            </li>
            <li>
                <img src="images/fondo3.jpg"> <!-- random image -->
                <div class="caption center-align black-text">
                <!-- <h3>Repostería KRUS-MARY!</h3> -->
                <br><br><br><br><br>
                <h5 class=""><b>Llámanos o haz una reserva desde la página</b> &#128512;.</h5>
                </div>
            </li>
        </ul>
    </div>
    <div class="container">
        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non explicabo et, modi rerum, magni, nostrum excepturi illum rem pariatur debitis tenetur consequatur facere ratione exercitationem natus. Minima blanditiis quos unde.</span>
    </div>
    
</body>

<footer class="page-footer">
    <div class="container">
        <div class="row">

            <div class="col s12">
                <h5 class="white-text">Redes sociales:</h5>
                <ul >
                    <li class="footer_redes" style="height:30px;" ><a  class="grey-text text-lighten-3" href="https://www.facebook.com/REPOSTERIAKRUSMARY"><i class="left"><img style="height:22px;" src="https://img.icons8.com/color/48/null/facebook-new.png"/></i> Facebook</a></li>
                    <li class="footer_redes" style="height:30px;" ><a  class="grey-text text-lighten-3" href="https://wa.me/59163757600?text=Hola..."><i class="left"><img style="height:22px;" src="https://img.icons8.com/color/48/null/whatsapp--v1.png"/></i>WhatsApp</a></li>
                    <!-- <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li> -->
                    <!-- <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2022 Copyright 
            <a class="grey-text text-lighten-4 right" href="#!">Repostería Krus Mary</a>
        </div>
    </div>
</footer>
</html>

<script>
    
  document.addEventListener('DOMContentLoaded', function() {
    // let options = {'height': '300'}
    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems);
  });

</script>