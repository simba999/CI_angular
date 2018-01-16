var app =  angular.module('crm-App',['ui.select2', 'ui.select','summernote', 'angularUtils.directives.dirPagination']);
app.filter('datetimeToNow', function() {
	
  return function(input,currentTime) {
    if(!input) return;
	return moment(input).fromNow();
  };
});
app.config(['$qProvider', function ($qProvider) {
    $qProvider.errorOnUnhandledRejections(false);
}]);
app.filter('unsafe', function($sce) { return $sce.trustAsHtml; });
app.filter('datetimeToPast', function() {
  return function(input) {
    if(!input) return;
	var currentDate = new Date();
	year = currentDate.getFullYear();
	month = currentDate.getMonth()+1;
	dt = currentDate.getDate();
	var cdate = year+'-'+month+'-'+dt;
	var fromdate = moment(cdate, 'YYYY-MM-DD'); // format in which you have the date
	var to = moment(input, 'YYYY-MM-DD');
	var pastTime =  fromdate.diff(to, 'days')+" day late";
	//console.log(fromd.diff(to, 'days')); 
	/* var pastTime = moment(input).fromNow();
	//daydiff(currentDate,input)
	pastTime = pastTime.replace("ago", "late"); */
    return pastTime;
  };
});
app.filter('compare2dates', function() {
		
  return function(input) {
    if(!input) return;
	var currentDate = new Date();
	year = currentDate.getFullYear();
	month = currentDate.getMonth()+1;
	dt = currentDate.getDate();
	var cdate = year+'-'+month+'-'+dt;
	var fromdate = moment(cdate, 'YYYY-MM-DD'); // format in which you have the date
	var to = moment(input, 'YYYY-MM-DD');
	var differnaceDays =  fromdate.diff(to, 'days');
	/* Gray == #A9A9A9
	orrange = #FFA500
	red = #	#FF0000 */
	var colorVal = '#A9A9A9';
	if(differnaceDays < 0)
	{
			colorVal = '#FF0000';
			//return colorVal;
	}
	else if(differnaceDays == 1)
	{
				colorVal = '#FFA500';
				//return colorVal;
	}
	
	console.log("color ="+colorVal);
	console.log("differnaceDays ="+differnaceDays);
	return "1";
  };
});
app.filter('spaceless',function() {
	
    return function(input) {
		if(!input) return;
        if (input) {
            return input.replace(/\s+/g, '-');    
        }
    };
});
app.directive('validPasswordC', function() {
  return {
    require: 'ngModel',
    scope: {

reference: '=validPasswordC'

    },
    link: function(scope, elm, attrs, ctrl) {
      ctrl.$parsers.unshift(function(viewValue, $scope) {

        var noMatch = viewValue != scope.reference
        ctrl.$setValidity('noMatch', !noMatch);
        return (noMatch)?noMatch:!noMatch;
      });

      scope.$watch("reference", function(value) {;
        ctrl.$setValidity('noMatch', value === ctrl.$viewValue);

      });
    }
  }
});
app.directive('confirmClick', ['$q', 'dialogModal', function($q, dialogModal) {
      return {
          link: function (scope, element, attrs) {
              // ngClick won't wait for our modal confirmation window to resolve,
              // so we will grab the other values in the ngClick attribute, which
              // will continue after the modal resolves.
              // modify the confirmClick() action so we don't perform it again
              // looks for either confirmClick() or confirmClick('are you sure?')
              var ngClick = attrs.ngClick.replace('confirmClick()', 'true')
                  .replace('confirmClick(', 'confirmClick(true,');

              // setup a confirmation action on the scope
              scope.confirmClick = function(msg) {
                  // if the msg was set to true, then return it (this is a workaround to make our dialog work)
                  if (msg===true) {
                      return true;
                  }
                  // msg can be passed directly to confirmClick('are you sure?') in ng-click
                  // or through the confirm-click attribute on the <a confirm-click="Are you sure?"></a>
                  msg = msg || attrs.confirmClick || 'Are you sure?';
                  // open a dialog modal, and then continue ngClick actions if it's confirmed
                  dialogModal(msg).result.then(function() {
                      scope.$eval(ngClick);
                  });
                  // return false to stop the current ng-click flow and wait for our modal answer
                  return false;
              };
          }
      }
 }]);
