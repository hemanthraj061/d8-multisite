$(function() {
	if ($('#map-link')[0]) {
                    var map = new GMaps({
				   div: '#map-link',
				   lat: $('#edit-latitude').val(),
				   lng: $('#edit-longitude').val()
				});
		var latlng = JSON.parse($('#edit-mark').val());
		var path = [];
		$(latlng).each(function(index, element) {
			map.addMarker({
			  lat: element.latitude,
			  lng: element.longitude,
			  icon: "/modules/custom/formmodule/js/mapicon.png",
			  infoWindow: {
				content: element.content
			  }
			});
			path.push([element.latitude,element.longitude]);
		});
		map.drawPolyline({
		  path: path,
		  strokeColor: '#B0CB1F',
		  strokeOpacity: 1,
		  strokeWeight: 6
		});
	}
	$('#edit-location').on('change', function() {
		GMaps.geocode({
		  address: this.value,
		  callback: function(results, status) {
		    if (status == 'OK') {
		      var latlng = results[0].geometry.location;
		      $('#edit-lat').val(latlng.lat());
		      $('#edit-long').val(latlng.lng());
		    }
		  }
		});
	});
});
