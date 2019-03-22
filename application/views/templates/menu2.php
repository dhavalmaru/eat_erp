<div class="panel-control-left">
		<ul id="slide-out-left" class="side-nav collapsible"  data-collapsible="accordion">
			<li class="author">
				<img src="<?php echo base_url().'img/icons/default_avatar.png';?>"    alt="">
				<div class="desc">
					<h5><?php if (isset($userdata['login_name'])) {echo $userdata['login_name'];} ?></h5>
					<span><?php if (isset($userdata['user_name'])) {echo $userdata['user_name'];} ?></span>
				</div>
			</li>
			<li id="home">
				<a   href="<?php echo  base_url().'index.php/Dashboard_sales_rep'; ?>"><i class="fa fa-home"></i>Home</a>
			</li>
					
						
						<li>
						  <a  class="menu--link" title="">
						  	<?php
						  	 // $check_in_time = $this->session->userdata('check_in_time');
						  	 // $check_out_time = $this->session->userdata('check_out_time');

						  	$check_in_time = null;
				  	 		$check_out_time = null;
				  	 		
						  	if(isset($attendancedata)){
						  		if(count($attendancedata)>0){
						  			$check_in_time = $attendancedata[0]->check_in_time;
						  	 		$check_out_time = $attendancedata[0]->check_out_time;
						  		}
						  	}
						  	
						  	 
						  	if($check_in_time!=null)
						  	{
						  		$now = date("Y-m-d");
						  		$s_checkin = date("Y-m-d",strtotime($check_in_time));
						  		$h_checkin = date("h:i A",strtotime($check_in_time));

						  		if($now!=$s_checkin)
						  		{
						  			$check = '00:00';
						  		}
						  		else
						  		{
						  			$check = $h_checkin ;
						  		}
						  	}
						  	else
						  	{
						  		$check = ' 00:00';
						  	}

						  	if($check_out_time!=null)
						  	{
						  		$now = date("Y-m-d");
						  		$s_checkout = date("Y-m-d",strtotime($check_out_time));
						  		$h_checkout = date("h:i A",strtotime($check_out_time));

						  		if($now!=$s_checkout)
						  		{
						  			$check_out = '00:00';
						  		}
						  		else
						  		{
						  			$check_out = $h_checkout ;
						  		}
						  	}
						  	else
						  	{
						  		$check_out = ' 00:00';
						  	}

						  	?>
							<span class="menu--label">Check In Time (<?=$check?>)</span>
						  </a>
						</li>
						
						<li>
						  <a class="menu--link" title="">
						
							<span class="menu--label">Check Out Time (<?=$check_out?>)</span>
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