/*document.getElementById("myBtn").onclick = displayDate;*/
function displayEmail(email) {
    //var $phoneNo=$phoneNo;
    myWindow = window.alert(email);
    /*document.getElementById("myBtn").innerHTML = $ConMemData->PhoneNo;*/
}

function displayPhone(phoneNo) {
    //var $phoneNo=$phoneNo;
    myWindow = window.alert(phoneNo);
    /*document.getElementById("myBtn").innerHTML = $ConMemData->PhoneNo;*/
}

function displayDescription(msg) {
    //var $phoneNo=$phoneNo;
    myWindow = window.alert(msg);
    /*document.getElementById("myBtn").innerHTML = $ConMemData->PhoneNo;*/
}

jQuery(document).ready(function($) {
    
    /*var tab12 = $('#exampleForContactTbl').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdf',
            //title : 'Contact List',
            //footer: true,
            exportOptions: {
                columns: [1, 2, 4]
            }
        }]
    });*/
    
//select All data
    $('#export_contact_All_show_me').on('change',function(){
        //tab12.fnFilterClear();
        //tab12.search(this.value).draw();
        //tab12.clear().draw();
    });

//select From Search data.
    $('#export_contact_from_search_show_me').on('change',function(){
        /*var temp = tab12.search(this.value).draw();*/
        var temp = this.value;
        //tab12.search($temp).draw();
    });

// select data from circle.
    $('input[type="radio"]').click(function() {
       if($(this).attr('id') == 'export_contact_from_circle_watch_me') {
            $('#export_contact_from_circle_show_me').show();           
       }
       else {
            $('#export_contact_from_circle_show_me').show();   
       }
    });
    $('#export_contact_from_circle_show_me').on('change',function(){
        //tab12.search(this.value).draw();
    });

//PDF Genarate button click. 
    $('#exportPDFBtn').on('click', function() {
        $('.buttons-pdf').click();
    });
//disable submit button for upload CSV File.
    $('#Uploadfile').on('change', function() {
    // $scope.disableSubmit = false;
        /*if ($(this).val()) {
            $('#uploadBtn').attr('disabled',true);
        }*/
    });

});