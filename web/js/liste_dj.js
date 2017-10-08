var range = document.getElementById('range');

var app = angular.module('beatMyDj' ).config(function($interpolateProvider){
	$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
}).controller('ListeController', function($scope,$http) {

	var getAllDj = Routing.generate('getAllUser');
	var getDjFiltred = Routing.generate('getFiltredDj');

	$scope.reloadAllform  = function(){
		$scope.allstyle = true;
		$scope.style = null;
		$http.get(getAllDj).then(function(response) {
			$scope.DJS = response.data.users.user;
		});	
	}
	$scope.refreshForm  = function(){
		$scope.allstyle = null;
		result = Array();
		if ($scope.style != null)
		{
			var result = Object.keys($scope.style).filter(function(x) { 
				return $scope.style[x] !== false; 
			});
		}
		if (result.length == 0 )
			$scope.allstyle = true;
		var prix = range.noUiSlider.get();
		console.log(prix);
		console.log($scope.experience);

		$http({
			url: getDjFiltred, 
			method: "POST",
			headers: {
				'Content-Type': 'application/json'
			},
			data: {style: result, prix: prix, experience: $scope.experience}
		}).then(function(response) {
			$scope.DJS = response.data.users;
		});	;


	}
	$scope.reloadAllform ();
});



range.style.height = '400px';
range.style.margin = '0 auto 30px';



noUiSlider.create(range, {
	start: [ 20,200 ], // 4 handles, starting at...
	connect: true, // Display a colored bar between the handles
	direction: 'rtl', // Put '0' at the bottom of the slider
	orientation: 'vertical', // Orient the slider vertically
	behaviour: 'tap-drag', // Move handle on tap, bar is draggable
	step: 10,
	tooltips: true,
	range: {
		'min': 20,
		'max': 200
	},
	pips: { // Show a scale with the slider
		mode: 'steps',
		stepped: true,
		density: 2
	}
});

range.noUiSlider.on('change', function(){
    var scope = angular.element(document.getElementById("advancedSearchId")).scope();

    scope.refreshForm();
});