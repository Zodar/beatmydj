

angular.module('beatMyDj', []).filter('secondsToDateTime', [function() {
	return function(seconds) {
		return new Date(1970, 0, 1).setSeconds(seconds);
	};
}]).controller('HeaderController', function($scope,$http) {
	var getStreamAvaible = Routing.generate('streamavailable');

	$http.get(getStreamAvaible).then(function(response) {
		if (response.data["events"] != null){
			$scope.nextlive = new Date(response.data["events"] * 1000);
			if (document.getElementById("voirLive") != null)
				document.getElementById("voirLive").href = document.getElementById("voirLive").href + response.data["id"];

			CountDownTimer($scope.nextlive, 'remainig');
		}

	});	
});

angular.module('beatMyDj').controller('FooterController', function($scope,$http) {
	var modalDiv = $('#avis').html();
	$scope.userReview = function(){
		var dialog = bootbox.dialog({
			title: 'Notez nous',
			message:  modalDiv
		});
	}
});
$( document ).ready(function() {
	$("body").on("click",".SendReview",function(){
		var note = "na"
			if ($(".formAvis input:checked").length != 0)
				note = $(".formAvis input:checked").attr("class").match(/\d+/)[0]
		var avisurl = Routing.generate('post_avis');
		bootbox.hideAll()
		$.ajax({type:"POST", data: {
			note: note, 
			text: $("#textavis").val(),
			page: window.location.href
		}, url: avisurl,
		success: function(data) {
			if (data.mail == 1){
				var dialog = bootbox.dialog({
					message: 'Votre avis a bien été envoyé ! Merciiiiiii'
				});
				setTimeout(function(){
					dialog.modal('hide')
				}, 1500);
			}
		},
		error: function(data){
			console.log(data);
		}
		});
	});
});

function CountDownTimer(dt, id)
{
	var end = dt;

	var _second = 1000;
	var _minute = _second * 60;
	var _hour = _minute * 60;
	var _day = _hour * 24;
	var timer;

	function showRemaining() {
		var now = new Date();
		var distance = end - now;
		if (distance < 0) {
			$("#beforeLive").hide();
			$("#gotolive").show();
			return;
		}
		var days = Math.floor(distance / _day);
		var hours = Math.floor((distance % _day) / _hour);
		var minutes = Math.floor((distance % _hour) / _minute);
		var seconds = Math.floor((distance % _minute) / _second);

		if (days >= 2)
		{
			document.getElementById(id).innerHTML = " + de " +  days + ' jours ';        	
		}
		else{
			if (days == 0)
				document.getElementById(id).innerHTML = "";
			else
				document.getElementById(id).innerHTML = days + ' jours ';
			document.getElementById(id).innerHTML += hours + ' hrs ';
			document.getElementById(id).innerHTML += minutes + ' mins ';
			document.getElementById(id).innerHTML += seconds + ' secs';
		}

		if (days == 0 && hours == 0 && minutes < 15){
		$("#liveEnCours").show();
		$("#beforeLive").hide();
		
		}
}

timer = setInterval(showRemaining, 1000);
}
