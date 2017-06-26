$(document).ready(function(){
	
	var baseurl = $("input[name='baseurl']").val();
	
	$("#inscription_form").submit(function(e) {
		$("#inscription_form span.info").text("");
		e.preventDefault();
		$.ajax({type:"POST", data: $(this).serialize(), url: baseurl + "register",
			success: function(data){
				if (data.value == "false") {
					$("#inscription_modal span.info").css("color", "red");
					$("#inscription_modal span.info").css("font-weight", "bold");
					$("#inscription_modal span.info").text(data.name);
									console.log(data);

				}
				else {
					$("#inscription_form .modal-body").prepend("<p id='dataname_result'> " + data.name + " </p>");
					$("#dataname_result").css("color", "red");
					$("#dataname_result").css("font-weight", "bold");
					$("#dataname_result").text(data.name);
					$("#inscription_form .modal-body").css("background","gray");
					setTimeout(function(){ window.location.replace(baseurl + "login"); }, 1000);
				} 
			},
			error: function(data){
				console.log(data.responseText);
			}
		});
		return false;
	});
	
//	$("#connexion_form").submit(function(e) {
//		console.log("envoi");
//		$("#connexion_form span.info").text("");
//		e.preventDefault();
//		$.ajax({type:"POST", data: $(this).serialize(), url:"app_dev.php/login",
//			success: function(data){
//				console.log(data);
//			},
//			error: function(data){
//				console.log(data.responseText);
//			}
//		});
//		return false;
//	});
})
