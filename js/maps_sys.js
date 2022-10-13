    // var marker;         
    // var coords = {};

    // initMap = function () {
    //       function (){

    //         let lat = $("#__lat").val();
    //         let lng = $("#__lng").val();

    //         coords =  {
    //           lng: lng,
    //           lat: lat
    //         };
    //       setMapa(coords);

    //       }
    // }

var marker;
function setMapa(coords) {

        var map = new google.maps.Map(document.getElementById('map'),
        {
          zoom: 17,
          center: {lat: coords.lat, lng: coords.lng}
        });

        marker = new google.maps.Marker({
          position: {lat: coords.lat, lng: coords.lng},
          map: map
        });

        // map.addListener('click', function(e) {
        
        // $("#coordLat").val(e.latLng.lat());
        // $("#coordLng").val(e.latLng.lng());

        //   marker.setPosition(e.latLng);
        //   marker.setMap(map);
        // }); 
}



//   var marker;         
//   var coords = {};

//   initMap = function () {
//         coords = getCoordenadas();
//           // coords =  {
//           //   lng: longitud,
//           //   lat: latitud 
//           // }
//         setMapa(coords);
//   }
//   function getCoordenadas(lat, lng) {
//     coords ={
//       lng: lng,
//       lat: lat
//     }
//     return coords;
//   }



// function setMapa(coords) {

//         var map = new google.maps.Map(document.getElementById('map'),
//         {
//           zoom: 17,
//           center: {lat: coords.lat, lng: coords.lng}
//         });

//         marker = new google.maps.Marker({
//           position: {lat: coords.lat, lng: coords.lng},
//           map: map
//         });

// }
