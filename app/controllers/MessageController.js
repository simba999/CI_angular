//app.directive('fixedHeader', fixedHeader);
// 
//    fixedHeader.$inject = ['$timeout'];
// 
//    function fixedHeader($timeout) {
//        return {
//            restrict: 'A',
//            link: link
//        };
// 
//        function link($scope, $elem, $attrs, $ctrl) {
//            var elem = $elem[0];
// 
//            // wait for data to load and then transform the table
//            $scope.$watch(tableDataLoaded, function(isTableDataLoaded) {
//                if (isTableDataLoaded) {
//                    transformTable();
//                }
//            });
// 
//            function tableDataLoaded() {
//                // first cell in the tbody exists when data is loaded but doesn't have a width
//                // until after the table is transformed
//                var firstCell = elem.querySelector('tbody tr:first-child td:first-child');
//                return firstCell && !firstCell.style.width;
//            }
// 
//            function transformTable() {
//                // reset display styles so column widths are correct when measured below
//                angular.element(elem.querySelectorAll('thead, tbody, tfoot')).css('display', '');
// 
//                // wrap in $timeout to give table a chance to finish rendering
//                $timeout(function () {
//                    // set widths of columns
//                    angular.forEach(elem.querySelectorAll('tr:first-child th'), function (thElem, i) {
// 
//                        var tdElems = elem.querySelector('tbody tr:first-child td:nth-child(' + (i + 1) + ')');
//                        var tfElems = elem.querySelector('tfoot tr:first-child td:nth-child(' + (i + 1) + ')');
//                        var columnWidth = tdElems ? tdElems.offsetWidth : thElem.offsetWidth;
//                        if (tdElems) {
//                            tdElems.style.width = columnWidth + 'px';
//                        }
//                        if (thElem) {
//                            thElem.style.width = columnWidth + 'px';
//                        }
//                        if (tfElems) {
//                            tfElems.style.width = columnWidth + 'px';
//                        }
//                    });
// 
//                    // set css styles on thead and tbody
//                    angular.element(elem.querySelectorAll('thead, tfoot')).css('display', 'block');
// 
//                    angular.element(elem.querySelectorAll('tbody')).css({
//                        'display': 'block',
//                        'height': $attrs.tableHeight || 'inherit',
//                        'overflow': 'scroll'
//                    });
// 
//                    // reduce width of last column by width of scrollbar
//                    var tbody = elem.querySelector('tbody');
//                    var scrollBarWidth = tbody.offsetWidth - tbody.clientWidth;
//                    if (scrollBarWidth > 0) {
//                        // for some reason trimming the width by 2px lines everything up better
//                        scrollBarWidth -= 2;
//                        var lastColumn = elem.querySelector('tbody tr:first-child td:last-child');
//                        lastColumn.style.width = (lastColumn.offsetWidth - scrollBarWidth) + 'px';
//                    }
//                });
//            }
//        }
//    }

