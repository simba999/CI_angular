app.controller('ToDoListController', function (dataFactory, $scope, $http, $timeout) {

    $scope.dailyTaskData = [];
    $scope.assignUsers = [];
    $scope.leadDropDown = [];
    $scope.templateDropDown = [];
    $scope.templateList = [];
    $scope.taskElements = [{}];
    $scope.taskTemplates = [];
    $scope.completedTaskTemplates = [];
    $scope.editTask = "";
    $scope.editTaskId = "";
	var currentDate = new Date();
	var year = currentDate.getFullYear();
	var month = currentDate.getMonth()+1;
	var date = currentDate.getDate();
	var cdate = month+'-'+date+'-'+year;
	$scope.form = {
		taskDueDate : cdate,
	};
	$scope.addTasksElement = function () {
        $scope.taskElements.push({});

    }
    $scope.removeElement = function (i) {
        $scope.taskElements.splice(i, 1);
    }
    //getAllTaskData();
    getAssignUsers();
    getLeadListDropdown();
   // getAllUnassignedTemplate();
    getAllTempates();
    getAllTaskTemplatesData();
    getAllCompletedTaskTemplatesData();

    function getAllTaskTemplatesData() {
        dataFactory.httpRequest(base_url + 'tasks/leadTasks', 'GET').then(function (data) {

            $scope.taskTemplates = data;

        });
    }
	function getAllCompletedTaskTemplatesData() {
        dataFactory.httpRequest(base_url + 'tasks/leadCompletedTasks', 'GET').then(function (data) {

            $scope.completedTaskTemplates = data;

        });
    }
    function getAllTaskData() {
        dataFactory.httpRequest(base_url + 'getAllTaskData', 'GET').then(function (data) {
            if (data.status == 1)
            {
                $scope.dailyTaskData = data.data;
            } else
            {
                $scope.dailyTaskData = [];
            }
        });
    }
    function getAssignUsers() {
        dataFactory.httpRequest(base_url + 'assignUsers', 'GET').then(function (data) {
            $scope.assignUsers = data;


        });
    }
    function getLeadListDropdown()
    {
        dataFactory.httpRequest(base_url + 'getLeadListDropdown', 'GET').then(function (data) {
            if (data.status == 1)
            {
                $scope.leadDropDown = data.data;
                $scope.form.taskTemplate.selectLead = $scope.leadDropDown[0].value;

            } else
            {
                $scope.leadDropDown = [];
            }
        });
    }
    function getAllUnassignedTemplate()
    {
        dataFactory.httpRequest(base_url + 'unassignedTemplate', 'GET').then(function (data) {
            if (data.status == 1)
            {
                $scope.templateDropDown = data.data;

            } else
            {
                $scope.templateDropDown = [];
            }
        });
    }


    function getAllTempates() {
        dataFactory.httpRequest(base_url + 'tasks/getAllTemplate', 'GET').then(function (data) {
            $scope.templateList = data;
        });

    }


    $("#taskdeadlineDatePicker").datepicker({
        startDate: new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd'
    }).on('changeDate', function (en, $scope) {
        angular.element($('#taskdeadline')).triggerHandler('input');

    });

    $(".select2-option").select2({
        width: '100%'
    });

    $scope.saveTemplateTask = function ()
    {
        dataFactory.httpRequest('saveTemplateTask', 'POST', {}, $scope.form).then(function (data) {

            console.log(data);
            if (data.status == 1)
            {
                alertify.alert('Task Template', 'Task template and all tasks added successfully!', function () {
                    window.location = base_url + 'tasks';
                });

            } else
            {
                alertify.alert('Error', data.message);
            }
        });
    }

    $scope.saveAssignTaskTemplate = function ()
    {
        dataFactory.httpRequest('saveTemplateTask', 'POST', {}, $scope.form).then(function (data) {

            if (data.status == 1)
            {
                alertify.alert('Task Template', 'Task template and all tasks added successfully!', function () {
                    window.location = base_url + 'tasks';
                });

            } else
            {
                alertify.alert('Error', data.message);
            }
        });
    }

    $scope.saveAssignTemplateTask = function ()
    {
        dataFactory.httpRequest(base_url + 'tasks/saveAssignTemplateTask', 'POST', {}, $scope.form).then(function (data) {

            if (data.status == 1)
            {
                alertify.notify('Template assign to Lead successfully!', 'success', 5, function () {});

            } else
            {
                alertify.alert('Error', data.message);
            }
            getAllTaskData();
            getAllTaskTemplatesData();
            $(".modal").modal("hide");

        });
    }


    /* dashbord function*/
    $("#dueDatePicker").datepicker({
        startDate: new Date(),
        autoclose: true,
        format: 'mm-dd-yyyy'
    }).on('changeDate', function (en) {
        angular.element($('#taskDueDate')).triggerHandler('input');
    });
    $scope.saveTask = function () {
        $scope.form.taskLeadId = $scope.leadId;
        $scope.form.taskId = $scope.editTaskId;
        if ($scope.form.taskLeadId != "undefined" && $scope.form.taskLeadId != "")
        {
            dataFactory.httpRequest(base_url + 'tasks/createTodoTask', 'POST', {}, $scope.form).then(function (data) {
                if (data.status == 1)
                {
                    alertify.notify(data.message, 'success', 5, function () {});

                } else
                {
                    if ($scope.editTask = "edit")
                    {
                        alertify.alert('Task Update', 'Nothing is updated');
                    } else
                    {
                        alertify.alert('Error', data.message, function () {
                            alertify.error(data.message)
                        });
                        $(".modal").modal("hide");
                    }
                }
            });
            getAllTaskTemplatesData();
            $(".modal").modal("hide");
        } else
        {
            alertify.alert('Error', 'There must be something went wrong please try again later');
            $(".modal").modal("hide");
        }
    }

    $scope.editTaskData = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var taskId = target.attr('taskId');
        dataFactory.httpRequest('getTask', 'GET', {'taskId': taskId}).then(function (data) {
            console.log(data);
            $scope.form = {
                taskId: data.Id,
                taskTitle: data.taskTitle,
                taskDescription: data.taskDescription,
                taskDueDate: data.DueDate,
                assignUser: data.assignUserId,
                assignLead: data.LeadId
            }
            $scope.editTask = "edit";
            $scope.editTaskId = data.Id;
        });
        
    }
    $scope.deleteTask = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var taskId = target.attr('taskId');
        alertify.confirm('Delete Task', 'Are you sure you want to delete this Task Data..?',
                function ()
                {
                    dataFactory.httpRequest('deleteTask', 'GET', {'taskId': taskId}).then(function (data) {});
                    getAllTaskTemplatesData();
                    
                    alertify.notify('Your task is deleted successfully!', 'success', 5, function () {});
                },
                function ()
                {
                    alertify.error('Cancelled')
                });
    }


});

