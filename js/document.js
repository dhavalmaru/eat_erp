$(function() { $('.datepicker1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0', changeYear: true }); });

jQuery(function(){
    var counter = $('input.doc_file').length;
    $('#repeat-documents').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'">' + 
                                '<div class="col-md-3 col-sm-3 col-xs-12"  >' + 
                                    '<div class="col-md-6 col-sm-6 col-xs-12">' + 
                                        '<input type="hidden" class="form-control" name="doc_type[]" id="doc_type_'+counter+'" />' + 
                                        '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="No" />' + 
                                        '<label class="doc_file control-label">Document </label>' + 
                                    '</div>' + 
                                    '<div class="col-md-6 col-sm-6 col-xs-12 documentname"  >' + 
                                        '<input type="hidden" id="doc_name_'+counter+'_id" name="doc_name[]" class="form-control doc_name" value="" data-error="#doc_name_'+counter+'_error"/>' + 
                                        '<input type="hidden" id="doc_name_'+counter+'" name="document_name[]" class="form-control auto_document" value="" placeholder="Type to choose document from database..." />' + 
                                        '<div id="doc_name_'+counter+'_error"></div>' + 
                                        '<input type="text" class="form-control" name="doc_ref_name[]" id="doc_ref_name_'+counter+'" placeholder="Document Name" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                ' <div class="col-md-4 col-sm-4 col-xs-12 documentname" >  ' + 
                                    '<div class="col-md-6 col-sm-6 col-xs-12" >' + 
                                        '<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />' + 
                                    '</div>' + 
                                    '<div class="col-md-6 col-sm-6 col-xs-12" >' + 
                                        '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-3 col-sm-3 col-xs-12 documentname" >' + 
                                    '<div class="col-md-6 col-sm-6 col-xs-12" >' + 
                                        '<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
                                    '</div>' + 
                                    '<div class="col-md-6 col-sm-6 col-xs-12" >' + 
                                        '<input type="text" id="date_expiry_'+counter+'" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-2 col-sm-2 col-xs-12" >' + 
									 '<div class=" col-sm-4 col-xs-4" >' + 
                                        '<a class="file-input-wrapper  fileinput btn btn-info btn-small ">' + 
                                            '<span>Browse</span>' + 
                                            '<input type="file" class="fileinput   btn-info btn-small doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error"  >' + 
                                        '</a>' + 
                                    '</div>' +
                                    ' <div class="col-md-3 col-sm-4 col-xs-4 download-width" >' + 
                                        '<input type="hidden" class="form-control" name="doc_document[]" value="" />' + 
                                        '<input type="hidden" class="form-control" name="document_name[]" value="" />' +                                         
                                        '<div id="doc_'+counter+'_error"></div>' + 
                                    '</div>'+							 
									 
									 
                                    '<div class="col-md-3 col-sm-4 col-xs-4 trash-width" >' + 
                                        '<a id="repeat_doc_'+counter+'_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>');
        $('#document_details').append(newRow);
        $('.auto_document', newRow).autocomplete(autocomp_opt_document);
        $('.datepicker').datepicker({  changeMonth: true,yearRange:'-100:+100',changeYear: true });
        $('.datepicker1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        $('form :input').change(function() {
            $('.save-form').prop("disabled",false);
        });
        counter++;
    });
    $('#reverse-documents').click(function(event){
        var id="#repeat_doc_"+(counter-1).toString();
        if($(id).length>0){
            $(id).remove();
            counter--;
        }
    });
});

function getExpiryDateStatus(element){
    var id = element.id;
    var doc_name = element.value;
    var index = id.substr(id.lastIndexOf('_')+1);

    $.ajax({
            url: BASE_URL+'index.php/documents/getDocumentDetails',
            data: 'doc_name='+doc_name,
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                var d_show_expiry_date = $.trim(data);
                if(d_show_expiry_date=='Yes') {
                    $("#date_expiry_" + index).show();
                } else {
                    $("#date_expiry_" + index).hide();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $("#date_expiry_" + index).hide();
            }
        });
}
