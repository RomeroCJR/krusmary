<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Compiled and minified CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">    
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   
    <title>Repostería KRUS-MARY</title>
</head>
<style>
    .slider{
        height: 100vh !important;
    }
    .slides{
        height: 95% !important;
    }
</style>
<body>
    
    <div class="slider" >
        <ul class="slides" >
            <li>
                <img src="images/fondo1.png"> <!-- random image -->
                <div class="caption center-align">
                <h3>This is our big Tagline!</h3>
                <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
            <li>
                <img src="images/fondo1.jpg"> <!-- random image -->
                <div class="caption left-align">
                <h3>Left Aligned Caption</h3>
                <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
            <li>
                <img src="images/fondo2.png"> <!-- random image -->
                <div class="caption right-align">
                <h3>Right Aligned Caption</h3>
                <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
            <li>
                <img src="images/fondo3.jpg"> <!-- random image -->
                <div class="caption center-align">
                <h3>This is our big Tagline!</h3>
                <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>
        </ul>
    </div>

    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non explicabo et, modi rerum, magni, nostrum excepturi illum rem pariatur debitis tenetur consequatur facere ratione exercitationem natus. Minima blanditiis quos unde.</span>


</body>
</html>
<script>
    
  document.addEventListener('DOMContentLoaded', function() {
    // let options = {'height': '300'}
    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems);
  });

</script>