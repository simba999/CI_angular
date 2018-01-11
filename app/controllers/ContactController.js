app.controller('ContactController', function (dataFactory, $scope, $http, $timeout, $compile) {
	$scope.leadTags = [];
	$scope.assignUsers = [];
    $scope.contactCsv = "";
    var taskCalander = [];
    $scope.data = [];
    $scope.recentLeadData = [];
    $scope.hotLeadData = [];
    $scope.dailyTaskData = [];
    $scope.overDueTaskData = [];
    $scope.leadSources = [];
    $scope.leadStatus = [];
	
    $scope.pageNumber = 1;
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
    $scope.circlearr = [];
    $scope.statusarr = [];
    $scope.tagarr = [];
    $scope.userarr = [];
	$scope.leads = [];
    $scope.FilterData = [];
    $scope.interactionTypesDropdown = [];
    $scope.leadStatus = [];
    $scope.leadSources = [];
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = currentDate.getMonth() + 1;
    var date = currentDate.getDate();
    var cdate = month + '-' + date + '-' + year;
	$scope.profileImage = base_url+"assets/global/images/Blank_Club_Website_Avatar_Gray.jpg";
    $scope.form = {
        birthdate: cdate,
        aniversaryDate: cdate,
		addressLine1 : '',
		addressLine2 : '',
		leadWebSite : '',
		leadCity : '',
		leadState : '',
		zipcode : '',
		tagsList : '',
    };
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
	
    
	$scope.sentMessage = function () {
        dataFactory.httpRequest('message/create', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
				alertify.alert('Message', 'Congratulations your message is created successfully!');
                //getInbox();
                $(".modal").modal("hide");
				$('#create-message').modal('hide');
			} else
            {
				alertify.alert("Error", data.message, function () {
                    alertify.error(data.message)
                });
            }
        });
    }
    
    $scope.importContact = function () {
        var fd = new FormData();
        fd.append('contactcsv', $scope.contactCsv);
        $http.post(base_url + 'contact/readCsv', fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
                .then(function successCallback(response) {
                    if (response.data.status == 1)
                    {
                        $(".modalImportCsv").modal("hide");
                        $(".sucessImportModel").modal("show");
                    }
                })
    };
    $scope.ExportChoose = "";
    $scope.AssignedUserId = "";

    $scope.FilterData = [];

    //$scope.form = {reminderDate : new Date('2017-11-05')};

    var vm = this;
    vm.overDueTaskData = []; //declare an empty array
    vm.pageno = 1; // initialize page no to 1
    vm.total_count = 0;
    vm.itemsPerPage = 10;
    $scope.changeCircle = function (circleId, item) {

        if (circleId) {
            // add item
            $scope.circlearr.push(item.Id);
        } else {
            // remove item
            for (var i = 0; i < $scope.circlearr.length; i++) {
                if ($scope.circlearr[i] == item.Id) {
                    $scope.circlearr.splice(i, 1);
                }
            }
        }
        $scope.IsSearch = 1;
        $scope.getOverDueTaskData(1);
    };
    $scope.changeStatus = function (statusId, item) {
        if (statusId) {
            // add item
            $scope.statusarr.push(item.Id);
        } else {
            // remove item
            for (var i = 0; i < $scope.statusarr.length; i++) {
                if ($scope.statusarr[i] == item.Id) {
                    $scope.statusarr.splice(i, 1);
                }
            }
        }
        $scope.IsSearch = 1;
        $scope.getOverDueTaskData(1);
    };

    $scope.changeTags = function (tagId, item) {
        if (tagId) {
            // add item
            $scope.tagarr.push(item.TagTitle);
        } else {
            // remove item
            for (var i = 0; i < $scope.tagarr.length; i++) {
                if ($scope.tagarr[i] == item.TagTitle) {
                    $scope.tagarr.splice(i, 1);
                }
            }
        }
        $scope.IsSearch = 1;
        $scope.getOverDueTaskData(1);
    };


    $scope.changeAssignedUsers = function (userId, item) {

        if (userId) {
            // add item
            $scope.userarr.push(item.Id);
        } else {
            // remove item
            for (var i = 0; i < $scope.userarr.length; i++) {
                if ($scope.userarr[i] == item.Id) {
                    $scope.userarr.splice(i, 1);
                }
            }
        }

        $scope.IsSearch = 1;
        $scope.getOverDueTaskData(1);

    };
    $scope.getFiltersData = function () {
        dataFactory.httpRequest(base_url + 'contact/getFiltersData', 'GET', {}).then(function (data) {
            $scope.FilterData = data;
        });
    };

    $scope.updateAssignee = function (user, AssignedUserId) {
        var postdata = {};
        postdata.AssignedUserId = AssignedUserId;
        postdata.contactId = user.contactId;
        dataFactory.httpRequest('contact/updateAssignee', 'POST', {}, postdata).then(function (data) {
            //$scope.FilterData = data;
        });
    };

    $scope.ExportToCSV = function ($event) {
        if ($scope.Export.$valid) {
            var postdata = $scope.Export;
            postdata.circle = $scope.circlearr;
            postdata.status = $scope.statusarr;
            postdata.tag = $scope.tagarr;
            postdata.user = $scope.userarr;
            dataFactory.httpRequest('contact/ExportContacts', 'POST', {}, postdata).then(function (data, status, headers, config) {
                if (data.FileUrl.length) {

                    var anchor = angular.element('<a/>');
                    anchor.attr({
                        href: data.FileUrl,
                        target: '_blank',
                        download: 'contactInfo.csv'
                    })[0].click();

                }
                else {
                    alert("There is no record found for this match.")
                }
            });
        }

    };
    $scope.displayEmail = function (email) {
        //var $phoneNo=$phoneNo;
        myWindow = window.alert(email);
        /*document.getElementById("myBtn").innerHTML = $ConMemData->PhoneNo;*/
    }

    $scope.displayPhone = function (phoneNo) {
        //var $phoneNo=$phoneNo;
        myWindow = window.alert(phoneNo);
        /*document.getElementById("myBtn").innerHTML = $ConMemData->PhoneNo;*/
    }

    $scope.displayDescription = function (msg) {
        //var $phoneNo=$phoneNo;
        myWindow = window.alert(msg);
        /*document.getElementById("myBtn").innerHTML = $ConMemData->PhoneNo;*/
    }


    $scope.getFiltersData();






    $scope.updateLeadId = function ($event) {
        $scope.leadId = angular.element($event.target).attr("data-leadId");
    }



    $scope.reminderTask = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var taskId = target.attr('taskId');
        dataFactory.httpRequest('getTask', 'GET', {'taskId': taskId}).then(function (data) {
            $scope.reminderTaskDescription = data.taskDescription;
            $scope.reminderTaskTitle = data.taskTitle;
            $scope.reminderTaskUserImage = data.leadUserImage;
            $scope.reminderLeadUserName = data.leadUserName;
            $scope.reminderLeadTitle = data.leadTitle;
            $scope.reminderTaskId = data.Id;

        });
    }
    function getInteractionTypesDropdown() {
        dataFactory.httpRequest(base_url + 'Contact/getInteractionTypesDropdown', 'GET', {}).then(function (data) {
            if (data.status == 1)
            {
                console.log('getInteractionTypesDropdown');
                console.log(data.data);
                $scope.interactionTypesDropdown = data.data;
            } else
            {
                $scope.interactionTypesDropdown = "";
            }

        });
    }
    $scope.saveReminderTask = function ($event) {

        $scope.form.Id = $scope.reminderTaskId;
        dataFactory.httpRequest('setTaskReminder', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
                getDailyTaskData();
                $(".modal").modal("hide");
                alertify.alert('Task', 'Task reminder date is added successfully!');
            }
            else
            {
                alertify.alert('Error', data.message);
            }
        });

    }
    $scope.editTaskData = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var taskId = target.attr('taskId');
        dataFactory.httpRequest('getTask', 'GET', {'taskId': taskId}).then(function (data) {

            $scope.form = {
                taskId: data.Id,
                taskTitle: data.taskTitle,
                taskDescription: data.taskDescription,
                taskDueDate: data.DueDate,
                assignUser: data.assignUserId

            }
        });
    }
    $scope.uploadCsv = function (ele) {
        $scope.contactCsv = ele[0];
    }


    $scope.returnToImport = function ()
    {
        $(".modalImportCsv").modal("show");
    }
    // Below function is created to Create Lead Interactions (Call, Text, Email)
    $scope.saveLeadInteraction = function () {
        dataFactory.httpRequest(base_url + 'Contact/saveLeadInteraction', 'POST', {}, $scope.form).then(function (data) {
			if (data.status == 1)
            {
                alertify.alert('Lead Interaction Type', 'Congratulations your lead interaction type is created successfully!');
                $("#create-interaction").modal("hide");
                $scope.addInteractionType.$setPristine();
                $scope.addInteractionType.$setUntouched();
                $scope.form.selectInteractionType = "";
                $scope.form.interactionDate = "";
                $scope.form.interactionTitle = "";
                $scope.form.leadId = "";
                getInteractionTypesDropdown();
            } else
            {
                alertify.alert('Error', data.message);
            }

        });
    }
    $scope.createLeadInteraction = function (Interactionvalue, leadID, type) {
        var newHidden = '<input ng-init="form.leadId =' + leadID + '" ng-value="' + leadID + '" type="hidden" name="leadId" id="leadId" ng-model="form.leadId" required="" autocomplete="off" class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" value="' + leadID + '">';
        var temp = $compile(newHidden)($scope);
        $("#formHidden").html('');
        $("#formHidden").html(temp);
        $("#selectInteractionType > option").each(function () {
            console.log($(this).text() + ' ' + $(this).val());
            $('#selectInteractionType').removeAttr('selected');
            if (this.text == type)
            {
                $scope.form.selectInteractionType = $(this).val();
                $(this).prop('selected', 'selected');
                $(this).attr('selected', 'selected');
            }
        });
        $("#create-interaction").modal('show');
    }

	
	
	$scope.createLeadInteractionEmail = function (Interactionvalue, leadID, $event) {
		var id=angular.element($event.currentTarget).attr('id');
        if(id!==undefined)
        {
            var val=angular.element($event.currentTarget).data('parent-id');
            $scope.form.parentId = val;
            $scope.form.replyMsg=1;
            var element="<br><br><div id='msg_block'></div><div style='border-left: solid 2px #ddd;padding: 0px 10px;'>";
            var content=angular.element($event.currentTarget).parent().parent().next('.sp-content').find('p').text();
            var endElement="</div>";
            var subject=angular.element($(".dis_"+val)).find('div').find('h6').text();
            console.log(subject);
            angular.element($('#createmessage')).find('input[name="subject"]').val('Re:'+subject);
            angular.element($('#createmessage')).find('textarea').text(content);
            angular.element($('.note-editable')).html(element+content+endElement);
        }
        else{
            if(angular.element('#parentId').length!=0)
                angular.element('#parentId').remove();
            angular.element($('#createmessage')).find('input[name="subject"]').val('');
            angular.element($('#createmessage')).find('textarea').text('');
            angular.element($('.note-editable')).html('');
        }
		var newHidden = '<input ng-init="form.leadId =' + leadID + '" ng-value="' + leadID + '" type="hidden" name="leadId" id="leadId" ng-model="form.leadId" required="" autocomplete="off" class="" value="' + leadID + '">';
        var temp = $compile(newHidden)($scope);
        $("#emailFormHidden").html('');
        $("#emailFormHidden").html(temp);
        $("#create-message").modal('show');
    };
	
	
	
    // End function 

    $scope.resetFormWithModalClose = function (form) {
        $("#interactionDatePicker").datepicker({
            //startDate: new Date(),
            currentDate: new Date(),
            setDate: new Date(),
            autoclose: true,
            format: 'mm-dd-yyyy'
        }).on('changeDate', function (en) {
            angular.element($('#interactionDate')).triggerHandler('input');
        });
        form.interactionDate = new Date();
        form.interactionTitle = '';
        form.selectInteractionType = '';
        angular.copy({}, form);
        var original = $scope.addInteractionType;
        $scope.addInteractionType = angular.copy(original);
        $scope.addInteractionType.$setPristine();
        $(".createLeadInteractionSubmitButton").attr('disabled', 'disabled');
        $('#create-interaction').modal('hide');
    };
    $scope.resetForm = function (form) {
        $(".createLeadInteractionSubmitButton").attr('disabled', 'disabled');
        $("#interactionDatePicker").datepicker({
            currentDate: new Date(),
            setDate: new Date(),
            autoclose: true,
            format: 'mm-dd-yyyy'
        }).on('changeDate', function (en) {
            angular.element($('#interactionDate')).triggerHandler('input');
        });
        form.interactionDate = new Date();
        form.interactionTitle = '';
        angular.copy({}, form);
        /*var original = $scope.addInteractionType;
         $scope.addInteractionType= angular.copy(original);*/
        $scope.addInteractionType.$setPristine();
        getInteractionTypesDropdown();
		$("#create-interaction").modal('hide');
    };
	$scope.editContactData = function($event) {
        $event.preventDefault();
		$scope.form = "";
		angular.copy({}, $scope.form);
        var target = angular.element($event.currentTarget);
        var leadId = target.attr('leadId');
        dataFactory.httpRequest('Contact/getLeadDataByLeadId', 'GET', {'leadId': leadId}).then(function (data) {
            console.log(data.data);
            if (!data.data["SocialProfile"])
            {
                var social = '';
            }
            else {
                var social = JSON.parse(data.data["SocialProfile"]);
            }
            if (data.data["LeadImage"] != '')
            {
                var fullImagepath = UploadDirectory + data.data["LeadImage"];
                var imageHTML = '<img src=' + fullImagepath + ' class="leadImgCircle" alt="avatar" ng-modal="form.leadImageURL"><div class="chng-img"><i class="fa fa-camera"></i> </div><input ng-model="form.leadImage" onchange="angular.element(this).scope().leadUploadImage(this.files)" type="file" id="leadImage" name="leadImage" accept="image/x-png,image/gif,image/jpeg" ngf-pattern=".jpg,.png" ngf-accept="image/*" class="form-control Profile-input-file ng-pristine ng-valid ng-empty ng-touched">';
                //console.log(imageHTML);
                var tempLeadImageCompile = $compile(imageHTML)($scope);
                $(".add-lead-img").html('');
                $(".add-lead-img").html(tempLeadImageCompile);
            }
            $scope.form = {
                leadId: !data.data["Id"] ? '' : data.data["Id"], leadImageURL: !data.data["LeadImage"] ? '' : data.data["LeadImage"],
                firstName: !data.data["FirstName"] ? '' : data.data["FirstName"],
                lastName: !data.data["LastName"] ? '' : data.data["LastName"],
                leadTitle: !data.data["Title"] ? '' : data.data["Title"],
                email: !data.data["Email"] ? '' : data.data["Email"],
                phoneNumber: !data.data["PhoneNo"] ? '' : data.data["PhoneNo"],
                leadWebSite: !data.data["WebSite"] ? '' : data.data["WebSite"],
                companyName: !data.data["CompanyName"] ? '' : data.data["CompanyName"],
                birthdate: !data.data["leadBirthDate"] ? '' : data.data["leadBirthDate"],
                aniversaryDate: !data.data["leadAniversaryDate"] ? '' : data.data["leadAniversaryDate"],
                addressLine1: !data.data["AddressLine1"] ? '' : data.data["AddressLine1"],
                addressLine2: !data.data["AddressLine2"] ? '' : data.data["AddressLine2"],
                zipcode: !data.data["Zipcode"] ? '' : data.data["Zipcode"],
                //location : data.data["Location"],
                leadFacebook: !social.facebook ? '' : social.facebook,
                leadInstagram: !social.instagram ? '' : social.instagram,
                leadTwitter: !social.twitter ? '' : social.twitter,
                leadLinkedin: !social.linkedin ? '' : social.linkedin,
                leadStatusSelection: !data.data["LeadStatusId"] ? '' : data.data["LeadStatusId"],
                leadSourceSelection: !data.data["LeadSourceId"] ? '' : data.data["LeadSourceId"],
                //tagsList: '',
                leadCity: !data.data["City"] ? '' : data.data["City"],
                leadState: !data.data["State"] ? '' : data.data["State"]
            }
			if(data.leadData!='' && typeof data.leadData !== "undefined" && data.leadData !== undefined)
			{
				var index = 0;
				var tagString  = '';
				var total = data.leadData.length;
				var html = '<div class="form-group leadTagsDiv"><textarea rows="5" cols="60" ng-model="form.tagsList" name="tagsList" id="tagsList" class="ng-pristine ng-untouched ng-valid ng-binding ng-not-empty" data-tagsinput-init="true" style="display: none;">contact1,contact2,contact3</textarea><div id="tagsList_tagsinput" class="tagsinput" style="width: auto; min-height: 100px; height: 100px;">';
				$.each(data.leadData, function(index, data){
					if(index!=(total-1))
					{
						var newTagTitle;
						newTagTitle = data.TagTitle+',';
						tagString = tagString + newTagTitle;
					}
					else {
						tagString = tagString + data.TagTitle;
					}
					html+='<span class="tag"><span>'+data.TagTitle+'&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span>';
					index++;
				});
				html+='<div id="tagsList_addTag"><input id="tagsList_tag" value="" data-default="add a tag" style="color: rgb(102, 102, 102); width: 68px;"></div><div class="tags_clear"></div></div></div>';
				var tempTag = $compile(html)($scope);
				/*$('.leadTags').html('');
				$('.leadTags').html(tempTag);*/
				getTagsById(data.data["Id"]);
				$('#tagsList').tagsInput({width:'auto'});
				console.log(html);
				$scope.form.tagsList = tagString;
			}
			console.log('here is a form');
            console.log($scope.form);
			$scope.editContact = "edit";
			
			if($scope.editContact = "edit")
			{
				$scope.showItem = false;
				$("#tagsList_tagsinput").css({'display':'none'});
				console.log($scope.form);
				console.log('show '+$scope.showItem);
			}
           // $scope.editContactId = data["Id"];
        });

        setTimeout(function () {
            var selectedStatus = $("#leadStatus option:selected").text();
            var selectedStatusClass = selectedStatus.toLowerCase();

            if ($('.leadStatusdd .select-styled').hasClass('hot'))
            {
                $('.leadStatusdd .select-styled').removeClass('hot');
            }
            else if ($('.leadStatusdd .select-styled').hasClass('closed'))
            {
                $('.leadStatusdd .select-styled').removeClass('closed');
            }
            else if ($('.leadStatusdd .select-styled').hasClass('nurtur'))
            {
                $('.leadStatusdd .select-styled').removeClass('nurtur');
            }
            else if ($('.leadStatusdd .select-styled').hasClass('dead'))
            {
                $('.leadStatusdd .select-styled').removeClass('dead');
            }
            $('.leadStatusdd .select-styled').addClass(selectedStatusClass);
            selectedStatus = "  " + selectedStatus;
            $('.leadStatusdd .select-styled').html(selectedStatus);
    var selectedSource = $("#leadSource option:selected").text();
    var selectedSourceClass = selectedSource.toLowerCase();
    if ($('.leadSourcedd .select-styled').hasClass('email'))
            {
                $('.leadSourcedd .select-styled').removeClass('email');
                $('.leadSourcedd .select-styled').removeClass('marketing');
            }
            else if ($('.leadSourcedd .select-styled').hasClass('cold'))
            {
                $('.leadSourcedd .select-styled').removeClass('cold');
                $('.leadSourcedd .select-styled').removeClass('call');
            }
            else if ($('.leadSourcedd .select-styled').hasClass('partner'))
            {
                $('.leadSourcedd .select-styled').removeClass('partner');
            }
            else if ($('.leadSourcedd .select-styled').hasClass('lk'))
            {
                $('.leadSourcedd .select-styled').removeClass('lk');
                $('.leadSourcedd .select-styled').removeClass('contacts');
            }

            $('.leadSourcedd .select-styled').addClass(selectedSourceClass);
            selectedSource = "  " + selectedSource;
            $('.leadSourcedd .select-styled').html(selectedSource);
        }, 2000);
        $('.btnEditLead').attr('disabled', 'false');
        $('.btnEditLead').attr('disabled', '');
        $("#create-lead").modal('show');
		$scope.callAddLeadModal();
    };
    $scope.changeLeadStatusHot = function ($event)
    {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var leadId = target.attr('leadId');
        alertify.confirm('Lead Status', 'Are you sure you want to make this lead as Hot Lead..?',
                function ()
                {
                    dataFactory.httpRequest('leadStatusChange', 'GET', {'leadId': leadId}).then(function (data) {

                        alertify.notify('Lead status is changed successfully!', 'success', 5, function () {
                        });
                        getHotLeads();
                    });
                },
                function ()
                {
                    alertify.error('Cancelled')

                });

        setTimeout(function () {
            var selectedStatus = $("#leadStatus option:selected").text();
            var selectedStatusClass = selectedStatus.toLowerCase();

            if ($('.leadStatusdd .select-styled').hasClass('hot'))
            {
                $('.leadStatusdd .select-styled').removeClass('hot');
            }
            else if ($('.leadStatusdd .select-styled').hasClass('closed'))
            {
                $('.leadStatusdd .select-styled').removeClass('closed');
            }
            else if ($('.leadStatusdd .select-styled').hasClass('nurtur'))
            {
                $('.leadStatusdd .select-styled').removeClass('nurtur');
            }
            else if ($('.leadStatusdd .select-styled').hasClass('dead'))
            {
                $('.leadStatusdd .select-styled').removeClass('dead');
            }
            $('.leadStatusdd .select-styled').addClass(selectedStatusClass);
            selectedStatus = "  " + selectedStatus;
            $('.leadStatusdd .select-styled').html(selectedStatus);





            var selectedSource = $("#leadSource option:selected").text();
            var selectedSourceClass = selectedSource.toLowerCase();


            if ($('.leadSourcedd .select-styled').hasClass('email'))
            {
                $('.leadSourcedd .select-styled').removeClass('email');
                $('.leadSourcedd .select-styled').removeClass('marketing');
            }
            else if ($('.leadSourcedd .select-styled').hasClass('cold'))
            {
                $('.leadSourcedd .select-styled').removeClass('cold');
                $('.leadSourcedd .select-styled').removeClass('call');
            }
            else if ($('.leadSourcedd .select-styled').hasClass('partner'))
            {
                $('.leadSourcedd .select-styled').removeClass('partner');
            }
            else if ($('.leadSourcedd .select-styled').hasClass('lk'))
            {
                $('.leadSourcedd .select-styled').removeClass('lk');
                $('.leadSourcedd .select-styled').removeClass('contacts');
            }

            $('.leadSourcedd .select-styled').addClass(selectedSourceClass);
            selectedSource = "  " + selectedSource;
            $('.leadSourcedd .select-styled').html(selectedSource);
		},1000);
        $('.btnEditLead').attr('disabled', 'false');
        $('.btnEditLead').attr('disabled', '');
        $("#create-lead").modal('show');
    };
    /*##### For contact list data : data-table ######## */
    /*  $(document).ready(function() {
     $('#exampleForContactTbl').DataTable();
     console.log('hi');
     } );*/
    getInteractionTypesDropdown();
    $("#interactionDatePicker").datepicker({
        //startDate: new Date(),
        currentDate: new Date(),
        setDate: new Date(),
        autoclose: true,
        format: 'mm-dd-yyyy'
    }).on('changeDate', function (en) {
        angular.element($('#interactionDate')).triggerHandler('input');
    });
    $('#interactionTitle').bind('input', function () {
        validateLeadInteractionFormValues();
    });
    $(document).on('change', 'input', function () {
        validateLeadInteractionFormValues();
    });
    $scope.saveLead = function () {
		var tagValue = getTagListValue();
		$scope.form.tagsList = tagValue;	
		var fd = new FormData();
		var facebook =  $scope.form.leadFacebook;
		var instagram = $scope.form.leadInstagram;
		var twitter =   $scope.form.leadTwitter;
		var linkedin =  $scope.form.leadLinkedin;
		var leadId = $scope.form.leadId;
		var socialProfileArray = {'facebook':facebook,'instagram':instagram, 'twitter': twitter,'linkedin':linkedin};
		var socialProfile = JSON.stringify(socialProfileArray);
		if($scope.editContact == 'edit')
		{
			fd.append('Id',$scope.form.leadId);
		}
		fd.append('firstName',$scope.form.firstName);
		fd.append('lastName',$scope.form.lastName);
		fd.append('leadTitle',$scope.form.leadTitle?$scope.form.leadTitle:'');
		fd.append('email',$scope.form.email);
		fd.append('phoneNumber',$scope.form.phoneNumber?$scope.form.phoneNumber:'');
		fd.append('leadWebSite',$scope.form.leadWebSite);
		fd.append('companyName',$scope.form.companyName?$scope.form.companyName:'');
		fd.append('birthdate',$scope.form.birthdate);
		fd.append('aniversaryDate',$scope.form.aniversaryDate);
		fd.append('tagsList',$scope.form.tagsList);
		fd.append('addressLine1',$scope.form.addressLine1?$scope.form.addressLine1:'');
		fd.append('addressLine2',$scope.form.addressLine2);
		fd.append('leadStatus',$scope.form.leadStatusSelection);
		fd.append('leadSource',$scope.form.leadSourceSelection);
		fd.append('leadCity',$scope.form.leadCity);
		fd.append('leadState',$scope.form.leadState);
		fd.append('zipcode',$scope.form.zipcode);
		fd.append('socialProfile',socialProfile);
		fd.append('leadImage', $scope.leadImage?$scope.leadImage:'');
		//fd.append('location',$scope.form.location);
		$http.post(base_url+'leadCreate', fd, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		})
		.then(function successCallback(response) {
			//console.log(response);
			if(response.data.status == 1)
				{
					$scope.loading = true;
					alertify.alert('Lead Created', 'Congratulations! your user is created successfully!' , function (e)
					{
						if (e)
						{
							getAssignUsers();
							if ($('#create-lead').hasClass('show') ) 
							{
								$('#create-lead').modal('hide');
							}
							angular.copy({},$scope.form);
							$("#create-lead").modal("hide");
							/*$scope.form.$pristine = true
							$scope.form.$valid = true*/
							setTimeout(function(){
								location.reload(base_url+'contact');
							},1000);
						}
					});
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
    $scope.leadUploadImage = function (ele) {
        $scope.leadImage = ele[0];
        if (ele && ele[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.leadImgCircle')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
            };
            reader.readAsDataURL(ele[0]);
        }
    }
    $scope.callAddLeadModal = function () {
		$scope.form.tagsList="";
		$scope.showItem = true;
		$("#tagsList_tagsinput").css({'display':'block'});
		$scope.editContact = undefined;
		console.log($scope.form);
		//angular.copy({}, $scope.form)
       // $scope.editContact = "";
       /*  angular.copy({}, $scope.form);
		$scope.addLead.$setPristine(); */
       // $("#create-lead").modal('show');
		//$scope.leadDropdown();
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
	function getInbox() {
        dataFactory.httpRequest('message/inbox', 'GET').then(function (data) {
            $scope.messageBox = 'inbox';
            $scope.inbox = data;
            $("#dropdownMenuButton").val('Inbox');
        });
         hideContents();
        
    }
    function validateLeadInteractionFormValues() {
        var interactionDate = $("#interactionDate").val();
        var interactionTitle = $("#interactionTitle").val();
        var interactionType = $("#selectInteractionType").val();
        if (interactionDate != '' && interactionTitle != '' && interactionType != '')
        {
            $(".createLeadInteractionSubmitButton").attr('disabled', false);
        }
    }
	function getLeads() {
      dataFactory.httpRequest(base_url+'leads/getLeadUser','GET').then(function(data) {
			$scope.leads = data;
			//console.log(data);
			console.log($scope.leads);
	  });
    }
    function getLeadStatus() {
        dataFactory.httpRequest(base_url + 'leadStatus', 'GET').then(function (data) {
            $scope.leadStatus = data;
            console.log($scope.leadStatus);
        });
    }
    function getLeadSource() {
        dataFactory.httpRequest(base_url + 'leadSource', 'GET').then(function (data) {
            $scope.leadSources = data;
        });
    }
    function getAssignUsers() {
        dataFactory.httpRequest(base_url + 'assignUsers', 'GET').then(function (data) {
            $scope.assignUsers = data;
            console.log(data);
            console.log($scope.assignUsers);
        });
    }
     $("#birthdatePicker").datepicker({
        endDate: new Date(),
        autoclose: true,
        format: 'mm-dd-yyyy'
    }).on('changeDate', function (en, $scope) {
        angular.element($('#birthdate')).triggerHandler('input');

    });
    $("#aniversaryDatePicker").datepicker({
        //startDate: new Date(),
        currentDate: new Date(),
        setDate: new Date(),
        autoclose: true,
        format: 'mm-dd-yyyy'
    }).on('changeDate', function (en) {
        angular.element($('#aniversaryDate')).triggerHandler('input');


    });
    getLeadStatus();
    getLeadSource();

    $("#dueDatePicker").datepicker({
        startDate: new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd'
    }).on('changeDate', function (en) {
        angular.element($('#taskDueDate')).triggerHandler('input');
    });
    $("#reminderDatePicker").datepicker({
        setDate: new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd'
    }).on('changeDate', function (en) {
        angular.element($('#reminderDate')).triggerHandler('input');
    }).datepicker('setDate', new Date());
    $("#reminderTime").timepicker({
        'icons': {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down'
        },
        'maxHours': 24,
        'showMeridian': false,
    }).on('changeTime.timepicker', function (e) {
        angular.element($('#reminderTime')).triggerHandler('input');
    });






    $scope.IsSearch = 0;

    $scope.getOverDueTaskData = function (pageno) {
        var searchurl = base_url + 'contact/getContactInfo/' + vm.itemsPerPage + '/' + pageno;
        postdata = {};
        if ($scope.IsSearch == 1) {



            postdata.circle = $scope.circlearr;
            postdata.status = $scope.statusarr;
            postdata.tag = $scope.tagarr;
            postdata.user = $scope.userarr;
        }


        dataFactory.httpRequest(searchurl, 'POST', {}, postdata).then(function (data) {
            var responsedata = {};
            responsedata.data = data.teamMembers.data;
            responsedata.itemsPerPage = vm.itemsPerPage;
            responsedata.total_count = data.teamMembers.totalRecord;
            $scope.overDueTaskData = responsedata;
			
        });


    };


    $scope.getOverDueTaskData(vm.pageno);



    $scope.edit = function (id) {
        dataFactory.httpRequest('itemsEdit/' + id).then(function (data) {

            $scope.form = data;
        });
    }

    $scope.saveEdit = function () {
        dataFactory.httpRequest('itemsUpdate/' + $scope.form.id, 'PUT', {}, $scope.form).then(function (data) {
            $(".modal").modal("hide");
            $scope.data = apiModifyTable($scope.data, data.id, data);
        });
    }

    $scope.remove = function (item, index) {
        var result = confirm("Are you sure delete this item?");
        if (result) {
            dataFactory.httpRequest('itemsDelete/' + item.id, 'DELETE').then(function (data) {
                $scope.data.splice(index, 1);
            });
        }
    }
    $scope.uploadImage = function (ele) {
        $scope.userImage = ele[0];
    }
    $scope.taskFilter = function ($event)
    {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var filterOption = target.attr('currentVal');
        dataFactory.httpRequest('getFilterdTask', 'GET', {'filterOption': filterOption}).then(function (data) {
            $scope.dailyTaskData = data.data;
        });
    }
	
    /*##### For contact list data : data-table ######## */
    /*  $(document).ready(function() {
     $('#exampleForContactTbl').DataTable();
     console.log('hi');
     } );*/
	getLeads();
	/* $scope.leadDropdown = function () {
       
    } */

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
	$scope.deleteTags = function ($event)
    {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var tagId = target.attr('tagId');
		alertify.confirm('Delete Tag', 'Are you sure you want to delete this tag from lead..?',
                function ()
                {
                    dataFactory.httpRequest(base_url + 'deleteTag', 'GET', {'tagId': tagId}).then(function (data) {
                        if (data.status == 1)
                        {
                            getAllTags(tagId);
                            getTagsById(tagId);
                            alertify.notify('Tag deleted successfully!', 'success', 5, function () {
                            });
                        } else
                        {
                            alertify.notify(data.message, 'error', 5, function () {
                            });
                        }

                    });

                },
                function ()
                {
                    alertify.error('Cancelled')
                });
    }
	$scope.addLeadTag = function ()
    {
		var postData = [];
		var currentLeadId = $scope.form.leadId;
		
		postData = {
			leadId : currentLeadId,
			selectedTags : $scope.form.addleadtag
		};
		console.log($scope.form);
		console.log(postData);
		dataFactory.httpRequest(base_url + 'addTags', 'POST', {}, postData).then(function (data) {
            if (data.status == 1)
            {
                getAllTags(currentLeadId);
                getTagsById(currentLeadId);
                alertify.notify('Tag is added successfully', 'success', 5, function () {
                });

            }
            else
            {
                alertify.notify(data.message, 'error', 5, function () {
                });
            }
            return;
        });
    }
	function getAllTags(currentLeadId)
    {
        dataFactory.httpRequest(base_url + 'getAllTags', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            if (data.status == 1)
            {
                $scope.tags = data.data;
            } else
            {
                $scope.tags = "";
            }
        });
    }
	function getTagsById(currentLeadId)
    {
        dataFactory.httpRequest(base_url + 'getTagsById', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            if (data.status == 1)
            {
                $scope.leadTags = data.data;
            } else
            {
                $scope.tags = "";
            }
        });
    }
});
function getTagListValue(){
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