app.service('dialogModal', ['$modal', function($modal) {
      return function (message, title, okButton, cancelButton) {
          // setup default values for buttons
          // if a button value is set to false, then that button won't be included
          okButton = okButton===false ? false : (okButton || 'Confirm');
          cancelButton = cancelButton===false ? false : (cancelButton || 'Cancel');

          // setup the Controller to watch the click
          var ModalInstanceCtrl = function ($scope, $modalInstance, settings) {
              // add settings to scope
              angular.extend($scope, settings);
              // ok button clicked
              $scope.ok = function () {
                  $modalInstance.close(true);
              };
              // cancel button clicked
              $scope.cancel = function () {
                  $modalInstance.dismiss('cancel');
              };
          };

          // open modal and return the instance (which will resolve the promise on ok/cancel clicks)
          var modalInstance = $modal.open({
              template: '<div class="dialog-modal"> \
                  <div class="modal-header" ng-show="modalTitle"> \
                      <h3 class="modal-title">{{modalTitle}}</h3> \
                  </div> \
                  <div class="modal-body">{{modalBody}}</div> \
                  <div class="modal-footer"> \
                      <button class="btn btn-primary" ng-click="ok()" ng-show="okButton">{{okButton}}</button> \
                      <button class="btn btn-warning" ng-click="cancel()" ng-show="cancelButton">{{cancelButton}}</button> \
                  </div> \
              </div>',
              controller: ModalInstanceCtrl,
              resolve: {
                  settings: function() {
                      return {
                          modalTitle: title,
                          modalBody: message,
                          okButton: okButton,
                          cancelButton: cancelButton
                      };
                  }
              }
          });
          // return the modal instance
          return modalInstance;
      }
 }]);
 
 app.directive('loading', function () {
      return {
        restrict: 'E',
        replace:true,
        template: '<div class="loading"><img src="http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif" width="20" height="20" />LOADING...</div>',
        link: function (scope, element, attr) {
              scope.$watch('loading', function (val) {
                  if (val)
                      $(element).show();
                  else
                      $(element).hide();
              });
        }
      }
});
app.directive('validFile',function(){
  return {
    require:'ngModel',
    link:function(scope,el,attrs,ngModel){
      //change event is fired when file is selected
      el.bind('change',function(){
        scope.$apply(function(){
          ngModel.$setViewValue(el.val());
          ngModel.$render();
        });
      });
    }
  }
});
/* app.directive('googleplace', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
                scope.$apply(function() {
                    model.$setViewValue(element.val());                
                });
            });
        }
    };
}); */
/* app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/dashboard', {
                templateUrl: 'dashboard/index.php',
                controller: 'DashboardController'
            }).
            when('/leads', {
                templateUrl: 'templates/items.html',
                controller: 'ItemController'
            });
	}
]); */



app.directive('bgDate', function () {
    return {
        scope: {
            enableDefault: '='
        },
        link: function(scope, element, attr) {

            attr.$observe('bgDate', function() {

                if (attr.bgDate && attr.bgDate != '') {
                    var currentDate = new Date();
                    year = currentDate.getFullYear();
                    month = currentDate.getMonth()+1;
                    dt = currentDate.getDate();
                    var cdate = year+'-'+month+'-'+dt;
                    var fromdate = moment(cdate, 'YYYY-MM-DD'); // format in which you have the date
                    var to = moment(attr.bgDate, 'YYYY-MM-DD');
                    var differnaceDays =  fromdate.diff(to, 'days');
                    /* Gray == #A9A9A9
                    orrange = #FFA500
                    red = # #FF0000 */
                    var colorVal = '#FF0000';
                    var displaydate = moment(attr.bgDate).format("MMM DD");
                    if(differnaceDays < 0)
                    {
                        colorVal = '#A9A9A9';
                        //return colorVal;
                    }
                    else if(differnaceDays == 0)
                    {
                          colorVal = '#FFA500';
                          displaydate = "Today";
                          //return colorVal;
                    }

                    element.css("color", colorVal);
                    element.html(displaydate);
                } 

            });
        }
    };
});

app.directive('nameAbbreviation', function ($compile) {
    return {
        restrict: 'E',
		scope: { name: "@"},
        replace: true,
        link: function (scope, element, attrs) {
            var colorList = [
                "maroon", "red", "purple", "fuchsia", "green", "teal", 
                "aqua", "orange", "bisque", "cyan","lightseagreen", "lightskyblue", 
                "lightslategray", "lightsteelblue", "limegreen", "lightsalmon", "mediumorchid"
                ];
            var arrName = scope.name.split(' ');
            var initName = arrName[0].charAt(0).toUpperCase() + arrName[1].charAt(0).toUpperCase();
            scope.initName = initName;
            
            var curIndex = 0;
            if (Math.floor(Math.random() * colorList.length) <= colorList.length) {
                curIndex = Math.floor(Math.random() * colorList.length);
            }

            element[0].parentNode.style.backgroundColor = colorList[curIndex];
            var html ='<span class="name-abbreviation">{{initName}}</span>';
            var e =$compile(html)(scope);
            element.replaceWith(e);
            
        }
    };
})