$(document).ready(function(){
	$("#search-query").prop('disabled', true);
	$("#search-query-tchat").prop('disabled', true);

	var baseurl = $("input[name='baseurl']").val();
	var photoPath = $("input[name='photo_path']").val();
	getAllUsers();

	$("#advanced_search input[type=checkbox]").change(function() {

		var form = $("#advanced_search form").serialize();
		$.ajax({type:"POST", data: {name : "style",value : form}, url: baseurl + "search_advanced",
			success: function(data){
				$("#dj_links").empty();
				$(data.data).each(function(){
					var test ="";
					test += "<div class=\"liste_dj_img_div\">";
					test += "<a href=\"" + photoPath + this.path + "\" title=\"\" data-gallery>";
					test += "<img src=\"" + photoPath + this.path + "\"  alt=\"" + this.userName + "\" />";
					test += "</a>";
					test += "<div class=\"liste_dj_desc_div\">";
					test += "<a href=\"profil\\" + this.userName + "\"type=\"button\" class=\"btn btn-primary\">";
					test += this.userName;
					test += "</a></div></div>";
					$("#dj_links").append(test);
				});
			},
			error: function(data){
				console.log(data.responseText);
			}
		});
	});
});

function getAllUsers() {
	var baseurl = $("input[name='baseurl']").val();
	var photoPath = $("input[name='photo_path']").val();

	$.ajax({data: $(this).serialize(), url: baseurl + "get_all_dj",
		success: function(data) {
			var usernames = new Array();
			var nbUsers = data.users.length - 1;
			$(".button_chat.js-trigger").html("Chat (" + nbUsers + ")");
			$(".chat__users").html("Utilisateurs: " + nbUsers);
	    	var ownUserName = $("input[name='user_userName']").val();

			$.each(data.users, function(k, v) {
				if (ownUserName != v.userName) {
					usernames.push(v.userName);
					var chat_choice = " <li class='chat__human'> <img class='chat__avatar' src=\"" + photoPath + v.path + "\"  alt=\"" + v.userName + "\" /> ";
					chat_choice += " <span class='chat__name'>" + v.userName + "</span> </li>";
					$(".chat__wrapper").append(chat_choice);
				}
			});
			$("#search-query").prop('disabled', false);
			$("#search-query-tchat").prop('disabled', false);
			$("#style-form-listeDJ").css('display', 'block');

			$("#search-query").autocomplete({
				source: usernames,
				select: function(event, ui) {
					if (ui.item) {
						$('#search-query').val(ui.item.value);
					}
					window.location.href =  baseurl + "profil/" + ui.item.value;
				}
			});
		},
		error: function(data){
			console.log(data);
		}
	});
}