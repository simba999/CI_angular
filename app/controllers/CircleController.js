app.controller('CircleController', function (dataFactory, $scope, $http) {

    $scope.circles = [];
    $scope.editCircle = "";
    $scope.editCircleId = [];
    $scope.assignUsers= [];

    getCircles();
    
    function getCircles() {
        dataFactory.httpRequest('circle/getCircles', 'GET').then(function (data) {
            $scope.circles = data;
        });


    }
	$scope.changeEditMode = function()
	{
			$scope.editCircle = "";
	}
	$scope.searchCircle =function()
	{
			var searchText = $("#serachCircleText").val();
			if(searchText != "" && searchText != "undefined")
			{
				dataFactory.httpRequest('circle/searchCircle', 'GET', {'searchText': searchText}).then(function (data) {
				 $scope.circles = data;
			});
			}
			else
			{
					getCircles();
			}
	}
    $scope.editCircleData = function ($event) {
		$event.preventDefault();
		var form = $("#createCircle");
		$scope.form = {
                circleId: "",
                Name: "",
                color: "",
                goal: "",
                reminder: "",
            }
		angular.copy({},form);
		var target = angular.element($event.currentTarget);
        var circleId = target.attr('circleId');
		dataFactory.httpRequest('circle/getSingleCircle', 'GET', {'circleId': circleId}).then(function (data) {
			/* console.log('circle data');
            console.log(data); */
            $scope.form = {
                circleId: data.Id,
                Name: data.Name,
                color: data.Color,
                goal: data.Goal,
                reminder: parseInt(data.ReminderDay),
            }
			/* console.log('form data');
			console.log($scope.form); */
			$scope.editCircle = "edit";
            $scope.editCircleId = data.Id;
        });
    }
    $scope.deleteCircle = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var circleId = target.attr('circleId');
        alertify.confirm('Delete Circle', 'Are you sure you want to delete this Circle?',
                function ()
                {
                    dataFactory.httpRequest('circle/deleteCircle', 'GET', {'circleId': circleId}).then(function (data) {});
                    getCircles();
                    alertify.notify('Your circle is deleted successfully!', 'success', 5, function () {});
                },
                function ()
                {
                    alertify.error('Cancelled')
                });
    }

    $scope.saveCircle = function () {
        dataFactory.httpRequest(base_url + 'circle/createCircle', 'POST', {}, $scope.form).then(function (data) {
            getCircles();
            $(".modal").modal("hide");
			$scope.editCircle = "";
        });
    }

    $('#circlecolor').colorpicker().on('changeColor',
            function(ev) {
                angular.element($('#colorpicker')).triggerHandler('input');
    });

});