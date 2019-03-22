$(function() {
    $('#repeat-periodically').hide(); 
    $('#repeat-monthly').hide();
    $('#repeat-weekly').hide();
    $('#repeat').change(function(){
        if($('#repeat').val() == 'Periodically') {
            $('#repeat-monthly').hide(); 
            $('#repeat-periodically').show(); 
            $('#repeat-weekly').hide();
        } else if($('#repeat').val() == 'Monthly') {				
            $('#repeat-periodically').hide(); 
            $('#repeat-monthly').show(); 
            $('#repeat-weekly').hide();
        } else if($('#repeat').val() == 'Never' || $('#repeat').val() == 'Daily' || $('#repeat').val() == 'Yearly') {$('#repeat-periodically').hide(); 
            $('#repeat-weekly').hide(); 
            $('#repeat-monthly').hide(); 			
        } else if($('#repeat').val() == 'Weekly') {				
            $('#repeat-periodically').hide(); 
            $('#repeat-monthly').hide();
            $('#repeat-weekly').show(); 
        } else {
            //alert($('#repeat').val());
        }
    });
});

function loadUser(user_id){
    //alert(user_id);
    $.ajax({
        url: BASE_URL +'index.php/Task/getUsers',
        dataType:'json',
        success:function(respondata){
            //console.log(respondata);
            $.each(respondata.userdetail,function(id,val){
                if(val.id==user_id){
                    $('#assigned').append($('<option></option>').val(val.id).html(val.text).attr('selected', 'selected'));
                } else {
                    $('#assigned').append($('<option></option>').val(val.id).html(val.text)) ;
                // alert(val.id);
                }
            });
        }
    });
}

function submitForm(){
    var form_name = "task_detail";
    //alert(form_name);
    var options = {
        beforeSubmit: function (){
            return validate(form_name);
        },
        beforeSend: function(){
            // Replace this with your loading gif image
            // $(".upload-image-messages").html("<img src='/public/images/loading_red.gif' class='loader'>");
        },
        dataType: 'json',				 
        success: function(responsmydata){
            alert('hi');
            /* if(responsmydata.status == 0){
            $("#tag_msg_div").removeClass("alert-success hide").addClass("alert-danger").html(responsmydata.msg).css("display","block").fadeOut(7000);
            }
            else if(responsmydata.status == 1){
            $("#tag_msg_div").removeClass("alert-danger hide").addClass("alert-success").html(responsmydata.msg).css("display","block").fadeOut(7000);
            }   */
        }
    }; 
    // Submit the form
    $("#"+form_name).ajaxForm(options);
    return false;
}

function validate(form_name){

    var $form = $("#"+form_name);

    if(!$form.valid()){
        return false;
    }

}

function loadTaskList(){
    $('#task_list_datatable').dataTable( {
        "bDestroy":true,
        "autoWidth": false,
        "bProcessing":true,
        "sServerMethod": "POST",
        "sAjaxSource": BASE_URL+'index.php?/Task/loadTaskListGrid',
        "columns": [
        { "data": "id" },
        { "data": "name" },
        { "data": "subject_detail" },
        { "data": "priority" },
        { "data": "from_date"},
        { "data": "to_date" },
        { "data": "status"},
        { "data": "c_view"},
        { "data": "c_edit"},
        { "data": "c_delete"}
        ]
    } );

}

function getselfContactId(vrtval){
    //alert(vrtval);
    if($("#self_assigned").is(":checked")) {
        $.ajax({
            url: BASE_URL +'index.php/Task/getUsersContact',
            dataType:'json',
            success:function(respondata){
                $("#txtname_id").val(respondata.value);
                $("#txtname").val(respondata.label);
            }
        });           
    } else {
        $("#txtname_id").val('');
        $("#txtname").val('');
    }
}

function deleteRecord(task_id){
    var formdata = {
        task_id : task_id
    }
    if((task_id != 0 || task_id) && confirm('Are you sure you wish to delete this Task?') ){ 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            url : BASE_URL+'index.php?/Task/deleteRecord',
            success : function(responsmydata){
                console.log(responsmydata);
                if(responsmydata.status == 0){
                    alert(responsmydata.msg);
                } else {
                    window.location.href=BASE_URL + 'index.php/Task';
                }
            }
        });
    }
}

function completeTask(task_id){
    var formdata = {
        task_id : task_id
    }
    if((task_id != 0 || task_id) && confirm('Are you sure you wish to complete this Task?') ){ 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            url : BASE_URL+'index.php?/Task/completeTask',
            success : function(responsmydata){
                console.log(responsmydata);
                if(responsmydata.status == 0){
                    alert(responsmydata.msg);
                } else {
                    window.location.href=BASE_URL + 'index.php/Task';
                }
            }
        });
    }
}

function addComment(task_id){
    var formdata = {
        task_id : task_id,
        task_comment: $("textarea#follower_comment_id").val()
    }
    if((task_id != 0 || task_id)){ 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            async: false,
            url : BASE_URL+'index.php?/Task/addCommentTask',
            success : function(responsmydata){
                $("#follower_comment_id").val('');
            }
        });
    }
    location.reload();
}