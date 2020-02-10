// ----------------- COMMON FUNCTIONS -------------------------------------
$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please.");

$.validator.addMethod("numbersonly", function(value, element) {
    return this.optional(element) || /^[0-9]+$/i.test(value);
}, "Numbers only please.");

$.validator.addMethod("numbersandcommaonly", function(value, element) {
    return this.optional(element) || /^[0-9]|^,+$/i.test(value);
}, "Numbers only please.");

$.validator.addMethod("numbersandcommaanddotonly", function(value, element) {
    return this.optional(element) || /^(0*[0-9][0-9.,]*)$/i.test(value);
}, "Not Valid Input");

$.validator.addMethod("checkemail", function(value, element) {
    return this.optional(element) || (/^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/i.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/i.test(value));
}, "Please enter valid email address.");

function addMultiInputNamingRules(form, field, rules, type){
    // alert(field);
    $(form).find(field).each(function(index){
        if (type=="Document") {
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            if($('#d_m_status_'+index).val()=="Yes"){
                $(this).attr('alt', $(this).attr('name'));
                $(this).attr('name', $(this).attr('name')+'-'+index);
                $(this).rules('add', rules);
            }
        } else {
            $(this).attr('alt', $(this).attr('name'));
            $(this).attr('name', $(this).attr('name')+'-'+index);
            $(this).rules('add', rules);
        }
    });
}

function removeMultiInputNamingRules(form, field){    
    $(form).find(field).each(function(index){
        $(this).attr('name', $(this).attr('alt'));
        $(this).removeAttr('alt');
    });
}

$('.save-form').click(function(){ 
    $("#submitVal").val('1');
});
$('.submit-form').click(function(){ 
    $("#submitVal").val('0');
});




