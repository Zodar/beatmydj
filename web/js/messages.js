$(document).ready(function(){
	var baseurl = $("input[name='baseurl']").val();
	
	$(".list_user .users").on("click", function() {
		$(".users").css("opacity", "0.3");
		$(this).css("opacity", "1");
	    
		$(".list_threads .threads").hide();
		$("#thread_" + $(this).attr("id")).show();
	});
	
	$(".send_message").on("click",function(){
		if ($("#response_" + $(this).attr("thread")).val().trim() == "") {
			return;
		}

		$.ajax({type:"POST", data: {id: $(this).attr("thread"), body: $("#response_" + $(this).attr("thread")).val()}, url: baseurl + "messages",
			success: function(data) {
				location.reload();
			},
			error: function(data) {
				console.log(data.responseText);
			}
		});
	});
});

