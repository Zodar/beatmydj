$(function () {
	var baseurl = $("input[name='baseurl']").val();
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	$('#calendar-holder').fullCalendar({
		header: {
			left: 'prev',
			right: 'month, agendaWeek, agendaDay, next,resize'
		},
		defaultView : "agendaWeek",
		eventClick: function(calEvent, jsEvent, view) {

			console.log(calEvent);
			$(this).css('border-color', 'red');
		},allDaySlot : false,
		dayClick: function(date, allDay, jsEvent, view) {

			console.log(date);
			moment.locale('fr');
			bootbox.prompt("Quand aura lieu l'evenement ? <br> Date : " + get_selects(date) + "</br>" + get_selects_hours(), function(result) {
				if (result != null)
					if (result != ""){
						$.ajax({type:"POST", data: {date : Date.parse(date),titre : result,user : $("input[name='user_id']").val()}, url: baseurl + "profil/add_event",
							success: function(data){
								if (data.success == "false"){
									var dialog = bootbox.alert({
										message: data.info
									});
									setTimeout(function(){
										dialog.modal('hide')
									}, 1500);

								}
								else{
									console.log(data.responseText);
									var dialog = bootbox.dialog({
										message: 'L\'evenement a bien été créé'
									});
									setTimeout(function(){
										dialog.modal('hide')
									}, 1500);
								}
							},
							error: function(data){
								console.log(data.responseText);
							}
						});



					}
			});
		},
		eventSources: [
		               {
		            	   url: Routing.generate('fullcalendar_loader'),
		            	   type: 'POST',
		            	   // A way to add custom filters to your event listeners
		            	   data: {
		            		   filter: 'my_custom_filter_param',
		            		   userid : $("input[name='user_id']").val()
		            	   },
		            	   error: function() {
		            		   //alert('There was an error while fetching Google Calendar!');
		            	   }
		               }
		               ]
	});

	function get_selects_hours(){
		var html = "Durée : <select name='hours' >";
		var select = "";
		for (var i = 0; 10 > i;i++){
			html += "<option value='"+i + "'"+ select + ">" + i + "H</option>";
			select = "";
		}
		html += "</select>"
			return html;
	}
	function get_selects(date){
		 moment.locale('fr');
		var months = moment.months();
		var html = "<select name='day' >";
		var select = "";
		for (var i = 0; 31 > i;i++){
			if (date.getDate() == i)
				select = "selected"
			html += "<option value='"+i + "'"+ select + ">" + i + "</option>";
			select = "";
		}
		
		html += "</select> <select>";
		for (var i = 0; months.length > i;i++){
			if (date.getMonth() == i)
				select = "selected"
			html += "<option value='"+i + "'"+ select + ">" + months[i] + "</option>"
			select = "";
		}
		html += "</select> <select>";
		var year = new Date().getFullYear();
		for (var i = year ; year + 2 > i;i++){
			if (date.getFullYear() == i)
				select = "selected"
			html += "<option value='"+i + "'"+ select + ">" + i + "</option>"
			select = "";
		}
		html += "</select>"
			
			return html;
	}
	$("#enlarge-calendar").click(function(){
		$("#calendar-holder").fullCalendar('option', 'height', 900);
		$('#calendar-holder').fullCalendar('option', 'aspectRatio', 10);
		var t = $("#calendar-holder").attr("id","calendar-holderbig");
//		$(".dispo #calendar-holder").hide();
		
		var dialog = bootbox.dialog({
			message: t,
			className: "bootbox-calendar",
			  onEscape: function() {
				  $(".dispo").append($("#calendar-holderbig"))
				 $("#calendar-holderbig").attr("id","calendar-holder");
					$('#calendar-holder').fullCalendar('option', 'aspectRatio', 1);
					$("#calendar-holder").fullCalendar('option', 'height', 300);
					$(window).trigger('resize');
					console.log("show");
			        // you can do anything here you want when the user dismisses dialog
			    }
		});
		
		$(window).trigger('resize');
		console.log("hide");
		
	})
});
