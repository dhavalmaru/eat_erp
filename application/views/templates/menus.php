
<link href="<?php echo base_url().'mobile-menu/vertical/demo.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'mobile-menu/vertical/vertical-responsive-menu.min.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'css/responsive.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'css/logout/popModal.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'css/select2/css/select2.min.css'; ?>" rel="stylesheet">
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="all-ie-only.css" />
<![endif]-->
<!--[if lt IE 9]>
<script src="dist/html5shiv.js"></script>
<![endif]-->

<style type="text/css">
    body {
        scrollbar-base-color: #222;
        scrollbar-3dlight-color: #222;
        scrollbar-highlight-color: #222;
        scrollbar-track-color: #3e3e42;
        scrollbar-arrow-color: #111;
        scrollbar-shadow-color: #222;
        scrollbar-dark-shadow-color: #222; 
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .form-control { padding:6px!important; z-index:999999;}
    body{ overflow:initial; }
    .fonts {
        font-size:35px; 
        text-align: center;
        width: 60px;
        line-height: 48px;
    }
    .x-navigation {overflow-x: hidden;}
    .x-navigation li > a .fa, .x-navigation li > a .glyphicon  {font-size: 20px;}
    .left-menu {  }
    /*.left-menu li{ padding-left:25px!important; }*/

    .left-menu li .fa{ font-size: 16px!important; padding-right:15px; }
    .left-menu li .glyphicon { font-size: 16px!important; padding-right:15px;  }
    .left-menu li .glyphicon { font-size: 16px!important; }
    .left-menu li:hover{ background: #23303b!important;}
    .scroller .x-navigation ul li { display: inline-block!important; visibility: visible!important; }
    .x-navigation.x-navigation-horizontal { float:none!important; left: 0;  position: fixed; overflow:hidden; }
    .x-navigation { float: none!important }
    .menu-wrapper { 
        top:61px;
    /* background-image: -webkit-linear-gradient(bottom, #008161 0%, #2F5F5B 23%, #343347 100%);
    background-image: linear-gradient(to top, #008161 0%, #2F5F5B 23%, #343347 100%);*/
    background-image: linear-gradient(to top, #05131f 0%, #13202c 23%, #33414e 100%);
    }
    .menu-wrapper ul { background: none!important }
    .menu { background: none!important }
    #ng-toggle {
        position: fixed;
    }
    .menu-wrapper ul li a span {opacity: 1;}
    .menu-wrapper .menu--faq {
        position: absolute;  
        left: 0;     text-shadow: 0px 1px 1px #000;
        bottom: 0;  line-height: 50px;
        z-index: 99999;
        width: 240px; 
    }
    .menu--faq  li { font-size: 1rem; }
    .gn-icon .icon-fontello:before {
        font-size: 20px;
        line-height: 50px;
        width: 50px;
    }
    .fa-sign-out {   }

    #edit{  display: inline-block; padding: 0 5px; cursor:pointer;    }
    .text-info { color:#fff!important; display: inline-block; line-height: 20px; }
    .grp_change{ display: none; }
    .menu-wrapper .scroller {
        position: absolute;
        overflow-y: scroll;
        width: 240px;
        height:80%;
    }

    .header-fixed-style {  width: 100%;  height: 61px; left:0;   position: fixed;  /*background: #33414e!important;*/ background:#245478!important;   z-index: 999; display:block;   }
    .logo-container { width:200px;  float:left; background:#fff; text-align:center; padding:6px 0;}
    .useremail-container {width:300px; float:left;}
    .useremail-container a { font-size:18px; color:#fff; padding:15px 10px; display: block;}
    .dropdown-selector { width:35%; float:right;   display:block; tex-align:right;}
    .dropdown-selector-left    { font-size:18px; color:#fff; padding:10px 19px;  display: block; float:right;     text-align: right;}
    .useremail-login { font-size:12px; color:#fff; display: block;}
    .useremail-login:hover{color:#fff; } 
    .logout-section { float:right; display:block;  }
    .logout-section a { color:#fff; font-size:25px;  padding:13px 15px;  display: block;  float:left; border-left:1px solid #0d3553;  }
    .logout-section a:hover { background:#0d3553!important; color:#fff;}

    ::-webkit-scrollbar {
        width: 0.5em;
        height: 0.5em;
    }
    ::-webkit-scrollbar-button:start:decrement,
    ::-webkit-scrollbar-button:end:increment  {
        display: none;
    }
    ::-webkit-scrollbar-track-piece  {
        background-color: #ccc;
        -webkit-border-radius:0px;
    }
    ::-webkit-scrollbar-thumb:vertical {
        -webkit-border-radius:0px;
        background: #072c48 ;
    }
    ::-webkit-scrollbar-thumb:horizontal {
        -webkit-border-radius:0px;
        background: #072c48;
    }
    ::-webkit-scrollbar-track, 
    ::-moz-scrollbar-track, 
    ::-o-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        -o-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius:0px;
        background-color: #F5F5F5;
    } 

    .vertical_nav .bottom-menu-fixed {
        /*bottom: 0!important;*/
        position: absolute;
        /* top: initial!important; */background:#245478!important;      border-top: 1px solid #0d3553;
        top:84.2%!important;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style-type: none;
        /* max-height: 329px; */
        z-index: 0;
    }

    .toggle_menu {
        display: none;
    }

    @media only screen and (max-width: 991px){
        .toggle_menu {
            display: block;
            float: left;
            padding:16px 10px; 
            color: #fff; cursor:pointer;
        }
    }

    @media screen and (max-width:320px) {.vertical_nav .bottom-menu-fixed {  top: 79.2%!important;} }
    @media only screen and (min-width:321px) and (max-width:360px) {.vertical_nav .bottom-menu-fixed {  top: 82.2%!important;}  }

    /*---------- Modal CSS ----------------*/
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 999; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    #cover 
    {
        background: url("<?php echo base_url();?>img/loader.gif") no-repeat scroll center center #FFF;
        position: absolute;
        height: 100%;
        width: 100%;
    }
</style>    

<div class="header-fixed-style">
    <!-- START X-NAVIGATION VERTICAL -->
    <div class="logo-container">  
        <a class="gn-icon-menu " href="<?php $sales_rep_id=$this->session->userdata('sales_rep_id');
                                        $type=$this->session->userdata('type');
                                        if(isset($sales_rep_id) && $sales_rep_id<>""){
                                          if(isset($type) && $type=="Promoter") {
                                            echo base_url().'index.php/Dashboard_promoter';
                                          }
                                          else {
                                            echo base_url().'index.php/Dashboard_sales_rep';
                                          }
                                        } else {
                                           if(!isset($Dashboard)) echo base_url().'index.php/Dashboard/Dashboardscreen';
                                           else if ($Dashboard==0) echo base_url().'index.php/Dashboard/Dashboardscreen';
                                           else echo base_url().'index.php/Dashboard';
                                        }
                                        // echo base_url().'index.php/dashboard'; 
                                        ?>"> 
            <img height="50" style=" "   src="<?php echo base_url().'img//eat-logo.png';?>" />  
        </a>
        <button id="collapse_menu" class="collapse_menu"></button>
    </div>
    <h2 class="production_dashboard" style="text-align:left; display:none;color:#fff">&nbsp &nbsp Production Dashboard</h2>
	
 
  <div class="toggle_menu"  id="toggleMenu">  <i class="fa fa-arrows-alt" aria-hidden="true"></i> </div>
  <div class="dropdown-selector">
    <div class="logout-section">
      <!-- <a class=" " id="confirmModal_ex1"  data-confirmmodal-bind="#confirm_content" data-topoffset="0" href="#"> 
        <i class="fa fa-cog" aria-hidden="true"></i><span class="xn-text"> </span>
      </a> -->
      <a class="mb-control" data-box="#message-box-success" href="#"> 
        <i class="fa fa-cog" aria-hidden="true"></i><span class="xn-text"> </span>
      </a>
      <!-- <button type="button" class="btn btn-success mb-control" data-box="#message-box-success">Success</button> -->

      <a href="#" id="confirmModal_ex2" class="top-sign" data-confirmmodal-bind="#confirm_content1">
        <span class="fa fa-sign-out"></span>
      </a>    
    </div>
    <div class="dropdown-selector-left">
      <span class="xn-text  text-info"><?php if (isset($userdata['login_name'])) {echo $userdata['login_name'];} ?></span> 
      <span class="useremail-login"  >
        <span class="xn-text">Logged in as <?php if (isset($userdata['user_name'])) {echo $userdata['user_name'];} ?>
        </span> 
      </span> 
    </div>
  </div>
</div>

 
<nav class="vertical_nav vertical_nav__minify">
    <ul id="js-menu" class="menu mCustomScrollbar"> 
        <li class="menu--item  menu--item__has_sub_menu"  <?php if ($Masters==0) echo 'style="display: none;"'; ?>>          
            <label class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-indent"></i>
                <span class="menu--label">Masters</span>
            </label>   

            <ul class="sub_menu new-menu">
               <li class="menu--item  menu--item__has_sub_menu1 main-submenu-1"   > 
                    <span class="menu--label">Product</span>  
                </li>
            
                <ul class="sub_menu menu--item__has_sub_menu-1">
                    <li class="sub_menu--item" <?php if ($Vendors==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Vendor'; ?>"   class="sub_menu--link"> Vendor</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Depot==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Depot'; ?>" class="sub_menu--link">Depot</a>
                    </li>
                    <li class="sub_menu--item"  <?php if ($Raw_Material==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Raw_material'; ?>" class="sub_menu--link"> Raw Material</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Batch_Processing==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Batch_master'; ?>"   class="sub_menu--link">  Batch Master</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Product==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Category'; ?>"   class="sub_menu--link"> Category</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Product==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Product'; ?>" class="sub_menu--link">Product</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Box==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Box'; ?>" class="sub_menu--link">Box</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Box==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Combo_box'; ?>" class="sub_menu--link">Combo Box</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Ingredient_Master==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/ingredients_master'; ?>" class="sub_menu--link">Recipe Master</a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-2"   > 
                    <span class="menu--label">Sales</span>  
                </li>
            
                <ul class="sub_menu menu--item__has_sub_menu-2"> 
                    <li class="sub_menu--item" <?php if ($Tax==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Tax_master'; ?>" class="sub_menu--link">Tax</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Sales_Rep==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Sales_rep'; ?>" class="sub_menu--link">Sales Representative</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor'; ?>" class="sub_menu--link">Distributor/Retailer</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Type==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor_type'; ?>" class="sub_menu--link">Distributor Type</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Zone==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Zone'; ?>" class="sub_menu--link">Zone</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Area==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Area'; ?>" class="sub_menu--link">Area</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Area==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Location'; ?>" class="sub_menu--link">Location</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Sales_Rep==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Sr_mapping/'; ?>" class="sub_menu--link">SR Mapping</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Type==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/relationship'; ?>" class="sub_menu--link">Relationship Master</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Type==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/store'; ?>" class="sub_menu--link">Stores Master</a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-3"   > 
                    <span class="menu--label">Global</span>  
                </li>
            
                <ul class="sub_menu menu--item__has_sub_menu-3"> 
                    <li class="sub_menu--item" <?php if ($City_Master==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Pincode_master'; ?>" class="sub_menu--link"> Pincode Master</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($City_Master==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/City_master'; ?>" class="sub_menu--link"> City Master</a>
                    </li>
                    <li  class="sub_menu--item" <?php if ($Bank_Master==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Bank'; ?>" class="sub_menu--link">  Bank Master</a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-5" <?php if ( $Distributor_Type==0) echo 'style="display: none;"'; ?>> 
                    <span class="menu--label">Beat Plan</span>  
                </li>

                <ul class="sub_menu menu--item__has_sub_menu-5"> 
                    <li class="sub_menu--item" >
                        <a href="<?php echo base_url().'index.php/Beat_master'; ?>" class="sub_menu--link"> Beat Master </a>
                    </li>
                    <li class="sub_menu--item" >
                        <a href="<?php echo base_url().'index.php/Beat_distributor'; ?>" class="sub_menu--link"> Beat Distributor </a>
                    </li>
                    <li class="sub_menu--item" >
                        <a href="<?php echo base_url().'index.php/Beat_allocation'; ?>" class="sub_menu--link"> Assign Beat </a>
                    </li>
                    <li class="sub_menu--item" >
                        <a href="<?php echo base_url().'index.php/Merchandiser_beat_plan'; ?>" class="sub_menu--link"> Upload Merchendizer </a>
                    </li>
                    <li class="sub_menu--item" >
                        <a href="<?php echo base_url().'index.php/Merchandiser_beat_plan/change_admin_sequence'; ?>" class="sub_menu--link"> Merchendizer Beat Plan </a>
                    </li>
                    <li class="sub_menu--item" >
                        <a href="<?php echo base_url().'index.php/Sales_rep_beat_plan'; ?>" class="sub_menu--link"> Upload SR Beat Plan</a>
                    </li>
                    <li  class="sub_menu--item">
                        <a href="<?php echo base_url().'index.php/sales_rep/change_admin_sequence'; ?>" class="sub_menu--link">SR Beat Plan</a>
                    </li>
                </ul>  

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-4"   > 
                    <span class="menu--label">Accounting</span>  
                </li>
            
                <ul class="sub_menu menu--item__has_sub_menu-4"> 
                    <li class="sub_menu--item" <?php if ($Vendors==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Vendor_type'; ?>"   class="sub_menu--link"> Vendor Type</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Credit_Debit_Note==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Exp_cat_master'; ?>" class="sub_menu--link"> 
                            Expense Category Master
                        </a>
                    </li>
                </ul>


                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-6" <?php if ($Reports==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/report_master'; ?>" class="sub_menu--link"> Report Master</a>
                </li>
            </ul>
        </li>

        <li class="menu--item  menu--item__has_sub_menu"  <?php if ($Transactions==0) echo 'style="display: none;"'; ?>>
            <label class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-rupee"></i>
                <span class="menu--label">Transaction</span>
            </label>

            <ul class="sub_menu new-menu"> 
                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-1"   > 
                    <span class="menu--label">Production</span>  
                </li>
                <ul class="sub_menu menu--item__has_sub_menu-1">
                    <li  class="sub_menu--item" <?php if ($Purchase_Order==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/production'; ?>"> Pre Production</a>
                    </li>
                    <li  class="sub_menu--item" <?php if ($Purchase_Order==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/production/post'; ?>"> Post Production</a>
                    </li>
                    <li  class="sub_menu--item" <?php if ($Purchase_Order==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Purchase_order'; ?>"> Purchase Order</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Raw_Material_In==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Raw_material_in'; ?>" class="sub_menu--link">Raw Material In</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Batch_Processing==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Batch_processing'; ?>" class="sub_menu--link">  Batch Processing</a>
                    </li> 
                    <li class="sub_menu--item" <?php if ($Purchase_Order==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Raw_material_recon'; ?>" class="sub_menu--link"> Raw Material Recon</a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-2"   > 
                    <span class="menu--label">Sales</span>  
                </li>
                <ul class="sub_menu menu--item__has_sub_menu-2">
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Order'; ?>" class="sub_menu--link"> Secondary Sales </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor_po'; ?>" class="sub_menu--link"> Distributor PO </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor_out'; ?>" class="sub_menu--link"> Sales </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Sample_out'; ?>" class="sub_menu--link"> Sample / Expiry </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor_out/product_expired'; ?>" class="sub_menu--link"> Product Expired </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_In==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor_in'; ?>" class="sub_menu--link"> Sales Return</a>
                    </li>
                    <li  class="sub_menu--item" <?php if ($this->session->userdata('role_id')!=1) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/freezed'; ?>">End of Month Sales</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Sales_upload'; ?>" class="sub_menu--link"> Sales Upload </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($this->session->userdata('role_id')!=1) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Sales_return_upload'; ?>" class="sub_menu--link"> Sales Return Upload </a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Shopify'; ?>" class="sub_menu--link"> Shopify Upload </a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-3"> 
                    <span class="menu--label">Allocations </span>
                </li>
                <ul class="sub_menu menu--item__has_sub_menu-3">
                    <li  class="sub_menu--item" <?php if ($Distributor_Sale==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Distributor_sale'; ?>">Super Stockist Sale</a>
                    </li>
                    <li  class="sub_menu--item" <?php if ($Distributor_Sale==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Distributor_sale_in'; ?>">Super Stockist Return</a>
                    </li>
                    <li  class="sub_menu--item" <?php if ($Distributor_Sale==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/sales_rep_store_plan/add_stock'; ?>">Add Stock Details</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Distributor_Transfer==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Distributor_transfer'; ?>" class="sub_menu--link">Distributor Transfer</a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-4"> 
                    <span class="menu--label">Bank </span>
                </li>
                <ul class="sub_menu menu--item__has_sub_menu-4">
                    <li  class="sub_menu--item"  <?php if ($Payment==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Payment'; ?>"> Payment Details</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Credit_Debit_Note==0) echo 'style="display: none;"'; ?>>
                        <a  class="sub_menu--link" href="<?php echo base_url().'index.php/Credit_debit_note'; ?>"> Credit Debit Note</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Payment==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Payment_upload'; ?>"> Payment Upload</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Payment==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Order/sodexo'; ?>"> Sodexo Details</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Payment==0) echo 'style="display: none;"'; ?>>
                        <a class="sub_menu--link" href="<?php echo base_url().'index.php/Order/sodexo_upload_files'; ?>"> Sodexo Upload Files</a>
                    </li>
                </ul>

                <li class="menu--item  menu--item__has_sub_menu1 main-submenu-5" <?php if ($Transfer==0) echo 'style="display: none;"'; ?>> 
                    <span class="menu--label">Transfer</span>
                </li> 
                <ul class="sub_menu menu--item__has_sub_menu-5 ">
                    <li class="sub_menu--item" <?php if ($Depot_Transfer==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Depot_transfer'; ?>" class="sub_menu--link"> Depot Transfer</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Bar_To_Box==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Bar_to_box'; ?>" class="sub_menu--link">Bar To Box</a>
                    </li>
                    <li class="sub_menu--item" <?php if ($Depot_Transfer==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Raw_material_in_out'; ?>" class="sub_menu--link"> Raw Material IN/OUT</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Box_To_Bar==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Box_to_bar'; ?>" class="sub_menu--link"> Box To Bar</a>
                    </li>
                    <li  class="sub_menu--item"  <?php if ($Bar_To_Box==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/Bar_to_bar'; ?>" class="sub_menu--link">Bar To Bar</a>
                    </li>
                </ul>
            </ul>
        </li>

        <!-- <li class="menu--item menu--item__has_sub_menu" <?php //if ($accounting==0) echo 'style="display: none;"'; ?>>
          <label class="menu--link" title="">
            <i class="menu--icon  fa fa-fw fa-money"></i>
            <span class="menu--label">Accounting</span>
          </label>
          <ul class="sub_menu">
            <li class="sub_menu--item" <?php //if ($Acc_Group==0) echo 'style="display: none;"'; ?>>
              <a href="<?php //echo base_url().'index.php/AccountGroup'; ?>" class="sub_menu--link"> Group Master</a>
            </li>
            <li class="sub_menu--item" <?php //if ($Acc_Ledger==0) echo 'style="display: none;"'; ?>>
              <a href="<?php //echo base_url().'index.php/AccountLedger'; ?>" class="sub_menu--link"> Ledger Master</a>
            </li>
          </ul>
        </li> -->
       
        <li class="menu--item menu--item__has_sub_menu" <?php if ($Settings==0) echo 'style="display: none;"'; ?>>
            <label class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-gear"></i>
                <span class="menu--label">Users</span>
            </label>
            <ul class="sub_menu">
                <li class="sub_menu--item" <?php if ($User==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/User'; ?>" class="sub_menu--link"> User</a>
                </li>
                <li class="sub_menu--item" <?php if ($User_Roles==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/User_roles'; ?>" class="sub_menu--link"> User Roles</a>
                </li>
            </ul>
        </li>

        <li class="menu--item menu--item__has_sub_menu" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
            <label class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-bullseye"></i>
                <span class="menu--label">Sales Rep</span>
            </label>
            <ul class="sub_menu">
                <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/Sales_rep_target'; ?>" class="sub_menu--link"> Sales Rep Target</a>
                </li>
                <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/Sales_rep_attendance'; ?>" class="sub_menu--link"> Attendance</a>
                </li>
            </ul>
        </li>

        <li class="menu--item menu--item__has_sub_menu" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
            <label class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-upload"></i>
                <span class="menu--label">PDF Upload</span>
            </label>
            <ul class="sub_menu">
                <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/Asin_master'; ?>" class="sub_menu--link"> ASIN Master</a>
                </li>
                <li class="sub_menu--item" <?php if ($Distributor_Out==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url().'index.php/Pdf_upload'; ?>" class="sub_menu--link"> PDF Upload</a>
                </li>
            </ul>
        </li>

        <!-- <li class="menu--item"  <?php //if ($Sales_Rep_Target==0) echo 'style="display: none;"'; ?>>
            <a href="<?php //echo  base_url().'index.php/Sales_rep_target'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-bullseye"></i>
                <span class="menu--label">Sales Rep Target</span>
            </a>
        </li> -->

        <li class="menu--item"  <?php if ($Reports==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Reports/view_reports'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-bar-chart-o"></i>
                <span class="menu--label">Report</span>
            </a>
        </li>

        <li class="menu--item"  <?php if ($Sales_Rep_Area==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Sales_rep_area'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-road"></i>
                <span class="menu--label">Area</span>
            </a>
        </li>

        <li class="menu--item"  <?php if ($Sales_Rep_Location==0) echo 'style="display: none;"'; else if(isset($type) && $type=="Promoter") echo 'style="display:none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Sales_rep_location'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-map-marker"></i>
                <span class="menu--label">Visit</span>
            </a>
        </li>

        <li class="menu--item"  <?php if ($Sales_Rep_Route_Plan==0) echo 'style="display: none;"'; else if(isset($type) && $type=="Promoter") echo 'style="display:none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Sales_rep_route_plan'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-globe"></i>
                <span class="menu--label">Route Plan</span>
            </a>
        </li>

        <li class="menu--item"  <?php if ($Sales_Rep_Distributors==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Sales_rep_distributor'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-group"></i>
                <span class="menu--label">Retailers</span>
            </a>
        </li>

        <li class="menu--item"  <?php if ($Sales_Rep_Orders==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Sales_rep_order'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-shopping-cart"></i>
                <span class="menu--label">Orders</span>
            </a>
        </li>

        <li class="menu--item"  <?php if ($Sales_Rep_Payment_Receivables==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo  base_url().'index.php/Sales_rep_payment_receivable'; ?>" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-money"></i>
                <span class="menu--label">Payment Receivables</span>
            </a>
        </li>

        <!-- <li class="menu--item menu--item__has_sub_menu">
          <label class="menu--link" title="">
            <i class="menu--icon  fa fa-fw fa-gear"></i>
            <a href="<?php //echo base_url();?>index.php/Eat_Attendence" class="menu--link" title="">Attendance</a>
          </label>
          <ul class="sub_menu">
            <li class="sub_menu--item">
              <a href="<?php //echo base_url();?>index.php/attendance" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-money"></i>
                <span class="menu--label">Upload</span>
              </a>
            </li>
            <li class="sub_menu--item">
              <a href="<?php //echo base_url();?>index.php/attendance/map" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-money"></i>
                <span class="menu--label">Map</span>
              </a>
            </li>
            <li class="sub_menu--item">
              <a href="<?php //echo base_url();?>index.php/attendance/approve" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-money"></i>
                <span class="menu--label">Approve</span>
              </a>
            </li>
          </ul>
        </li> -->
        
        <li class="menu--item" >
            <a href="<?php echo base_url();?>index.php/Eat_Attendence" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-gear"></i>
                <span class="menu--label">Eat Attendance</span>
            </a>
        </li>

        <li class="menu--item" >
            <a href="<?php echo base_url();?>index.php/Task" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-gear"></i>
                <span class="menu--label">Task</span>
            </a>
        </li>

        <li class="menu--item" >
            <a href="<?php echo base_url();?>index.php/payment_voucher" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-money"></i>
                <span class="menu--label">Payment Voucher</span>
            </a>
        </li>

        <li class="menu--item" <?php if ($Log==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url();?>index.php/Log" class="menu--link" title="">
                <i class="menu--icon  fa fa-fw fa-pencil-square-o"></i>
                <span class="menu--label">Log</span>
            </a>
        </li>

    </ul>
</nav>

<script type="text/javascript" src="<?php echo base_url().'mobile-menu/vertical/jquery-3.1.0.min.js';?>"></script>                
<script type="text/javascript" src="<?php echo base_url().'mobile-menu/vertical/vertical-responsive-menu.min.js';?>"></script>  

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
    $('.menu--item menu--item__has_sub_menu').click(function() { 
        $('.menu--subitens__opened').slideToggle(200);  
        $('.menu--item__has_sub_menu-2,  .menu--item__has_sub_menu-3, .menu--item__has_sub_menu-4, .menu--item__has_sub_menu-5').hide(200); 
        return false;
    });
    $('.menu--item__has_sub_menu-1, .menu--item__has_sub_menu-2, .menu--item__has_sub_menu-3, .menu--item__has_sub_menu-4, .menu--item__has_sub_menu-5').hide(); 
    $('.main-submenu-1').click(function() {  
        $('.menu--item__has_sub_menu-1').slideToggle(200);  
        $(this).toggleClass('special');  
        $('.main-submenu-4, .main-submenu-3, .main-submenu-2, .menu--item__has_sub_menu-5').removeClass( "special" );
        $('.menu--item__has_sub_menu-2,  .menu--item__has_sub_menu-3, .menu--item__has_sub_menu-4, .menu--item__has_sub_menu-5').hide(200); 
        return false;
    });
    $('.main-submenu-2').click(function() { 
        $('.menu--item__has_sub_menu-2').slideToggle(200);  
        $(this).toggleClass('special');  
        $('.main-submenu-1, .main-submenu-3, .main-submenu-4, .main-submenu-5').removeClass( "special" );
        $('.menu--item__has_sub_menu-1,   .menu--item__has_sub_menu-3, .menu--item__has_sub_menu-4, .menu--item__has_sub_menu-5').hide(200); 
        return false;
    });
    $('.main-submenu-3').click(function() { 
        $('.menu--item__has_sub_menu-3').slideToggle(200); 
        $(this).toggleClass('special'); 
        $('.main-submenu-2, .main-submenu-4, .main-submenu-1, .main-submenu-5').removeClass( "special" );
        $('.menu--item__has_sub_menu-1,   .menu--item__has_sub_menu-2, .menu--item__has_sub_menu-4, .menu--item__has_sub_menu-5').hide(200); 
        return false;
    });
    $('.main-submenu-4').click(function() { 
        $('.menu--item__has_sub_menu-4').slideToggle(200); 
        $(this).toggleClass('special'); 
        $('.main-submenu-3, .main-submenu-2, .main-submenu-1, .main-submenu-5').removeClass( "special" );
        $('.menu--item__has_sub_menu-1,   .menu--item__has_sub_menu-2, .menu--item__has_sub_menu-3, .menu--item__has_sub_menu-5').hide(200); 
        return false;
    });
    $('.main-submenu-5').click(function() { 

        $('.menu--item__has_sub_menu-5').slideToggle(200); 
        $(this).toggleClass('special'); 
        $('.main-submenu-3, .main-submenu-2, .main-submenu-1, .main-submenu-4').removeClass( "special" );
        $('.menu--item__has_sub_menu-1,   .menu--item__has_sub_menu-2, .menu--item__has_sub_menu-3, .menu--item__has_sub_menu-4').hide(200); 
        return false;
    });
</script>


<script>
    $('body').append('<div id="cover"></div>');
    var start = new Date();
    var ajaxTime= new Date().getTime();
    $(window).on('load', function(){
        setTimeout(removeLoader, 1000); //wait for page load PLUS two seconds.
        // $('body').html(new Date() - start); 
    });

    function removeLoader(){
        var totaltime = (new Date().getTime()-ajaxTime)/ 1000;
        $( "#cover" ).fadeOut(500, function() {
            // fadeOut complete. Remove the loading div
            $( "#cover" ).remove(); //makes page more lightweight 

            var pathName = window.location.href;
            // alert(pathName);
            $.ajax({
                type: "POST",
                url:'<?=base_url()?>index.php/Loading_screen_log/',
                data: {loadtime:totaltime,url:pathName}
            }).done(function () {
                // Here I want to get the how long it took to load some.php and use it further
            });
        });
    }
</script>