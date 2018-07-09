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
var autocomp_opt_city={
    source: BASE_URL+'index.php/Autocomplete/loadcity',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
            
            var state_id = 'state_id';
            var index = '';
            if(id.lastIndexOf('_')>0){
                index = id.substr(id.lastIndexOf('_')+1);
                state_id = 'con_state_'+index+'_id';
            }
            $("#"+state_id).val(ui.item.state_id);
    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            var state_id = 'state_id';
            var state = 'state';
            var country_id = 'country_id';
            var country = 'country';
            var state_code = 'state_code';
            var index = '';
            if(id.lastIndexOf('_')>0){
                index = id.substr(id.lastIndexOf('_')+1);
                state_id = 'con_state_'+index+'_id';
                state = 'con_state_'+index;
                country_id = 'con_country_'+index+'_id';
                country = 'con_country_'+index;
                state_code = 'con_state_code_'+index;
            }

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadcity',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                    $("#"+id).val(responsdata[0].label);
                    $("#" + id + "_id").val(responsdata[0].id);
                    $("#"+state_id).val(responsdata[0].state_id);
                }   
              });
            }

            $.ajax({
              method:"POST",
              url:BASE_URL+'index.php/Autocomplete/getStateCountryByState',
              data:{state_id : $("#"+state_id).val()},
              dataType:"json",
              success:function(responsdata){
                $("#"+state).val(responsdata.state_name);
                $("#"+country).val(responsdata.country_name);
                $("#"+country_id).val(responsdata.country_id);
                $("#"+state_code).val(responsdata.state_code);
              }   
            });
    },
    minLength:1
};
$(function() {
  $(".autocompleteCity").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/loadcity',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
            
            var state_id = 'state_id';
            var index = '';
            if(id.lastIndexOf('_')>0){
                index = id.substr(id.lastIndexOf('_')+1);
                state_id = 'con_state_'+index+'_id';
            }
            $("#"+state_id).val(ui.item.state_id);
    },
    change: function (event, ui) { 
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');
			
            var state_id = 'state_id';
            var state = 'state';
            var country_id = 'country_id';
            var country = 'country';
            var state_code = 'state_code';
            var index = '';
            if(id.lastIndexOf('_')>0){
                index = id.substr(id.lastIndexOf('_')+1);
                state_id = 'con_state_'+index+'_id';
                state = 'con_state_'+index;
                country_id = 'con_country_'+index+'_id';
                country = 'con_country_'+index;
                state_code = 'con_state_code_'+index;
            }

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadcity',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                    $("#"+id).val(responsdata[0].label);
                    $("#"+id+"_id").val(responsdata[0].id);
                    $("#"+state_id).val(responsdata[0].state_id);
					$("#"+state_code).val(responsdata[0].state_code);
                }   
              });
            }
            
           	$.ajax({
              method:"POST",
              url:BASE_URL+'index.php/Autocomplete/getStateCountryByState',
              data:{state_id : $("#"+state_id).val()},
              dataType:"json",
              success:function(responsdata){
                $("#"+state).val(responsdata.state_name);
                $("#"+country).val(responsdata.country_name);
                $("#"+country_id).val(responsdata.country_id);
                $("#"+state_code).val(responsdata.state_code);
				get_sell_rate();
              }   
            });
			
    },
    minLength: 1
  });
});


/**
*getCountry list autocomplete
**/
var autocomp_opt_country={
    source: BASE_URL+'index.php/Autocomplete/loadcountry',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
};
$(function(){
  $(".loadcountrydropdown").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/loadcountry',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
                  $("#" + id + "_id").val(responsdata[0].id);
                }   
              });
            }
    },
    minLength:1
  });
});




/**
*getstate list autocomplete
**/
var autocomp_opt_state={
    source: BASE_URL+'index.php/Autocomplete/loadstate',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
    },
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            var country_id = 'country_id';
            var country = 'country';
            var state_code = 'state_code';
            var index = '';
            if(id.lastIndexOf('_')>0){
                index = id.substr(id.lastIndexOf('_')+1);
                country_id = 'con_country_'+index+'_id';
                country = 'con_country_'+index;
                state_code = 'con_state_code_'+index;
            }

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadstate',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                    $("#"+id).val(responsdata[0].label);
                    $("#" + id + "_id").val(responsdata[0].id);
                    $("#"+country).val(responsdata[0].country_name);
                    $("#"+country_id).val(responsdata[0].country_id);
                    $("#"+state_code).val(responsdata[0].state_code);
                }
              });
            }
    },
    minLength:1
};
$(function() {
  $(".loadstatedropdown").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/loadstate',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
    },
    change: function (event, ui) { 
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            var country_id = 'country_id';
            var country = 'country';
            var state_code = 'state_code';
            var index = '';
            if(id.lastIndexOf('_')>0){
                index = id.substr(id.lastIndexOf('_')+1);
                country_id = 'con_country_'+index+'_id';
                country = 'con_country_'+index;
                state_code = 'con_state_code_'+index;
            }

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/Autocomplete/loadstate',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                    $("#"+id).val(responsdata[0].label);
                    $("#"+id+"_id").val(responsdata[0].id);
                    $("#"+country).val(responsdata[0].country_name);
                    $("#"+country_id).val(responsdata[0].country_id);
                    $("#"+state_code).val(responsdata[0].state_code);
                }   
              });
            }
    },
    minLength: 1
  });
});


/**
*get Vendor list autocomplete
**/
$(function(){
  $(".load_vendor").autocomplete({
    source: BASE_URL+'index.php/Autocomplete/load_vendor',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);

            var id = this.id;
            $("#" + id + "_id").val(ui.item.id);
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
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
            var id = this.id;
            $("#" + id + "_id").val(ui.item.value);
    },
    change: function(event, ui) {
            var id = this.id;
            var con_name = $(this).val();

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
  $(".auto_document").autocomplete({
    source: BASE_URL+'index.php/documents/loadDocuments',
    focus: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
    },
    select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
            var id = this.id;
            $("#" + id + "_id").val(ui.item.value);
    },
    change: function(event, ui) {
            var id = this.id;
            var con_name = $(this).val();

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