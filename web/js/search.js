$(document).ready(function(){

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
	var getAllUser = Routing.generate('getAllUser');
	var profil = Routing.generate('profil');

	$.ajax({data: $(this).serialize(), url: getAllUser,
		success: function(data){
			var usernames = new Array();
			$.each(data.users, function(k, v) {
				usernames.push(v.userName);
			});
			$("#search-query").prop('disabled', false);
			$("#style-form-listeDJ").css('display', 'block');

			$("#search-query").autocomplete({
				source: usernames,
				select: function(event, ui) {
					if(ui.item){
						$('#search-query').val(ui.item.value);
					}
					window.location.href =  profil + "/" + ui.item.value;
				}
			});
		},
		error: function(data){
			console.log(data);
		}
	});
}