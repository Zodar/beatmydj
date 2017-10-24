$(function () {
	jQuery.datetimepicker.setLocale('fr');
	var baseurl = $("input[name='baseurl']").val();
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var prix = $("#userPrix").text().replace( /^\D+/g, '');

	$('#calendar-holder').fullCalendar({
		header: {
			left: 'prev',
			right: 'month, agendaWeek, agendaDay, next,resize'
		},
		aspectRatio: 4.09,
		defaultView : "month",
		eventClick: function(calEvent, jsEvent, view) {

			console.log(calEvent);
			$(this).css('border-color', 'red');
		},allDaySlot : false,
		dayClick: function(date, allDay, jsEvent, view) {
			if ($( "input[name=user_isdj]" ).val() == 0){
				moment.locale('fr');
				bootbox.confirm("<div class='chooseCalendar'> Quand aura lieu l'evenement ? <br/>" + '<input id="eventdatepicker" type="text" ></input>' + "</br>" + get_selects_hours() + " </div>" + $(".alwaysHide .payment").html(), function(result) {
					if (result != null)
						if (result != ""){
							$.ajax({type:"POST", data: {
								date : $('#eventdatepicker').datetimepicker('getValue').getTime(),
								titre : result,
								user : $("input[name='user_id']").val(),
								duree : $("#hourseventdatepicker").val()
							}, url: baseurl + "profil/add_event",
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
										message: 'L\'evenement est en attente de validation du DJ.</br> Le prélévement sera débité une fois que le DJ aura validé'
									});
									$('#calendar-holder').fullCalendar( 'refetchEvents' );
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
				}).find("div.modal-content").addClass("calendarBootbox");
				$(".btn-primary").prop('disabled', true);
				$(".bootbox-body .montant-total").text(prix * $("#hourseventdatepicker").val() +"€");
				$( "#eventdatepicker" ).datetimepicker({
					format:'d/m/Y H:00',
					defaultDate: date._d,
					inline:true,
				});
			}
			else{
				var dialog = bootbox.dialog({
					message: 'Seul un client peux reserver un créneau'
				});
				$('#calendar-holder').fullCalendar( 'refetchEvents' );
				setTimeout(function(){
					dialog.modal('hide')
				}, 1500);
			}
		},
		eventSources: [
			{
				url: baseurl + "profil/userEvent",
				type: 'POST',
				// A way to add custom filters to your event listeners
				data: {
					filter: 'my_custom_filter_param',
					userid : $("input[name='user_id']").val(),
				},
				error: function() {
					//alert('There was an error while fetching Google Calendar!');
				}
			}
			]
	});

	function get_selects_hours(){
		var html = "Durée : <select name='hours' id='hourseventdatepicker'>";
		html += "<option value='1' selected >1H</option>";
		for (var i = 2; 10 > i;i++){
			html += "<option value='"+i + "'>" + i + "H</option>";
		}
		html += "</select>"
			return html;
	}

	
	$("body").on("change",".inputCard",function(){
		console.log("a");
		$(".btn-primary").prop('disabled', false);
		var value = $('.bootbox-body .owner').val();
		if (value.length == 0)
			$(".btn-primary").prop('disabled', true);
		console.log("b");
		var value = $('.bootbox-body .cardNumber').val();
		if (value.length < 14)
			$(".btn-primary").prop('disabled', true);
		console.log("c");
		var value = $('.bootbox-body .cvv').val();
		if (value.length < 1)
			$(".btn-primary").prop('disabled', true);
		var cardDate = new Date("20" + $('.bootbox-body .expirationYear').val(), $('.bootbox-body .expirationMonth').val())
		 todaysDate = new Date();
	    todaysDate.setHours(0, 0, 0, 0);
	    if (cardDate < todaysDate)
	    	$(".btn-primary").prop('disabled', true);
	});
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
	
	$('.nav-tabs #calendrierTab').on('shown.bs.tab', function(event){
		$('#calendar-holder').fullCalendar('render');
	});
	
	$("body").on("change","#hourseventdatepicker",function(){
		$(".bootbox-body .montant-total").text(prix * $(this).val() +"€");

	})

});
