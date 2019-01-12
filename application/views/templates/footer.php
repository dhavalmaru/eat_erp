<style type="text/css">
  @media only screen and  (min-width:280px)  and (max-width:991px) {  
	.form-horizontal .mb-content .col-md-12 { float: none;  }
}
.form-horizontal .mb-content { text-align: left!important;     font-size: 12px;  }
.form-horizontal .control-label { text-align: left!important;     font-size: 12px;       }
</style>

<div id="confirm_content1" style="display:none">
	<div class="logout-containerr">
		<button type="button" class="close" data-confirmmodal-but="cancel">×</button>
		<div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Log <strong>Out</strong> ? </div>
		<div class="confirmModal_content">
			<p>Are you sure you want to log out?</p>                    
			<p>Press No if you want to continue work. Press Yes to logout current user.</p>
		</div>
		<div class="confirmModal_footer">
			<a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a>
			<button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">No</button>
		</div>
	</div>
</div>


<!-- <form id="form_change_password" role="form" class="form-horizontal" method="post" action="<?php //echo base_url().'index.php/login/change_password'; ?>"> -->
	<!-- <div id="confirm_content" style="display:none">
		<button type="button" class="close" data-confirmmodal-but="cancel">×</button>
		<div class="confirmModal_header">  <span>  Change password </span>  </div>

		<div class="confirmModal_content">
			<div class=" "  >
				<div class="col-md-12">
					<label class="control-label">Password *</label>
					<div class=" ">
						<input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" value=""/>
					</div>
				</div>
				<div class="col-md-12 ">
					<label class="control-label">New Password *</label>
					<div >
						<input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value=""/>
					</div>
				</div>
				<div class="col-md-12 ">
					<label class=" control-label">Confirm Password *</label>
					<div class="  ">
						<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" value=""/>
					</div>
				</div>
				<div class="col-md-12 ">
					<label class="error" id="form_error_label">HIII</label>
				</div>
				<br clear="all"/>
			</div>
		</div>

		<div class="confirmModal_footer">
			<button type="button" class="btn btn-success "  type="submit" data-confirmmodal-but="ok">Submit</button>
			<button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">Cancel</button>
		</div>
	</div> -->
<!-- </form> -->
<!-- END MESSAGE BOX-->

<!-- success -->
<div class="message-box message-box-success animated fadeIn" id="message-box-success">
	<form id="form_change_password" role="form" class="form-horizontal" method="post" action="">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-check"></span> Change password </div>
            <div class="mb-content">
            	 
                <div class="col-md-12" >
					<div class="col-md-12">
						<label class="control-label">Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" value=""/>
						</div>
					</div>
					<div class="col-md-12 ">
						<label class="control-label">New Password *</label>
						<div >
							<input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value=""/>
						</div>
					</div>
					<div class="col-md-12 ">
						<label class=" control-label">Confirm Password *</label>
						<div class="  ">
							<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" value=""/>
						</div>
					</div>
				</div>
				 
            </div>
            <div class="mb-footer">
            	<a class="btn btn-success pull-left" id="btn_change_password" href="javascript:void(0);">Submit</a>
            	<!-- <button class="btn pull-left" id="btn_change_password">Submit</button> -->
                <button class="btn btn-danger pull-right mb-control-close">Close</button>
            </div>
        </div>
    </div>
    </form>
