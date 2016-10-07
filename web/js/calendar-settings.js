$(function () {
	var baseurl = $("input[name='baseurl']").val();
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	$('#calendar-holder').fullCalendar({
		header: {
			left: 'prev',
			right: 'month, agendaWeek, agendaDay, next'
		},
		defaultView : "agendaWeek",
		eventClick: function(calEvent, jsEvent, view) {

			console.log(calEvent);
			$(this).css('border-color', 'red');
		},allDaySlot : false,
		dayClick: function(date, allDay, jsEvent, view) {

			console.log(date);
			moment.locale('fr');
			bootbox.prompt("Quel est le nom de l'evenement ? <br> Date : " + moment(date).format('LLL'), function(result) {
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
});
