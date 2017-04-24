$(document).ready(function(){
	$("#search-query").prop('disabled', true);
	$("#search-query-tchat").prop('disabled', true);

	var baseurl = $("input[name='baseurl']").val();
	var photoPath = $("input[name='photo_path']").val();

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

