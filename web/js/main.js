angular.module('beatMyDj', []).controller('FooterController', function($scope,$http) {
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
