<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
  header,
main,
footer {
  padding-left: 240px;
}

body {
  backgroud: white;
}

@media only screen and (max-width: 992px) {
  header,
  main,
  footer {
    padding-left: 0;
  }
}

#credits li,
#credits li a {
  color: white;
}

#credits li a {
  font-weight: bold;
}

.footer-copyright .container,
.footer-copyright .container a {
  color: #BCC2E2;
}

.fab-tip {
  position: fixed;
  right: 85px;
  padding: 0px 0.5rem;
  text-align: right;
  background-color: #323232;
  border-radius: 2px;
  color: #FFF;
  width: auto;
}

.carousel .carousel-item {
  width: 100%;
}

  </style>
</head>

<body>

  <ul id="slide-out" class="side-nav fixed z-depth-2">
    <li class="center no-padding">
      <div class="indigo darken-2 white-text" style="height: 180px;">
        <div class="row">
          <img style="margin-top: 5%;" width="100" height="100" src="https://res.cloudinary.com/dacg0wegv/image/upload/t_media_lib_thumb/v1463990208/photo_dkkrxc.png" class="circle responsive-img" />

          <p style="margin-top: -13%;">
            Tirth Patel
          </p>
        </div>
      </div>
    </li>

    <li id="dash_dashboard"><a class="waves-effect" href="#!"><b>Dashboard</b></a></li>

    <ul class="collapsible" data-collapsible="accordion">
      <li id="dash_users">
        <div id="dash_users_header" class="collapsible-header waves-effect"><b>Users</b></div>
        <div id="dash_users_body" class="collapsible-body">
          <ul>
            <li id="users_seller">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Seller</a>
            </li>

            <li id="users_customer">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Customer</a>
            </li>
          </ul>
        </div>
      </li>

      <li id="dash_products">
        <div id="dash_products_header" class="collapsible-header waves-effect"><b>Products</b></div>
        <div id="dash_products_body" class="collapsible-body">
          <ul>
            <li id="products_product">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Products</a>
              <a class="waves-effect" style="text-decoration: none;" href="#!">Orders</a>
            </li>
          </ul>
        </div>
      </li>

      <li id="dash_categories">
        <div id="dash_categories_header" class="collapsible-header waves-effect"><b>Categories</b></div>
        <div id="dash_categories_body" class="collapsible-body">
          <ul>
            <li id="categories_category">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Category</a>
            </li>

            <li id="categories_sub_category">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Sub Category</a>
            </li>
          </ul>
        </div>
      </li>

      <li id="dash_brands">
        <div id="dash_brands_header" class="collapsible-header waves-effect"><b>Brands</b></div>
        <div id="dash_brands_body" class="collapsible-body">
          <ul>
            <li id="brands_brand">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Brand</a>
            </li>

            <li id="brands_sub_brand">
              <a class="waves-effect" style="text-decoration: none;" href="#!">Sub Brand</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </ul>

  <header>
    <ul class="dropdown-content" id="user_dropdown">
      <li><a class="indigo-text" href="#!">Profile</a></li>
      <li><a class="indigo-text" href="#!">Logout</a></li>
    </ul>

    <nav class="indigo" role="navigation">
      <div class="nav-wrapper">
        <a data-activates="slide-out" class="button-collapse show-on-" href="#!"><img style="margin-top: 17px; margin-left: 5px;" src="https://res.cloudinary.com/dacg0wegv/image/upload/t_media_lib_thumb/v1463989873/smaller-main-logo_3_bm40iv.gif" /></a>

        <ul class="right hide-on-med-and-down">
          <li>
            <a class='right dropdown-button' href='' data-activates='user_dropdown'><i class=' material-icons'>account_circle</i></a>
          </li>
        </ul>

        <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </nav>

    <nav>
      <div class="nav-wrapper  indigo darken-2">
		<ul id="tabs-swipe-demo" class="tabs indigo darken-2">
			<li class="tab col s3"><a href="#test-swipe-1"><i class="material-icons">home</i></a></li>
			<li class="tab col s3"><a class="active" href="#test-swipe-2"><i class="material-icons">place</i></a></li>
			<li class="tab col s3"><a href="#test-swipe-3"><i class="material-icons">group</i></a></li>
			<li class="tab col s3"><a href="#test-swipe-3"><i class="material-icons">shopping_cart</i></a></li>
			<li class="tab col s3"><a href="#test-swipe-3"><i class="material-icons">public</i></a></li>
		</ul>

        <div style="margin-right: 20px;" id="timestamp" class="right"></div>
      </div>
    </nav>
  </header>

  <main>
   

    <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
      <a class="btn-floating  pink waves-effect waves-light">
        <i class=" material-icons">add</i>
      </a>

      <ul>
        <li>
          <a class="btn-floating red"><i class="material-icons">note_add</i></a>
          <a href="" class="btn-floating fab-tip">Add a note</a>
        </li>

        <li>
          <a class="btn-floating yellow darken-1"><i class="material-icons">add_a_photo</i></a>
          <a href="" class="btn-floating fab-tip">Add a photo</a>
        </li>

        <li>
          <a class="btn-floating green"><i class="material-icons">alarm_add</i></a>
          <a href="" class="btn-floating fab-tip">Add an alarm</a>
        </li>

        <li>
          <a class="btn-floating blue"><i class="material-icons">vpn_key</i></a>
          <a href="" class="btn-floating fab-tip">Add a master password</a>
        </li>
      </ul>
    </div>
	

  <div id="test-swipe-1" class="col s12">
  
   <div class="row">
		<div class="col s12">
			<div class="row">
				<div style="padding: 10px;" align="center" class="">
					<a class="btn-floating btn-large waves-effect waves-light violet" align="center"><i class="material-icons"> AP</i></a>
         
				</div>
			</div>
			<div class="row">
				<div class="center card-title">
				<b>Web Developer</b>
				</div>
			</div>
		</div>
	</div>
    <div class="row">
      <div class="col s6">
        <div style="padding: 35px;" align="center" class="">
        

          <div class="row">
          <a class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">place</i></a>
         
          </div>
		  
		   <div class="row">
            <div class="center card-title">
              <b>Visit</b>
            </div>
          </div>
        </div>
      </div>

	<div class="col s6">
        <div style="padding: 35px;" align="center" class="">
          

          <div class="row">
          <a class="btn-floating btn-large waves-effect waves-light pink "><i class="material-icons">public</i></a>
          </div>
		  <div class="row">
            <div class="center card-title">
              <b>Route plan</b>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
    <div class="col s6">
        <div style="padding: 35px;" align="center" class="">
          

          <div class="row">
          <a class="btn-floating btn-large waves-effect waves-light violet"><i class="material-icons">group</i></a>
         
          </div>
		  
		  <div class="row">
            <div class="center card-title">
              <b>Retailers</b>
            </div>
          </div>
        </div>
      </div>


     <div class="col s6">
        <div style="padding: 35px;" align="center" class="">
          

          <div class="row">
          <a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">shopping_cart</i></a>
         
          </div>
		  <div class="row">
            <div class="center card-title">
              <b>Orders</b>
            </div>
          </div>
        </div>
      </div>

    </div>

            
  
  </div>
  <div id="test-swipe-2" class="col s12 red">
     <ul class="collection">
	<li class="collection-item avatar">
      <i class="material-icons circle">folder</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
    <li class="collection-item avatar">
     
      <span class="title">ddddd dddddddddddddd dddddddddd dddddd dddddddd</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"> <i class="material-icons circle">folder</i></a>
    </li>
    <li class="collection-item avatar">
      <i class="material-icons circle green">insert_chart</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
    </li>
    <li class="collection-item avatar">
      <i class="material-icons circle red">play_arrow</i>
      <span class="title">Title</span>
      <p>First Line <br>
         Second Line
      </p>
      <a href="#!" class="secondary-content waves-effect waves-light  btn">button</a></a>
    </li>
  </ul>
  </div>
  <div id="test-swipe-3" class="col s12 green">
 <div class="collection">
    <a href="#!" class="collection-item"><span class="badge">1</span>Alan</a>
    <a href="#!" class="collection-item"><span class="new badge">4</span>Alan</a>
    <a href="#!" class="collection-item">Alan</a>
    <a href="#!" class="collection-item"><span class="badge">14</span>Alan</a>
  </div>
            

</div>
  </main>

 
  
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>

  <script>
   

  $(document).ready(function(){
    $('.tabs').tabs({
  swipeable: true,
  //responsiveThreshold: Infinity
});
});

        
  $('.button-collapse').sideNav();

$('.collapsible').collapsible();

$('select').material_select();
  </script>
</body>

</html>