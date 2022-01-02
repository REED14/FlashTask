let map;

var userCoordX = -34;
var userCoordY = 150;

var workerCoordX = -34.1;
var workerCoordY = 150;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 12,
  });

  const userMarker = new google.maps.Marker({
        position: {lat: userCoordX, lng: userCoordY},
        map,
  });

  const workerMarker = new google.maps.Marker({
        position: {lat: workerCoordX, lng: workerCoordY},
        map,
  });

  /*
  setInterval(function() {
    workerCoordX += 0.01;
    workerCoordY += 0.01;
    position = new google.maps.LatLng(workerCoordX, workerCoordY);
    workerMarker.setPosition(position);
  }, 1000); */

  setInterval(fetch_data, 2000);

  function fetch_data(){
  
      $.ajax({
          url:"./server-scripts/load_cstate.php",
          dataType : "JSON",
          success : function(result){
              //console.log(result['wLat']);
              workerCoordX = parseFloat(result['wLng']);
              workerCoordY = parseFloat(result['wLat']);
              userCoordX = parseFloat(result['uLng']);
              userCoordY = parseFloat(result['uLat']);
              //console.log(userCoordX, userCoordY);
              console.log(userCoordX);

              Uposition = new google.maps.LatLng(userCoordX, userCoordY);
              userMarker.setPosition(Uposition);
              //map.setCenter(Uposition);

              Wposition = new google.maps.LatLng(workerCoordX, workerCoordY);
              workerMarker.setPosition(Wposition);
          },
          error: function(result){
            console.log(result);
          }
      });
    }

}