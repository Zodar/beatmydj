var app = angular.module('beatMyDj').config(function($interpolateProvider){
	$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}).filter('parseDate', function() {
	return function(input) {
		return new Date(input);
	};
}).controller('ChatController', function($scope,$http) {
	$scope.showme = false;

	$scope.canchat = function(){
		var ownUserName = document.getElementsByName("user_userName")[0];
		if (ownUserName != null && ownUserName != "") {
			$scope.showme = !$scope.showme;
		} else {
			$scope.showme = false;
			alert("Veuillez vous connecter pour pouvoir utiliser le tchat");
		}
	}
	var getOnlineUser = Routing.generate('getOnlineUser');
	
	$http.get(getOnlineUser).then(function(response) {
		$scope.useronline = response.data.users;
		$(".chat").css("display", "block");
	});	
});

$('body').on('click', '.conversation__header', function() {
	$(this).closest('.conversation').removeClass("isShown");
	$(this).closest('.conversation').addClass("isHidden");
    $(this).closest('.conversation').slideToggle(300);
});

$('body').on('click', '.chat__human', function() {
	var nom = $(this).find(".chat__name").html();
	newDiscussion(nom);
});

function newDiscussion (nom) {
	if ($("#conversation_"+nom).length == 0) {
		$('.all_conversation').append("<div id='conversation_"+nom+"' class='conversation'> <div class='conversation__header'>"+nom+"</div> <ul class='conversation__wrap'> </ul> <input class='input_chat' type='text' /> </div>");
	    $("#conversation_"+nom).slideToggle(300);
	    $('#conversation_' + nom).addClass("isShown");
	    $('#conversation_' + nom).removeClass("isHidden");
	    
	    $("#conversation_"+nom).siblings('.isShown').addClass("isHidden");
		$("#conversation_"+nom).siblings('.isShown').slideToggle(300);
		$("#conversation_"+nom).siblings('.isShown').removeClass("isShown");
		
	    $('.input_chat').focus();
	} else {
		$("#conversation_"+nom).siblings('.isShown').addClass("isHidden");
		$("#conversation_"+nom).siblings('.isShown').slideToggle(300);
		$("#conversation_"+nom).siblings('.isShown').removeClass("isShown");
		
		if ($("#conversation_"+nom).hasClass("isShown")) {
			$("#conversation_"+nom).slideToggle(300);
		    $('#conversation_' + nom).addClass("isHidden");
			$('#conversation_' + nom).removeClass("isShown");
		} else {
			$("#conversation_"+nom).slideToggle(300);
		    $('#conversation_' + nom).addClass("isShown");
			$('#conversation_' + nom).removeClass("isHidden");
		}
	}
}

$('body').on('keypress', '.input_chat', function(e) {
    if (e.which == 13) {

    	var baseurl = $("input[name='baseurl']").val();
    	var ownUserName = $("input[name='user_userName']").val();
    	var nom = $(this).siblings('.conversation__header').html();
    	var msgValue = $(this).val();
    	
    	var msg = "<li class='conversation__msg cf'> <br> <span class='right_chat'>";
    	msg += msgValue;
    	msg += "</span> </li>";
    	$(this).siblings(".conversation__wrap").append(msg);
    	$(this).siblings(".conversation__wrap").animate({ scrollTop: 100000 }, "slow");
    	
    	$.ajax({type:"POST", data: {to: nom, from: ownUserName, value: msgValue}, url: baseurl + "post_tchat_msg",
			success: function(data) {
				console.log(data);
			},
			error: function(data){
				console.log(data);
			}
		});
		$(this).val("");
    }
});
var ownUserName = $("input[name='user_userName']").val();
if (ownUserName != null)
setInterval(function() {
	var baseurl = $("input[name='baseurl']").val();
	var ownUserName = $("input[name='user_userName']").val();
	$.ajax({type:"GET", url: baseurl + "get_tchat_msg",
		success: function(data) {
			$(data.value).each(function() {
				if ($("#conversation_"+this.from).length < 1 || $("#conversation_"+this.from).hasClass("isHidden")) {
					newDiscussion(this.from);
				}
				if ($("#msg_"+this.id).length < 1) {
					var msg = "<li class='conversation__msg cf'> <br> <span id='msg_" + this.id + "' class=''>";
					msg += this.value;
					msg += "</span> </li>";
					$("#conversation_" + this.from).find(".conversation__wrap").append(msg);
					$("#conversation_" + this.from).find(".conversation__wrap").animate({ scrollTop: 100000 }, "slow");
			    	$.ajax({type:"POST", data: {id: this.id}, url: baseurl + "set_viewed_tchat_msg",
						success: function(data) {
						},
						error: function(data){
							console.log(data);
						}
					});
				}
			});
		},
		error: function(data){
			console.log(data);
		}
	});
}, 3000);