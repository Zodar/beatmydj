var app = angular.module('beatMyDj').config(function($interpolateProvider){
	$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}).filter('parseDate', function() {
	return function(input) {
		return new Date(input);
	};
}).controller('ProfilController', function($scope,$http) {
	var djstreams = Routing.generate('djPanel_streams');
	var djacceptStreams = Routing.generate('djPanel_acceptstreams');
	var djrefuseStreams = Routing.generate('djPanel_refusestreams');
	var djpanel_view = Routing.generate('djpanel_view');
	
	
	$scope.streamcheck = 0; 
	$scope.stateChanged = function (qId) {
		   if(qId){ //If it is checked
			   $scope.streamcheck++; 
		   }
		   else 
			   $scope.streamcheck--; 
	}
	
	$scope.validestream = function(){
		var streamId = getStreamsId();

		console.log(streamId);
		$http({
			url: djacceptStreams,
			method: "POST",
			data: {ids: streamId},
			headers: {'Content-Type': 'application/json'}
		})
		.then(function(response) {
			console.log(response)
			afterAction(response.data.info)
			$scope.loadstream();
		}, 
		function(response) { // optional
		});
	}
	
	
	$scope.refusestream = function(){
		var streamId = getStreamsId();

		console.log(streamId);
		$http({
			url: djrefuseStreams,
			method: "POST",
			data: {ids: streamId},
			headers: {'Content-Type': 'application/json'}
		})
		.then(function(response) {
			console.log(response)
			afterAction(response.data.info);
			$scope.loadstream();
		}, 
		function(response) { // optional
		});
	}
	$http.get(djpanel_view).then(function(response) {
		$scope.views = response.data.views;
	});	
	djpanel_view
	$scope.loadstream = function (){
		$http.get(djstreams).then(function(response) {
			$scope.streams = response.data.streams;
		});	
	};
	
	$scope.loadstream();
	
});

function afterAction(info){
	var dialog = bootbox.alert({
		message: info
	});
	setTimeout(function(){
		dialog.modal('hide')
	}, 1500);
}
function getStreamsId(){
	var streamId = new Array();
	$("body input.events:checked").each(function(){
		streamId.push($(this).attr("eventid")); 
	});
	return streamId;
}
function selectRow(row)
{
    var firstInput = row.parentElement.getElementsByTagName('input')[0];
    firstInput.checked = !firstInput.checked;
}