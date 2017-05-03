angular.module('beatMyDj', []).controller('FooterController', function($scope,$http) {
	$scope.userReview = function(){
		var dialog = bootbox.dialog({
			title: 'Notez nous',
			message: '<div class="formAvis" >'+
			'<div class="starRating"><p class="detailRating"> La note de BeatMyDJ </p> <div class="divstar"> <input class="star star-5" id="star-5" type="radio" name="star"/>' +
			'<label class="star star-5" for="star-5"></label>' +
			'<input class="star star-4" id="star-4" type="radio" name="star"/>' +
			'<label class="star star-4" for="star-4"></label>' +
			'<input class="star star-3" id="star-3" type="radio" name="star"/>' +
			'<label class="star star-3" for="star-3"></label>'+
			'<input class="star star-2" id="star-2" type="radio" name="star"/>'+
			'<label class="star star-2" for="star-2"></label>'+
			'<input class="star star-1" id="star-1" type="radio" name="star"/>'+
			'<label class="star star-1" for="star-1"></label> </div></div>'+
			'<div class="avisarea"><p >Un avis ? </p> <textarea id="textavis" name="avis"/>' + 
			'<div> <Button class="SendReview">Envoyer</button></div></div></div>' 
		});
	}
});;
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
