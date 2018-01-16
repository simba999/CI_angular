app.controller('LeadController', function (dataFactory, $scope, $http, $timeout, $compile) {
    $scope.leadData = [];
    $scope.leadDetailsData = [];
    $scope.leadInteractionType = [];
    $scope.interactionsData = [];
    $scope.relatedLeadsDropdown = [];
    $scope.editRelatedLeadsDropdown = [];
    $scope.relatedContacts = [];
    $scope.leadSources = [];
    $scope.leadStatus = [];
    $scope.houseHoldContacts = [];
    $scope.searchInteractionDate = '';
    $scope.searchInteractionTitle = '';
    $scope.leadEditMode = '';
    $scope.editRelationId = '';
    $scope.selectedCircles = [];
    $scope.circles = [];
    $scope.leadCircle = [];
    $scope.leadAssignCircle = [];
    $scope.tags = [];
    $scope.leadTags = [];
    $scope.selectedCircle = '';
    $scope.leadDocumentsData = '';
    $scope.leadDocuments = [];
    $scope.select2Options = {
        simple_tags: true,
        tags: $scope.tags,
        formatResult: function (item) {
            return item.text;
        },
        formatSelection: function (item) {
            return item.text;
        },
    };
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = currentDate.getMonth() + 1;
    var date = currentDate.getDate();
    var cdate = month + '-' + date + '-' + year;
    $scope.form = {
        birthdate: cdate,
        aniversaryDate: cdate
                //leadStatusSelection: cdate, 
    };
    //$scope.birthdate = cdate;
    //$scope.aniversaryDate = cdate;
    //$scope.form.leadStatusSelection = '';
    //$scope.form.leadSourceSelection = '';
    /* $('.selectLead').select2().on("change", 
     function (e) {
     console.log("denis");
     console.log(e);
     console.log(this.val);
     angular.element($('#selectLead')).triggerHandler('input'); 
     });  */
    $scope.uploadDocuments = function (ele) {

        angular.element($('#leadDocument')).triggerHandler('input');
        angular.element($('#leadDocument')).triggerHandler('change');
        for (var i = 0; i < ele.length; i++) {
            console.log("File==" + ele[i]);
            $scope.leadDocuments.push(ele[i])
        }
    }
    $scope.saveLeadDocument = function ()
    {
        //console.log($scope.leadDocuments);
        //console.log($scope.form.adddocument);

        var fd = new FormData();
        for (var i in $scope.leadDocuments) {
            fd.append("leadDocuments[]", $scope.leadDocuments[i]);
        }
        fd.append('leadId', currentLeadId);
        //console.log(fd);
        $http.post(base_url + 'addLeadDocuments', fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
                .then(function successCallback(response) {
                    //console.log(response);
                    if (response.data.status == 1)
                    {

                        alertify.alert('Document', 'Congratulations your document is uploaded for lead!');
                        getLeadDocuments();
                        $scope.leadDocuments = [];
                        $(".modal").modal("hide");
                    }
                    else
                    {
                        alertify.alert('Error', response.data.message);
                    }
                }
                , function errorCallback(response) {
                    alertify.alert('Error', response.data.message, function () {
                        alertify.error(response.data.message)
                    });
                });
    }
    $("#interactionDatePicker").datepicker({
        autoclose: true,
        //format: 'yyyy-mm-dd'
		format: 'mm-dd-yyyy'
    }).on('changeDate', function (en) {
        //console.log(en);
        angular.element($('#interactionDate')).triggerHandler('input');

    });
    $("#searchInteractionDate").daterangepicker({
        autoclose: true,
        "locale": {
            //"format": "YYYY-MM-DD",
			"format": "MM-DD-YYYY",
            "separator": "|",
        },
        //format: 'YYYY/MM/DD'
    }).on('changeDate', function (en) {
        angular.element($('#searchInteractionDate')).triggerHandler('input');

    });
    function getLeadDocuments()
    {
        dataFactory.httpRequest(base_url + 'getLeadDocuments', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            if (data.status == 1)
            {
				$scope.leadDocumentsData = data.data;
            }
            else
            {
                $scope.leadDocumentsData = "";
            }
        })
    }
    function getLeadData() {
		//alert('getLeadData');
        dataFactory.httpRequest(base_url + 'getLeadData', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            if (data.status == 1)
            {
                $scope.leadData = data.data;
                console.log('lead data');
                var socialProfile = $.parseJSON($scope.leadData.SocialProfile);
                $scope.form = {
                    firstName: $scope.leadData.FirstName,
                    lastName: $scope.leadData.LastName,
                    leadTitle: $scope.leadData.leadTitle?$scope.leadData.leadTitle:'',
                    email: $scope.leadData.email,
                    phoneNumber: $scope.leadData.phoneNo?$scope.leadData.phoneNo:'',
                    leadWebSite: $scope.leadData.WebSite,
                    companyName: $scope.leadData.companyName?$scope.leadData.companyName:'',
                    birthdate: $scope.leadData.BirthDate,
                    aniversaryDate: $scope.leadData.AniversaryDate,
                    addressLine1: $scope.leadData.AddressLine1?$scope.leadData.AddressLine1:'',
                    addressLine2: $scope.leadData.AddressLine2,
                    leadCity: $scope.leadData.City,
                    leadState: $scope.leadData.State,
                    zipcode: $scope.leadData.Zipcode,
                    leadOwnerName: $scope.leadData.leadOwnerName,
                    //timezone: $scope.leadData.timezone,
                    locationName: $scope.leadData.location,
                    leadSourceSelection: $scope.leadData.leadSourceId,
                    leadStatusSelection: $scope.leadData.leadStatusId,
                    facebook: socialProfile.facebook ? socialProfile.facebook : '',
                    instagram: socialProfile.instagram ? socialProfile.instagram : '',
                    twitter: socialProfile.twitter ? socialProfile.twitter : '',
                    linkedin: socialProfile.linkedin ? socialProfile.linkedin : '',
                }
                setTimeout(function () {
                    var selectedStatus = $("#leadStatusLead option:selected").text();
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
                    var selectedSource = $("#leadSourceLead option:selected").text();
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

                console.log($scope.form);

            } else
            {
                $scope.leadData = '';
            }
        });
    }
    function getLeadInteractionType() {
        dataFactory.httpRequest(base_url + 'getleadInteractionTypes', 'GET').then(function (data) {
            $scope.leadInteractionType = data;
        })
    }
    function getAllInteractions() {

        var interactionTypeId = 0;
        dataFactory.httpRequest(base_url + 'getAllInteractions', 'GET', {'interactionTypeId': interactionTypeId, 'currentLeadId': currentLeadId}).then(function (data) {
            $scope.interactionsData = data;
        });
    }
    /* function getRelatedLeadDropdown() {
     dataFactory.httpRequest(base_url + 'getRelatedLeadDropdown', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
     if (data.status == 1)
     {
     $scope.relatedLeadsDropdown = data.data;
     console.log($scope.relatedLeadsDropdown);
     } else
     {
     $scope.relatedLeadsDropdown = "";
     }
     });
     } */
    function getEditRelatedLeadDropdown() {
        dataFactory.httpRequest(base_url + 'getEditRelatedLeadDropdown', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            if (data.status == 1)
            {
                $scope.editRelatedLeadsDropdown = data.data;
            } else
            {
                $scope.editRelatedLeadsDropdown = "";
            }
        });
    }
    function getRelatedContacts() {
        dataFactory.httpRequest(base_url + 'getRelatedContacts', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            $scope.relatedContacts = data.data;
        });
    }
    function getHouseHoldContacts()
    {
        dataFactory.httpRequest(base_url + 'getHouseHoldContacts', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            $scope.houseHoldContacts = data.data;
        });
    }
    function getLeadSource() {
        dataFactory.httpRequest(base_url + 'leadSource', 'GET').then(function (data) {
            $scope.leadSources = data;

        });
    }
    function getLeadStatus() {
        dataFactory.httpRequest(base_url + 'leadStatus', 'GET').then(function (data) {
            $scope.leadStatus = data;
        });
    }


    function getCircles() {
        dataFactory.httpRequest(base_url + 'leadCircles/getCircles', 'GET', {'currentLeadId': currentLeadId}).then(function (data) {
            $scope.circles = data;
			console.log('circle data');
			console.log($scope.circles);
            $scope.form.addleadcircle = {
                leadId: currentLeadId,
            }
        });
    }
    function getAllTags()
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
    function getTagsById()
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
    $scope.deleteDocument = function ($event)
    {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var leadDocumentId = target.attr('leadDocumentId');
        alertify.confirm('Delete Document', 'Are you sure you want to delete this document from lead..?',
                function ()
                {
                    dataFactory.httpRequest(base_url + 'deleteLeadDocument', 'GET', {'leadDocumentId': leadDocumentId}).then(function (data) {
                        if (data.status == 1)
                        {
                            getLeadDocuments();
                            alertify.notify('Document deleted successfully!', 'success', 5, function () {
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
                            getAllTags();
                            getTagsById();
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
    $scope.leadEditFlag = function ()
    {
		//$scope.leadEditMode = '1';	
		$scope.leadEditMode = !$scope.leadEditMode
        var input = document.getElementById('addressLine1');
        autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var times_Stamp = (Math.round((new Date().getTime()) / 1000)).toString();
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            $("#zipcode").val('');
            $("#addressLine2").val('');
            $("#leadCity").val('');
            $("#leadState").val('');
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "postal_code") {
                        $("#zipcode").val(place.address_components[i].long_name);
                        angular.element($('#zipcode')).triggerHandler('input');
                    }
                    if (place.address_components[i].types[j] == "sublocality_level_1") {
                        $("#addressLine2").val(place.address_components[i].long_name);
                        angular.element($('#addressLine2')).triggerHandler('input');
                    }
                    if (place.address_components[i].types[j] == "administrative_area_level_2") {
                        $("#leadCity").val(place.address_components[i].long_name);
                        angular.element($('#leadCity')).triggerHandler('input');

                    }
                    if (place.address_components[i].types[j] == "administrative_area_level_1") {
                        $("#leadState").val(place.address_components[i].long_name);
                        angular.element($('#leadState')).triggerHandler('input');

                    }
                }
            }
            //angular.element($('#locationName')).triggerHandler('input');
        });
		setTimeout(function(){
			//alert('leadEditFlag');
			var LeadStatus = $("#leadStatusLead option:selected").text();
			var LeadSource = $("#leadSourceLead option:selected").text();
			$('#leadStatusLead,#leadSourceLead').each(function () {
				var $this = $(this), numberOfOptions = $(this).children('option').length;
				$this.addClass('select-hidden');
				$this.wrap('<div class="select"></div>');
				$this.after('<div class="select-styled"></div>');
				var $styledSelect = $this.next('div.select-styled');
				var elementName = "";
				if ($(this).attr('id') == 'leadStatusLead')
				{
					//$styledSelect.addClass('hot');
					elementName = 'leadStatus';
					$styledSelect.text(LeadStatus);
					LeadStatus = LeadStatus.toLowerCase();
					$styledSelect.addClass(LeadStatus);
				}
				if ($(this).attr('id') == 'leadSourceLead')
				{
					elementName = 'leadSource';
					$styledSelect.text(LeadSource);
					LeadSource = LeadSource.toLowerCase();
					$styledSelect.addClass(LeadSource);
				}
				//alert($this.children('option').eq(0).text());
				
				var $list = $('<ul/>', {
					'class': 'select-options'
				}).insertAfter($styledSelect);

				for (var i = 0; i < numberOfOptions; i++) {
					console.log($this.children('option').eq(i).val());
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
		}, 1000);

    }

    $scope.getInteractions = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var interactionTypeId = target.attr('interactionTypeId');
        if (interactionTypeId == 3)
        {
            dataFactory.httpRequest(base_url + 'message/inbox', 'GET').then(function (data) {
                $scope.interactionsData = data;

            });
        }
        else
        {
            dataFactory.httpRequest(base_url + 'getAllInteractions', 'GET', {'interactionTypeId': interactionTypeId, 'currentLeadId': currentLeadId, 'searchInteractionDate': $scope.searchInteractionDate, 'searchInteractionTitle': $scope.searchInteractionTitle}).then(function (data) {
                $scope.interactionsData = data;
            });
        }

    }
    $scope.addInteraction = function ($event) {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var interactionTypeId = target.attr('interactionTypeId');
        $scope.form.interactionTypeId = interactionTypeId;
        console.log($scope.form);
        dataFactory.httpRequest(base_url + 'interactionCreate', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
                $scope.saveInteraction.$setPristine();
                $scope.saveInteraction.$setUntouched();
                $scope.form.interactionTitle = "";
                $scope.form.interactionDate = "";

                alertify.alert('Interaction', 'Congratulations your interaction is created successfully!');
                getAllInteractions();
            } else
            {
                alertify.alert('Error', data.message);
            }

        });
    }
    $scope.saveCircle = function ()
    {
        dataFactory.httpRequest('circleCreate', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
                $(".modal").modal("hide");
                alertify.alert('Circle', 'Congratulations your circle is created successfully!');
            } else
            {
                alertify.alert('Error', data.message, function () {
                    alertify.error(data.message)
                });
            }
        });
    }
    $scope.searchInteractions = function ()
    {
        $scope.searchInteractionDate = "";
        $scope.searchInteractionTitle = "";
        if ($scope.form.searchInteractionDate != "")
        {
            $scope.searchInteractionDate = $scope.form.searchInteractionDate;
        }
        if ($scope.form.searchInteractionTitle != "")
        {
            $scope.searchInteractionTitle = $scope.form.searchInteractionTitle;
        }
        dataFactory.httpRequest(base_url + 'searchInteractions', 'POST', {}, $scope.form).then(function (data) {
            $scope.interactionsData = data.data;
        });
    }
    $scope.saveRelatedContact = function ()
    {
        //alert("ddd");
        /* dataFactory.httpRequest(base_url + 'saveRelatedContact', 'POST', {}, $scope.form).then(function (data) {
         if (data.status == 1)
         {
         alertify.alert('Related Contact', 'Congratulations your related contact is created successfully!');
         //getRelatedLeadDropdown();
         return false;
         getRelatedContacts();
         //$(".modal").modal("hide");
         $scope.addRelation.$setPristine();
         $scope.addRelation.$setUntouched();
         $scope.form.selectLead = "";
         $scope.form.relationTitle = "";
         } else
         {
         alertify.alert('Error', data.message);
         }
         
         }); */
    }
    $scope.saveHouseHoldContact = function ()
    {
        dataFactory.httpRequest(base_url + 'saveHouseHoldContacts', 'POST', {}, $scope.form.houseHold).then(function (data) {
            if (data.status == 1)
            {
                alertify.alert('House Hold Contact', 'Congratulations your house hold contact is created successfully!');
                //getRelatedLeadDropdown();
                getHouseHoldContacts();
                $(".modal").modal("hide");
                $scope.addHouseHoldContact.$setPristine();
                $scope.addHouseHoldContact.$setUntouched();
                $scope.form.houseHoldtLead = "";
                $scope.form.houseHoldRelationTitle = "";
            } else
            {
                alertify.alert('Error', data.message);
            }

        });
    }


    $scope.addLeadCircle = function ()
    {
        dataFactory.httpRequest(base_url + 'leadCircles/addLeadCircle', 'POST', {}, $scope.form.addleadcircle).then(function (data) {
            alertify.notify('Assign circle successfully', 'success', 5, function () {
            });
            return;
        });
    }
    $scope.addLeadTag = function ()
    {
        $scope.form.addleadtag.leadId = currentLeadId;
        console.log($scope.form.addleadtag);
        dataFactory.httpRequest(base_url + 'addTags', 'POST', {}, $scope.form.addleadtag).then(function (data) {
            if (data.status == 1)
            {
                getAllTags();
                getTagsById();
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
    $scope.deleteRelatedContact = function ($event)
    {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var relationId = target.attr('relatedId');
        alertify.confirm('Delete Relation', 'Are you sure you want to delete this relation Data..?',
                function ()
                {
                    dataFactory.httpRequest(base_url + 'deleteRelation', 'GET', {'relationId': relationId}).then(function (data) {

                        if (data.status == 1)
                        {
                            getRelatedContacts();
                            alertify.notify('Your related lead is deleted successfully!', 'success', 5, function () {
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
    $scope.editRelatedContact = function ($event)
    {
        $event.preventDefault();
        var target = angular.element($event.currentTarget);
        var relationId = target.attr('relatedId');
        dataFactory.httpRequest(base_url + 'getRelatedContactById', 'GET', {'relationId': relationId}).then(function (data) {
            if (data.status == 1)
            {
                $scope.form = {
                    relationId: data.data.Id,
                    editRelationTitle: data.data.relation
                }
                $scope.editRelationId = data.data.Id;
                $('#edit-relation').modal('show');
            }
        });
    }
    $scope.updateRelatedContact = function ()
    {
        dataFactory.httpRequest(base_url + 'updateRelatedContact', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
                $(".modal").modal("hide");
                getRelatedContacts();
                alertify.alert('Lead Relations', 'Congratulations your relation is updated successfully!');
            } else
            {
                alertify.alert('Error', data.message, function () {
                    alertify.error(data.message)
                });
            }
        });
    }
    $scope.updateLeadDetails = function ()
    {
        $scope.form.currentLeadId = currentLeadId;
        if ($scope.userImage) {
            $scope.form.userImage = $scope.userImage;
        } else {
            $scope.form.userImage = '';
        }

        var fd = new FormData();
        fd.append('currentLeadId',$scope.form.currentLeadId);
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
		fd.append('userImage', $scope.userImage?$scope.userImage:'');

        $http.post(base_url+'updateLeadData', fd, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		})
		.then(function successCallback(response) {
			if (response.data.status == 1)
            {
                getLeadData();
                alertify.alert('Lead Updated', 'Congratulations! Your lead details is updated successfully!');
                $timeout(function () {
                    angular.element(document.querySelector('#editLeadBtn')).triggerHandler('click');
                });
            } else
            {
                alertify.alert('Lead Update', 'Nothing is updated');
                $timeout(function () {
                    angular.element(document.querySelector('#editLeadBtn')).triggerHandler('click');
                });
            }
		}
		,function errorCallback(response) {
			//$scope.loading = false;
			alertify.alert('Error', response.data.message,function(){ alertify.error(response.data.message)});
		});

        // dataFactory.httpRequest(base_url + 'updateLeadData', 'POST', {}, fd).then(function (data) {
        //     if (data.status == 1)
        //     {
        //         getLeadData();
        //         alertify.alert('Lead Update', 'Congratulations your lead details is updated successfully!');
        //         $timeout(function () {
        //             angular.element(document.querySelector('#editLeadBtn')).triggerHandler('click');
        //         });
        //     } else
        //     {
        //         alertify.alert('Lead Update', 'Nothing is updated');
        //         $timeout(function () {
        //             angular.element(document.querySelector('#editLeadBtn')).triggerHandler('click');
        //         });
        //     }
        // });
    }

    $scope.deleteHouseHold = function ($event)
    {
        var target = angular.element($event.currentTarget);
        var houseHoldId = target.attr('houseHoldId');
        console.log(houseHoldId);
        alertify.confirm('Delete', 'Are you sure you want to delete house hold contact',
                function ()
                {
                    dataFactory.httpRequest(base_url + 'deleteHouseHoldContact', 'GET', {'houseHoldId': houseHoldId}).then(function (data) {
                        console.log("console log");
                        alertify.notify('Household concat is deleted successfully!', 'success', 5, function () {
                        });
                        getHouseHoldContacts();
                    });
                },
                function ()
                {
                    alertify.error('Cancelled')
                });
    }
    $scope.saveRelatedLeadData = function (leadid)
    {
        var currentLeadID = $('input[name=leadId]').val();
        var relationValue = $('input[name=relationTitle_' + leadid + ']').val();
        var relatedLeadID = $('input[name=relatedLeadId_' + leadid + ']').val();
        if (relationValue != '')
        {
            var relatedLeadData = {
                'leadId': currentLeadID,
                'selectLead': relatedLeadID,
                'relationTitle': relationValue
            };
            dataFactory.httpRequest(base_url + 'saveRelatedContact', 'POST', {}, relatedLeadData).then(function (data) {
                if (data.status == 1)
                {
                    alertify.alert('Related Contact', 'Congratulations your related contact is created successfully!', function (e)
                    {
                        if (e)
                        {
                            var table = ".tblContent_" + leadid;
                            $(table).remove();
                        }
                        return;

                    });
                    //getRelatedLeadDropdown();
                    getRelatedContacts();
                    $scope.addRelation.$setPristine();
                    $scope.addRelation.$setUntouched();
                    $scope.form.selectLead = "";
                    $scope.form.relationTitle = "";
                } else
                {
                    alertify.alert('Error', data.message);
                }
            });
        }
    }
    $scope.searchRelatedContact = function (event)
    {
        var searchContactValue = angular.element('#searchContact').val();
        dataFactory.httpRequest(base_url + 'getRelatedLeadDropdown', 'GET', {'currentLeadId': currentLeadId, 'searchContactValue': searchContactValue}).then(function (data) {
            if (data.status == 1)
            {
                if (data.data.length > 0)
                {
                    $(".relatedContactData").html('');
                    var log = [];
                    var htmlContent = '';
                    var i = 0;
                    angular.forEach(data.data, function (value, key) {
                        htmlContent += '<table class="table table-contact-list leadTable tblContent_' + value.leadId + '"><tbody><tr><td width="33.33%">';
                        htmlContent += '<div class="row"><div class="relatedContactContents media stream-post">';
                        htmlContent += '<input required   ng-value ="{{' + value.leadId + '}}" type="hidden" name="relatedLeadId_' + value.leadId + '" id="leadId" />';
                        htmlContent += '<div class="imageContent">';

                        if (value.leadImage != "")
                        {
                            htmlContent += '<div class="avatar avatar-circle"><img src="' + UploadDirectory + '/' + value.leadImage + '" class=""/></div>';
                        }

                        htmlContent += '</div>';
                        htmlContent += '<div class="media-body"><h4 class="media-heading mt-1"><a href="javascript:void(0)" class="sp-auther ng-binding">' + value.leadUserName + '</a></h4><small class="sp-meta ng-binding">' + value.leadEmail + '</small></div>';

                        htmlContent += '</div></td>';


                        htmlContent += '<td width="33.33%"><div class="col-sm-12 relatedContactContents relatedLeadRelationValue"><div class="form-group"><input type="text" class="form-control relationTitle" name="relationTitle_' + value.leadId + '" placeholder="Relation" data-id=' + value.leadId + '  required/></div></div></div></td>'; // End div stream-post

                        htmlContent += '<td width="35%" class="perform-action"><button  type="button"  class="btn btn-skyblue-outline pull-right btnaddRelation" data-id="' + value.leadId + '" ng-click = "saveRelatedLeadData(' + value.leadId + ')">Add Relation</button></td></tr></table>';
                        i++;
                    }, log);
                    var temp = $compile(htmlContent)($scope);
                    $(".relatedContactData").html('');
                    $(".relatedContactData").html(temp);
                    $(".btnaddRelation").attr('disabled', 'true');
                }
            }
            else {
                $(".relatedContactData").html('');
            }
        });
    }
    $("#create-relation .close").on("click", function () {
        $('#searchContact').val('');
        $("#create-relation .relatedContactData").html('');
        $("#create-relation").modal("hide");
    });
    getLeadData();
    getLeadInteractionType();
    getAllInteractions();
    //getRelatedLeadDropdown();
    getRelatedContacts();
    getHouseHoldContacts();
    getEditRelatedLeadDropdown();
    getLeadSource();
    getLeadStatus();
    getCircles();
    getAllTags();
    getTagsById();
    getLeadDocuments();
    //getLeadCircle();

    $(document).on('input', ".relationTitle", function () {
        var dataId = $(this).attr('data-id');
        if ($(this).val() != "")
        {
            $(this).parents('td').next('td').find('.btnaddRelation').attr('disabled', 'false');
            $(this).parents('td').next('td').find('.btnaddRelation').removeAttr('disabled');
        }
        else {
            $(this).parents('td').next('td').find('.btnaddRelation').attr('disabled', 'true');
        }
    });
    $("#birthdatePicker").datepicker({
        endDate: new Date(),
        autoclose: true,
        format: 'mm-dd-yyyy'
    }).on('changeDate', function (en, $scope) {
        angular.element($('#birthdate')).triggerHandler('input');

    });
    $("#aniversaryDatePicker").datepicker({
        endDate: new Date(),
        autoclose: true,
        format: 'mm-dd-yyyy'
    }).on('changeDate', function (en, $scope) {
        angular.element($('#aniversaryDatePicker')).triggerHandler('input');

    });
    $scope.changeList = function (selectedVal, elementId) {
		if (elementId == "leadStatus")
        {
			$scope.form.leadStatusSelection = selectedVal;
		}
        if (elementId == "leadSource")
        {
            $scope.form.leadSourceSelection = selectedVal;
		}
	}

    // upload userImage
    $scope.userUploadImage = function(ele) {
        $scope.userImage = ele[0];
        $scope.isLeadImage = false;
        
        if (ele && ele[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.name-abbreviation').css('display', 'none');
                $('.leadUserImage')
                    .attr('src', e.target.result)
                    .css('display', '')
                    .width(200)
                    .height(200);
            };
            reader.readAsDataURL(ele[0]);
        }
   }
});