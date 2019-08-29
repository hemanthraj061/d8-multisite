$(function() {
	if ($('#map-link')[0]) {
                    var map = new GMaps({
				   div: '#map-link',
				   lat: $('#edit-latitude').val(),
				   lng: $('#edit-longitude').val(),
				});
	}
});