// ----------------- USER DETAILS FORM VALIDATION -------------------------------------
$("#form_user_details").validate({
    rules: {
        first_name: {
            required: true,
            lettersonly: true
        },
        last_name: {
            required: true,
            lettersonly: true
        },
        email_id: {
            required: true,
            checkemail: true,
            check_email_availablity: true
        },
        mobile: {
            required: true,
            numbersonly: true,
            minlength: 10,
            maxlength: 10
        },
        role_id: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_email_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/User/check_email_availablity',
        data: 'id='+$("#id").val()+'&email_id='+$("#email_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Email ID already in use.');

$('#form_user_details').submit(function() {
    if (!$("#form_user_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- USER ROLE DETAILS FORM VALIDATION -------------------------------------
$("#form_user_role_details").validate({
    rules: {
        role_name: {
            required: true,
            check_role_availablity: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_role_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/user_roles/check_role_availablity',
        data: 'id='+$("#id").val() + '&role_name='+$("#role_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'User Role already exist.');

$('#form_user_role_details').submit(function() {
    if (!$("#form_user_role_details").valid()) {
        return false;
    } else {
        if (check_role()==false) {
            return false;
        }

        return true;
    }
});

function check_role() {
    var validator = $("#form_user_role_details").validate();
    var valid = true;

    var result = 1;

    $('.cls_chk').each(function(){
        if ($(this).is(":checked")) result=0;
    });

    if (result) {
        var errors = {};
        var name = "role_name";
        errors[name] = "Please assign atleast one role.";
        validator.showErrors(errors);
        valid = false;
    }

    return valid;
}

function get_bar_qty(model_name,form_name,depochange='') {
    var validator = $("#"+form_name).validate();
    var valid = true;
    var module=model_name;
    var btn_val = $(document.activeElement).val();
    var depot_id = $("#prev_depo").val();
    if(depot_id=='')
    {
        depot_id = $("#depot_id").val();
    }
    /*console.log('btn_val'+btn_val);*/
    $('.bar').each(function(){
        if ($(this).is(":visible") == true) {  
            /*console.log('entered');*/
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            /*console.log('index'+index);*/
            var bar_id = $(this).attr('id');
            var bar = $(this).val();
            if(btn_val=='Delete' || depochange=='depochange' || $('#expired').is(':checked')==true)
            {
                var entered_qty = 0;
            }
            else
            {
                 var entered_qty = parseFloat(get_number($('#qty_'+index).val())); 
            }
            
            /*var depot_id = $("#prev_depo").val();*/
            var ref_id = $("#ref_id").val();
            var ref_id = $("#ref_id").val();
            var qty = 0
            current_stock = 0;
            var pre_qty = parseInt($('#pre_qty_'+index).val());

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+bar+'&qty='+qty+'&ref_id='+ref_id+'&get_stock=1',
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    current_stock = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(current_stock!=undefined)
                {
                    /*console.log('current_stock'+current_stock+'pre qty'+pre_qty);*/

                    /*var deducted_qty = current_stock-pre_qty;*/
                    var final_qty = current_stock+entered_qty;

                    if(final_qty<0)
                    {
                        var id = 'qty_'+index;
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = 'Bar Stock Will be negative by  '+final_qty;
                        validator.showErrors(errors);
                        valid = false;
                    }

                }

            
            
        }    
     });
    return valid;
}

function get_raw_material_qty(model_name,form_name,depochange='') {
    /*console.log('eneterd2'+model_name);*/
    var validator = $("#"+form_name).validate();
    var valid = true;
    var module=model_name;
    var btn_val = $(document.activeElement).val();
    var depot_id = $("#prev_depo").val();
    if(depot_id=='')
    {
        depot_id = $("#depot_id").val();
    }
    /*console.log('btn_val'+btn_val);*/
    $('.raw_material').each(function(){
        /*console.log($(this).is(":visible"));*/
        if ($(this).is(":visible") == true) {  
            /*console.log('entered');*/
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            /*console.log('index'+index);*/
            var bar_id = $(this).attr('id');
            var bar = $(this).val();

            var raw_material_id = $(this).attr('id');
            var raw_material = $(this).val();
            if(btn_val=='Delete' || depochange=='depochange')
            {
                var entered_qty = 0;
            }
            else
            {
               var entered_qty = parseFloat(get_number($('#qty_'+index).val())); 
            }

            /*console.log('entered_qty  '+entered_qty);*/

            /*var depot_id = $("#prev_depo").val();*/
            var ref_id = $("#ref_id").val();
            
            var qty = 0
            current_stock = 0;
            var pre_qty = parseInt($('#pre_qty_'+index).val());

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_raw_material_qty_availablity',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&raw_material_id='+raw_material+'&qty='+qty+'&ref_id='+ref_id+'&get_stock=1',
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    current_stock = parseFloat(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(current_stock!=undefined )
            {
                /*console.log('current_stock'+current_stock+'pre qty'+pre_qty);*/
                /*var deducted_qty = current_stock-pre_qty;*/
                var final_qty = current_stock+entered_qty;
                if(final_qty<0)
                {
                    var id = 'qty_'+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = 'Stock Will be negative by  '+final_qty;
                    validator.showErrors(errors);
                    valid = false;
                }
            }

          }    
     });

    return valid;
}

function get_box_qty(model_name,form_name,depochange='') {
    /*console.log('eneterd2'+model_name);*/
    var validator = $("#"+form_name).validate();
    var valid = true;
    var module=model_name;
    var btn_val = $(document.activeElement).val();
    var depot_id = $("#prev_depo").val();
    if(depot_id=='')
    {
        depot_id = $("#depot_id").val();
    }
    /*console.log('btn_val'+btn_val);*/
    $('.box').each(function(){
        /*console.log($(this).is(":visible"));*/
        if ($(this).is(":visible") == true) {  
            /*console.log('entered');*/
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            /*console.log('index'+index);*/
            var bar_id = $(this).attr('id');
            var bar = $(this).val();
            if(btn_val=='Delete' || depochange=='depochange' || $('#expired').is(':checked')==true)
            {
                var entered_qty = 0;
            }
            else
            {
               var entered_qty = parseFloat(get_number($('#qty_'+index).val())); 
            }

            /*console.log('entered_qty  '+entered_qty);*/

            /*var depot_id = $("#prev_depo").val();*/
            var ref_id = $("#ref_id").val();
            
            var qty = 0
            current_stock = 0;
            var pre_qty = parseInt($('#pre_qty_'+index).val());

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&box_id='+bar+'&qty='+qty+'&ref_id='+ref_id+'&get_stock=1',
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    current_stock = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(current_stock!=undefined )
            {
                /*console.log('current_stock'+current_stock+'pre qty'+pre_qty);*/

                /*var deducted_qty = current_stock-pre_qty;*/
                var final_qty = current_stock+entered_qty;

                if(final_qty<0)
                {
                    var id = 'qty_'+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = 'Box Stock Will be negative by  '+final_qty;
                    validator.showErrors(errors);
                    valid = false;
                }
            }

          }    
     });

    return valid;
}




// ----------------- VENDOR DETAILS FORM VALIDATION -------------------------------------
$("#form_vendor_details").validate({
    rules: {
        vendor_name: {
            required: true,
            check_vendor_availablity: true
        },
        pincode: {
            numbersonly: true
        },
        v_email_id: {
            checkemail: true
        },
        v_mobile: {
            required: true,
            numbersonly: true,
            minlength: 10,
            maxlength: 10
        },
        state: {
            required: true
        }
        // ,
        // tin_number: {
        //     required: true
        // },
        // cst_number: {
        //     required: true
        // }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_vendor_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Vendor/check_vendor_availablity',
        data: 'id='+$("#id").val()+'&vendor_name='+$("#vendor_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Vendor Name already in use.');

$('#form_vendor_details').submit(function() {
    removeMultiInputNamingRules('#form_vendor_details', 'input[alt="contact_person[]"]');
    removeMultiInputNamingRules('#form_vendor_details', 'input[alt="email_id[]"]');
    removeMultiInputNamingRules('#form_vendor_details', 'input[alt="mobile[]"]');

    addMultiInputNamingRules('#form_vendor_details', 'input[name="contact_person[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_vendor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
    addMultiInputNamingRules('#form_vendor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
    if (!$("#form_vendor_details").valid()) {
        return false;
    } else {

        removeMultiInputNamingRules('#form_vendor_details', 'input[alt="contact_person[]"]');
        removeMultiInputNamingRules('#form_vendor_details', 'input[alt="email_id[]"]');
        removeMultiInputNamingRules('#form_vendor_details', 'input[alt="mobile[]"]');

        return true;
    }
});




// ----------------- RAW MATERIAL DETAILS FORM VALIDATION -------------------------------------
$("#form_raw_material_details").validate({
    rules: {
        rm_name: {
            required: true,
            check_raw_material_name_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_raw_material_name_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/raw_material/check_raw_material_name_availablity',
        data: 'id='+$("#id").val()+'&rm_name='+$("#rm_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Raw Material Name already in use.');

$('#form_raw_material_details').submit(function() {
    if (!$("#form_raw_material_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- PRODUCT DETAILS FORM VALIDATION -------------------------------------
$("#form_product_details").validate({
    rules: {
        product_name: {
            required: true,
            check_product_availablity: true
        },
        grams: {
            required: true,
            number: true
        },
        rate: {
            required: true,
            numbersandcommaonly: true
        },
        cost: {
            required: true,
            numbersandcommaonly: true
        },
        hsn_code: {
            required: true
        },
        short_name: {
            required: true
        },
        category_id:{
            required: true
        },
        tax_percentage:{
            required: true
        }
        // ,
        // rate_of_box: {
        //     required: true,
        //     numbersandcommaonly: true
        // }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_product_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Product/check_product_availablity',
        data: 'id='+$("#id").val()+'&product_name='+$("#product_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Product Name already in use.');

$('#form_product_details').submit(function() {
    if (!$("#form_product_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- DEPOT DETAILS FORM VALIDATION -------------------------------------
$("#form_depot_details").validate({
    rules: {
        depot_name: {
            required: true,
            check_depot_availablity: true
        },
        d_email_id: {
            checkemail: true
        },
        pincode: {
            numbersonly: true
        },
        d_mobile: {
            required: true,
            numbersonly: true,
            minlength: 10,
            maxlength: 10
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_depot_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Depot/check_depot_availablity',
        data: 'id='+$("#id").val()+'&depot_name='+$("#depot_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Depot Name already in use.');

$('#form_depot_details').submit(function() {
    removeMultiInputNamingRules('#form_depot_details', 'input[alt="contact_person[]"]');
    removeMultiInputNamingRules('#form_depot_details', 'input[alt="email_id[]"]');
    removeMultiInputNamingRules('#form_depot_details', 'input[alt="mobile[]"]');

    addMultiInputNamingRules('#form_depot_details', 'input[name="contact_person[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_depot_details', 'input[name="email_id[]"]', { checkemail: true }, "");
    addMultiInputNamingRules('#form_depot_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
    if (!$("#form_depot_details").valid()) {
        return false;
    } else {

        removeMultiInputNamingRules('#form_depot_details', 'input[alt="contact_person[]"]');
        removeMultiInputNamingRules('#form_depot_details', 'input[alt="email_id[]"]');
        removeMultiInputNamingRules('#form_depot_details', 'input[alt="mobile[]"]');

        return true;
    }
});




// ----------------- SALES REP DETAILS FORM VALIDATION -------------------------------------
$("#form_sales_rep_details").validate({
    rules: {
        sales_rep_name: {
            required: true,
            check_sales_rep_availablity: true
        },
        pan_no: {
            required: true
        },
		zone: {
            required: true
		},
        email_id: {
            required: true,
            checkemail: true
        },
        mobile: {
            required: true,
            numbersonly: true,
            minlength: 10,
            maxlength: 10
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_sales_rep_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Sales_rep/check_sales_rep_availablity',
        data: 'id='+$("#id").val()+'&sales_rep_name='+$("#sales_rep_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Sales Representative Name already in use.');

$('#form_sales_rep_details').submit(function() {
    if (!$("#form_sales_rep_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- DISTRIBUTOR DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_details").validate({
    rules: {
        distributor_name: {
            required: true,
            check_distributor_availablity: true
        },
        sell_out: {
            required: true,
            number: true
        },
        send_invoice: {
            required: true
        },
        credit_period: {
            required: true,
            numbersonly: true
        },
        d_email_id: {
            checkemail: true
        },
        pincode: {
            numbersonly: true
        },
        d_mobile: {
            required: true,
            numbersonly: true,
            minlength: 10,
            maxlength: 10
        },
        class: {
            required: true
        },
        state: {
            required: true
        },
        state_code: {
            required: true
        },
        type_id: {
            required: true
        },
		 zone_id: {
            required: true
        },
        area_id: {
            required: true
        },
        location_id: {
            required: {
                depends: function() {
                    return ($('#classes').val() == "normal" || $('#classes').val() == "direct");
                }
            }
        },
        'con_name[]': {
            required: true
        },
        'con_address[]': {
            required: true
        },
        'con_state[]': {
            required: true
        },
        'con_state_code[]': {
            required: true
        },
		'inv_margin[]': {
            required: true
        },
        'pro_margin[]': {
            required: true
        },
        prefix: {
            required: {
                depends: function() {
                    return ($('#classes').val() == "direct");
                }
            }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_distributor_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Distributor/check_distributor_availablity',
        data: 'id='+$("#id").val()+'&distributor_name='+$("#distributor_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Distributor Name already in use.');

$('#form_distributor_details').submit(function() {
    removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
    removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
    removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_name[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_address[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_city[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_pincode[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_state[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_country[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_state_code[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_gst_number[]"]');

    addMultiInputNamingRules('#form_distributor_details', 'input[name="contact_person[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
    addMultiInputNamingRules('#form_distributor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");

    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_name[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_address[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_city[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_pincode[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_state[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_country[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_state_code[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_gst_number[]"]', { required: true }, "");
    
    if (!$("#form_distributor_details").valid()) {
        return false;
    } else {

        removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
        removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
        removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_name[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_address[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_city[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_pincode[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_state[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_country[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_state_code[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_gst_number[]"]');

        return true;
    }
});




// ----------------- PURCHASE ORDER DETAILS FORM VALIDATION -------------------------------------
$("#form_purchase_order_details").validate({
    rules: {
        order_date: {
            required: true
        },
        vendor_id: {
            required: true
        },
        depot_id: {
            required: true
        },
        total_amount: {
            required: true
        },
        remarks: {
            required: {
                depends: function() {
                    return (d_status == "Approved");
                }
            }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_purchase_order_details').submit(function() {
    removeMultiInputNamingRules('#form_purchase_order_details', 'select[alt="raw_material[]"]');
    removeMultiInputNamingRules('#form_purchase_order_details', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_purchase_order_details', 'select[name="raw_material[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase_order_details', 'input[name="qty[]"]', { required: true, number: true }, "");
    if (!$("#form_purchase_order_details").valid()) {
        return false;
    } else {
        if (check_purchase_order_details()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_purchase_order_details', 'select[alt="raw_material[]"]');
        removeMultiInputNamingRules('#form_purchase_order_details', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_purchase_order_details() {
    var validator = $("#form_purchase_order_details").validate();
    var valid = true;

    if($('.raw_material').length=='0'){
        var errors = {};
        var name = $('#order_date').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {
        $('.raw_material').each(function(){
            var raw_material_id = $(this).attr('id');
            var raw_material = $(this).val();

            $('.raw_material').each(function(){
                if(raw_material_id != $(this).attr('id')){
                    if(raw_material == $(this).val()){
                        var errors = {};
                        var name = $(this).attr('name');
                        errors[name] = "Please select different item for all records.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }
            });
        });
    }
    
    return valid;
}




// ----------------- PURCHASE ORDER PAYMENT DETAILS FORM VALIDATION -------------------------------------
$("#form_purchase_order_payment_details").validate({
    rules: {
        balance_amount: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_purchase_order_payment_details').submit(function() {
    removeMultiInputNamingRules('#form_purchase_order_payment_details', 'select[alt="payment_mode[]"]');
    removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="ref_no[]"]');
    removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="payment_date[]"]');
    removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="payment_amount[]"]');
    removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="deposit_date[]"]');


    addMultiInputNamingRules('#form_purchase_order_payment_details', 'select[name="payment_mode[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="ref_no[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="payment_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="payment_amount[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="deposit_date[]"]', { required: true }, "");
    if (!$("#form_purchase_order_payment_details").valid()) {
        return false;
    } else {
        if (check_purchase_order_payment_details()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_purchase_order_payment_details', 'select[alt="payment_mode[]"]');
        removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="ref_no[]"]');
        removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="payment_date[]"]');
        removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="payment_amount[]"]');
        removeMultiInputNamingRules('#form_purchase_order_payment_details', 'input[alt="deposit_date[]"]');
        
        return true;
    }
});

function check_purchase_order_payment_details() {
    var validator = $("#form_purchase_order_payment_details").validate();
    var valid = true;

    if($('.payment_mode').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {
        // if(parseFloat($('#balance_amount').val())<0){
        //     var errors = {};
        //     var name = $('#balance_amount').attr('name');
        //     errors[name] = "Balance Amount can not be negative.";
        //     validator.showErrors(errors);
        //     valid = false;
        // }
    }

    return valid;
}




// ----------------- RAW MATERIAL IN DETAILS FORM VALIDATION -------------------------------------
$("#form_raw_material_in_details").validate({
    rules: {
        date_of_receipt: {
            required: true
        },
        vendor_id: {
            required: true
        },
        depot_id: {
            required: true
        },
        final_amount: {
            required: true
        },
        remarks: {
            required: {
                depends: function() {
                    return (d_status == "Approved");
                }
            }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_raw_material_in_details').submit(function() {
    removeMultiInputNamingRules('#form_raw_material_in_details', 'select[alt="raw_material[]"]');
    removeMultiInputNamingRules('#form_raw_material_in_details', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_raw_material_in_details', 'input[alt="rate[]"]');

    addMultiInputNamingRules('#form_raw_material_in_details', 'select[name="raw_material[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_raw_material_in_details', 'input[name="qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_raw_material_in_details', 'input[name="rate[]"]', { required: true }, "");
    if (!$("#form_raw_material_in_details").valid()) {
        return false;
    } else {
        if (check_raw_material()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_raw_material_in_details', 'select[alt="raw_material[]"]');
        removeMultiInputNamingRules('#form_raw_material_in_details', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_raw_material_in_details', 'input[alt="rate[]"]');
        
        return true;
    }
});

function check_raw_material() {
    var validator = $("#form_raw_material_in_details").validate();
    var valid = true;

    if($('.raw_material').length=='0'){
        var errors = {};
        var name = $('#date_of_receipt').attr('name');
        errors[name] = "Please add atleast one raw material.";
        validator.showErrors(errors);
        valid = false;
    } else {
        $('.raw_material').each(function(){
            var raw_material_id = $(this).attr('id');
            var raw_material = $(this).val();

            $('.raw_material').each(function(){
                if(raw_material_id != $(this).attr('id')){
                    if(raw_material == $(this).val()){
                        var errors = {};
                        var name = $(this).attr('name');
                        errors[name] = "Please select different raw material for all records.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }
            });
        });
    }
    
    return valid;
}




// ----------------- PAYMENT VOUCHER FORM VALIDATION -------------------------------------
$("#form_payment_voucher").validate({
    rules: {
        vendor_id: {
            required: true
        },
        vendor_name:{
            required: true
        },
        final_amount: {
            required: true
        },
        type: {
            required: true
        },
        invoice_date:{
           required: true
       },
       invoice_no:{
        required: true
       },
       attached:{
        required: true
       },
       po_no:{
        required: true
       },
       type_use:{
        required: true
       },
       purchase_order_id:{
        required: true
       },
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_payment_voucher').submit(function() {
    removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="tax[]"]');
    removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="rate[]"]');
    removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="particulars[]"]');
    removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="invoice_date[]"]');
    removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="invoice_no[]"]');
    

    addMultiInputNamingRules('#form_payment_voucher', 'input[name="tax[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_voucher', 'input[name="qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_voucher', 'input[name="rate[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_voucher', 'input[name="particulars[]"]', { required: true }, "");
   

    if (!$("#form_payment_voucher").valid()) {
        return false;
    } else {

        removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="tax[]"]');
        removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="rate[]"]');
        removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="particulars[]"]');
        removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="invoice_date[]"]');
        removeMultiInputNamingRules('#form_payment_voucher', 'input[alt="invoice_no[]"]');
            
        return true;
    }
});




// ----------------- EXPENSE CATEGORY MASTER FORM VALIDATION -------------------------------------
$("#form_exp_cat_master_details").validate({
    rules: {
        category: {
            required: true,
            check_category_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_category_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Exp_cat_master/check_category_availablity',
        data: 'id='+$("#id").val()+'&category='+$("#category").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Category already in use.');




// ----------------- BATCH MASTER FORM VALIDATION -------------------------------------
$("#form_batch_master_details").validate({
    rules: {
        batch_no: {
            required: true,
            check_batch_id_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_batch_id_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Batch_processing/check_batch_id_availablity',
        data: 'id='+$("#id").val()+'&batch_id_as_per_fssai='+$("#batch_no").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Batch Id already in use.');



var add_loader = function() {
    console.log('add_loader');
    $('body').append('<div id="cover"></div>');
    setTimeout(removeLoader, 1000);
}

var remove_loader = function() {
    $( "#cover" ).fadeOut(500, function() {
        $( "#cover" ).remove();
    });
    console.log('remove_loader');
}



// ----------------- BATCH PROCESSING DETAILS FORM VALIDATION -------------------------------------
$("#form_batch_processing_details").validate({
    rules: {
        batch_no_id: {
            required: true
        },
        // batch_id_as_per_fssai: {
        //     required: true,
        //     check_batch_id_availablity: true
        // },
        date_of_processing: {
            required: true
        },
		
		
        depot_id: {
            required: true
        },
        product_id: {
            required: true
        },
		  no_of_batch: {
            required: true
        },
        qty_in_bar: {
            required: true
        },
        actual_wastage: {
            required: true
        },
        wastage_percent: {
            required: true
        },
        anticipated_wastage: {
            required: true
        },
        wastage_variance: {
            required: true
        },
        remarks: {
            required: {
                depends: function() {
                    return (d_status == "Approved");
                }
            }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_batch_processing_details').submit(function() {
    // add_loader();

    removeMultiInputNamingRules('#form_batch_processing_details', 'select[alt="raw_material_id[]"]');
    removeMultiInputNamingRules('#form_batch_processing_details', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_batch_processing_details', 'select[name="raw_material_id[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_batch_processing_details', 'input[name="qty[]"]', { required: true }, "");
    if (!$("#form_batch_processing_details").valid()) {
        return false;
    } else {
        if (check_raw_material_availablity_for_batch_processing()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_batch_processing_details', 'select[alt="raw_material_id[]"]');
        removeMultiInputNamingRules('#form_batch_processing_details', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_raw_material_availablity_for_batch_processing() {
    var validator = $("#form_batch_processing_details").validate();
    var valid = true;

    if($('.raw_material').length=='0'){
        var errors = {};
        var name = $('#batch_no_id').attr('name');
        errors[name] = "Please add atleast one raw material.";
        validator.showErrors(errors);
        valid = false;
    } else {
        $('.raw_material').each(function(){
            var raw_material_id = $(this).attr('id');
            var index = raw_material_id.substr(raw_material_id.lastIndexOf('_')+1);
            var raw_material = $(this).val();
            var qty = $("#qty_"+index).val();

            $('.raw_material').each(function(){
                if(raw_material_id != $(this).attr('id')){
                    if(raw_material == $(this).val()){
                        var id = "raw_material_"+index;
                        var errors = {};
                        var name = $('#'+id).attr('name');
                        errors[name] = "Please select different raw material for all records.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }
            });

            var result = 1;
            var module="batch_processing";

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_raw_material_availablity',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&raw_material_id='+raw_material,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var id = "raw_material_"+index;
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Raw material not available in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_raw_material_qty_availablity',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&raw_material_id='+raw_material+'&qty='+qty+'&ref_id='+$("#ref_id").val(),
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var id = "qty_"+index;
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Raw material qty is not enough in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }
        });
    }

    return valid;
}




// ----------------- DISTRIBUTOR OUT LIST FORM VALIDATION -------------------------------------
$("#form_distributor_out_list").validate({
    rules: {
        status: {
            required: true
        },
        sales_rep_id: {
            required: true
        },
        delivery_status: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_distributor_out_list').submit(function() {
    if (!$("#form_distributor_out_list").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- DISTRIBUTOR OUT DETAILS FORM VALIDATION -------------------------------------


var clkBtn = "";
$('input[type="submit"]').click(function(evt) {
    $(this).find().attr('form','novalidate');
    clkBtn = evt.target.id;
});

/*if(btnID=='btn_reject')
  {
    console.log('entered');
  }*/
$("#form_distributor_out_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        depot_id: {
            required: true
        },
        distributor_id: {
            required: true
        },
        sales_rep_id: {
            required: true
        },
        total_amount: {
            required: true
        },
        due_date: {
            required: true
        },
        delivery_status: {
            required: true
        },
        delivery_date: {
            required: {
                depends: function() {
                    return ($("#delivery_status").val() == "Delivered");
                }
            }
        },
        transport_type: {
            required: true
        },
        vehicle_number: {
            required: {
                depends: function() {
                    return ($("#transport_type").val() == "Transport");
                }
            }
        },
        reverse_charge: {
            required: true
        },
        shipping_address: {
            required: true
        },
        distributor_consignee_id: {
            required: {
                depends: function() {
                    return ($("#shipping_address_no:checked").length);
                }
            }
        },
        basis_of_sales: {
            required: true
            
        },
        order_no: {
            required: {
                depends: function() {
                    return (clkBtn!='btn_reject');
                }
            },
            check_order_id_availablity: {
              required: {
                depends: function() {
                        return (clkBtn!='btn_reject');
                    }
                }  
            }
        },
        email_from: {
            required: true,
            checkemail: true
        },
        email_date_time:{
            required: true
        },
        remarks: {
            required: {
                depends: function() {
                    return (d_status == "Approved");
                }
            }
        },
        mobile_no: {
            numbersonly: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});  

$('#form_distributor_out_details').submit(function() {
    var btnID = clkBtn;
    if(btnID=='btn_reject') {
        if ($('#remarks').val()=="") {
            var validator = $("#form_distributor_out_details").validate();
            var errors = {};
            var name = $('#remarks').attr('name');
            errors[name] = "This field is required.";
            validator.showErrors(errors);
            return false;
        } else {
            return true;
        }
    } else {
        removeMultiInputNamingRules('#form_distributor_out_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_distributor_out_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_distributor_out_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_distributor_out_details', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_distributor_out_details', 'input[alt="sell_rate[]"]');

        addMultiInputNamingRules('#form_distributor_out_details', 'select[name="type[]"]', { required: true }, "");
        addMultiInputNamingRules('#form_distributor_out_details', 'select[name="bar[]"]', { required: true }, "");
        addMultiInputNamingRules('#form_distributor_out_details', 'select[name="box[]"]', { required: true }, "");
        addMultiInputNamingRules('#form_distributor_out_details', 'input[name="qty[]"]', { required: true }, "");
        addMultiInputNamingRules('#form_distributor_out_details', 'input[name="sell_rate[]"]', { required: true }, "");
        
        if (!$("#form_distributor_out_details").valid()) {
            return false;
        } else {
            if (check_product_availablity_for_distributor_out()==false) {
                return false;
            }

            removeMultiInputNamingRules('#form_distributor_out_details', 'select[alt="type[]"]');
            removeMultiInputNamingRules('#form_distributor_out_details', 'select[alt="bar[]"]');
            removeMultiInputNamingRules('#form_distributor_out_details', 'select[alt="box[]"]');
            removeMultiInputNamingRules('#form_distributor_out_details', 'input[alt="qty[]"]');
            removeMultiInputNamingRules('#form_distributor_out_details', 'input[alt="sell_rate[]"]');
            
            return true;
        }
    }
    
});

$.validator.addMethod("check_order_id_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/distributor_out/check_order_id_availablity',
        data: 'id='+$("#id").val()+'&order_no='+$("#order_no").val()+'&ref_id='+$("#ref_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Order No already in use.');

function check_product_availablity_for_distributor_out() {
    var validator = $("#form_distributor_out_details").validate();
    var valid = true;
    var btn_val = $(document.activeElement).val();
    var result = 1;

    if(btn_val=='Submit For Approval' || btn_val=='Delete') {
        $.ajax({
            url: BASE_URL+'index.php/Freezed/check_freedzed_month',
            data: 'date='+$("#date_of_processing").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

        if (result) {
            var errors = {};
            var name = $('#date_of_processing').attr('name');
            errors[name] = "Please Select Another Date ,This Date is Freezed";
            validator.showErrors(errors);
            valid = false;
        }
    }

    // if($('#basis_of_sales').val()=='PO Number')
    // {
    //     if($("#distributor_id").val()=="214"){
    //         var order=$("#order_no").val();
    //         var pattern= /^\d{3}-?\d{7}-?\d{7}$/;
    //         if(!pattern.test(order)) {
    //             var errors = {};
    //             var name = $('#order_no').attr('name');
    //             errors[name] = "Please Enter Valid Order No eg. 123-1234567-1234567.";
    //             validator.showErrors(errors);
    //             valid = false;
    //         }
    //     }
    // }
    
	
    if($('.type').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {

        var depot_id = $("#depot_id").val();
        var distributor_id = $("#distributor_id").val();
        var sales_rep_id = $("#sales_rep_id").val();
        var ref_id = $("#ref_id").val();
        var module="distributor_out";

        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.bar').each(function(){
                //     if ($(this).is(":visible") == true) { 
                //         if(bar_id != $(this).attr('id')){
                //             if(bar == $(this).val()){
                //                 var errors = {};
                //                 var name = $(this).attr('name');
                //                 errors[name] = "Please select different bar for all records.";
                //                 validator.showErrors(errors);
                //                 valid = false;
                //             }
                //         }
                //     }
                // });

                if(btn_val=='Approve') {
					var result = 1;

					$.ajax({
						url: BASE_URL+'index.php/Stock/check_bar_availablity_for_depot',
						data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+bar,
						type: "POST",
						dataType: 'html',
						global: false,
						async: false,
						success: function (data) {
							result = parseInt(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
					});

					if (result) {
						var id = "bar_"+index;
						var errors = {};
						var name = $("#"+id).attr('name');
						errors[name] = "Bar not available in selected depot.";
						validator.showErrors(errors);
						valid = false;
					}

					result = 1;

					$.ajax({
						url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
						data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+bar+'&qty='+qty+'&ref_id='+ref_id,
						type: "POST",
						dataType: 'html',
						global: false,
						async: false,
						success: function (data) {
							result = parseInt(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
					});

					if (result) {
						var id = "qty_"+index;
						var errors = {};
						var name = $("#"+id).attr('name');
						errors[name] = "Bar qty is not enough in selected depot.";
						validator.showErrors(errors);
						valid = false;
					}
				}

                if($('#promo_margin_'+index).val()=='')
                {
                    var id = "sell_rate_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Promo margin is blank,Please Modify Some Fields";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });

        $('.box').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.box').each(function(){
                //     if ($(this).is(":visible") == true) { 
                //         if(box_id != $(this).attr('id')){
                //             if(box == $(this).val()){
                //                 var errors = {};
                //                 var name = $(this).attr('name');
                //                 errors[name] = "Please select different box for all records.";
                //                 validator.showErrors(errors);
                //                 valid = false;
                //             }
                //         }
                //     }
                // });

                if(btn_val=='Approve') {
					var result = 1;

					$.ajax({
						url: BASE_URL+'index.php/Stock/check_box_availablity_for_depot',
						data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box,
						type: "POST",
						dataType: 'html',
						global: false,
						async: false,
						success: function (data) {
							result = parseInt(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
					});

					if (result) {
						var id = "bar_"+index;
						var errors = {};
						var name = $("#"+id).attr('name');
						errors[name] = "Box not available in selected depot.";
						validator.showErrors(errors);
						valid = false;
					}

					result = 1;

					$.ajax({
						url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
						data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box+'&qty='+qty+'&ref_id='+ref_id,
						type: "POST",
						dataType: 'html',
						global: false,
						async: false,
						success: function (data) {
							result = parseInt(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
					});

					if (result) {
						var id = "qty_"+index;
						var errors = {};
						var name = $("#"+id).attr('name');
						errors[name] = "Box qty is not enough in selected depot.";
						validator.showErrors(errors);
						valid = false;
					}
				}

                if($('#promo_margin_'+index).val()=='')
                {
                    var id = "sell_rate_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Promo margin is blank,Please Modify Some Fields";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });

        if($('#final_amount').val()=='0.00' || $('#final_amount').val()=='0' || $('#final_amount').val()==''){
            var errors = {};
            var name = $('#final_amount').attr('name');
            errors[name] = "Amount cannot be zero.";
            validator.showErrors(errors);
            valid = false;
        }
    }

    return valid;
}





// ----------------- DISTRIBUTOR PAYMENT DETAILS FORM VALIDATION -------------------------------------
$("#form_payment_details").validate({
    rules: {
        date_of_deposit: {
            required: true
        },
        bank_id: {
            required: true
        },
        payment_mode: {
            required: true
        },
        total_amount: {
            required: true
        },
        remarks: {
            required: {
                depends: function() {
                    return (d_status == "Approved");
                }
            }
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_payment_details').submit(function() {
    removeMultiInputNamingRules('#form_payment_details', 'select[alt="distributor_id[]"]');
    removeMultiInputNamingRules('#form_payment_details', 'input[alt="ref_no[]"]');
    removeMultiInputNamingRules('#form_payment_details', 'input[alt="bank_name[]"]');
    removeMultiInputNamingRules('#form_payment_details', 'input[alt="bank_city[]"]');
    // removeMultiInputNamingRules('#form_payment_details', 'input[alt="payment_date[]"]');
    removeMultiInputNamingRules('#form_payment_details', 'input[alt="payment_amount[]"]');
    // removeMultiInputNamingRules('#form_payment_details', 'input[alt="deposit_date[]"]');

    addMultiInputNamingRules('#form_payment_details', 'select[name="distributor_id[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_details', 'input[name="ref_no[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_details', 'input[name="bank_name[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_details', 'input[name="bank_city[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_payment_details', 'input[name="payment_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_payment_details', 'input[name="payment_amount[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_payment_details', 'input[name="deposit_date[]"]', { required: true }, "");

    if (!$("#form_payment_details").valid()) {
        return false;
    } else {
        if (check_payment_details()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_payment_details', 'select[alt="distributor_id[]"]');
        removeMultiInputNamingRules('#form_payment_details', 'input[alt="ref_no[]"]');
        removeMultiInputNamingRules('#form_payment_details', 'input[alt="bank_name[]"]');
        removeMultiInputNamingRules('#form_payment_details', 'input[alt="bank_city[]"]');
        // removeMultiInputNamingRules('#form_payment_details', 'input[alt="payment_date[]"]');
        removeMultiInputNamingRules('#form_payment_details', 'input[alt="payment_amount[]"]');
        // removeMultiInputNamingRules('#form_payment_details', 'input[alt="deposit_date[]"]');
        
        return true;
    }
});

function check_payment_details() {
    var validator = $("#form_payment_details").validate();
    var valid = true;

    if($('#payment_mode').val()=='Cash'){
        if(add_denomination_amount()==false)
        {
            var errors = {};
            var name = $('#total_amount').attr('name');
            errors[name] = "Denomination and Total Amount is not same.";
            validator.showErrors(errors);
            valid = false;
        }
    }
      
    if($('.distributor').length=='0'){
        var errors = {};
        var name = $('#date_of_deposit').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {
        // if(parseFloat($('#balance_amount').val())<0){
        //     var errors = {};
        //     var name = $('#balance_amount').attr('name');
        //     errors[name] = "Balance Amount can not be negative.";
        //     validator.showErrors(errors);
        //     valid = false;
        // }
    }

    return valid;
}


function add_denomination_amount() {

    var denomination_2000=0,denomination_500=0,denomination_100=0;
    var denomination_50=0,denomination_20=0,denomination_10=0;denomination_other_amount=0;

    if($('#denomination_2000').val()!='')
    {
      denomination_2000 = parseInt($('#denomination_2000').val())*2000;
    }

    if($('#denomination_500').val()!='')
    {
      denomination_500 =  parseInt($('#denomination_500').val())*500;
    
    }

    if($('#denomination_100').val()!='')
    {
       denomination_100 = parseInt($('#denomination_100').val())*100;
    }

    if($('#denomination_50').val()!='')
    {
       denomination_50 = parseInt($('#denomination_50').val())*50;
    }

    if($('#denomination_20').val()!='')
    {
       denomination_20 = parseInt($('#denomination_20').val())*20;
    }

    if($('#denomination_10').val()!='')
    {
       denomination_10 = parseInt($('#denomination_10').val())*10;
    }

    if($('#denomination_other_amount').val()!='')
    {
       denomination_other_amount = parseInt($('#denomination_other_amount').val());
    }

    var total_amount = (denomination_2000+denomination_500+denomination_100+denomination_50+denomination_20+denomination_10+denomination_other_amount);


    if(total_amount==parseInt($('#total_amount').val()))
    {
        return true;
    }
    else
    {
        return false;

    }
    
}

// ----------------- DISTRIBUTOR IN DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_in_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        depot_id: {
            required: true
        },
        distributor_id: {
            required: true
        },
        sales_rep_id: {
            required: true
        },
        total_amount: {
            required: true
        },
        due_date: {
            required: true
        },
        remarks: {
            required: true
        },
        final_amount_ex: {
            required: true
        },
        final_amount: {
            equalTo: {
                param: '#final_amount_ex',
                depends: function() {
                    return ($("#exc_table").css("display") == "block");
                }
            }
        },
        invoice_no:
        {
            required: true
        },
        sales_type:{
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_distributor_in_details').submit(function() {
    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="type[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="sell_rate[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="batch_no[]"]');

    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="type_ex[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="bar_ex[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="box_ex[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="qty_ex[]"]');
    removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="sell_rate_ex[]"]');

    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'input[name="qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'input[name="sell_rate[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="batch_no[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="batch_no_ex[]"]', { required: true }, "");

    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="type_ex[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="bar_ex[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'select[name="box_ex[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'input[name="qty_ex[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_in_details', 'input[name="sell_rate_ex[]"]', { required: true }, "");

   


    if (!$("#form_distributor_in_details").valid()) {
        return false;
    } else {
         var check_product_in = check_product_availablity_for_distributor_in();
         var check_bar_qty = get_bar_qty('distributor_in','form_distributor_in_details'); 
         var check_box_qty = get_box_qty('distributor_in','form_distributor_in_details');
         var check_stock_out = checkstock_out();
        if (check_product_in==false || check_bar_qty==false || check_box_qty==false || check_stock_out==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="sell_rate[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="batch_no[]"]');
            
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="type_ex[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="bar_ex[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="box_ex[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="qty_ex[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'input[alt="sell_rate_ex[]"]');
        removeMultiInputNamingRules('#form_distributor_in_details', 'select[alt="batch_no_ex[]"]');


        return true;
    }
});

function check_product_availablity_for_distributor_in() {
    var validator = $("#form_distributor_in_details").validate();
    var valid = true;
    var btn_val = $(document.activeElement).val();

    if(btn_val=='Submit For Approval' || btn_val=='Delete') {
        $.ajax({
            url: BASE_URL+'index.php/Freezed/check_freedzed_month',
            data: 'date='+$("#date_of_processing").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

        if (result) {
            var errors = {};
            var name = $('#date_of_processing').attr('name');
            errors[name] = "Please Select Another Date ,This Date is Freezed";
            validator.showErrors(errors);
            valid = false;
        }
    }

    if($('.type').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {

        var depot_id = $("#depot_id").val();
        var distributor_id = $("#distributor_id").val();
        var sales_rep_id = $("#sales_rep_id").val();
        var module="distributor_in";

        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.bar').each(function(){
                //     if ($(this).is(":visible") == true) { 
                //         if(bar_id != $(this).attr('id')){
                //             if(bar == $(this).val()){
                //                 var errors = {};
                //                 var name = $(this).attr('name');
                //                 errors[name] = "Please select different bar for all records.";
                //                 validator.showErrors(errors);
                //                 valid = false;
                //             }
                //         }
                //     }
                // }); 


                // var result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_bar_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&product_id='+bar,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "bar_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Bar not available in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                // result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&product_id='+bar+'&qty='+qty,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "qty_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Bar qty is not enough in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                if($('#promo_margin_'+index).val()=='')
                {
                    var id = "sell_rate_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Promo margin is blank,Please Modify Some Fields";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });

        $('.box').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.box').each(function(){
                //     if ($(this).is(":visible") == true) { 
                //         if(box_id != $(this).attr('id')){
                //             if(box == $(this).val()){
                //                 var errors = {};
                //                 var name = $(this).attr('name');
                //                 errors[name] = "Please select different box for all records.";
                //                 validator.showErrors(errors);
                //                 valid = false;
                //             }
                //         }
                //     }
                // });
                
                // var result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_box_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&box_id='+box,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "box_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Box not available in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                // result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&box_id='+box+'&qty='+qty,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "qty_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Box qty is not enough in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                if($('#promo_margin_'+index).val()=='')
                {
                    var id = "sell_rate_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Promo margin is blank,Please Modify Some Fields";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    }

    return valid;
}




// ----------------- DISTRIBUTOR IN DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_sale_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        distributor_id: {
            required: true
        },
        total_amount: {
            required: true
        },
        due_date: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_distributor_sale_details').submit(function() {
    removeMultiInputNamingRules('#form_distributor_sale_details', 'select[alt="type[]"]');
    removeMultiInputNamingRules('#form_distributor_sale_details', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_distributor_sale_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_distributor_sale_details', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_distributor_sale_details', 'input[alt="sell_rate[]"]');


    addMultiInputNamingRules('#form_distributor_sale_details', 'select[name="type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_sale_details', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_sale_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_sale_details', 'input[name="qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_sale_details', 'input[name="sell_rate[]"]', { required: true }, "");
    if (!$("#form_distributor_sale_details").valid()) {
        return false;
    } else {
        if (check_product_availablity_for_distributor_sale()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_distributor_sale_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_distributor_sale_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_distributor_sale_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_distributor_sale_details', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_distributor_sale_details', 'input[alt="sell_rate[]"]');
        
        return true;
    }
});

function check_product_availablity_for_distributor_sale() {
    var validator = $("#form_distributor_sale_details").validate();
    var valid = true;

    if($('.type').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {

        var distributor_id = $("#distributor_id").val();
        var module="distributor_sale";

        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.bar').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(bar_id != $(this).attr('id')){
                            if(bar == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different bar for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });


                //var result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_bar_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&product_id='+bar,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "bar_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Bar not available in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                // result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&product_id='+bar+'&qty='+qty,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "qty_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Bar qty is not enough in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }
            }
        });

        $('.box').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.box').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(box_id != $(this).attr('id')){
                            if(box == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different box for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });
                
                // var result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_box_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&box_id='+box,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "box_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Box not available in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                // result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_distributor',
                //     data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_id").val()+'&box_id='+box+'&qty='+qty,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "qty_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Box qty is not enough in selected distributor.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }
            }
        });
    }

    return valid;
}




// ----------------- Download Report FORM VALIDATION -------------------------------------
$("#form_download_report").validate({
    rules: {
        owner: {
            required: true
        },
        from_date: {
            required: true
        },
        to_date: {
            required: true
        },
        property: {
            required: true
        }
    },

    ignore:":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});




// ----------------- Category FORM VALIDATION -------------------------------------
$("#category_master").validate({
    rules: {
        category_name: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});




// ----------------- Tax FORM VALIDATION -------------------------------------
$("#form_tax").validate({
    rules: {
        txn_type_1: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_tax').submit(function() {
    removeMultiInputNamingRules('#form_tax', 'input[alt="tax_name[]"]');
    removeMultiInputNamingRules('#form_tax', 'input[alt="tax_perecnt[]"]');

    addMultiInputNamingRules('#form_tax', 'input[name="tax_name[]"]', { required: function(element) {
                                                    return true;
                                                }
                                }, "");

    addMultiInputNamingRules('#form_tax', 'input[name="tax_perecnt[]"]', { required: function(element) {
                                                    return true;
                                                }
                                }, "");

    $('.txn_action').each(function() {
        $(this).rules("remove");
    });
    $('.txn_action').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        $(this).rules("add", { required: function(element) {
                                                return true;
                                            }
                            });
    });

    if (!$("#form_tax").valid()) {
        return false;
    } else {
        if(checkTaxNameAvailability()==false){
            return false;
        }
        removeMultiInputNamingRules('#form_tax', 'input[alt="tax_name[]"]');
        removeMultiInputNamingRules('#form_tax', 'input[alt="tax_perecnt[]"]');
        return true;
    }
});

function checkTaxNameAvailability() {
    var validator = $("#form_tax").validate();
    var tax_id = $('#tax_id_1').val();
    var valid = true;
    var makerCnt = 0;
    var checkerCnt = 0;

    $('.tax_name').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        var tax_id = $('#tax_id_'+index).val();
        var tax_name = $(this).val();

        var result = 1;

        $.ajax({
            url: BASE_URL+'index.php/Tax_master/checkTaxNameAvailability',
            data: 'tax_id='+tax_id+'&tax_name='+tax_name,
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

        if (result) {
            var errors = {};
            var name = $('#tax_name_'+index).attr('name');
            errors[name] = "Tax_name already in use.";
            validator.showErrors(errors);
            valid = false;
        }

        var counter = $('.tax_name').length;
        // for(i=index; i<=counter; i++) {
        for(i=counter; i>0; i--) {
            if ($('#tax_name_'+i).val()==tax_name && i!=index) {
                var errors = {};
                var name = $('#tax_name_'+i).attr('name');
                errors[name] = "Tax_name already in use.";
                validator.showErrors(errors);
                valid = false;
            }
        }
    });
    
    return valid;
}




// ----------------- BOX DETAILS FORM VALIDATION -------------------------------------
$("#form_box_details").validate({
    rules: {
        box_name: {
            required: true,
            check_box_name_availablity: true
        },
        barcode: {
            required: true,
            check_barcode_availablity: true
        },
        box_rate: {
            required: true
        },
        hsn_code: {
            required: true
        },
        short_name: {
            required: true
        },
        category_id:{
            required: true
        },
        tax_percentage:{
            required: true
        },
        sku_code:{
            required: true,
            check_sku_code_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_box_name_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Box/check_box_name_availablity',
        data: 'id='+$("#id").val()+'&box_name='+$("#box_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Box Name already in use.');

$.validator.addMethod("check_barcode_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Box/check_barcode_availablity',
        data: 'id='+$("#id").val()+'&barcode='+$("#barcode").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Barcode already in use.');

$.validator.addMethod("check_sku_code_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Box/check_sku_code_availablity',
        data: 'id='+$("#id").val()+'&sku_code='+$("#sku_code").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'SKU Code already in use.');

$('#form_box_details').submit(function() {
    removeMultiInputNamingRules('#form_box_details', 'select[alt="product[]"]');
    removeMultiInputNamingRules('#form_box_details', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_box_details', 'select[name="product[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_box_details', 'input[name="qty[]"]', { required: true }, "");
    if (!$("#form_box_details").valid()) {
        return false;
    } else {
        if (check_product_availablity_for_box()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_box_details', 'select[alt="product[]"]');
        removeMultiInputNamingRules('#form_box_details', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_product_availablity_for_box() {
    var validator = $("#form_box_details").validate();
    var valid = true;

    if($('.product').length=='0'){
        var errors = {};
        var name = $('#box_name').attr('name');
        errors[name] = "Please add atleast one product.";
        validator.showErrors(errors);
        valid = false;
    } else {
        $('.product').each(function(){
            var product_id = $(this).attr('id');
            var product = $(this).val();

            $('.product').each(function(){
                if(product_id != $(this).attr('id')){
                    if(product == $(this).val()){
                        var errors = {};
                        var name = $(this).attr('name');
                        errors[name] = "Please select different product for all records.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }
            });
        });
    }
    
    return valid;
}




// ----------------- BAR TO BOX DETAILS FORM VALIDATION -------------------------------------
$("#form_bar_to_box_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        depot_id: {
            required: true
        },
        total_qty: {
            required: true
        },
        total_grams: {
            required: true
        },
        total_amount: {
            required: true
        },
        "batch_no[]": {
            required: true
        },
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_bar_to_box_details').submit(function() {
    removeMultiInputNamingRules('#form_bar_to_box_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_bar_to_box_details', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_bar_to_box_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_bar_to_box_details', 'input[name="qty[]"]', { required: true }, "");
    if (!$("#form_bar_to_box_details").valid()) {
        return false;
    } else {
         var check_bar_qty = get_bar_qty('bar_to_box','form_bar_to_box_details'); 
         var check_box_qty = get_box_qty('bar_to_box','form_bar_to_box_details');
         var check_box_availablity = check_box_availablity_for_bar_to_box();

        if (check_box_availablity==false || check_box_qty==false || check_bar_qty==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_bar_to_box_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_bar_to_box_details', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_box_availablity_for_bar_to_box() {
    var validator = $("#form_bar_to_box_details").validate();
    var valid = true;

    if($('.box').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one box.";
        validator.showErrors(errors);
        valid = false;

    } else {

        var depot_id = $("#depot_id").val();
        var product_id = [];
        var product_qty = [];
        var box_index = [];
        var module = "bar_to_box";

        $('.box').each(function(){
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            var box_id = $(this).attr('id');
            var box = $(this).val();
            var qty = parseFloat(get_number($('#qty_'+index).val()));
            if (isNaN(qty)) qty=0;

            $.ajax({
                url: BASE_URL+'index.php/Box/get_products',
                data: 'id='+box,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    var result = parseInt(data.result);
                    if(result==1){
                        for(var i=0; i<data.product.length; i++){
                            var flag = false;
                            for(var j=0; j<product_id.length; j++){
                                if(product_id[j]==data.product[i]){
                                    product_qty[j]=parseFloat(product_qty[j])+(parseFloat(data.qty[i])*qty);
                                    flag=true;
                                }
                            }
                            if(flag==false){
                                product_id.push(data.product[i]);
                                product_qty.push(parseFloat(data.qty[i])*qty);
                                box_index.push(index);
                            }
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            // $('.box').each(function(){
            //     if(box_id != $(this).attr('id')){
            //         if(box == $(this).val()){
            //             var errors = {};
            //             var name = $(this).attr('name');
            //             errors[name] = "Please select different box for all records.";
            //             validator.showErrors(errors);
            //             valid = false;
            //         } else {
            //             var id2 = $(this).attr('id');
            //             var index2 = id2.substr(id2.lastIndexOf('_')+1);
            //             var box_id2 = $(this).attr('id');
            //             var box2 = $(this).val();
            //             var qty2 = parseFloat(get_number($('#qty_'+index2).val()));
            //             if (isNaN(qty2)) qty2=0;

            //             $.ajax({
            //                 url: BASE_URL+'index.php/Box/get_products',
            //                 data: 'id='+box2,
            //                 type: "POST",
            //                 dataType: 'json',
            //                 global: false,
            //                 async: false,
            //                 success: function (data) {
            //                     var result = parseInt(data.result);
            //                     if(result==1){
            //                         for(var i=0; i<data.product.length; i++){
            //                             for(var j=0; j<product_id.length; j++){
            //                                 if(product_id[j]==data.product[i]){
            //                                     product_qty[j]=parseFloat(product_qty[j])+(parseFloat(data.qty[i])*qty2);
            //                                 }
            //                             }
            //                         }
            //                     }
            //                 },
            //                 error: function (xhr, ajaxOptions, thrownError) {
            //                     alert(xhr.status);
            //                     alert(thrownError);
            //                 }
            //             });
            //         }
            //     }
            // });
        });

        for(var j=0; j<product_id.length; j++){
            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_bar_availablity_for_depot',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&product_id='+product_id[j],
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var id = "box_"+box_index[j];
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Bars required for this box are not available in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
                data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&product_id='+product_id[j]+'&qty='+product_qty[j],
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var id = "qty_"+box_index[j];
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Bar qty required for this box is not enough in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}




// ----------------- BAR TO BOX DETAILS FORM VALIDATION -------------------------------------
$("#form_box_to_bar_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        depot_id: {
            required: true
        },
        total_qty: {
            required: true
        },
        total_grams: {
            required: true
        },
        total_amount: {
            required: true
        },
        "batch_no[]": {
            required: true
        },
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_box_to_bar_details').submit(function() {
    removeMultiInputNamingRules('#form_box_to_bar_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_box_to_bar_details', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_box_to_bar_details', 'input[alt="total_bar_qty[]"]');
    removeMultiInputNamingRules('#form_box_to_bar_details', 'input[alt="bal_bar_qty[]"]');

    addMultiInputNamingRules('#form_box_to_bar_details', 'input[name="total_bar_qty[]"]', {  }, "");
    addMultiInputNamingRules('#form_box_to_bar_details', 'input[name="bal_bar_qty[]"]', {  }, "");
    addMultiInputNamingRules('#form_box_to_bar_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_box_to_bar_details', 'input[name="qty[]"]', { required: true }, "");
    if (!$("#form_box_to_bar_details").valid()) {
        return false;
    } else {
        var check_qty = checkbox_qty();
        var check_box_availablity = check_box_availablity_for_box_to_bar();
        if (check_qty==false || check_box_availablity==false) {
            return false;
        }


        removeMultiInputNamingRules('#form_box_to_bar_details', 'input[alt="total_bar_qty[]"]');
        removeMultiInputNamingRules('#form_box_to_bar_details', 'input[alt="bal_bar_qty[]"]');
    
        removeMultiInputNamingRules('#form_box_to_bar_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_box_to_bar_details', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_box_availablity_for_box_to_bar() {
    var validator = $("#form_box_to_bar_details").validate();
    var valid = true;

    if($('.box').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one box.";
        validator.showErrors(errors);
        valid = false;

    } else {

        var depot_id = $("#depot_id").val();
        var module = "box_to_bar";
        
        $('.box').each(function(){
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            var box_id = $(this).attr('id');
            var box = $(this).val();
            var qty = parseFloat(get_number($('#qty_'+index).val()));
            if (isNaN(qty)) qty=0;

            $('.box').each(function(){
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.box').each(function(){
                //     if(box_id != $(this).attr('id')){
                //         if(box == $(this).val()){
                //             var errors = {};
                //             var name = $(this).attr('name');
                //             errors[name] = "Please select different box for all records.";
                //             validator.showErrors(errors);
                //             valid = false;
                //         }
                //     }
                // });

                var result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_box_availablity_for_depot',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "box_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Box not available in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }

                result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box+'&qty='+qty,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "qty_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Box qty is not enough in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }
            });
        });
    }
    
    return valid;
}




// ----------------- DEPOT TRANSFER DETAILS FORM VALIDATION -------------------------------------
$("#form_depot_transfer_details").validate({
    rules: {
        date_of_transfer: {
            required: true
        },
        depot_out_id: {
            required: true
        },
        depot_in_id: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_depot_transfer_details').submit(function() {
    removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="type[]"]');
    removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="raw_material[]"]');
    removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_depot_transfer_details', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_depot_transfer_details', 'select[name="type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_depot_transfer_details', 'select[name="raw_material[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_depot_transfer_details', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_depot_transfer_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_depot_transfer_details', 'input[name="qty[]"]', { required: true }, "");
    
    $('.type').each(function(){
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        if($('.type').val()=='Bar' || $('.type').val()=='Box')
        {
          var name = $('#batch_no_'+index).attr('name')
          removeMultiInputNamingRules('#form_depot_transfer_details', 'select[name="'+name+'"]');
          addMultiInputNamingRules('#form_depot_transfer_details', 'select[name="'+name+'"]', { required: true });
        }
        
    });

    if (!$("#form_depot_transfer_details").valid()) {
        return false;
    } else {
        var check_bar_qty = get_bar_qty('depot_transfer','form_depot_transfer_details'); 
        var check_box_qty = get_box_qty('depot_transfer','form_depot_transfer_details');
        var check_raw_material_qty = get_raw_material_qty('depot_transfer','form_depot_transfer_details');
        var check_product_availablity = check_product_availablity_for_depot_transfer();

        if (check_product_availablity==false || check_bar_qty==false || check_box_qty==false || check_raw_material_qty==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="raw_material[]"]');
        removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_depot_transfer_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_depot_transfer_details', 'input[alt="qty[]"]');
        
        $('.type').each(function(){
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        if($('.type').val()=='Bar' || $('.type').val()=='Box')
        {
          var name = $('#batch_no_'+index).attr('name')
          removeMultiInputNamingRules('#form_depot_transfer_details', 'select[name="'+name+'"]');
        }
        });
        return true;
    }
});

function check_product_availablity_for_depot_transfer() {
    var validator = $("#form_depot_transfer_details").validate();
    var valid = true;

    if($('#depot_out_id').val()==$('#depot_in_id').val()){
        var errors = {};
        var name = $('#depot_out_id').attr('name');
        errors[name] = "Please select different depot for transfer.";
        validator.showErrors(errors);
        valid = false;
    }

    if($('.type').length=='0'){
        var errors = {};
        var name = $('#date_of_transfer').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {

        var module="depot_transfer";

        $('.raw_material').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var raw_material_id = $(this).attr('id');
                var raw_material = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.raw_material').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(raw_material_id != $(this).attr('id')){
                            if(raw_material == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different raw material for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });

                var result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_raw_material_availablity',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_out_id").val()+'&raw_material_id='+raw_material,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "raw_material_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Raw material not available in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }

                result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_raw_material_qty_availablity',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_out_id").val()+'&raw_material_id='+raw_material+'&qty='+qty,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "qty_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Raw material qty is not enough in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });

        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.bar').each(function(){
                //     if ($(this).is(":visible") == true) { 
                //         if(bar_id != $(this).attr('id')){
                //             if(bar == $(this).val()){
                //                 var errors = {};
                //                 var name = $(this).attr('name');
                //                 errors[name] = "Please select different bar for all records.";
                //                 validator.showErrors(errors);
                //                 valid = false;
                //             }
                //         }
                //     }
                // });

                var result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_bar_availablity_for_depot',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_out_id").val()+'&product_id='+bar,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "bar_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Bar not available in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }

                result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_out_id").val()+'&product_id='+bar+'&qty='+qty,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "qty_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Bar qty is not enough in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });

        $('.box').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                // $('.box').each(function(){
                //     if ($(this).is(":visible") == true) { 
                //         if(box_id != $(this).attr('id')){
                //             if(box == $(this).val()){
                //                 var errors = {};
                //                 var name = $(this).attr('name');
                //                 errors[name] = "Please select different box for all records.";
                //                 validator.showErrors(errors);
                //                 valid = false;
                //             }
                //         }
                //     }
                // });

                var result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_box_availablity_for_depot',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_out_id").val()+'&box_id='+box,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "box_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Box not available in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }

                result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_out_id").val()+'&box_id='+box+'&qty='+qty,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "qty_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Box qty is not enough in selected depot.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    }

    return valid;
}




// ----------------- DISTRIBUTOR TRANSFER DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_transfer_details").validate({
    rules: {
        date_of_transfer: {
            required: true
        },
        distributor_out_id: {
            required: true
        },
        distributor_in_id: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_distributor_transfer_details').submit(function() {
    removeMultiInputNamingRules('#form_distributor_transfer_details', 'select[alt="type[]"]');
    removeMultiInputNamingRules('#form_distributor_transfer_details', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_distributor_transfer_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_distributor_transfer_details', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_distributor_transfer_details', 'select[name="type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_transfer_details', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_transfer_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_transfer_details', 'input[name="qty[]"]', { required: true }, "");
    if (!$("#form_distributor_transfer_details").valid()) {
        return false;
    } else {
        if (check_product_availablity_for_distributor_transfer()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_distributor_transfer_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_distributor_transfer_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_distributor_transfer_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_distributor_transfer_details', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_product_availablity_for_distributor_transfer() {
    var validator = $("#form_distributor_transfer_details").validate();
    var valid = true;

    if($('#distributor_out_id').val()==$('#distributor_in_id').val()){
        var errors = {};
        var name = $('#distributor_out_id').attr('name');
        errors[name] = "Please select different distributor for transfer.";
        validator.showErrors(errors);
        valid = false;
    }

    if($('.type').length=='0'){
        var errors = {};
        var name = $('#date_of_transfer').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {

        var module="distributor_transfer";

        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.bar').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(bar_id != $(this).attr('id')){
                            if(bar == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different bar for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });

                var result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_bar_availablity_for_distributor',
                    data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_out_id").val()+'&product_id='+bar,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "bar_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Bar not available in selected distributor.";
                    validator.showErrors(errors);
                    valid = false;
                }

                result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_distributor',
                    data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_out_id").val()+'&product_id='+bar+'&qty='+qty,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "qty_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Bar qty is not enough in selected distributor.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });

        $('.box').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.box').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(box_id != $(this).attr('id')){
                            if(box == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different box for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });

                var result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_box_availablity_for_distributor',
                    data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_out_id").val()+'&box_id='+box,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "box_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Box not available in selected distributor.";
                    validator.showErrors(errors);
                    valid = false;
                }

                result = 1;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_distributor',
                    data: 'id='+$("#id").val()+'&module='+module+'&distributor_id='+$("#distributor_out_id").val()+'&box_id='+box+'&qty='+qty,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        result = parseInt(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if (result) {
                    var id = "qty_"+index;
                    var errors = {};
                    var name = $("#"+id).attr('name');
                    errors[name] = "Box qty is not enough in selected distributor.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    }

    return valid;
}




// ----------------- BANK FORM VALIDATION -------------------------------------
$("#form_bank").validate({
    rules: {
        registered_phone: {
            numbersonly: true
        },
        registered_email: {
            checkemail: true
        },
        bank_name: {
            required: true
        },
        bank_branch: {
            required: true
        },
        bank_address: {
            required: true
        },
        bank_pincode: {
            numbersonly: true
        },
        account_type: {
            required: true
        },
        account_no: {
            required: true
        },
        customer_id: {
            required: true
        },
        ifsc: {
            required: true
        },
        phone_no: {
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-bank-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in bank details. <br/>";
        }
        if ($('#panel-authorised_signatory').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in Authorised Signatory. <br/>";
        }
        
        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$('#form_bank').submit(function() {
    var submitVal = $(document.activeElement).val();
    removeMultiInputNamingRules('#form_bank', 'input[alt="auth_name[]"]');
    removeMultiInputNamingRules('#form_bank', 'select[alt="auth_type[]"]');

    addMultiInputNamingRules('#form_bank', 'input[name="auth_name[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_bank', 'select[name="auth_type[]"]', { required: true }, "");

    if (!$("#form_bank").valid()) {
        return false;
    } else {
        if (checkAuthSign()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_bank', 'input[alt="auth_name[]"]');
        removeMultiInputNamingRules('#form_bank', 'select[alt="auth_type[]"]');

        return true;
    }
});

function checkAuthSign() {
    var validator = $("#form_bank").validate();
    var valid = true;
    var jointCnt = 0;
    var jointIndex = 1;
    var counter = $('.auth_name').length;

    if (counter==0) {
        var errors = {};
        var name = $('#bank_name').attr('name');
        errors[name] = "Add atleast one authorised signatory";
        validator.showErrors(errors);
        valid = false;
    }

    // $('.auth_name').each(function() {
    //     var id = $(this).attr('id');
    //     var index = id.substr(id.lastIndexOf('_')+1);
    //     var auth_name_id = $('#auth_name_'+index+'_id').val();
    //     var auth_type = $('#auth_type_'+index).val();

    //     for(i=counter; i>0; i--) {
    //         if ($('#auth_name_'+i+'_id').val()==auth_name_id && i!=index) {
    //                 var errors = {};
    //                 var name = $('#auth_name_'+i+'_id').attr('name');
    //                 errors[name] = "Select different contacts for all records";
    //                 validator.showErrors(errors);
    //                 valid = false;
    //         }
    //     }

    //     if(auth_type=="Joint"){
    //         jointCnt=jointCnt+1;
    //         jointIndex=index;
    //     }
    // });

    // if(jointCnt==1) {
    //     var errors = {};
    //     var name = $('#auth_type_'+jointIndex).attr('name');
    //     errors[name] = "Add atleast two records for joint authorisation";
    //     validator.showErrors(errors);
    //     valid = false;
    // }
    
    return valid;
}



// ----------------- CREDIT DEBIT NOTE DETAILS FORM VALIDATION -------------------------------------
$("#form_credit_debit_note_details").validate({
    rules: {
        date_of_transaction: {
            required: true
        },
        distributor_id: {
            required: true
        },
        transaction: {
            required: true
        },
        amount_without_tax: {
            required: true,
            // numbersonly: true,
            numbersandcommaanddotonly: true
        },
        tax: {
            // numbersonly: true,
            numbersandcommaanddotonly: true
        },
        remarks: {
            required: true
        },
        exp_category_id: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_credit_debit_note_details').submit(function() {
    if (!$("#form_credit_debit_note_details").valid()) {
        return false;
    }
    else {
        if (check_freezed_credit_debit_note()==false) {
            return false;
        }
        return true;
    }
});

function check_freezed_credit_debit_note() {
    var validator = $("#form_credit_debit_note_details").validate();
    var valid = true;
    var btn_val = $(document.activeElement).val();

    if(btn_val=='Submit For Approval' || btn_val=='Delete') {
        $.ajax({
            url: BASE_URL+'index.php/Freezed/check_freedzed_month',
            data: 'date='+$("#date_of_transaction").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

        if (result) {
            var errors = {};
            var name = $('#date_of_transaction').attr('name');
            errors[name] = "Please Select Another Date ,This Date is Freezed";
            validator.showErrors(errors);
            valid = false;
        }
    }

    return valid;
}




// ----------------- Area DETAILS FORM VALIDATION -------------------------------------
$("#form_area_details").validate({
    rules: {
        type_id: {
            required: true
        },
        zone_id: {
            required: true
        },
        area: {
            required: true,
            check_area_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_area_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/area/check_area_availablity',
        data: 'id='+$("#id").val()+'&area='+$("#area").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Area Name already in use.');

$('#form_area_details').submit(function() {
    if (!$("#form_area_details").valid()) {
        return false;
    } else {
        return true;
    }
});



// ----------------- LOCATION DETAILS FORM VALIDATION -------------------------------------
$("#form_location_details").validate({
    rules: {
        type_id: {
            required: true
        },
        zone_id: {
            required: true
        },
        location: {
            required: true,
            check_location_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_location_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/location/check_location_availablity',
        data: 'id='+$("#id").val()+'&location='+$("#location").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Location Name already in use.');

$('#form_location_details').submit(function() {
    if (!$("#form_location_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Distributor Type DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_type_details").validate({
    rules: {
        distributor_type: {
            required: true,
            check_distributor_type_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_distributor_type_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/distributor_type/check_distributor_type_availablity',
        data: 'id='+$("#id").val()+'&distributor_type='+$("#distributor_type").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Distributor Type already in use.');

$('#form_distributor_type_details').submit(function() {
    if (!$("#form_distributor_type_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Zone DETAILS FORM VALIDATION -------------------------------------
$("#form_zone_details").validate({
    rules: {
        type_id: {
            required: true
        },
        zone: {
            required: true,
            check_zone_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_zone_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/zone/check_zone_availablity',
        data: 'id='+$("#id").val()+'&zone='+$("#zone").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Zone already in use.');

$('#form_zone_details').submit(function() {
    if (!$("#form_zone_details").valid()) {
        return false;
    } else {
        return true;
    }
});



// ----------------- Ingredients master FORM VALIDATION -------------------------------------
$("#form_ingredients_master_details").validate({
    rules: {
        
			total_batch_in_grams:{
            required: true
            
			},
			per_bar: {
            required: true
            
			},
			total_batch_bar: {
            required: true
            
			},
			product_id: {
            required: true,
            check_product_id_availablity: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_product_id_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/ingredients_master/check_product_id_availablity',
        data: 'id='+$("#id").val()+'&product_id='+$("#product_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Product already in use.');

$('#form_ingredients_master_details').submit(function() {
    if (!$("#form_ingredients_master_details").valid()) {
        return false;
    } else {
        return true;
    }
});









// ----------------- SALES REP ROUTE PLAN FORM VALIDATION -------------------------------------
$("#form_sales_rep_route_plan_details").validate({
    rules: {
        area: {
            required: true
        },
        distributor_name: {
            required: true
        },
        distributor_status: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

// $('#form_sales_rep_route_plan_details').submit(function() {
//     if (!$("#form_sales_rep_route_plan_details").valid()) {
//         return false;
//     } else {
//         return true;
//     }
// });




// ----------------- SALES REP DISTRIBUTOR FORM VALIDATION -------------------------------------
$("#form_sales_rep_distributor_details").validate({
    rules: {
        distributor_name: {
            required: true
        },
        contact_no: {
            numbersonly: true,
            minlength: 10,
            maxlength: 10
        },
        margin: {
            number: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

// $('#form_sales_rep_distributor_details').submit(function() {
//     if (!$("#form_sales_rep_distributor_details").valid()) {
//         return false;
//     } else {
//         return true;
//     }
// });




// ----------------- SALES REP ORDER FORM VALIDATION -------------------------------------
$("#form_sales_rep_order_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        distributor_id: {
            required: true
        },
        total_amount: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_sales_rep_order_details').submit(function() {
    removeMultiInputNamingRules('#form_sales_rep_order_details', 'select[alt="type[]"]');
    removeMultiInputNamingRules('#form_sales_rep_order_details', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_sales_rep_order_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_sales_rep_order_details', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_sales_rep_order_details', 'input[alt="sell_rate[]"]');


    addMultiInputNamingRules('#form_sales_rep_order_details', 'select[name="type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sales_rep_order_details', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sales_rep_order_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sales_rep_order_details', 'input[name="qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sales_rep_order_details', 'input[name="sell_rate[]"]', { required: true }, "");
    if (!$("#form_sales_rep_order_details").valid()) {
        return false;
    } else {
        if (check_product_availablity_for_sales_rep_order()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_sales_rep_order_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_sales_rep_order_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_sales_rep_order_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_sales_rep_order_details', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_sales_rep_order_details', 'input[alt="sell_rate[]"]');
        
        return true;
    }
});

function check_product_availablity_for_sales_rep_order() {
    var validator = $("#form_sales_rep_order_details").validate();
    var valid = true;

    if($('.type').length=='0'){
        var errors = {};
        var name = $('#date_of_processing').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {
        // var depot_id = $("#depot_id").val();
        var distributor_id = $("#distributor_id").val();
        var module="sales_rep_order";

        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.bar').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(bar_id != $(this).attr('id')){
                            if(bar == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different bar for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });


                // var result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_bar_availablity_for_depot',
                //     data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&product_id='+bar,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "bar_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Bar not available in selected depot.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                // result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
                //     data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&product_id='+bar+'&qty='+qty,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "qty_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Bar qty is not enough in selected depot.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }
            }
        });

        $('.box').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.box').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(box_id != $(this).attr('id')){
                            if(box == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different box for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });


                // var result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_box_availablity_for_depot',
                //     data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "bar_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Box not available in selected depot.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }

                // result = 1;

                // $.ajax({
                //     url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
                //     data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box+'&qty='+qty,
                //     type: "POST",
                //     dataType: 'html',
                //     global: false,
                //     async: false,
                //     success: function (data) {
                //         result = parseInt(data);
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert(xhr.status);
                //         alert(thrownError);
                //     }
                // });

                // if (result) {
                //     var id = "qty_"+index;
                //     var errors = {};
                //     var name = $("#"+id).attr('name');
                //     errors[name] = "Box qty is not enough in selected depot.";
                //     validator.showErrors(errors);
                //     valid = false;
                // }
            }
        });
    }

    return valid;
}




// ----------------- SALES REP TARGET FORM VALIDATION -------------------------------------
$("#form_sales_rep_target_details").validate({
    rules: {
        sales_rep_id: {
            required: true
        },
        month: {
            required: true
        },
        target: {
            required: true,
            numbersandcommaonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_sales_rep_target_details').submit(function() {
    if (!$("#form_sales_rep_target_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- SALES REP AREA FORM VALIDATION -------------------------------------
$("#form_sales_rep_area_details").validate({
    rules: {
        date_of_visit: {
            required: true
        },
        area: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_sales_rep_area_details').submit(function() {
    if (!$("#form_sales_rep_area_details").valid()) {
        return false;
    } else {
        if (check_date_of_visit()==false) {
            return false;
        }

        return true;
    }
});

function check_date_of_visit() {
    var validator = $("#form_sales_rep_area_details").validate();
    var valid = true;

    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Sales_rep_area/check_date_of_visit',
        data: 'id='+$("#id").val()+'&date_of_visit='+$("#date_of_visit").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        var errors = {};
        var name = $("#date_of_visit").attr('name');
        errors[name] = "Area for this date is already taken.";
        validator.showErrors(errors);
        valid = false;
    }

    return valid;
}




// ----------------- SALES REP LOCATION FORM VALIDATION -------------------------------------
$("#form_sales_rep_location_details").validate({
    rules: {
        date_of_visit: {
            required: true
        },
      
        channel_type: {
            required: true
        },
        distributor_type: {
            required: true
        },
		 zone_id: {
            required: true
        },
		 reation_id: {
            required: true
        },
			 area_id: {
            required: true
        },
			 location_id: {
            required: true
        },
		  distributor_id: {
            required: true
        },
		  distributor_name: {
            required: true,
			check_sales_rep_distributor_availablity:true
        },
        followup_date: {
            required: true
        },
		
        // orange_bar: {
           // digits: true
           // required: true
        // },
        // mint_bar: {
           // digits: true
            // required: false
        // },
        // butterscotch_bar: {
           // digits: true
            // required: true
        // },
        // chocopeanut_bar: {
           // digits: true
           // required: true
        // },
        // bambaiyachaat_bar: {
          //  digits: true
           // required: true
        // },
        // mangoginger_bar: {
           // digits: true
            //required: true
        // }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_sales_rep_location_details').submit(function() {
    if (!$("#form_sales_rep_location_details").valid()) {
        return false;
    } else {
        // if (check_date_of_visit_for_location()==false) {
            // return false;
        // }

        return true;
    }
});


$.validator.addMethod("check_sales_rep_distributor_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Sales_rep_distributor/check_distributor_availablity',
        data: 'id='+$("#id").val()+'&distributor_name='+$("#distributor_name").val()+'&zone_id='+$("#zone_id").val()+'&area_id='+$("#area_id").val()+'&location_id='+$("#location_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Distributor Name already in use.');




// ----------------- ACCOUNT GROUP FORM VALIDATION -------------------------------------
$("#form_group_details").validate({
    rules: {
        group_name: {
            required: true,
            check_group_availablity: true
        },
        fk_primary_id: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_group_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/AccountGroup/check_group_availablity',
        data: 'id='+$("#id").val()+'&group_name='+$("#group_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Group Name already in use.');

$('#form_group_details').submit(function() {
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

    // addMultiInputNamingRules('#form_distributor_details', 'input[name="contact_person[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
    if (!$("#form_group_details").valid()) {
        return false;
    } else {

        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

        return true;
    }
});



// ----------------- ACCOUNT LEDGER FORM VALIDATION -------------------------------------
$("#form_ledger_details").validate({
    rules: {
        ledger_name: {
            required: true,
            check_ledger_availablity: true
        },
        fk_group_id: {
            required: true
        },
        opening_balance: {
            required: true,
            numbersandcommaonly: true
        },
        trans_type: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_ledger_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/AccountLedger/check_ledger_availablity',
        data: 'id='+$("#id").val()+'&ledger_name='+$("#ledger_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Ledger Name already in use.');

$('#form_ledger_details').submit(function() {
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

    // addMultiInputNamingRules('#form_distributor_details', 'input[name="contact_person[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
    // addMultiInputNamingRules('#form_distributor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
    if (!$("#form_ledger_details").valid()) {
        return false;
    } else {

        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
        // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

        return true;
    }
});

// function check_date_of_visit_for_location() {
    // var validator = $("#form_sales_rep_location_details").validate();
    // var valid = true;

    // var result = 1;

    // $.ajax({
        // url: BASE_URL+'index.php/Sales_rep_location/check_date_of_visit',
        // data: 'id='+$("#id").val()+'&date_of_visit='+$("#date_of_visit").val()+'&distributor_name='+$("#distributor_name").val(),
        // type: "POST",
        // dataType: 'html',
        // global: false,
        // async: false,
        // success: function (data) {
            // result = parseInt(data);
        // },
        // error: function (xhr, ajaxOptions, thrownError) {
            // alert(xhr.status);
            // alert(thrownError);
        // }
    // });

    // if (result) {
        // var errors = {};
        // var name = $("#date_of_visit").attr('name');
        // errors[name] = "Entered Distributor for this date is already taken.";
        // validator.showErrors(errors);
        // valid = false;
    // }

    // return valid;
// }







// ----------------- SALES REP Mapping DETAILS FORM VALIDATION -------------------------------------
$("#form_sr_mapping").validate({
    rules: {
        // sales_rep_id1: {
            // required: true,
            
        // },
		 // sales_rep_id2: {
            // required: true,
            
        // },
        	class: {
            required: true,
        },
        type_id: {
            required: true,
          
        },
		
		 // area_id: {
           // required: true,
           
      // },
		zone_id: {
            required: true,
           
        },
		location_id: {
            required: true,
            check_mapping_availablity: true,
        },
       
       reporting_manager_id: {
            required: true,
           
        }
       
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

// $.validator.addMethod("check_sales_rep_availablity", function (value, element) {
    // var result = 1;

    // $.ajax({
        // url: BASE_URL+'index.php/Sales_rep/check_sales_rep_availablity',
        // data: 'id='+$("#id").val()+'&sales_rep_name='+$("#sales_rep_name").val(),
        // type: "POST",
        // dataType: 'html',
        // global: false,
        // async: false,
        // success: function (data) {
            // result = parseInt(data);
        // },
        // error: function (xhr, ajaxOptions, thrownError) {
            // alert(xhr.status);
            // alert(thrownError);
        // }
    // });

    // if (result) {
        // return false;
    // } else {
        // return true;
    // }
// }, 'Sales Mapping Name already in use.');




$.validator.addMethod("check_mapping_availablity", function (value, element) {
    var result = 1;

	   var type_id = $('#type_id').val();

	
	  if(( type_id == '7') || (type_id == '4'))
		{
		$.ajax({
        url: BASE_URL+'index.php/sr_mapping/check_mapping_availablity',
        data: 'id='+$("#id").val()+'&type_id='+$("#type_id").val()+'&zone_id='+$("#zone_id").val()+'&area_id1='+$("#area_id1").val()+'&location_id='+$("#location_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

 
		}
	else
		{
		   $.ajax({
        url: BASE_URL+'index.php/sr_mapping/check_mapping_availablity',
        data: 'id='+$("#id").val()+'&type_id='+$("#type_id").val()+'&zone_id='+$("#zone_id").val()+'&area_id='+$("#area_id").val()+'&location_id='+$("#location_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
		}

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Mapping already in use.');
		
	
	

$('#form_sr_mapping').submit(function() {
    if (!$("#form_sr_mapping").valid()) {
        return false;
    } else {
        return true;
    }
});






// ----------------- DISTRIBUTOR OUT SKU DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_out_sku_details").validate({
    rules: {
        sales_rep_id: {
            required: true
        },
        tracking_id:{
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$("#form_distributor_out_model").validate({
    rules: {
        delivery_status: {
            required: true
        },
        delivery_date: {
            required: {
                depends: function() {
                    return ($("#delivery_status").val() == "Delivered Not Complete");
                }
            }
        },
        upload: {
            required: {
                depends: function() {
                    return ($("#delivery_status").val() == "Delivered Not Complete");
                }
            }
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});





$('#form_distributor_out_sku_details').submit(function() {
    removeMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_qty');
    removeMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_no');

    addMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_qty', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_no', { required: true }, "");
    if (!$("#form_distributor_out_sku_details").valid()) {
        return false;
    } else {
        // if (check_product_availablity_for_sku_details()==false) {
            // return false;
        // }

        removeMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_qty');
        removeMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_no');
        
        return true;
    }
});

function test_loop(){
    $('.item_qty').each(function(){
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        var qty = $(this).val();

        console.log(id);

        $('[id^=batch_no_qty_'+index+'_]').each(function(){
            console.log($(this).attr('id'));
        });
    });
}

function check_product_availablity_for_sku_details() {
    var validator = $("#form_distributor_out_sku_details").validate();
    var valid = true;

    $('.item_qty').each(function(){
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        var qty = 0;
        var batch_qty = 0;
        var t_qty = 0;

        t_qty = $(this).val();
        if(!isNaN(t_qty) && t_qty!=''){
            qty = parseInt(t_qty);
        }

        $('[id^=batch_no_qty_'+index+'_]').each(function(){
            t_qty = $(this).val();
            if(!isNaN(t_qty) && t_qty!=''){
                batch_qty = batch_qty + parseInt(t_qty);
            }
        });

        if(qty!=batch_qty){
            var errors = {};
            var name = $('#batch_no_qty_'+index+'_0').attr('name');
            errors[name] = "Total no of qty does not match.";
            validator.showErrors(errors);
            valid = false;
        }

        var sales_id = $("#sales_id_"+index).val();
        var sales_ref_id = $("#sales_ref_id_"+index).val();
        var depot_id = $("#item_depot_"+index).val();
        var item_type = $("#item_type_"+index).val();
        var item_id = $("#item_id_"+index).val();
        var module="distributor_out";

        if(item_type=='Bar'){
            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_bar_availablity_for_depot',
                data: 'id='+sales_id+'&module='+module+'&depot_id='+depot_id+'&product_id='+item_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#batch_no_qty_'+index+'_0').attr('name');
                errors[name] = "Bar not available in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
                data: 'id='+sales_id+'&module='+module+'&depot_id='+depot_id+'&product_id='+item_id+'&qty='+qty+'&ref_id='+sales_ref_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#batch_no_qty_'+index+'_0').attr('name');
                errors[name] = "Bar qty is not enough in selected depot. ";
                validator.showErrors(errors);
                valid = false;
            }
        } else {
            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_box_availablity_for_depot',
                data: 'id='+sales_id+'&module='+module+'&depot_id='+depot_id+'&box_id='+item_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#batch_no_qty_'+index+'_0').attr('name');
                errors[name] = "Box not available in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
                data: 'id='+sales_id+'&module='+module+'&depot_id='+depot_id+'&box_id='+item_id+'&qty='+qty+'&ref_id='+sales_ref_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#batch_no_qty_'+index+'_0').attr('name');
                errors[name] = "Box qty is not enough in selected depot.";
                validator.showErrors(errors);
                valid = false;
            }
        }
        
    });

    return valid;
}






// ----------------- DISTRIBUTOR PO DETAILS FORM VALIDATION -------------------------------------
$("#form_distributor_po_details").validate({
    rules: {
        date_of_po: {
            required: true
        },
        po_expiry_date: {
            required: true
        },
        depot_id: {
            required: true
        },
        delivery_through: {
            required: true
        },
        distributor_id: {
            required: true
        },
        type_id: {
            required: true
        },
        zone_id: {
            required: true
        },
        store_id: {
            required: true
        },
        location_id: {
            required: true
        },
        discount: {
            required: true
        },
        tax: {
            required: true
        },
        tax_per: {
            required: true
        },
        estimate_delivery_date: {
            required: true
        },
        distributor_consignee_id:{
            required: true     
        },
        basis_of_sales: {
            required: true
            
        },
        po_number: {
            required: {
                depends: function() {
                    return (clkBtn!='btn_reject');
                }
            },
            check_po_number_availablity: {
              required: {
                depends: function() {
                        return (clkBtn!='btn_reject');
                    }
                }  
            }
        },
        email_from: {
            required: true,
            checkemail: true
        },
        email_date_time:{
            required: true
        },
        // remarks: {
        //     required: {
        //         depends: function() {
        //             // return (d_status == "Approved");
        //             return ($('#po_invoice_amount').val()!=$('#invoice_amount').val());
        //         }
        //     }
        // },
        delivery_status:{
            required: true     
        },
        // delivery_date: {
            // required: {
            //     depends: function() {
            //         return ($("#delivery_status").val() == "Delivered");
            //     }
            // }
        // },
        delivery_date:{
            required: true     
        },
        delivery_remarks:{
            required: {
                depends: function() {
                    // return ($("#delivery_status").val() == "Delivered");
                    return ($('#po_invoice_amount').val()!=$('#invoice_amount').val());
                }
            }     
        },
        doc_file:{
            required: {
                depends: function() {
                    return ($('#doc_document').val()=="");
                }
            }
        },
        entered_invoice_amount:{
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_po_number_availablity", function (value, element) {
    var result = 1;
	if($("#delivery_through_distributor").is(":checked"))
	// if($("input[name='delivery_through'][value='Distributor']").prop("checked", true)

	{
		url = BASE_URL+'index.php/distributor_po/check_po_number_availablity';
		data ='id='+$("#id").val()+'&po_number='+$("#po_number").val()+'&ref_id='+$("#ref_id").val()
	}
	else
	{
		url = BASE_URL+'index.php/distributor_po/check_po_number_availablity_whpl';
		data ='id='+$("#id").val()+'&order_no='+$("#po_number").val()+'&ref_id='+$("#ref_id").val
	}
	

    $.ajax({
       // url: ()? : BASE_URL+'index.php/distributor_po/check_po_number_availablity_whpl',
     // data: ($("#delivery_through").val()=='Distributor')? 'id='+$("#id").val()+'&po_number='+$("#po_number").val()+'&ref_id='+$("#ref_id").val():'id='+$("#id").val()+'&order_no='+$("#po_number").val()+'&ref_id='+$("#ref_id").val(),
		url: url,
       data: data,
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
			// console.log('result'+result);
			
	//console.log('Distributorssssssssss'+$("#delivery_through").val());
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    // else if($("#delivery_through").val()=='WHPL')
    // {
    	// $.ajax({
            // url: BASE_URL+'index.php/distributor_po/check_po_number_availablity_whpl',
            // data: 'id='+$("#id").val()+'&order_no='+$("#po_number").val()+'&ref_id='+$("#ref_id").val(),
            // type: "POST",
            // dataType: 'html',
            // global: false,
            // async: false,
            // success: function (data) {
                // result = parseInt(data);
            // },
            // error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            // }
        // });
    // }

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Po Number Already in use.');



$("#form_distributor_po_list").validate({
    rules: {    
        delivery_status:{
            required: true     
        },
        delivery_date:{
            required: true     
        },
        person_name:{
            required: true     
        },
        cancellation_date:{
            required: true     
        }
    },    
    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});


function check_po_invoice_amount() {
    var validator = $("#form_distributor_po_details").validate();
    var valid = false;

    // if(parseFloat(get_number($('#entered_invoice_amount').val()))!=parseFloat(get_number($('#invoice_amount').val())))
    // {
    //     var errors = {};
    //     var name = $('#entered_invoice_amount').attr('name');
    //     errors[name] = "Please Enter Correct amount";
    //     validator.showErrors(errors);
    //     valid = false;
    // }
    if($("#modal_result").val()==""){
        $("#mi-modal").modal('show');
    } else if($("#modal_result").val()=="No"){
        valid = false;
    } else {
        valid = true;
    }

    return valid;
}

$('#form_distributor_po_details').submit(function() {
    removeMultiInputNamingRules('#form_distributor_po_details', 'select[alt="type[]"]');
    removeMultiInputNamingRules('#form_distributor_po_details', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_distributor_po_details', 'select[alt="box[]"]');
    removeMultiInputNamingRules('#form_distributor_po_details', 'input[alt="qty[]"]');
    removeMultiInputNamingRules('#form_distributor_po_details', 'input[alt="sell_rate[]"]');

    addMultiInputNamingRules('#form_distributor_po_details', 'select[name="type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_po_details', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_po_details', 'select[name="box[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_po_details', 'input[name="qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_distributor_po_details', 'input[name="sell_rate[]"]', { required: true }, "");
    if (!$("#form_distributor_po_details").valid()) {
        return false;
    } else {
        // if (check_po_invoice_amount()==false) {
        //     return false;
        // }

        removeMultiInputNamingRules('#form_distributor_po_details', 'select[alt="type[]"]');
        removeMultiInputNamingRules('#form_distributor_po_details', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_distributor_po_details', 'select[alt="box[]"]');
        removeMultiInputNamingRules('#form_distributor_po_details', 'input[alt="qty[]"]');
        removeMultiInputNamingRules('#form_distributor_po_details', 'input[alt="sell_rate[]"]');
        
        return true;
    }
});

function StopNonNumeric(el, evt) {
    //var r=e.which?e.which:event.keyCode;
    //return (r>31)&&(r!=46)&&(48>r||r>57)?!1:void 0
    var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    //just one dot (thanks ddlab)
    if(number.length>1 && charCode == 46){
        return false;
    }
    //get the carat position
    var dotPos = el.value.indexOf(".");
    if( dotPos>-1 && (number[1].length > 5)){
        return false;
    }
    return true;
}




// ----------------- STORE DETAILS FORM VALIDATION -------------------------------------
$("#form_store_details").validate({
    rules: {
        zone_id: {
            required: true
        },
        store_id: {
            required: true
        },
        location_id: {
            required: true
        },
        category: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_store_details').submit(function() {
    if (!$("#form_store_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- PRODUCTION DETAILS FORM VALIDATION -------------------------------------
$("#form_production_details").validate({
    rules: {
        p_id: {
            required: true
        },
        from_date: {
            required: true
        },
        to_date: {
            required: true
        },
        manufacturer_id: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_production_details').submit(function() {
    if (!$("#form_production_details").valid()) {
        return false;
    } else {
        return true;
    }
});


// ----------------- CONFIRM DETAILS FORM VALIDATION -------------------------------------
$("#form_confirm_details").validate({
    rules: {
        p_id: {
            required: true
        },
        from_date: {
            required: true
        },
        to_date: {
            required: true
        },
        manufacturer_id: {
            required: true
        },
        confirm_from_date: {
            required: true
        },
        confirm_to_date: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_confirm_details').submit(function() {
    if (!$("#form_confirm_details").valid()) {
        return false;
    } else {
        return true;
    }
});


// ----------------- CONFIRM BATCH FORM VALIDATION -------------------------------------
$("#form_confirm_batch").validate({
    rules: {
        p_id: {
            required: true
        },
        manufacturer_id: {
            required: true
        },
        confirm_from_date: {
            required: true
        },
        confirm_to_date: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_confirm_batch').submit(function() {
    removeMultiInputNamingRules('#form_confirm_batch', 'select[alt="bar[]"]');
    removeMultiInputNamingRules('#form_confirm_batch', 'input[alt="qty[]"]');

    addMultiInputNamingRules('#form_confirm_batch', 'select[name="bar[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_confirm_batch', 'input[name="qty[]"]', { required: true }, "");

    if (!$("#form_confirm_batch").valid()) {
        return false;
    } else {
        if (check_batch()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_confirm_batch', 'select[alt="bar[]"]');
        removeMultiInputNamingRules('#form_confirm_batch', 'input[alt="qty[]"]');
        
        return true;
    }
});

function check_batch() {
    var validator = $("#form_confirm_batch").validate();
    var valid = true;

    if($('.bar').length=='0'){
        var errors = {};
        var name = $('#p_id').attr('name');
        errors[name] = "Please add atleast one item.";
        validator.showErrors(errors);
        valid = false;
    } else {
        $('.bar').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_id = $(this).attr('id');
                var bar = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                $('.bar').each(function(){
                    if ($(this).is(":visible") == true) { 
                        if(bar_id != $(this).attr('id')){
                            if(bar == $(this).val()){
                                var errors = {};
                                var name = $(this).attr('name');
                                errors[name] = "Please select different bar for all records.";
                                validator.showErrors(errors);
                                valid = false;
                            }
                        }
                    }
                });
            }
        });
    }

    return valid;
}




// ----------------- CONFIRM RAW MATERIAL FORM VALIDATION -------------------------------------
$("#form_confirm_raw_material").validate({
    rules: {
        p_id: {
            required: true
        },
        manufacturer_id: {
            required: true
        },
        confirm_from_date: {
            required: true
        },
        confirm_to_date: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_confirm_raw_material').submit(function() {
    removeMultiInputNamingRules('#form_confirm_raw_material', 'select[alt="raw_material[]"]');
    removeMultiInputNamingRules('#form_confirm_raw_material', 'input[alt="required_qty[]"]');
    removeMultiInputNamingRules('#form_confirm_raw_material', 'input[alt="available_qty[]"]');
    removeMultiInputNamingRules('#form_confirm_raw_material', 'input[alt="difference_qty[]"]');

    addMultiInputNamingRules('#form_confirm_raw_material', 'select[name="raw_material[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_confirm_raw_material', 'input[name="required_qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_confirm_raw_material', 'input[name="available_qty[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_confirm_raw_material', 'input[name="difference_qty[]"]', { required: true }, "");

    if (!$("#form_confirm_raw_material").valid()) {
        return false;
    } else {
        removeMultiInputNamingRules('#form_confirm_raw_material', 'select[alt="raw_material[]"]');
        removeMultiInputNamingRules('#form_confirm_raw_material', 'input[alt="required_qty[]"]');
        removeMultiInputNamingRules('#form_confirm_raw_material', 'input[alt="available_qty[]"]');
        removeMultiInputNamingRules('#form_confirm_raw_material', 'input[alt="difference_qty[]"]');
        
        return true;
    }
});




// ----------------- PRELIMINARY DETAILS FORM VALIDATION -------------------------------------
$("#form_preliminary_details").validate({
    rules: {
        email_to: {
            required: true
        },
        email_subject: {
            required: true
        },
        email_body: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_preliminary_details').submit(function() {
    if (!$("#form_preliminary_details").valid()) {
        return false;
    } else {
        return true;
    }
});



// ----------------- TASK FORM VALIDATION -------------------------------------
$("#task_detail").validate({
    rules: {
        subject_detail: {
            required: true
        },
        description: {
            required: true
        },
        assigned: {
            required: true
        },
        priority: {
            required: true
        },
        from_date: {
            required: true
        },
        to_date: {
            required: function(element) {
                        if($("#repeat").val()=="Never"){
                            return false;
                        } else {
                            return true;
                        }
                    }
        },
        repeat: {
            required: true
        },
        periodic_interval: {
            required: function(element) {
                        if($("#repeat").val()=="Periodically"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        weekday: {
            required: function(element) {
                        if($("#repeat").val()=="Weekly"){
                            return ($('input[name*="weekly_interval"]:checked').length <= 0);
                        } else {
                            return false;
                        }
                    }
        },
        monthly_interval: {
            required: function(element) {
                        if($("#repeat").val()=="Monthly"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        monthly_interval2: {
            required: function(element) {
                        if($("#repeat").val()=="Monthly"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("dategreaterthantoday", function(value, element) {
    var cur_date = new Date(new Date().setHours(0, 0, 0, 0));
    var from_date = $('#from_date').val();
    if(from_date.indexOf("/")!=-1){
        var date = from_date.split("/");
        from_date = date[2] + "-" + date[1] + "-" + date[0];
        from_date = new Date(from_date);
        from_date = new Date(from_date.setHours(0, 0, 0, 0));
    }

    // cur_date.setHours(0, 0, 0, 0, 0);
    // from_date.setHours(0, 0, 0, 0, 0);
    return (cur_date<=from_date);

    // return moment(from_date).isAfter(cur_date, 'day');
    
}, "Please enter date greater than or equal to today.");

$.validator.addMethod("dategreaterthanfromdate", function(value, element) {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    if(from_date.indexOf("/")!=-1){
        var date = from_date.split("/");
        from_date = date[2] + "-" + date[1] + "-" + date[0];
        from_date = new Date(from_date);
        from_date = new Date(from_date.setHours(0, 0, 0, 0));
    }
    if(to_date.indexOf("/")!=-1){
        var date = to_date.split("/");
        to_date = date[2] + "-" + date[1] + "-" + date[0];
        to_date = new Date(to_date);
        to_date = new Date(to_date.setHours(0, 0, 0, 0));
    }

    // from_date.setHours(0, 0, 0, 0, 0);
    // to_date.setHours(0, 0, 0, 0, 0);
    return (from_date<=to_date);
}, "Please enter to_date greater than or equal to from_date.");

$('#task_detail').submit(function() {
    if (!$("#task_detail").valid()) {
        return false;
    } else {
        return true;
    }
});


function checkstock_out(){
    var validator = $("#form_distributor_in_details").validate();
    var valid = true;
    var depot_id = $("#prev_depo").val();
    if(depot_id=='')
    {
        depot_id = $("#depot_id").val();
    }
    var distributor_id = $("#distributor_id").val();
    var sales_rep_id = $("#sales_rep_id").val();
    var ref_id = $("#ref_id").val();
    var module="distributor_out";
    if($('#exchanged').is(':checked')==true)
    {
        $('.bar_ex').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var bar_ex_id = $(this).attr('id');
                var bar_ex = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;

                /*if(btn_val=='Approve') {*/
                    var result = 1;

                    $.ajax({
                        url: BASE_URL+'index.php/Stock/check_bar_availablity_for_depot',
                        data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+bar_ex,
                        type: "POST",
                        dataType: 'html',
                        global: false,
                        async: false,
                        success: function (data) {
                            result = parseInt(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });

                    if (result) {
                        var id = "bar_ex_"+index;
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = "bar_ex not available in selected depot.";
                        validator.showErrors(errors);
                        valid = false;
                    }

                    result = 1;

                    $.ajax({
                        url: BASE_URL+'index.php/Stock/check_bar_qty_availablity_for_depot',
                        data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+bar_ex+'&qty='+qty+'&ref_id='+ref_id,
                        type: "POST",
                        dataType: 'html',
                        global: false,
                        async: false,
                        success: function (data) {
                            result = parseInt(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });

                    if (result) {
                        var id = "qty_ex_"+index;
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = "bar_ex qty is not enough in selected depot.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                /*}*/
            }
        });

        $('.box_ex').each(function(){
            if ($(this).is(":visible") == true) { 
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var box_id = $(this).attr('id');
                var box = $(this).val();
                var qty = parseFloat(get_number($('#qty_'+index).val()));
                if (isNaN(qty)) qty=0;
                /*if(btn_val=='Approve') {*/
                    var result = 1;

                    $.ajax({
                        url: BASE_URL+'index.php/Stock/check_box_availablity_for_depot',
                        data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box,
                        type: "POST",
                        dataType: 'html',
                        global: false,
                        async: false,
                        success: function (data) {
                            result = parseInt(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });

                    if (result) {
                        var id = "bar_ex_"+index;
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = "Box not available in selected depot.";
                        validator.showErrors(errors);
                        valid = false;
                    }

                    result = 1;

                    $.ajax({
                        url: BASE_URL+'index.php/Stock/check_box_qty_availablity_for_depot',
                        data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+$("#depot_id").val()+'&box_id='+box+'&qty='+qty+'&ref_id='+ref_id,
                        type: "POST",
                        dataType: 'html',
                        global: false,
                        async: false,
                        success: function (data) {
                            result = parseInt(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });

                    if (result) {
                        var id = "qty_ex_"+index;
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = "Box qty is not enough in selected depot.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                /*}*/
            }
        });  
    }
    
    return valid;
}

function checkbox_qty() {
    var validator = $("#form_box_to_bar_details").validate();
    var valid = true;
    var depot_id = $("#prev_depo").val();
    if(depot_id=='')
    {
        depot_id = $("#depot_id").val();
    }

    $('.total_bar_qty').each(function(){
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        var available_qty = $(this).val();
        var bal_qty = $('#bal_bar_qty_'+index).val();
        if(bal_qty=='')
        {
            if(available_qty<0)
            {
                var id = "total_bar_qty_"+index;
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Stock Can Not Be Negative";
                validator.showErrors(errors);
                valid = false;
            }
        }
        else
        {    
            if(bal_qty<0)
            {
                var id = "bal_bar_qty_"+index;
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Stock Can Not Be Negative";
                validator.showErrors(errors);
                valid = false;
            }
        }

    });
    
    return valid;
}




// ----------------- RAW MATERIAL RECON FORM VALIDATION -------------------------------------
$("#form_raw_material_recon_details").validate({
    rules: {
        date_of_processing: {
            required: true
        },
        depot_id: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_raw_material_recon_details').submit(function() {
    removeMultiInputNamingRules('#form_raw_material_recon_details', 'select[alt="raw_material_id[]"]');
    removeMultiInputNamingRules('#form_raw_material_recon_details', 'input[alt="physical_qty[]"]');

    addMultiInputNamingRules('#form_raw_material_recon_details', 'select[name="raw_material_id[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_raw_material_recon_details', 'input[name="physical_qty[]"]', { required: true }, "");
    if (!$("#form_raw_material_recon_details").valid()) {
        return false;
    } else {

        removeMultiInputNamingRules('#form_raw_material_recon_details', 'select[alt="raw_material_id[]"]');
        removeMultiInputNamingRules('#form_raw_material_recon_details', 'input[alt="physical_qty[]"]');

        return true;
    }
});




// ----------------- BEAT MASTER FORM VALIDATION -------------------------------------
$("#form_beat_master").validate({
    rules: {
        beat_id: {
            required: true
        },
        beat_name: {
            required: true,
            check_beat_name_availablity: true
        },
        type_id: {
            required: true
        },
        zone_id: {
            required: true
        },
        'location_id[]': {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_beat_name_availablity", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/beat_master/check_beat_name_availablity',
        data: 'id='+$("#id").val()+'&beat_name='+$("#beat_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Beat Name already in use.');

$('#form_beat_master').submit(function() {
    // removeMultiInputNamingRules('#form_beat_master', 'input[alt="sequence[]"]');
    // addMultiInputNamingRules('#form_beat_master', 'input[name="sequence[]"]', { required: true }, "");
    if (!$("#form_beat_master").valid()) {
        return false;
    } else {
        // removeMultiInputNamingRules('#form_beat_master', 'input[alt="sequence[]"]');
        return true;
    }
});




// ----------------- BEAT DISTRIBUTOR FORM VALIDATION -------------------------------------
$("#form_beat_distributor").validate({
    rules: {
        beat_id: {
            required: true
        },
        'distributor_id[]': {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_beat_distributor').submit(function() {
    if (!$("#form_beat_distributor").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- BEAT ALLOCATION FORM VALIDATION -------------------------------------
$("#form_beat_allocation").validate({
    rules: {
        type_id: {
            required: true
        },
        sales_rep_id: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_beat_allocation').submit(function() {
    // removeMultiInputNamingRules('#form_beat_allocation', 'input[alt="weekday_id[]"]');
    // removeMultiInputNamingRules('#form_beat_allocation', 'input[alt="weekday[]"]');
    removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="frequency[]"]');
    removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="dist_id1[]"]');
    removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="beat_id1[]"]');
    removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="dist_id2[]"]');
    removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="beat_id2[]"]');

    // addMultiInputNamingRules('#form_beat_allocation', 'input[name="weekday_id[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_beat_allocation', 'input[name="weekday[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_beat_allocation', 'select[name="frequency[]"]', 
                                { required: function(elem) {
                                        var id = elem.id;
                                        var index = id.substring(id.lastIndexOf('_')+1);
                                        if($("#dist_id1_"+index).val()!="" || $("#beat_id1_"+index).val()!="") {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    } 
                                }, "");
    addMultiInputNamingRules('#form_beat_allocation', 'select[name="dist_id1[]"]', 
                                { required: function(elem) {
                                        var id = elem.id;
                                        var index = id.substring(id.lastIndexOf('_')+1);
                                        if($("#frequency_"+index).val()!="" || $("#beat_id1_"+index).val()!="") {
                                            return true;
                                        } else {
                                            return false;
                                        } 
                                    } 
                                }, "");
    addMultiInputNamingRules('#form_beat_allocation', 'select[name="beat_id1[]"]', 
                                { required: function(elem) {
                                        var id = elem.id;
                                        var index = id.substring(id.lastIndexOf('_')+1);
                                        if($("#frequency_"+index).val()!="" || $("#dist_id1_"+index).val()!="") {
                                            return true;
                                        } else {
                                            return false;
                                        } 
                                    } 
                                }, "");
    addMultiInputNamingRules('#form_beat_allocation', 'select[name="dist_id2[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_beat_allocation', 'select[name="beat_id2[]"]', { required: true }, "");

    if (!$("#form_beat_allocation").valid()) {
        return false;
    } else {

        var validator = $("#form_beat_allocation").validate();
        var valid = true;

        if($("#frequency_0").val()=="" && $("#frequency_1").val()=="" && $("#frequency_2").val()=="" && 
           $("#frequency_3").val()=="" && $("#frequency_4").val()=="" && $("#frequency_5").val()=="") {
                var id = "sales_rep_id";
                var errors = {};
                var name = $("#"+id).attr('name');
                errors[name] = "Please add atleast one plan";
                validator.showErrors(errors);
                valid = false;
        }

        // removeMultiInputNamingRules('#form_beat_allocation', 'input[alt="weekday_id[]"]');
        // removeMultiInputNamingRules('#form_beat_allocation', 'input[alt="weekday[]"]');
        removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="frequency[]"]');
        removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="dist_id1[]"]');
        removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="beat_id1[]"]');
        removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="dist_id2[]"]');
        removeMultiInputNamingRules('#form_beat_allocation', 'select[alt="beat_id2[]"]');

        return valid;
    }
});




// ----------------- Sales Rep Attendance FORM VALIDATION -------------------------------------
$("#form_sales_rep_attendance_details").validate({
    rules: {
        check_in_date: {
            required: true
        },
        sales_rep_id: {
            required: true
        },
        check_in_time: {
            required: true
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_sales_rep_attendance_details').submit(function() {
    if (!$("#form_sales_rep_attendance_details").valid()) {
        return false;
    } else {
        return true;
    }
});





// ----------------- Beat Plan Upload FORM VALIDATION -------------------------------------
$("#form_beat_plan_upload").validate({
    rules: {
        upload: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_beat_plan_upload').submit(function() {
    if (!$("#form_beat_plan_upload").valid()) {
        return false;
    } else {
        return true;
    }
});





// ----------------- REPORT MASTER FORM VALIDATION -------------------------------------
$("#form_report_master").validate({
    rules: {
        report_name: {
            required: true
        },
        sender_name: {
            required: true
        },
        from_email: {
            required: true
        },
        to_email: {
            required: true
        },
        cc_email: {
            required: true
        },
        bcc_email: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_report_master').submit(function() {
    if (!$("#form_report_master").valid()) {
        return false;
    } else {
        return true;
    }
});