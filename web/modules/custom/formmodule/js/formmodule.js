if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(function(position){
        document.getElementById("edit-latitude").innerHTML = position.coords.latitude;
        document.getElementById("edit-longitude").innerHTML = position.coords.longitude;
    });
}
 