app.controller('MessageController', function (dataFactory, $rootScope, $scope, $http, $sce) {

    $scope.data = [];
    $scope.inbox = [];
    $scope.inbox['totalInbox']=0;
    $scope.inbox['totalSent']=0;
    $scope.inbox['totalDraft']=0;
    $scope.sentbox = [];
    $scope.draft = [];
    $scope.assignUsers = [];
    $scope.messageBox = 'inbox';
    $scope.showContentData = false;
    $scope.tdShow = true;
    $scope.options = {
        height: 200,
        toolbar: [
                    ['fontface', ['fontname']],
                    ['textsize', ['fontsize']],
                    ['style', ['bold', 'italic', 'underline']],
                    ['color', ['color']],
                    ['para', ['paragraph','ol','ul']],
                    ['insert', ['link','picture']],
                    ['view', ['codeview']],		    
        ],
        oninit: function() {
            // Add "open" - "save" buttons
            var noteBtn = '<button id="makeSnote" type="button" class="btn btn-default btn-sm btn-small" title="Add Attachments" data-event="click" tabindex="-1"><i class="fa fa-paperclip"></i></button>';
                noteBtn += '<button id="makeSnote1" type="button" class="btn btn-default btn-sm btn-small dropdown-toggle" title="Add Quote" data-event="something" tabindex="-1"><i class="fa fa-quote-right"></i> </button>';
            var noteBtn1 = '<button id="makeSnote2" type="button" class="btn btn-default btn-sm btn-small" title="Add Listing" data-event="something" tabindex="-1"><i class="fa fa-plus"></i> Add Listing from</button>';
            var noteBtn2 = '<button id="makeSnote3" type="button" class="btn btn-default btn-sm btn-small" title="Add Template" data-event="something" tabindex="-1"><i class="fa fa-file"></i> Templates</button>';
            var fileGroup = '<div class="note-files btn-group">' + noteBtn + '</div>';
            $(fileGroup).appendTo($('.note-insert'));
            var fileGroup2 = '<div class="note-listing btn-group">' + noteBtn1 + '</div>';
            $(fileGroup2).appendTo($('.note-toolbar'));
            var fileGroup3 = '<div class="note-templates btn-group">' + noteBtn2 + '</div>';
            $(fileGroup3).appendTo($('.note-toolbar'));
            // Button tooltips
            $('#makeSnote').tooltip({
              container: 'body',
              placement: 'bottom'
            });
            // Button events
            $('#makeSnote').on('click',function(event) {
                console.log("test click");
            });
        }
    }
    $scope.leads = [];
    getInbox();
    getAssignUsers();
    getLeads();
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
    function getInbox() {
        $scope.html5spinner = true;
        dataFactory.httpRequest('message/inbox', 'GET').then(function (data) {
            $scope.messageBox = 'inbox';
			$scope.inbox = data['inboxMessages'];
			$scope.inbox['totalInbox']=data['totalInbox'];
            $scope.inbox['totalSent']=data['totalSent'];
            $scope.inbox['totalDraft']=data['totalDraft'];
            $scope.html5spinner = false;
            $("#dropdownMenuButton").val('Inbox');
        });
        hideContents();
        
    }
	
    function getAssignUsers() {
        dataFactory.httpRequest(base_url + 'assignUsers', 'GET').then(function (data) {
            $scope.assignUsers = data;
            //console.log($scope.assignUsers);
        });
    }
    function getLeads() {
      dataFactory.httpRequest(base_url+'leads/getLeadUser','GET').then(function(data) {
			$scope.leads = data;
			//console.log(data);
			console.log($scope.leads);
	  });
    }
    $scope.getInboxs = function () {
         hideContents();
         $scope.html5spinner = true;
        dataFactory.httpRequest('message/inbox', 'GET').then(function (data) {
            $scope.messageBox = 'inbox';
//            $scope.inbox = data;
$scope.inbox = data['inboxMessages'];
            $scope.inbox['totalInbox']=data['totalInbox'];
            $scope.inbox['totalSent']=data['totalSent'];
            $scope.inbox['totalDraft']=data['totalDraft'];
             $scope.html5spinner = false;
			$("#btnText").html('Inbox');

        });    
        
    }

    $scope.getSentbox = function () {
         hideContents();
         $scope.html5spinner = true;
        dataFactory.httpRequest('message/sentbox', 'GET').then(function (data) {
			$scope.messageBox = 'sentbox';
            $scope.sentbox = data;
             $scope.html5spinner = false;
			$("#btnText").html('Sent');
        });
        
    }

    $scope.getDraftbox = function () {
         hideContents();
         $scope.html5spinner = true;
        dataFactory.httpRequest('message/darftbox', 'GET').then(function (data) {
            $scope.messageBox = 'draft';
            $scope.draft = data;
             $scope.html5spinner = false;
			$("#btnText").html('Draft');
        });
        
    }


    $scope.sentMessage = function () {
        dataFactory.httpRequest('message/create', 'POST', {}, $scope.form).then(function (data) {
            if (data.status == 1)
            {
                alertify.alert('Message', 'Congratulations your message is created successfully!');
                getInbox();
                $(".modal").modal("hide");

            } else
            {
                alertify.alert("Error", data.message, function () {
                    alertify.error(data.message)
                });
            }
        });
    }
    
    $scope.setFocusTo=function($event){
        angular.element($('.select2-search__field:first')).focus();
        //angular.element($('.select2-search__field:first')).parents('.select2-container--default').siblings('.select2-container--default').remove();
                
        angular.element($('.select2-container--default:last')).remove();
    }
    $("#schedulePicker").datepicker({
        startDate: new Date(),
        autoclose: true,
        format: 'yyyy-mm-dd'
    }).on('changeDate', function (en) {
        angular.element($('#scheduleDate')).triggerHandler('input');
    });

    $scope.savedraft = function () {
        $scope.form.messagetype = "draft";
    }
    $scope.showContent = function ($event) {
		console.log($scope.showContentData);
		if($scope.showContentData == true)
            hideContents();
        var newElement='.readMsg'+angular.element($event.currentTarget).data('id');
        $scope.data['ReadMessage']=angular.element($(newElement)).data('read-val');
        $scope.data['Id']=angular.element($(newElement)).data('msg-id');
        if( $scope.data['ReadMessage']==0){
            dataFactory.httpRequest('message/readStatus', 'POST', $scope.data, $scope.data).then(function (data) {   
			});
        }
        
        $scope.showContentData = true;
        $scope.tdShow = false;
        //console.log($scope.showContentData);
        if (angular.element($('.mail-list')).hasClass('col-sm-12')) {
            angular.element($('.mail-list')).removeClass('col-sm-12');
            angular.element($('.mail-list')).addClass('col-sm-6');
        }

    }
    $scope.hideContent = function () {
        $scope.showContentData = false;
        $scope.tdShow = true;
        if (angular.element($('.mail-list')).hasClass('col-sm-6')) {
            angular.element($('.mail-list')).removeClass('col-sm-6');
            angular.element($('.mail-list')).addClass('col-sm-12');
        }
        hideContents();
    }
    function hideContents(){
        console.log("called");
        $scope.showContentData = false;
        $scope.tdShow = true;
        if (angular.element($('.mail-list')).hasClass('col-sm-6')) {
            angular.element($('.mail-list')).removeClass('col-sm-6');
            angular.element($('.mail-list')).addClass('col-sm-12');
        }
    }
    $scope.readStatus=function($event){
        var currentEle=angular.element($event.currentTarget).attr('class');
        $scope.data['ReadMessage']=angular.element($event.currentTarget).data('read-val');
        $scope.data['Id']=angular.element($event.currentTarget).data('msg-id');
        
        dataFactory.httpRequest('message/readStatus', 'POST', $scope.data, $scope.data).then(function (data) {  
            if (data.status == 1)
            {
                getInbox();

            } else
            {
                if($scope.data['ReadMessage']==0)
                    angular.element($("."+currentElement)).find('i').css('color','#4e9618');
                else {
                    angular.element($("."+currentElement)).find('i').css('color','#c4c4c4');
                }
            }
        });
    }
    $scope.replyMsg=function($event){
        var id=angular.element($event.currentTarget).attr('id');
        if(id!==undefined)
        {
            var val=angular.element($event.currentTarget).data('parent-id');
            $scope.form.parentId = val;
            $scope.form.replyMsg=1;
            var element="<br><br><div id='msg_block'></div><div style='border-left: solid 2px #ddd;padding: 0px 10px;'>";
            var content=angular.element($event.currentTarget).parent().parent().next('.sp-content').find('p').html();
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
    }
    
});