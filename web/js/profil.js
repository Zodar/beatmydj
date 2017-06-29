$(document).ready(function(){
	var baseurl = $("input[name='baseurl']").val();
	var path_messages = $("input[name='path_messages']").val();
	var page_type = $("input[name='page_type']").val();
		
	$("#send_messages").on("click",function(){
		if($("#new_messages").val() == ""){
			alert("Un message vide ne peux être envoyé");
			return;
		}

		$.ajax({type:"POST", data: {userId :  $(this).attr("userid") ,body : $("#new_messages").val()}, url: baseurl + "messages_new",
			success: function(data){
				var dialog = bootbox.dialog({
					message: 'Votre message a bien été envoyé'
				});
				setTimeout(function(){ window.location.replace(path_messages); }, 1000);
			},
			error: function(data){
				console.log(data.responseText);
			}
		});
	})
	
	switch (page_type) {
	    case "own_profil_edit":
	        own_profil_edit();
	        break;
	    case "own_profil_view":
	    	$(".only_view").css("display", "inline");
	    	$(".only_view").css("visibility", "visible");
	    	break;
	    case "other_profil":
	    	$(".only_other_profil").css("display", "inline");
	    	$(".only_other_profil").css("visibility", "visible");
	        break;
	    case "unsigned":
	    	$(".only_unsigned").css("display", "inline");
	       	$(".only_unsigned").css("visibility", "visible");
	}

	function own_profil_edit() {
    	$(".only_edit").css("display", "inline");
        $(".only_edit").css("visibility", "visible");
    	$.fn.editable.defaults.mode = 'popup';
    	$.fn.editable.defaults.showbuttons = "bottom";
    	$.fn.editable.defaults.placement = "right";
    	$.fn.editable.defaults.ajaxOptions = {type: "POST"};
    	var finalURL = baseurl + 'profil/edit';
    	$('#userFirstName').editable({type: 'text', pk: 1, url: finalURL, title: 'Prénom', validate: requiered});
    	$('#userLastName').editable({type: 'text', pk: 1, url: finalURL, title: 'Nom', validate: requiered});
    	$('#userLocation').editable({type: 'text', pk: 1, url: finalURL, title: 'Localisation', validate: requiered});
    	$('#userEmail').editable({type: 'text', pk: 1, url: finalURL, title: 'Email', validate: requiered});
    	$('#userTarif').editable({type: 'text', pk: 1, url: finalURL, title: 'Tarif', validate: requiered});
    	$('#userStyles').editable({type: 'text', pk: 1, url: finalURL, title: 'Styles'});
    	$('#userPresentation').editable({type: 'textarea', pk: 1, url: finalURL, title: 'Présentation', inputclass: 'for_prez', rows: 7, mode: "inline", validate: requiered});
    	$('#userDisponibilite').editable({type: 'text', pk: 1, url: finalURL, title: 'Disponibilité', validate: requiered});
    	$('#changePlaylist').editable({type: 'text', pk: 1, url: finalURL, title: 'Lien de la playlist SoundClood', validate: requiered});
	}
	
	/*
		Fonction de validation du formulaire
	*/
	function requiered(value) {
		if ($.trim(value) == '') {
	        return 'Le champ est vide';
	    } 
		if (value.length > 250) {
		    return 'Le champ dépasse le nombre de caractères autorisé';	
	    }
	}
	/*
		Fonction d'édition de profil
	*/	
	$("#prez_edit").click(function(e){
		var form = $("#style-form").serialize();
		$.ajax({type:"POST", data: {name : "style",value : form}, url: baseurl + "profil/edit",
			success: function(data){
				console.log(data.responseText);
				var dialog = bootbox.dialog({
					message: 'Vos informations ont bien été enregistré'
				});
				setTimeout(function(){
					dialog.modal('hide')
				}, 1500);
			},
			error: function(data){
				console.log(data.responseText);
			}
		});
	});

	/*
		Fonction d'import de fichier
	*/
	$('#fileToUpload').change(function(){
		var file = this.files[0];
		var name = file.name;
		var size = file.size;
		var type = file.type;

		var reader = new FileReader();
		reader.onload = function (e) {
			$('#user_image').attr('src', e.target.result);
		}
		reader.readAsDataURL($('#fileToUpload')[0].files[0]);
	});

	$("#formImgUpld").submit(function(event ){
		event.preventDefault();
		var formData = new FormData($('#formImgUpld')[0]);
		$.ajax({
			url: baseurl + 'profil/edit/picture',
			type: 'POST',
			dataType: 'json',
			success: function(data){
				if (data.success == "true"){
					var dialog = bootbox.dialog({
						message: 'Vos informations ont bien été enregistré'
					});
					setTimeout(function(){dialog.modal('hide')},1500);
				}
			},
			error: function(data){
				console.log(data.responseText);
			},
			data:new FormData(this),
			cache: false,
			contentType: false,
			processData: false
		});
	});

	/*
		Fonction de Suppression d'utilisateur
	*/
	$("#remove_user").click(function(e){
		bootbox.confirm("Etes vous sur de vouloir supprimer votre compte ?", function(result) {
			if (result) {
				$.ajax({type:"POST", url: baseurl + "profil/remove",
					success: function(data){
						if (data.success == "true") {
							setTimeout(function() {
								window.location.href = baseurl;
							}, 1000);
						}
					}, error: function(data) {
						console.log(data.responseText);
					}
				});
				return false;
			} 
		});
	});
	
	/*
		Fonction d'ajout de commentaire
	*/
	$("#add_comment").click(function(e){
		var comment = $.trim($('#my_comment').val());
		if (comment.length == 0){
			return;
		}

		$.ajax({type:"POST", data: {
			content : comment,
			userpage : $("input[name='user_id']").val(),
			response : null
		}, url: baseurl + "profil/addcomment",
		success: function(data){
			var mes = "";
			if (data.success == "true") {
				mes = "Votre avis a bien été envoyé"

			}
			else 
				mes = "une erreur s'est produite";
			var dialog = bootbox.dialog({
				message: mes
			});
			setTimeout(function(){dialog.modal('hide')},1500);
			location.reload();
		},
		error: function(data){
			console.log(data.responseText);
		}
		});

	});

	/*
		Fonction d'envoi de message
	 */
	$("#new_message").click(function(){
		bootbox.prompt({
			title : "Message privé a : " + $(".username").html(), 
			inputType : "textarea",
			callback : function(result){
				if (result != null && result.length > 0)
				$.ajax({type:"POST", data: {userId :  $("input[name='user_id']").val()  ,body : result}, url: baseurl + "messages_new",
					success: function(data){
						var dialog = bootbox.dialog({
							message: 'Votre message a bien été envoyé'
						});
						setTimeout(function(){ window.location.replace(path_messages); }, 1000);
					},
					error: function(data){
						console.log(data.responseText);
					}
				});		
			}
		})
	})

})