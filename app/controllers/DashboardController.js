app.controller('DashboardController', function(dataFactory,$scope,$http,$timeout,$compile){
 
 var taskCalander = [];
  $scope.data = [];
  $scope.recentLeadData = [];
  $scope.hotLeadData = [];
  $scope.dailyTaskData = [];
  $scope.overDueTaskData = [];
  $scope.leadSources = [];
  $scope.leadStatus = [];
 // $scope.leadDropdownStatus = '1';
  $scope.assignUsers = [];
  $scope.pageNumber = 1;
//  $scope.assignUsersMessage = [];
  $scope.userImage = "";
  $scope.reminderTaskDescription = "";
  $scope.reminderTaskTitle = "";
  $scope.reminderTaskUserImage = "";
  $scope.reminderLeadUserName = "";
  $scope.reminderTaskId = "";
  $scope.reminderLeadTitle = "";
  $scope.editTask = "";
  $scope.editTaskId = "";
  $scope.libraryTemp = {};
  $scope.totalItemsTemp = {};
  $scope.taskCalanderDailyTask = [];
  $scope.taskCalanderDueTask = [];
  $scope.fullCalendarEventSources = [];
  $scope.filterOption = 'today';
    $scope.select2Options = {
        tags :   $scope.assignUsers,
        simple_tags: true,
        //tags :  $scope.tags,
        formatResult: function (item) {
         return item.text;
        },
        formatSelection: function (item) {
         return item.text;
        },

    };
//$scope.recentLeadLength = '';


  /* $scope.form = {
	leadStatus:1,
	leadSource:1,
  }; */
  //$scope.form = {reminderDate : new Date('2017-11-05')};
  var currentDate = new Date();
  var year = currentDate.getFullYear();
  var month = currentDate.getMonth()+1;
  var date = currentDate.getDate();
  var cdate = month+'-'+date+'-'+year;
  $scope.form = {
		birthdate : cdate,
		aniversaryDate : cdate,
		addressLine1 : '',
		addressLine2 : '',
		leadWebSite : '',
		leadCity : '',
		leadState : '',
		zipcode : '',
		tagsList : '',
		taskDueDate : cdate,
		assignUser : '',
  };
   getHotLeads();
   getRecenetLeads();
   getDailyTaskData();
   getLeadSource();
   getLeadStatus();
   getAssignUsers();
   getOverDueTaskData();
   getCalanderTaskData();
  getAssignUserMessage();
  $scope.updateLeadId = function($event) {
            $scope.leadId = angular.element($event.target).attr("data-leadId");
			console.log($scope.leadId);
			
   } 
/*$scope.range = function(min, max, step) {
    step = step || 1;
    var input = [];
    for (var i = min; i <= max; i += step) {
        input.push(i);
    }
    return input;
};*/

  $scope.reminderTask = function($event) {	
  
			    $event.preventDefault();
				var target = angular.element($event.currentTarget);
				var taskId = target.attr('taskId');
				dataFactory.httpRequest('getTask','GET',{'taskId':taskId}).then(function(data) {
				$scope.reminderTaskDescription = data.taskDescription;
				$scope.reminderTaskTitle = data.taskTitle;
				$scope.reminderTaskUserImage = data.leadUserImage;
				$scope.reminderLeadUserName = data.leadUserName;
				$scope.reminderLeadTitle = data.leadTitle;
				$scope.reminderTaskId = data.Id;
				
			});
	}
   $scope.saveReminderTask = function($event){
		$scope.form.Id = $scope.reminderTaskId;
		dataFactory.httpRequest('setTaskReminder','POST',{},$scope.form).then(function(data) {
			if(data.status == 1)
			{
				getDailyTaskData();
				$(".modal").modal("hide");
				alertify.alert('Task', 'Task reminder date is added successfully!');
			}
			else
			{
				alertify.alert('Error',data.message);
			}
		}); 
  }
  $scope.editTaskData = function($event){
				$event.preventDefault();
				var target = angular.element($event.currentTarget);
				var taskId = target.attr('taskId');
				dataFactory.httpRequest('getTask','GET',{'taskId':taskId}).then(function(data) {
				console.log(data);
				$scope.form = {
					taskId : data.Id,
					taskTitle : data.taskTitle,
					taskDescription : data.taskDescription,
					taskDueDate : data.DueDate,
					assignUser : data.assignUserId
				}
				$scope.editTask = "edit";
				$scope.editTaskId =  data.Id;
			});
  }
  $scope.deleteTask = function($event){
		$event.preventDefault();
		var target = angular.element($event.currentTarget);
		var taskId = target.attr('taskId');
		alertify.confirm('Delete Task', 'Are you sure you want to delete this Task Data..?',
		function ()
		{
			dataFactory.httpRequest('deleteTask','GET',{'taskId':taskId}).then(function(data) {}); 
			getDailyTaskData();
			getOverDueTaskData();
			alertify.notify('Your task is deleted successfully!', 'success', 5, function(){});
		},
		function ()
		{
			alertify.error('Cancelled')
		});
  }
  $scope.changeLeadStatusHot = function($event)
  {
	 $event.preventDefault();
	 var target = angular.element($event.currentTarget);
	 var leadId = target.attr('leadId'); 
	 alertify.confirm('Lead Status', 'Are you sure you want to make this lead as Hot Lead..?',
		function ()
		{
			dataFactory.httpRequest('leadStatusChange','GET',{'leadId':leadId}).then(function(data) {
				console.log("console log");
				alertify.notify('Lead status is changed successfully!', 'success', 5, function(){});
				getHotLeads();
			}); 
		},
		function ()
		{
			alertify.error('Cancelled')
		});
	 
  }
  $scope.changeTaskStatus = function($event)
  {
	 $event.preventDefault();
	 var target = angular.element($event.currentTarget);
	 var taskId = target.attr('taskId'); 
	 alertify.confirm('Task Status', 'Are you sure you want to make this task as completed.?',
		function ()
		{
			dataFactory.httpRequest('taskStatusChange','GET',{'taskId':taskId}).then(function(data) {
				if(data.status == 1)
				{
					alertify.alert('Task','Your task status is changed successfully!');
					//alertify.notify('Your task status is changed successfully!', 'success', 5, function(){});
					getDailyTaskData();
				}
				else
				{
					alertify.alert('Lead',data.message);	
				}
				
			}); 
		},
		function ()
		{
			alertify.error('Cancelled')
		});
  }
  $scope.deleteLead = function($event)
  {
	 $event.preventDefault();
	 var target = angular.element($event.currentTarget);
	 var leadId = target.attr('leadId'); 
	 alertify.confirm('Lead Delete', 'Are you sure you want to delete this lead data?',
		function ()
		{
			dataFactory.httpRequest('leadDelete','GET',{'leadId':leadId}).then(function(data) {
				if(data.status == 1)
				{
					alertify.notify('Lead is deleted successfully!', 'success', 5, function(){});
					getHotLeads();
					getRecenetLeads();
				}
				else
				{
					alertify.alert('Lead',data.message);	
				}
			}); 
		},
		function ()
		{
			alertify.error('Cancelled')
		});
  }

  $("#birthdatePicker").datepicker({
		 //endDate: new Date(),
		  currentDate : new Date(),
		 currentDate : new Date(),
		 autoclose: true,
		 format : 'mm-dd-yyyy'
	}).on('changeDate', function(en,$scope) {
		angular.element($('#birthdate')).triggerHandler('input');
			
  });
  $("#aniversaryDatePicker").datepicker({
		 //startDate: new Date(),
		 currentDate : new Date(),
		 autoclose: true,
		format : 'mm-dd-yyyy'
   }).on('changeDate', function(en) {
		angular.element($('#aniversaryDate')).triggerHandler('input');
			
  }); 
  $("#dueDatePicker").datepicker({
		 startDate: new Date(),
		 autoclose: true,
		 format : 'mm-dd-yyyy'
	}).on('changeDate', function(en) {
		angular.element($('#taskDueDate')).triggerHandler('input');
  }); 
   $("#reminderDatePicker").datepicker({
		 setDate: new Date(),
		 autoclose: true,
		 format : 'yyyy-mm-dd'
	}).on('changeDate', function(en) {
		angular.element($('#reminderDate')).triggerHandler('input');
  }).datepicker('setDate', new Date());
  $("#reminderTime").timepicker({
	
	'icons' : {
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down'
		},
	'maxHours':24,
	'showMeridian' :false,
	
	}).on('changeTime.timepicker', function(e) {
		angular.element($('#reminderTime')).triggerHandler('input');
  });
  
   
   function getHotLeads() {
      dataFactory.httpRequest(base_url+'hotLeads','GET').then(function(data) {
			$scope.hotLeadData = data;
	  });
   }
   function getRecenetLeads() {
      dataFactory.httpRequest(base_url+'recentLeads','GET').then(function(data) {
			$scope.recentLeadData = data;
			$scope.recentLeadLength = $scope.recentLeadData.length
	  });
   }
   function getDailyTaskData() {
      dataFactory.httpRequest(base_url+'dailyTask','GET').then(function(data) {
			$scope.dailyTaskData = data;
	  });
   } 
   function getLeadSource() {
      dataFactory.httpRequest(base_url+'leadSource','GET').then(function(data) {
			$scope.leadSources = data;
	  });
   }
   function getLeadStatus() {
      dataFactory.httpRequest(base_url+'leadStatus','GET').then(function(data) {
			$scope.leadStatus = data;
			console.log($scope.leadStatus);
	  });
   }
   function getAssignUsers() {
      dataFactory.httpRequest(base_url+'assignUsers','GET').then(function(data) {
			$scope.assignUsers = data;
			console.log(data);
			console.log($scope.assignUsers);
	  });
   }
   function getOverDueTaskData() {
      dataFactory.httpRequest(base_url+'overDueTask','GET').then(function(data) {
			$scope.overDueTaskData = data;
	  });
   }
   function getCalanderTaskData(){
	dataFactory.httpRequest(base_url+'getCalanderTaskData','GET').then(function(data) {
			$scope.taskCalanderDailyTask = data.dailyTask;
			$scope.taskCalanderDueTask = data.dueTask;
			$scope.fullCalendarEventSources = {
				dailyTask : {
					events:$scope.taskCalanderDailyTask,
					textColor : '#000',
					backgroundColor: '#FFD000',
				},
				dueTask : {
					events:$scope.taskCalanderDueTask,
					textColor : '#fff',
					backgroundColor: '#da1445',  
				},
				googleCalander :{
						events: {
								googleCalendarApiKey: 'AIzaSyDWw5Ww0sEobiRR_CSCzqIxNnwqIthg0u8',
								googleCalendarId: 'luj0lai8qij8p86eu8tq81pqmo@group.calendar.google.com',
						},
				}
			};
			
			
	  });
   }
	$scope.saveLead = function(){
		var fd = new FormData();
		var tagValue = getTagListValue();
		$scope.form.tagsList = tagValue;	
		var facebook =  $scope.form.leadFacebook;
		var instagram = $scope.form.leadInstagram;
		var twitter =   $scope.form.leadTwitter;
		var linkedin =  $scope.form.leadLinkedin;
		var socialProfileArray = {'facebook':facebook,'instagram':instagram, 'twitter': twitter,'linkedin':linkedin};
		var socialProfile = JSON.stringify(socialProfileArray);
		fd.append('firstName',$scope.form.firstName);
		fd.append('lastName',$scope.form.lastName);
		fd.append('email',$scope.form.email);
		fd.append('phoneNumber',$scope.form.phoneNumber?$scope.form.phoneNumber:'');
		fd.append('birthdate',$scope.form.birthdate);
		fd.append('aniversaryDate',$scope.form.aniversaryDate);
		fd.append('leadTitle',$scope.form.leadTitle?$scope.form.leadTitle:'');
		fd.append('companyName',$scope.form.companyName?$scope.form.companyName:'');
		fd.append('location',$scope.form.location);
		fd.append('leadSource',$scope.form.leadSourceSelection);
		fd.append('leadStatus',$scope.form.leadStatusSelection);
		fd.append('leadWebSite',$scope.form.leadWebSite);
		fd.append('addressLine1',$scope.form.addressLine1?$scope.form.addressLine1:'');
		fd.append('addressLine2',$scope.form.addressLine2);
		fd.append('leadCity',$scope.form.leadCity);
		fd.append('leadState',$scope.form.leadState);
		fd.append('zipcode',$scope.form.zipcode);
		fd.append('socialProfile',socialProfile);
		fd.append('leadImage', $scope.leadImage?$scope.leadImage:'');
		fd.append('tagsList', $scope.form.tagsList);
		$http.post(base_url+'leadCreate', fd, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		})
		.then(function successCallback(response) {
			if(response.data.status == 1)
				{
					
					getHotLeads();
					getRecenetLeads();
					alertify.alert('Lead Created', 'Congratulations! Your user is created successfully!',function(){location.reload()});
					//$(".modal").modal("hide");
					
				}
				else
				{
					//$scope.loading = false;
					alertify.alert('Error', response.data.message);
				}	
		}
		,function errorCallback(response) {
			//$scope.loading = false;
			alertify.alert('Error', response.data.message,function(){ alertify.error(response.data.message)});
		});

	}
	 $scope.saveTask = function(){
		$scope.form.taskLeadId =  $scope.leadId;
		$scope.form.taskId =  $scope.editTaskId;
		if($scope.form.taskLeadId != "undefined" && $scope.form.taskLeadId != "")
		{
			dataFactory.httpRequest(base_url+'taskCreate','POST',{},$scope.form).then(function(data) {
				if(data.status == 1)
				{
					alertify.notify(data.message, 'success', 5, function(){});
					$scope.addTask.$setPristine();
					$scope.addTask.$setUntouched();
					$scope.form = {};
					$(".modal").modal("hide");
					getDailyTaskData();
					/* getCalanderTaskData();
					console.log("updateed=="+$scope.taskCalanderDailyTask);
					$scope.fullCalendarEventSources = {
						dailyTask : {
							events:$scope.taskCalanderDailyTask,
							textColor : '#000',
							backgroundColor: '#FFD000',
						},
						dueTask : {
							events:$scope.taskCalanderDueTask,
							textColor : '#fff',
							backgroundColor: '#da1445',  
						}
				
					};
				$timeout(function () {
                    $('#fullcalendar').fullCalendar('removeEventSource',$scope.fullCalendarEventSources.dailyTask);
					console.log("updateed=="+$scope.taskCalanderDailyTask);
					$('#fullcalendar').fullCalendar('addEventSource',$scope.fullCalendarEventSources.dailyTask);
					$('#fullcalendar').fullCalendar('refetchEventSources',$scope.fullCalendarEventSources.dailyTask);
					$('#fullcalendar').fullCalendar('rerenderEvents');
					$('#fullcalendar').fullCalendar('refetchEvents');
					$('#fullcalendar').fullCalendar('refresh');
					$('#fullcalendar').fullCalendar('updateEvents',$scope.fullCalendarEventSources.dailyTask);
						$('#fullcalendar').fullCalendar('rerenderEvents');
					$('#fullcalendar').fullCalendar('refetchEvents');
					$('#fullcalendar').fullCalendar('refresh');
					console.log("after update==");
                }); */
				
				
					
					//alertify.alert('Task', 'Congratulations your task is created successfully!');
					
				}
				else
				{
					if($scope.editTask = "edit")
					{
						alertify.alert('Task Update','Nothing is updated');
					}
					else
					{
						alertify.alert('Error', data.message,function(){ alertify.error(data.message)});
						$(".modal").modal("hide");
					}
				}
			});
		}
		else
		{
			alertify.alert('Error', 'There must be something went wrong please try again later');
			$(".modal").modal("hide");
		}
	}
	$scope.saveUser = function(){
		var fd = new FormData();
		
		fd.append('userFirstName',$scope.form.userFirstName);
		fd.append('userLastName',$scope.form.userLastName);
		fd.append('userEmail',$scope.form.userEmail);
		fd.append('username',$scope.form.username);
		fd.append('userPassword',$scope.form.userPassword);
		fd.append('userImage', $scope.userImage);
		$http.post(base_url+'userCreate', fd, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		})
		.then(function successCallback(response) {
			if(response.data.status == 1)
				{
					$scope.loading = true;
					alertify.alert('User', 'Congratulations your user is created successfully!');
					getAssignUsers();
					$(".modal").modal("hide");
					
				}
				else
				{
					$scope.loading = false;
					alertify.alert('Error', response.data.message);
				}	
		}
		,function errorCallback(response) {
			$scope.loading = false;
			alertify.alert('Error', response.data.message,function(){ alertify.error(response.data.message)});
		});
	}

  $scope.edit = function(id){
    dataFactory.httpRequest(base_url+'itemsEdit/'+id).then(function(data) {
    	console.log(data);
      	$scope.form = data;
    });
  }

  $scope.saveEdit = function(){
    dataFactory.httpRequest(base_url+'itemsUpdate/'+$scope.form.id,'PUT',{},$scope.form).then(function(data) {
      	$(".modal").modal("hide");
        $scope.data = apiModifyTable($scope.data,data.id,data);
    });
  }

  $scope.remove = function(item,index){
    var result = confirm("Are you sure delete this item?");
   	if (result) {
      dataFactory.httpRequest('itemsDelete/'+item.id,'DELETE').then(function(data) {
          $scope.data.splice(index,1);
      });
    }
  }
  $scope.uploadImage = function(ele) {
				$scope.userImage = ele[0];
   }
   $scope.leadUploadImage= function(ele) {
				$scope.leadImage = ele[0];
				 if (ele && ele[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('.leadImgCircle')
								.attr('src', e.target.result)
								// .width(200)
								// .height(200);
					};
					reader.readAsDataURL(ele[0]);
				}
   }
   $scope.taskFilter = function($event)
   {	
		$event.preventDefault();
		var target = angular.element($event.currentTarget);
		var filterOption = target.attr('currentVal');
		var currentText = target.attr('currentText');
		console.log(currentText);
		dataFactory.httpRequest('getFilterdTask','GET',{'filterOption':filterOption}).then(function(data) {
			$scope.dailyTaskData = data.data;
			$("#taskFilerBtnText").html(currentText);
			
		 });
   }
   	$scope.sentMessage = function () {
        dataFactory.httpRequest(base_url+'message/create', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
				$("#create-message").modal("hide");
				dataFactory.httpRequest(base_url+'dashboard/addFlagForFirstMessage', 'POST', {}, $scope.form).then(function (data) {
		            if (data.status == 1)
		            {
		            	$("a[data-target='#create-message']").parent().attr('class','cancel');
		            	
		            	var progresssbar = $('.progress-bar').attr('aria-valuenow');
		            	var newprogresssbar = (parseInt(progresssbar) + 25);
		            	$('.progress-bar').attr('aria-valuenow',newprogresssbar);
		            	$('.progress-bar').css('width',newprogresssbar+'%');
		            	$('.progress-bar span').html(newprogresssbar+'%');
		                alertify.alert('Message', 'Congratulations your message is created successfully!');
						$("#sucess-message").modal("show");
		            }
		        });
                

            } else
            {
                alertify.alert("Error", data.message, function () {
                    alertify.error(data.message)
                });
            }
        });
    }
    function getAssignUserMessage() {
        dataFactory.httpRequest(base_url+'leads/getLeadUser','GET').then(function(data) {
			$scope.assignUsersMessage = data;
	  });
    }
	$scope.leadDropdown = function () {
        $('#leadStatus,#leadSource').each(function () {
            var $this = $(this), numberOfOptions = $(this).children('option').length;
            $this.addClass('select-hidden');
            $this.wrap('<div class="select"></div>');
            $this.after('<div class="select-styled"></div>');
            var $styledSelect = $this.next('div.select-styled');
			var elementName = "";
            if ($(this).attr('id') == 'leadStatus')
            {
                $styledSelect.addClass('hot');
				elementName = 'leadStatus';
            }
			if ($(this).attr('id') == 'leadSource')
			{
					elementName = 'leadSource';
			}
            $styledSelect.text($this.children('option').eq(0).text());

            var $list = $('<ul/>', {
                'class': 'select-options'
            }).insertAfter($styledSelect);

            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    class: $this.children('option').eq(i).text().toLowerCase(),
					//'data-name':$this.attr('id'),
                    rel: $this.children('option').eq(i).val(),
                    'ng-click': "changeList("+$this.children('option').eq(i).val()+",'"+elementName+"')"

                }).appendTo($list);
            }
            var $listItems = $list.children('li');
            $styledSelect.click(function (e) {
                e.stopPropagation();
                $('div.select-styled.active').not(this).each(function () {
                    $(this).removeClass('active').next('ul.select-options').hide();
                });
                $(this).toggleClass('active').next('ul.select-options').toggle();
            });
            $listItems.click(function (e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');

                $styledSelect.attr('class', '');
                $styledSelect.addClass('select-styled  ' + $(this).text().toLowerCase());
                $this.val($(this).attr('rel'));
                $list.hide();
            });
            $compile($list)($scope)

            $(document).click(function () {
                $styledSelect.removeClass('active');
                $list.hide();
            });

        });
    }

    $scope.changeList = function (selectedVal,elementId) {
		console.log(selectedVal);
		console.log(elementId);
		if(elementId == "leadStatus")
		{
			$scope.form.leadStatusSelection = selectedVal;
		}
		if(elementId == "leadSource")
		{
				$scope.form.leadSourceSelection = selectedVal;
		}
        
    }
	$scope.calendarPopup = function($event)
	{
		$event.preventDefault();
		$('#connect-emailaccount').modal('hide');
		//$('#contact-add').modal('hide');
		$('#connect-calender').modal('show');
	
	}
	$scope.calendarPreviousPopup = function($event)
	{
		$event.preventDefault();
		$('#contact-add').modal('hide');
		$('#connect-calender').modal('show');
	
	}
	$scope.add25Contacts = function($event)
	{	
	 $event.preventDefault();
	 $('#connect-calender').modal('hide');
	 $('#contact-add').modal('show');
	
	}
	$scope.sendFirstMessage = function($event)
	{		
		 $event.preventDefault();
		 $('#contact-add').modal('hide');
		 $('#create-message').modal('show');
	
	}
$scope.connectEmailPopup = function()
{
	 $('#connect-calender').modal('hide');
	 $('#connect-emailaccount').modal('show');
	
}
$scope.prevContactAdd = function()
{
	 $('#create-message').modal('hide');
	 $('#contact-add').modal('show');
	
}
});
function getTagListValue(str){
	var i=0;
	var tagList = [];
	  $("#tagsList_tagsinput span.tag").each(function(){
		  if($(this).find('span').length>0){
			  var text = $(this).find('span').text();
				console.log(text.slice(0,-2)); 
				tagList.push(text.slice(0,-2));
			}
		i++;
	  });
	return tagList;
}