</div>
<!-- end success -->


        <!-- START PRELOADS -->
       
        <!-- END PRELOADS -->               

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
		
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
<!--<script type="text/javascript" src="<?php //echo base_url(); ?>js/jquery-ui-1.11.2/jquery-ui-timepicker-addon.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
    
        <!-- END PLUGINS -->                

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/demo_tables.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-select.js"></script>
		<script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/validationengine/languages/jquery.validationEngine-en.js'></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/validationengine/jquery.validationEngine.js'></script>
		<script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/jquery-validation/jquery.validate.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tagsinput/jquery.tagsinput.min.js"></script>		               
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/datatables/jquery.dataTables.min.js"></script>  
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/tableExport.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jquery.base64.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/html2canvas.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/jspdf.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/tableexport/jspdf/libs/base64.js"></script>
        <!-- END PAGE PLUGINS -->

        <!-- START TEMPLATE -->
                
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>
        <!-- END TEMPLATE -->

 
		<!--<script src="<?php //echo base_url('js/jquery-ui-1.11.2/jquery-ui.min1.js'); ?>"></script>-->
	<script src="<?php echo base_url('js/jquery-ui-1.11.2/jquery-ui.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'js/jquery.cookie.js';?>"></script>  
		     <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
		     <script type="text/javascript" src="<?php echo base_url(); ?>build/js/bootstrap-datetimepicker.min.js"></script>
		<script>
		$(document).ready(function() {
			$('#collapse_menu').click(function() {
				//alert('hi');
				if($('.vertical_nav').hasClass('vertical_nav__minify')) {
					//alert('hi');
					$.cookie("menu","open");
					$('.mCustomScrollBox').css('overflow','hidden');
					//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
				} else {
					$.cookie("menu","open");
					$('.mCustomScrollBox').css('overflow','hidden');
					//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
				}
			}); 
		});

		$(document).ready(function() {
			if($.cookie("menu")==="open") {
				$('.vertical_nav').removeClass('vertical_nav__minify');
				$('.wrapper').removeClass('wrapper__minify');
				//alert('if');
			} else {
				$('.vertical_nav').removeClass('vertical_nav__minify');
				$('.wrapper').removeClass('wrapper__minify');
				// alert('else');
			}
		});
		</script>
		
		<script>
    		$(document).ready(function() {
    			$("form").attr("autocomplete", "Off");
                // $("input[name='submit']").prop("disabled",true);
                $(".save-form").prop("disabled",true);
    		});

            $("form :input").change(function() {
                $(".save-form").prop("disabled",false);
            });
			
			$('.datepicker').attr('readonly','true');
			$('.datepicker1').attr('readonly','true');
    	</script>

        <script>
        var table;
        $(document).ready(function() {
            //var oTable;
            //oTable=$("#customers2").DataTable({"bPaginate": true});
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

   //          var settings = table.fnSettings();
			// var oldDisplayLength = settings._iDisplayLength;
			// settings._iDisplayLength = -1;
			// table.fnDraw();
			// settings._iDisplayLength = oldDisplayLength;
			// table.fnDraw();
			table.DataTable(tableOptions);
            
            $("#csv").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'csv',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });
            
            $("#xls").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'excel',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });



            $("#txt").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'txt',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });
            $("#doc").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'doc',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });
            $("#powerpoint").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'powerpoint',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });
            $("#png").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'png',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });

               $("#pdf").click(function(){
                table.DataTable().destroy();
                tableOptions.bPaginate = false;
                table.DataTable(tableOptions);
                table.tableExport({type:'pdf',escape:'false'});
                table.DataTable().destroy();
                tableOptions.bPaginate = true;
                table.DataTable(tableOptions);
            });

            //var oTable;
            //oTable=$("#customers3").DataTable({"bPaginate": true});
            table =  $('#customers3');
            var tableOptions = {
                'bPaginate': true,
                'iDisplayLength': 10,
                aLengthMenu: [
                    [10,25, 50, 100, 200, -1],
                    [10,25, 50, 100, 200, "All"]
                ],
            };
            table.DataTable(tableOptions);
            
            table =  $('#customers4');
            var tableOptions = {
                'bPaginate': true,
                'iDisplayLength': 10,
                aLengthMenu: [
                    [10,25, 50, 100, 200, -1],
                    [10,25, 50, 100, 200, "All"]
                ],
            };
            table.DataTable(tableOptions);
            
        });
        </script>
    <script src="<?php echo base_url(); ?>css/logout/popModal.js"></script>     
   
