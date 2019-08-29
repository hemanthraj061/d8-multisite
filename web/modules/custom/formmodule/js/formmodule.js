$(function() {
	if ($('#map-link')[0]) {
                    var map = new GMaps({
				   div: '#map-link',
				   lat: $('#edit-latitude').val(),
				   lng: $('#edit-longitude').val()
				});
		var latlng = JSON.parse($('#edit-mark').val());
		$(latlng).each(function(index, element) {
			map.addMarker({
			  lat: element.latitude,
			  lng: element.longitude,
			  infoWindow: {
				content: element.content
			  }
			});
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
