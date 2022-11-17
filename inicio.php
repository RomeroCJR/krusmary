<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Vista mobile -->
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="theme-color" content="#ee6e73">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <link rel="icon" type="image/x-icon" href="images/logo.ico">
    <link rel="manifest" href="manifest.json">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">    
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/butter.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   
    <title>Repostería KRUS-MARY</title>
</head>
<style>
    html{
        scroll-behavior: smooth;
    }
    @media only screen and (min-width : 992px) {
        .slider{
            height: 100vh !important;
        }
        .slides{
            height: 100% !important;
        }
        .indicators{
            z-index:999;
            padding-bottom:10px;
        }
        .slides li img {
            /* max-width: 100% !important; */
            /* height: 100% !important; */
            background-attachment: fixed !important;
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

   .grid-item:hover{
    filter: opacity(0.9);
    transform: scale(1.04);
   }
   .grid-container{
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    grid-auto-rows: minmax(200px, auto);
    gap:20px;
    padding: 20px;
    grid-auto-flow: dense;
   }

   @media (min-width: 600px){
    .wide{
        grid-column: span 2;
    }
    .tall{
        grid-row: span 2;
    }
   }

   @media (max-width: 992px){
    .dropdown-trigger i{
        padding-right: 15px;
    }
   }
   @media (max-width: 600px){
    .dropdown-trigger i{
        padding: 15px;
    }
   }
   

    


</style>
<body >
    <!-- <div id="butter"> -->
    <ul id="dropdown1" class="dropdown-content" >
        <li><a href="#section-1" class="waves-effect waves-light black-text">Inicio</a></li>
        <li><a href="#section-2" class="waves-effect waves-light black-text">Galería</a></li>
        <li><a href="#section-3" class="waves-effect waves-light black-text">Nuestros productos</a></li>
        <li><a href="#section-4" class="waves-effect waves-light black-text">Contáctanos</a></li>
    </ul>
    <div class="" style="position:fixed; z-index:9999; width:100%; top:0px;">
        <nav style="background: rgba(255,255,255, 0.6); ">
            <div class="nav-wrapper">
                <ul class="left hide-on-large-only">
                    <li ><a class="black-text dropdown-trigger" href="#!" data-target="dropdown1">Menú<i class="material-icons-outlined right">arrow_drop_down</i></a></li>
                </ul>
                <ul class="left hide-on-med-and-down">
                    <li><a href="#section-1" class="waves-effect waves-light black-text">Inicio</a></li>
                    <li><a href="#section-2" class="waves-effect waves-light black-text">Galería</a></li>
                    <li><a href="#section-3" class="waves-effect waves-light black-text">Nuestros productos</a></li>
                    <li><a href="#section-4" class="waves-effect waves-light black-text">Contáctanos</a></li>
                </ul>
                <a href="#" class="brand-logo center"><img id="logo" src="img/logo.png" alt=""></a>
                <ul class="right">
                    <li><a href="registro.php" class="roboto" style="color:black;">Ingresa o Regístrate</a></li>
                </ul>
            </div>
        </nav>  
    </div>  

    <section id="section-1">
        <div class="slider " >
            <ul class="slides" >
                <li >
                    <img src="images/fondo1.png" style="width:100% !important;"> <!-- random image -->
                    <div class="caption left-align black-text ">
                        <h3>Repostería KRUS-MARY!</h3>
                        <h5 class=""><b>Las mejores tortas para cumpleaños...</b></h5>
                    </div>
                </li>
                <li>
                    <img src="images/torta_tres_leches_8910_orig.jpg"> <!-- random image -->
                    <div class="caption center-align black-text">
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
                    <div class="caption right-align black-text">
                    <!-- <h3>Repostería KRUS-MARY!</h3> -->
                    <br><br><br><br><br>
                    <h5 class=""><b>Llámanos o haz una reserva desde la página</b> &#128512;.</h5>
                    </div>
                </li>
                
            </ul>
            
        </div>
    </section>
    <section id="section-2">
        <div class="container" >
            <h3 class="rubik">Galería</h3>
            <div class="grid-container">
                <!-- <div class="z-depth-3 grid-item" ><img src="images/481ad81b-feda-4b43-b34c-df87d6455427.jpg" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item wide tall" ><img src="images/708c9fe9-a129-4ac9-b5fa-ecebdc268607.jpg" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item wide tall" ><img src="images/7387c9dc-ddd5-43bd-831f-04a870552328.jpg" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item" ><img src="images/18620064_501200630271525_7595693900660456076_n.png" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item" ><img src="images/d7d89023-1ce1-4cf1-b3fb-1d2d3dcf7993.jpg" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item" ><img src="images/f35c10d7-72b1-4168-934b-f618b97a9f9a.jpg" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item" ><img src="images/PXL_20220722_232513850.MP.jpg" class="materialboxed" width="100%" alt=""></div>
                <div class="z-depth-3 grid-item" ><img src="images/18581799_501200553604866_5054816197699773601_n.jpg" class="materialboxed" width="100%" alt=""></div>
                -->
                
                
                
                <div class="z-depth-3 grid-item " style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/481ad81b-feda-4b43-b34c-df87d6455427.jpg')"></div>
                <div class="z-depth-3 grid-item wide tall" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/708c9fe9-a129-4ac9-b5fa-ecebdc268607.jpg')"></div>
                <div class="z-depth-3 grid-item wide tall " style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/7387c9dc-ddd5-43bd-831f-04a870552328.jpg')"></div>
                <div class="z-depth-3 grid-item" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/18620064_501200630271525_7595693900660456076_n.png')"></div>
                <div class="z-depth-3 grid-item" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/d7d89023-1ce1-4cf1-b3fb-1d2d3dcf7993.jpg')"></div>
                <div class="z-depth-3 grid-item" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/f35c10d7-72b1-4168-934b-f618b97a9f9a.jpg')"></div>
                <div class="z-depth-3 grid-item " style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/PXL_20220722_232513850.MP.jpg')"></div>
                <div class="z-depth-3 grid-item " style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/18581799_501200553604866_5054816197699773601_n.jpg')"></div>
                <div class="z-depth-3 grid-item " style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/119743793_1453578671700378_8355588776018510533_n.jpg')"></div>
                <div class="z-depth-3 grid-item wide" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/b08facb7-faeb-47fe-bfd4-01cc9a1d8180.jpg')"></div>
                <div class="z-depth-3 grid-item" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/torta_tres_leches_8910_orig - copia.jpg')"></div>
                <div class="z-depth-3 grid-item wide tall" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/torta-amor-receta-lo-mismo-pero-sano.jpg')"></div>
                <div class="z-depth-3 grid-item" style="background-size: 100%; background-repeat: no-repeat;background-image: url('images/fondo1.jpg')"></div>
                
            </div>
        </div>
    </section>
    <section id="section-3">
        <div class="" style="background-color: #fce4ec">
            <div class="container row" id="cards_row" >
            <h3 class="rubik">Nuestros productos</h3>
                <div class="col s12 m4" style="padding-top:20px;">
                    <div class="col s12 ">
                        <center><img src="images/icon1.png" width="50%"  alt=""></center>
                    </div>
                    <div class="col s12">
                        <div class="card-panel light-blue darken-2">
                            <span class="white-text">Repostería de alta calidad: tortas y pasteles a pedido del cliente, contamos con foto tortas e impresiones de alta calidad, también puedes agregar dedicatorias personalizadas.</span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4" style="padding-top:20px;">
                    <div class="col s12 ">
                        <center><img src="images/icon2.png" width="50%"  alt=""></center>
                    </div>
                    <div class="col s12">
                        <div class="card-panel light-blue darken-2">
                            <span class="white-text">Queques, masitas, postres y una gran variedad de productos a tu elección preparados de manera artesanal, nuestros famosos postres te van a encantar!</span>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4" style="padding-top:20px;">
                    <div class="col s12 ">
                            <center><img src="images/icon3.png" width="50%"  alt=""></center>
                    </div>
                    <div class="col s12">
                        <div class="card-panel light-blue darken-2">
                            <span class="white-text">Nuestros productos al ser preparados artesanalmente, no contienen ningún tipo de conservantes u otros ingredientes que pudieran perjudicarte.
                                <br>Cuidamos tu salud. &#128522;
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="section-4">
        <div class="container">
            <h3 class="rubik">Contáctanos</h3>
            <div class="form_contact">
                <p><a href="tel:+59167673738"><i class="material-icons-outlined left">call</i>+591 67673738</a></p>    
                <p><i class="material-icons-outlined left">location_on</i>Nuestra dirección</p>
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1744.7512672633209!2d-65.59398282854221!3d-22.08787750842093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9406a5f2313e0d1f%3A0x6666d4c71bedca0d!2sREPOSTERIA%20%22KRUSMARI%22!5e0!3m2!1ses-419!2sbo!4v1667683772221!5m2!1ses-419!2sbo" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            
            </div>
        </div>
    </section>
    <br>
    <footer class="page-footer pink lighten-1" id="section-5">
    <div class="container">
        <div class="row">

            <div class="col s6">
                <h5>Redes:</h5>
                <ul >
                    <li class="footer_redes" style="height:30px;" ><a  class="grey-text text-lighten-3" href="https://www.facebook.com/REPOSTERIAKRUSMARY"><i class="left"><img style="height:22px;" src="https://img.icons8.com/color/48/null/facebook-new.png"/></i> Facebook</a></li>
                    <li class="footer_redes" style="height:30px;" ><a  class="grey-text text-lighten-3" href="https://wa.me/59163757600?text=Hola..."><i class="left"><img style="height:22px;" src="https://img.icons8.com/color/48/null/whatsapp--v1.png"/></i>WhatsApp</a></li>
                    <!-- <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li> -->
                    <!-- <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li> -->
                </ul>
            </div>
            <div class="col s6">
                <h5>Dirección:</h5>
                <ul>
                    <li>
                        <span>Calle independencia esquina cochabamba #395 Villazón, Bolivia</span>
                    </li>
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
<!-- </div> -->
</body>


</html>
<script src="script.js"></script>
<script>
    // butter.init({cancelOnTouch: true});
    document.addEventListener('DOMContentLoaded', function() {
        // let options = {'height': '300'}
        var elems = document.querySelectorAll('.slider');
        var instances = M.Slider.init(elems);
        var elem = document.querySelectorAll('.materialboxed');
        var instance = M.Materialbox.init(elem);
        $(".dropdown-trigger").dropdown();
    });


</script>