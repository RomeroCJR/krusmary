    var marker;         
    var coords = {};

    initMap = function () {

        navigator.geolocation.getCurrentPosition(
          function (position){
            coords =  {
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };
            $("#coordLat").val(coords.lat);
            $("#coordLng").val(coords.lng);
          setMapa(coords);

          },function(error){console.log(error);});
    }

function setMapa(coords) {

        var map = new google.maps.Map(document.getElementById('map'),
        {
          zoom: 16,
          center: {lat: coords.lat, lng: coords.lng}
        });

        marker = new google.maps.Marker({
          position: {lat: coords.lat, lng: coords.lng},
          map: map
        });

        map.addListener('click', function(e) {
        
        $("#coordLat").val(e.latLng.lat());
        $("#coordLng").val(e.latLng.lng());

          marker.setPosition(e.latLng);
          marker.setMap(map);
        }); 
}