<script>
$(function(){
	$('#popModal_ex1').click(function(){
		$('#popModal_ex1').popModal({
			html : $('#content'),
			placement : 'bottomLeft',
			showCloseBut : true,
			onDocumentClickClose : true,
			onDocumentClickClosePrevent : '',
			overflowContent : false,
			inline : true,
			asMenu : false,
			beforeLoadingContent : 'Please, wait...',
			onOkBut : function() {},
			onCancelBut : function() {},
			onLoad : function() {},
			onClose : function() {}
		});
	});
		
	$('#popModal_ex2').click(function(){
		$('#popModal_ex2').popModal({
			html : function(callback) {
				$.ajax({url:'ajax.html'}).done(function(content){
					callback(content);
				});
			}
		});
	});
	
	$('#popModal_ex3').click(function(){
		$('#popModal_ex3').popModal({
			html : $('#content3'),
			placement : 'bottomLeft',
			asMenu : true
		});
	});
	
	$('#notifyModal_ex1').click(function(){
		$('#content2').notifyModal({
			duration : 2500,
			placement : 'center',
			overlay : true,
			type : 'notify',
			onClose : function() {}
		});
	});
	
	$('#dialogModal_ex1').click(function(){
		$('.dialog_content').dialogModal({
			topOffset: 0,
			top: '10%',
			type: '',
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function(el, current) {},
			onClose: function() {},
			onChange: function(el, current) {
				if(current == 3){
					el.find('.dialogModal_header span').text('Page 3');
					$.ajax({url:'ajax.html'}).done(function(content){
						el.find('.dialogModal_content').html(content);
					});
				}
			}
		});
	});
	
	$('#confirmModal_ex').click(function(){
		$('#confirm_content1').confirmModal({
			topOffset: 0,
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function() {},
			onClose: function() {}
		});
	});
	
	
	/* tab */
(function($) {
	$.fn.tab = function(method){
	
		var methods = {
			init : function(params) {

				$('.tab').click(function() {
					var curPage = $(this).attr('data-tab');
					$(this).parent().find('> .tab').each(function(){
						$(this).removeClass('active');
					});
					$(this).parent().find('+ .page_container > .page').each(function(){
						$(this).removeClass('active');
					});
					$(this).addClass('active');
					$('.page[data-page="' + curPage + '"]').addClass('active');
				});
			
			}
		};

		if (methods[method]) {
			return methods[method].apply( this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		}
		
	};
	$('html').tab();
	
})(jQuery);
	
});
</script>   


<script>
	$(document).ready(function() { 
		// ----------------- CHANGE PASSWORD FORM VALIDATION -------------------------------------
		$("#form_change_password").validate({
		    rules: {
		        old_password: {
		            required: true,
		            minlength: 6,
		            maxlength: 10,
		            check_old_password: true
		        },
		        new_password: {
		            required: true,
		            minlength: 6,
		            maxlength: 10
		        },
		        confirm_new_password: {
		            required: true,
		            minlength: 6,
		            maxlength: 10,
	    			equalTo: "#new_password"
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

		$.validator.addMethod("check_old_password", function (value, element) {
		    var result = 1;

		    $.ajax({
		        url: '<?php echo base_url();?>index.php/Login/check_old_password',
		        data: 'password='+$("#old_password").val(),
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
		        return true;
		    } else {
		        return false;
		    }
		}, 'Old Password does not match.');

		$('#form_change_password').submit(function() {
		    console.log("submit");
		    if (!$("#form_change_password").valid()) {
		        return false;
		    } else {
		        return true;
		    }
		});

		$('#btn_change_password').on('click', function (e) {
		    if (!$("#form_change_password").valid()) {
		        return false;
		    } else {

		    	var result = 1;

			    $.ajax({
			        url: '<?php echo base_url();?>index.php/Login/change_password',
			        data: 'new_password='+$("#new_password").val(),
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

			    if(result==1) {
			    	alert("Password changed successfully.")
			    	$(this).parents(".message-box").removeClass("open");
       				return true;
			    } else {
			    	return false;
			    }
		    }
		});
	}); 
	
</script>
<script type="text/javascript" src="<?php echo base_url().'css/select2/js/select2.full.min.js';?>"></script>     
	<script>
    		$(document).ready(function() 
			{
				 $('.select2').select2();
    		
            });
			
			
    	</script>


<script type="text/javascript">
	var d_status = "<?php if(isset($data[0]->status)){ echo $data[0]->status;}?>";
	
</script>