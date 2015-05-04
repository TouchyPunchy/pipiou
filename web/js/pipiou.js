
function show_map(position) {
	var latitude = position.coords.latitude;
	var longitude = position.coords.longitude;

	// replace "toner" here with "terrain" or "watercolor"
	var layer = new L.StamenTileLayer("toner");
	var map = new L.Map("map", {
	    center: new L.LatLng(48.855,2.35),// PARIS // SF :37.7, -122.4),
	    zoom: 12
	});
	// Creates a marker with the tint icon
	var pipiMarker = L.AwesomeMarkers.icon({
		icon: 'tint',
		markerColor: 'orange'
	});

	var places = JSON.parse($("#map").attr("data-places"));
	var markers = [];
	places.forEach(function(p) {
		var pos = [p.position.x,p.position.y];
		var marker = L.marker(pos, {icon: pipiMarker, clickable: true});
		marker.name = p.name;
		marker.id = p.id;
		marker.creator = p.creator;
		marker.on('click', onMarkerClick);
		markers.push(marker);
		marker.addTo(map);
	});
	map.addLayer(layer);

	var popup = L.popup();
	function onMapClick(e) {
		$("#form_position").val(e.latlng.lat + " " + e.latlng.lng);
	    popup
	        .setLatLng(e.latlng)
	        .setContent("You clicked the map at " + e.latlng.toString())
	        .openOn(map);
	}

	function onMarkerClick(e){
		alert(e.target.name + " " + e.target.id + ", added by " + e.target.creator);
	}

	map.on('click', onMapClick);
}

//navigator.geolocation.getCurrentPosition(show_map);
var position = {
	coords : {
		latitude : 48.855,
		longitude : 2.35
	}
};
show_map(position);
