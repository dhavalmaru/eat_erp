jQuery(function(){
    var counter = $('.title').length;
	
    $('#repeat_batch_docs').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="batch_doc_'+counter+'_row">'+
                              '<td>'+
                                    '<input type="title" class="form-control title" name="title[]" id="title_'+counter+'" placeholder="title" value=""/>'+
                                '</td>'+
                                '<td>'+
								    '<input type="hidden" class="form-control receivable_doc" name="receivable_doc[]" value="receivable_doc_'+counter+'" />'+
                                    '<a class="file-input-wrapper btn btn-default fileinput btn btn-info btn-small batch_doc">'+
                                        '<span>Browse</span>'+
                                        '<input type="file" class="fileinput btn btn-info btn-small batch_doc" name="doc_img_'+counter+'" id="doc_img_'+counter+'" placeholder="image" value="" style="left: -244px; top: -1px;">'+
                                    '</a>'+
                                '</td>'+
                                '<td style="text-align:center;  vertical-align: middle;">'+
                                    '<a id="batch_doc_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#batch_doc_details').append(newRow);
      
     
        $('.delete_row').click(function(event){
            delete_row($(this));
          
        });
        counter++;
    });
});

// $("#tabs").tabs({
//     activate: function(event, ui) {
//         alert("PRESSED TAB!");
//     }
// });

var get_tab_details = function(str_type){
    console.log(str_type);
    if(str_type=='batch_master'){
        $.ajax({
                url:BASE_URL+'index.php/Production/get_tab_details',
                data:"str_type:"+str_type+", production_id:"+$('#production_id').val(),
                method:"post",
                dataType:"json",
                async:false,
                success: function(data){
                    console.log(data);
                    // if(data!='') {
                    //     $('#batch_master').html(data);
                    // }
                }, error: function (response) {
                    var r = jQuery.parseJSON(response.responseText);
                    alert("Message: " + r.Message);
                    alert("StackTrace: " + r.StackTrace);
                    alert("ExceptionType: " + r.ExceptionType);
                }
            });

        table =  $('#customers2');
        var tableOptions = {
            'bPaginate': true,
            'iDisplayLength': 10,
            aLengthMenu: [
                [10,25, 50, 100, 200, -1],
                [10,25, 50, 100, 200, "All"]
            ],
            'bDeferRender': true,
            'bProcessing': true
        };
        table.DataTable(tableOptions);
    }
}