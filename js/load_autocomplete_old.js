var approveflag=false;
function approvalFlag() {
  if (document.getElementById('approvalform')!=null) {
    approveflag=true;
    if(approveflag==true) {
      document.getElementById('approvalform').style.display = "none";
      document.getElementById('submitform').style.display = "block";
    } else {
      document.getElementById('approvalform').style.display = "block";
      document.getElementById('submitform').style.display = "none";
    }
  }
}
function loadFlag() {
	if (document.getElementById('approvalform')!=null) {
		document.getElementById('approvalform').style.display = "block";
		document.getElementById('submitform').style.display = "none";
	}
}


/**
*getCity list autocomplete
**/
$(function() {
  //autocomplete
  $(".autocompleteCity").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/loadcity',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
          	//console.log(event);
          	//console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            $("#state_id").val(ui.item.state_id);
    },
    change: function (event, ui) { 
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadcity',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
            
            var state_id= $("#state_id").val();
           	$.ajax({
              method:"POST",
              url:BASE_URL+'index.php/Autocomplete/getStateCountryByState',
              data:{state_id : state_id},
              dataType:"json",
              success:function(responsdata){
                $("#state").val(responsdata.state_name);
                $("#country").val(responsdata.country_name);
                $("#country_id").val(responsdata.country_id);
                $("#state_code").val(responsdata.state_code);
              }   
            });
    },
    minLength: 1
  });
});


/**
*getCountry list autocomplete
**/
$(function(){
  $(".loadcountrydropdown").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/loadcountry',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadcountry',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*getState list autocomplete
**/
$(function(){
  $(".loadstatedropdown").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/loadState',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadState',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Vendor list autocomplete
**/
$(function(){
  $(".load_vendor").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_vendor',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_vendor',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Distributor list autocomplete
**/
$(function(){
  $(".load_distributor").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_distributor',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_distributor',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Sales Representative list autocomplete
**/
$(function(){
  $(".load_sales_rep").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_sales_rep',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_sales_rep',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Raw Material list autocomplete
**/
var autocomp_opt_raw_material={
    source: BASE_URL+'index.php/Autocomplete/load_raw_material',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_raw_material',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
};
$(function(){
  $(".load_raw_material").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_raw_material',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_raw_material',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Product list autocomplete
**/
$(function(){
  $(".load_product").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_product',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_product',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Depot list autocomplete
**/
$(function(){
  $(".load_depot").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_depot',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_depot',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*get Distributor list autocomplete
**/
$(function(){
  $(".load_batch").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_batch',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
        //console.log(event);
        //console.log(this);
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);

            var id = this.id;

            $("#" + id + "_id").val(ui.item.id);
            //var id1=id.substr(0, 9);
           // $("#"+id1+"state_id").val(ui.item.state_id)

    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/load_batch',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});


/**
*getDocument list autocomplete
**/
var autocomp_opt_document={
    source: BASE_URL+'index.php/documents/loadDocuments',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            var id = this.id;
            $("#" + id + "_id").val(ui.item.value);
    },
    change: function(event, ui) {
            var id = this.id;
            // $("#" + id + "_id").val('');
            var con_name = $(this).val();
            // $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/documents/loadDocuments',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                  var d_show_expiry_date = responsdata[0].d_show_expiry_date;
                  var index = id.substr(id.lastIndexOf('_')+1);
                  if(d_show_expiry_date=='Yes') {
                    $("#date_expiry_" + index).show();
                  } else {
                    $("#date_expiry_" + index).hide();
                  }
                }   
              });
            }
    },
    minLength: 1
};

$(function() {
  //autocomplete
  $(".auto_document").autocomplete({
    source: BASE_URL+'index.php/documents/loadDocuments',
    focus: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            // prevent autocomplete from updating the textbox
            event.preventDefault();
            // manually update the textbox and hidden field
            $(this).val(ui.item.label);
            var id = this.id;
            $("#" + id + "_id").val(ui.item.value);
    },
    change: function(event, ui) {
            var id = this.id;
            // $("#" + id + "_id").val('');
            var con_name = $(this).val();
            // $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/documents/loadDocuments',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                  var d_show_expiry_date = responsdata[0].d_show_expiry_date;
                  var index = id.substr(id.lastIndexOf('_')+1);
                  if(d_show_expiry_date=='Yes') {
                    $("#date_expiry_" + index).show();
                  } else {
                    $("#date_expiry_" + index).hide();
                  }
                }   
              });
            }
    },
    minLength: 1
  });
});
