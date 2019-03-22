jQuery(function(){
    var counter = $('.raw_material_check_doc_type').length;
	
    $('#repeat_raw_material_check').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="raw_material_check_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control raw_material_check_doc_type" name="raw_material_check_doc_type[]" value="raw_material_check" />'+
                                    '<input type="text" class="form-control raw_material_check_doc_title" name="raw_material_check_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="raw_material_check_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="raw_material_check_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small raw_material_check_doc" name="raw_material_check_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="raw_material_check_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#raw_material_check').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.recon_of_rm_doc_type').length;
    
    $('#repeat_sorting').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="sorting_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control sorting_doc_type" name="sorting_doc_type[]" value="sorting" />'+
                                    '<input type="text" class="form-control sorting_doc_title" name="sorting_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="sorting_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="sorting_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small sorting_doc" name="sorting_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="sorting_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#sorting').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.processing_doc_type').length;
    
    $('#repeat_processing').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="processing_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control processing_doc_type" name="processing_doc_type[]" value="processing" />'+
                                    '<input type="text" class="form-control processing_doc_title" name="processing_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="processing_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="processing_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small processing_doc" name="processing_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="processing_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#processing').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.quality_control_doc_type').length;
    
    $('#repeat_quality_control').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="quality_control_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control quality_control_doc_type" name="quality_control_doc_type[]" value="quality_control" />'+
                                    '<input type="text" class="form-control quality_control_doc_title" name="quality_control_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="quality_control_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="quality_control_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small quality_control_doc" name="quality_control_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="quality_control_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#quality_control').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.packaging_doc_type').length;
    
    $('#repeat_packaging').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="packaging_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control packaging_doc_type" name="packaging_doc_type[]" value="packaging" />'+
                                    '<input type="text" class="form-control packaging_doc_title" name="packaging_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="packaging_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="packaging_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small packaging_doc" name="packaging_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="packaging_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#packaging').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.qc_report_doc_type').length;
    
    $('#repeat_qc_report').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="qc_report_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control qc_report_doc_type" name="qc_report_doc_type[]" value="qc_report" />'+
                                    '<input type="text" class="form-control qc_report_doc_title" name="qc_report_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="qc_report_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="qc_report_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small qc_report_doc" name="qc_report_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="qc_report_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#qc_report').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.erp_updating_doc_type').length;
    
    $('#repeat_erp_updating').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="erp_updating_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control erp_updating_doc_type" name="erp_updating_doc_type[]" value="erp_updating" />'+
                                    '<input type="text" class="form-control erp_updating_doc_title" name="erp_updating_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="erp_updating_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="erp_updating_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small erp_updating_doc" name="erp_updating_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="erp_updating_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#erp_updating').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.physical_rm_doc_type').length;
    
    $('#repeat_physical_rm').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="physical_rm_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control physical_rm_doc_type" name="physical_rm_doc_type[]" value="physical_rm" />'+
                                    '<input type="text" class="form-control physical_rm_doc_title" name="physical_rm_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="physical_rm_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="physical_rm_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small physical_rm_doc" name="physical_rm_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="physical_rm_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#physical_rm').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});

jQuery(function(){
    var counter = $('.recon_of_rm_doc_type').length;
    
    $('#repeat_recon_of_rm').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<tr id="recon_of_rm_'+counter+'_row">'+
                                '<td>'+
                                    '<input type="hidden" class="form-control recon_of_rm_doc_type" name="recon_of_rm_doc_type[]" value="recon_of_rm" />'+
                                    '<input type="text" class="form-control recon_of_rm_doc_title" name="recon_of_rm_doc_title[]" placeholder="Title" value="" />'+
                                '</td>'+
                                '<td>'+
                                    '<input type="hidden" class="form-control" name="recon_of_rm_doc_name[]" value="" />'+
                                    '<input type="hidden" class="form-control" name="recon_of_rm_doc_path[]" value="" />'+
                                    '<input type="file" class="fileinput btn btn-info btn-small recon_of_rm_doc" name="recon_of_rm_doc_img_'+counter+'">'+
                                '</td>'+
                                '<td style="text-align:center; vertical-align: middle;">'+
                                    '<a id="recon_of_rm_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                '</td>'+
                            '</tr>');
        $('#recon_of_rm').append(newRow);
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        counter++;
    });
});
