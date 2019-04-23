/*google.maps.event.addDomListener(window, 'load', init);

function init() {
	var snazzyStyles = [{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"lightness":"27"}]},{"featureType":"landscape.natural.terrain","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"visibility":"simplified"},{"lightness":"24"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"simplified"},{"lightness":"0"},{"gamma":"1"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"},{"lightness":"0"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"lightness":"0"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"lightness":"0"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.fill","stylers":[{"saturation":"0"},{"lightness":"0"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.stroke","stylers":[{"lightness":"0"}]},{"featureType":"road.highway.controlled_access","elementType":"labels","stylers":[{"lightness":"0"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"lightness":"66"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"lightness":"47"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"transit.line","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"transit.station","elementType":"labels.text","stylers":[{"visibility":"simplified"},{"color":"#787878"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"saturation":"-100"},{"visibility":"simplified"}]},{"featureType":"water","elementType":"all","stylers":[{"lightness":"39"}]}];

	if(jQuery('#map').length){
		var markers = [];
		var centerLat = 0, centerLng = 0;

		var $pins = $('#map .map-pin');
		$pins.each(function() {
			var location = new google.maps.LatLng($(this).data('latitude'), $(this).data('longitude'));
			centerLat += location.lat();
			centerLng += location.lng();

			markers.push({
				'location': location,
				'icon': $(this).data('pin'),
				'parent': $(this).data('parent'),
			});
		});

		var center = new google.maps.LatLng(centerLat / $pins.length, centerLng / $pins.length);

		var mapOptions = { 
			zoom: 13,
			draggable: false,
			scrollwheel: false,
			zoomControl: true,
			streetViewControl: false,
			mapTypeControl: false,
			center: center,
			styles: snazzyStyles
		};

		var mapElement = document.getElementById('map');
		var map = new google.maps.Map(mapElement, mapOptions);

		for(var i in markers) {
			var marker = new google.maps.Marker({
				position: markers[i].location, 
				icon: markers[i].icon,
				map: map,
			});

			marker.addListener('click', function() {
				map.setCenter(this.position);
				map.setZoom(15);
			});

			$(markers[i].parent).prop('_marker', marker);
		}

		window.addEventListener('resize', function() {
			map.setCenter(center);
		});

		$('.tile.location').click(function() {
			var marker = $(this).prop('_marker');
			if(marker) {
				map.setCenter(marker.position);
				map.setZoom(15);
			}
		});
	}
}*/