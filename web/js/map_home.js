var map;
var infoWindows = [];

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
    	var place = events[i].place;
    	var name = events[i].name;
		setInfoWindow(place, name, map);
	}
}

function setInfoWindow(place, name, map) {
	$.ajax({data: {address:  place}, url: "https://maps.google.com/maps/api/geocode/json",
		success: function(data) {
			if (data.status === google.maps.GeocoderStatus.OK)
			{
				var infowindow = new google.maps.InfoWindow({});
				var marker = new google.maps.Marker(
				{
			    	position: data.results[0].geometry.location,
			    	map: map,
			    	title: name
		    	});
				bindInfoWindow(marker, infowindow, name, map);
		   	} 
		    else if (data.status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) 
		    {    
		        setTimeout(function()
			    {
		            setInfoWindow(place, name, map);
		        }, 100);
			} 
		    else
		    {
	            console.log(data);
		    }				
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
