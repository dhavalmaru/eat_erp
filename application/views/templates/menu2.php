<div class="panel-control-left">
		<ul id="slide-out-left" class="side-nav collapsible"  data-collapsible="accordion">
			<li class="author">
				<img src="<?php echo base_url().'img/icons/default_avatar.png';?>"    alt="">
				<div class="desc">
					<h5><?php if (isset($userdata['login_name'])) {echo $userdata['login_name'];} ?></h5>
					<span><?php if (isset($userdata['user_name'])) {echo $userdata['user_name'];} ?></span>
				</div>
			</li>
			<li>
				<a href="<?php echo  base_url().'index.php/Dashboard_sales_rep'; ?>"><i class="fa fa-home"></i>Home</a>
			</li>
					<li <?php if ($Sales_Rep_Distributors==0) echo 'style="display: none;"'; else if(isset($type) && $type=="Promoter") echo 'style="display:none;"'; ?>>
						  <a href="<?php echo  base_url().'index.php/Sales_rep_store_plan'; ?>" class="menu--link" title="">
							<i class="menu--icon  fa fa-fw fa-map-marker"></i>
							<span class="menu--label">Visit</span>
						  </a>
						</li>

						<li <?php if ($Sales_Rep_Distributors!=0 || $Sales_Rep_Location==0) echo 'style="display: none;"'; else if(isset($type) && $type=="Promoter") echo 'style="display:none;"'; ?>>
						  <a href="<?php echo  base_url().'index.php/Merchandiser_location'; ?>" class="menu--link" title="">
							<i class="menu--icon  fa fa-fw fa-map-marker"></i>
							<span class="menu--label">Visit</span>
						  </a>
						</li>

						<li   <?php if ($Sales_Rep_Route_Plan==0) echo 'style="display: none;"'; else if(isset($type) && $type=="Promoter") echo 'style="display:none;"'; ?>>
						  <a href="<?php echo  base_url().'index.php/Sales_rep_route_plan'; ?>" class="menu--link" title="">
							<i class="menu--icon  fa fa-fw fa-globe"></i>
							<span class="menu--label">Route Plan</span>
						  </a>
						</li>

						<li <?php if ($Sales_Rep_Distributors==0) echo 'style="display: none;"'; ?>>
						  <a href="<?php echo  base_url().'index.php/Sales_rep_distributor'; ?>" class="menu--link" title="">
							<i class="menu--icon  fa fa-fw fa-group"></i>
							<span class="menu--label">Retailers</span>
						  </a>
						</li>

						<li  <?php if ($Sales_Rep_Orders==0) echo 'style="display: none;"'; ?>>
						  <a href="<?php echo  base_url().'index.php/Sales_rep_order'; ?>" class="menu--link" title="">
							<i class="menu--icon  fa fa-fw fa-shopping-cart"></i>
							<span class="menu--label">Orders</span>
						  </a>
						</li>
						<li>
						  <a href="<?php echo base_url();?>index.php/login/logout" class="menu--link" title="">
							<i class="menu--icon  fa fa-sign-out"></i>
							<span class="menu--label">Logout</span>
						  </a>
						</li>
		</ul>
	</div>