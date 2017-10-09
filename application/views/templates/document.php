<style>
.documentname { padding:0!important;}
.delete_row .trash {
    font-size: 21px;
    color: #cc2127;
}
#document_details .col-md-6 {text-align:right!important; }
.btn-small {  }
.col-md-2 .col-md-4 .btn { margin-top:-2px!important;}
.col-md-2 .col-md-3 { text-align:center;   }
.col-md-2 .col-md-4 .download {  }
.col-md-2 .col-md-4 .trash   { }
 .download-width { padding:4px 0;   }
.trash-width { padding:4px 0;   } 
 .download {  font-size: 21px;     color: #5cb85c;}
 @media screen and (max-width: 767px) {
	 #document_details .col-md-6 {text-align:left!important;  } #document_details {padding-top:10px;} 
.addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-'] {
    padding-left: 8px!important;
    padding-right: 8px!important;
}
}

@media only screen and (min-width: 767px) and (max-width: 1020px) { #document_details { overflow-x:scroll;  }
#document_details .form-group { width:1020px;}
.col-md-2 .col-md-3 { text-align:right;   }
#document_details .col-md-6 {text-align:right!important; }
 }
@media only screen and (min-width: 260px) and (max-width: 1020px) {
.custom-padding .col-md-6 .control-label {
    margin-top:0px;
} 
.document_details { overflow-x:scroll;}

}
</style>

<div id="document_details" class="">

<?php 
    $doc_no=0;
    $doc_exist=false;

    if(isset($documents)) {
        if(count($documents)>0){
            $doc_exist=true;
        }

        for($i=0; $i<count($documents); $i++) { 
        if(isset($documents[$i]->d_type_id) && $documents[$i]->d_type_id!='') {
            if (count($docs[$documents[$i]->d_type_id])>0) {
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group">
        <div class="col-md-3 col-sm-12 col-xs-12"  >
            <div class="col-md-6 ">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->d_type_id; ?>" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->d_m_status; ?>" />
                <label class="doc_file control-label"><?php echo $documents[$i]->d_type; ?> </label>
            </div>
            <div class="col-md-6 "  >
                <select name="doc_name[]" class="form-control doc_name" id="doc_name_<?php echo $doc_no; ?>" onChange="getExpiryDateStatus(this);" style="display: none;">
                    <option value="">Select</option>
                    <?php for ($j=0; $j < count($docs[$documents[$i]->d_type_id]) ; $j++) { ?>
                        <option value="<?php echo $docs[$documents[$i]->d_type_id][$j]->d_id; ?>" <?php if($docs[$documents[$i]->d_type_id][$j]->d_id==$documents[$i]->doc_doc_id) { echo 'selected'; } ?>><?php echo $docs[$documents[$i]->d_type_id][$j]->d_documentname; ?></option>
                    <?php } ?>
                </select>
                <input type="text" class="form-control" name="doc_ref_name[]" id="doc_ref_name_<?php echo $doc_no; ?>" placeholder="Document Name" value="<?php echo $documents[$i]->doc_ref_name; ?>" />
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12"  >                                                     
            <div class="col-md-6"  >
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6"  >
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"  >
            <div class="col-md-6"  >
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6"  >
                <input type="text" id="date_expiry_<?php echo $doc_no; ?>" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>" style="<?php if($documents[$i]->d_show_expiry_date=='No') echo 'display:none;'?>" />
            </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12" >
            <div class="col-md-6" >
                <input type="hidden" class="form-control" name="doc_document[]" value="<?php echo $documents[$i]->doc_document; ?>" />
                <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                <input type="file" class="fileinput btn btn-info btn-small doc_file" name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
            </div>
			
            <div class="col-md-3 col-sm-3 col-xs-4 download-width"  >
               <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><span class="fa download fa-download" ></span></a><?php } ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-4  trash-width"  >
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#" style="<?php if($documents[$i]->d_m_status=='Yes') echo 'display: none;'; ?>"><span class="fa trash fa-trash-o"  ></span></a>
            </div>
        </div>
    </div>

<?php 
    }} else { 
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12"  >
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="No" />
                <label class="doc_file control-label">Document </label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 documentname"  >
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_name[]" class="form-control doc_name" value="<?php echo $documents[$i]->doc_doc_id; ?>" data-error="#doc_name_<?php echo $doc_no; ?>_error"/>
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>" class="form-control" value="<?php echo $documents[$i]->doc_documentname; ?>" placeholder="Type to choose document from database..." />
                <div id="doc_name_<?php echo $doc_no; ?>_error"></div>
                <input type="text" class="form-control" name="doc_ref_name[]" id="doc_ref_name_<?php echo $doc_no; ?>" placeholder="Document Name" value="<?php echo $documents[$i]->doc_ref_name; ?>" />
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 documentname"  >                                                     
            <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" >
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 documentname" >
            <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" id="date_expiry_<?php echo $doc_no; ?>" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12"  >
            <div class="col-md-6 col-sm-4 col-xs-4" >
                <input type="hidden" class="form-control" name="doc_document[]" value="<?php echo $documents[$i]->doc_document; ?>" />
                <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                <input type="file" class="fileinput btn btn-info btn-small doc_file"  name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
            </div>			
            <div class="col-md-3 col-sm-4 col-xs-4 download-width" >
             <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><span class="fa download fa-download" ></span></a></a><?php } ?>
            </div>
            <div class="col-md-3  col-sm-4 col-xs-4 trash-width" >
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
            </div>
        </div>
    </div>

<?php }}} if($doc_exist==false) { ?>
    
    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12" >
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="No" />
                <label class="doc_file control-label">Document </label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 documentname"  >
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_name[]" class="form-control doc_name" value="" data-error="#doc_name_<?php echo $doc_no; ?>_error"/>
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>" name="document_name[]" class="form-control auto_document" value="" placeholder="Type to choose document from database..." />
                <div id="doc_name_<?php echo $doc_no; ?>_error"></div>
                <input type="text" class="form-control" name="doc_ref_name[]" id="doc_ref_name_<?php echo $doc_no; ?>" placeholder="Document Name" value="" />
            </div>
        </div>
       <div class="col-md-4 col-sm-4 col-xs-12 documentname"  >                                                     
            <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value=""/>
            </div>
        </div>
       <div class="col-md-3 col-sm-3 col-xs-12 documentname" >
            <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value=""/>
            </div>
             <div class="col-md-6 col-sm-6 col-xs-12"  >
                <input type="text" id="date_expiry_<?php echo $doc_no; ?>" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/>
            </div>
        </div>
          <div class="col-md-2 col-sm-2 col-xs-12"  >
            <div class="  col-sm-4 col-xs-4" >
                <input type="hidden" class="form-control" name="doc_document[]" value="" />
                <input type="hidden" class="form-control" name="document_name[]" value="" />
                <input type="file" class="fileinput   btn-info btn-small doc_file"    name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
            </div>
			 <div class="col-md-3 col-sm-4 col-xs-4 download-width" > &nbsp; </div>
              <div class="col-md-3  col-sm-4 col-xs-4 trash-width" >
                <a id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
            </div>
        </div>
    </div>

<?php } ?>
</div>