var map;
var infoWindows = [];

initMap();

function initMap() {
	var map = new google.maps.Map(document.getElementById('googleMap'), {
		zoom: 12
	});
	
	var infoWindow = new google.maps.InfoWindow({map: map});

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
			infoWindow.setPosition(pos);
			infoWindow.setContent('Votre Position');
			map.setCenter(pos);
		}, function() {
			var pos = {lat: 48.813533, lng: 2.392854};
			infoWindow.setPosition(pos);
			infoWindow.setContent('Votre Position');
			map.setCenter(pos);
		});
	} else {
		var pos = {lat: 48.813533, lng: 2.392854};
		infoWindow.setPosition(pos);
		infoWindow.setContent('Votre Position');
		map.setCenter(pos);
	}
	
    for (var i = 0; i < events.length; i++) {
		setInfoWindow(events[i].place, events[i].name, map);
    }
}

function setInfoWindow(place, name, map) {
	$.ajax({data: {address:  place}, url: "http://maps.google.com/maps/api/geocode/json",
		success: function(data) {
			var infowindow = new google.maps.InfoWindow({});
	        			
			var marker = new google.maps.Marker({
	        	position: data.results[0].geometry.location,
	        	map: map,
	        	title: name
	        });
			
			bindInfoWindow(marker, infowindow, name, map);
		}
	});
}

function bindInfoWindow(marker, infowindow, name, map) {	
	if (infowindow) {
		infowindow.close();
	}

	google.maps.event.addListener(marker, 'click', function() {
        closeAllInfoWindows();
        infowindow.setContent(name);
        infowindow.open(map, marker);
        infoWindows.push(infowindow);
	});
}

function closeAllInfoWindows() {
	for (var i = 0; i < infoWindows.length; i++) {
		infoWindows[i].close();
	}
}