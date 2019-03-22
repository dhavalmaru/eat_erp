<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Task_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase_Order' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_user_list(){
	$sql="select * from user_master where status = 'Approved' order by first_name, id";
	$query=$this->db->query($sql);
	return $query->result();
}

function getUsers($user_id){
	$this->db->select('cm.id, concat_ws(" ",cm.first_name,cm.last_name) name, concat_ws("-",cm.email_id,cm.mobile) as name2 ');
	$this->db->from(' user_master cm ');
	$this->db->where('cm.id = '.$user_id.' ');
	$this->db->order_by('cm.first_name asc, cm.id asc');
	$result=$this->db->get();
	$dataarray=array();
	$i=0;
	foreach($result->result() as $row){			
            $dataarray= array('value' => $row->id , 'label' => $row->name . ' - ' . $row->name2);
        }
	return $dataarray;
}

function testFormData($form_data) {
	$newArray=array();
	//print_r($form_data);

	$subject_detail=$form_data['subject_detail'];
	$description=$form_data['description'];
	$priority=$form_data['priority'];
	$from_time=$form_data['from_time'];
	$to_time=$form_data['to_time'];
	$repeat=$form_data['repeat'];
	$interval2=$form_data['monthly_interval2'];
	// $property=$form_data['property'];
	// $owner_name=$form_data['owner_name'];

	if($form_data['repeat']=='Weekly'){
		//print_r($form_data['weekly_interval']);
		$interval=implode(',',$form_data['weekly_interval']);
	}elseif($form_data['repeat']=='Periodically'){
		$interval=$form_data['periodic_interval'];
	}elseif($form_data['repeat']=='Monthly'){
		$interval=$form_data['monthly_interval'];
	}else{
		$interval='';
	}

	if(isset($form_data['self_assigned'])){
		if($form_data['self_assigned'] =='self'){
		$assign_to=$this->session->userdata('session_id');
		}else{
			$assign_to=$form_data['assigned'];
		}
	}else{
		$assign_to=$form_data['assigned'];
	}

	$from_date = FormatDate($form_data['from_date']);
	$to_date = FormatDate($form_data['to_date']);
	$due_date = FormatDate($form_data['from_date']);
	$cur_date = date('Y-m-d');
	$week_index=0;

	while($due_date<=$to_date) {
		// echo $due_date . ' ';

		if($due_date>=$cur_date) {
			// echo 'Insert ';
		}

		if($repeat=="Never") {
			break;
		} else if($repeat=="Daily") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+1 days"));
		} else if($repeat=="Periodically") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+".$interval." days"));
		} else if($repeat=="Weekly") {
			$week_day="";

			if (isset($form_data['weekly_interval'][$week_index])) {
				$week_day=$form_data['weekly_interval'][$week_index];
				$week_index=$week_index+1;
				if (! isset($form_data['weekly_interval'][$week_index])) {
					$week_index=0;
				}
			}

			if($week_day=="Mon") $week_day="monday";
			else if($week_day=="Tue") $week_day="tuesday";
			else if($week_day=="Wed") $week_day="wednesday";
			else if($week_day=="Thu") $week_day="thursday";
			else if($week_day=="Fri") $week_day="friday";
			else if($week_day=="Sat") $week_day="saturday";
			else if($week_day=="Sun") $week_day="sunday";

			// echo $week_day;

			if($week_day!=''){
				$date = new DateTime($due_date);
				$date->modify('next ' . $week_day);
				$due_date = $date->format('Y-m-d');
			}

		} else if($repeat=="Monthly") {
			$date = explode('-',$due_date);
			$due_date = $date[0] . '-' . strval(intval($date[1])+intval($interval)) . '-' . $interval2;
			$d = DateTime::createFromFormat("Y-m-d", $due_date);
			$due_date = strval($d->format('Y-m-d'));
		} else if($repeat=="Yearly") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+1 years"));
		}
	}
}

function get_contact_details($id){
	$sql="select * from user_master where id = '$id' order by first_name, id";
	$query=$this->db->query($sql);
	return $query->result();
}

function get_task_list_table($subject, $assigned_to, $priority, $repeat, $from_date, $to_date, $status) {
    $table='';
    $table='<div>
            <table style="border-collapse: collapse; border: 1px solid black;">
                <thead>
                    <tr>
                        <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                        <th style="padding:5px; border: 1px solid black;" width="100">Task Name</th>
                        <th style="padding:5px; border: 1px solid black;" width="100">Assigned To</th>
                        <th style="padding:5px; border: 1px solid black;" width="90">Priority</th>
                        <th style="padding:5px; border: 1px solid black;" width="90">Frequency</th>
                        <th style="padding:5px; border: 1px solid black;" width="90">From Date</th>
                        <th style="padding:5px; border: 1px solid black;" width="90">To Date</th>
                        <th style="padding:5px; border: 1px solid black;" width="50">Status</th>
                    </tr>
                </thead>
                <tbody>';

    $table=$table.'<tr>
                    <td style="padding:5px; border: 1px solid black;">1</td>
                    <td style="padding:5px; border: 1px solid black;">'.$subject.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$assigned_to.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$priority.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$repeat.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$from_date.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$to_date.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$status.'</td>
                </tr>';

    $table=$table.'</tbody></table></div>';

    // echo $table;
    return $table;
}

function insertDetails($form_data) {
	$newArray=array();
	//print_r($form_data);

	$subject_detail=$form_data['subject_detail'];
	$description=$form_data['description'];
	$task_status=$form_data['task_status'];
	$priority=$form_data['priority'];
	$from_time=$form_data['from_time'];
	$to_time=$form_data['to_time'];
	$repeat=$form_data['repeat'];
	$interval2=$form_data['monthly_interval2'];
	// $property=$form_data['property'];
	// $sub_property=$form_data['sub_property'];
	// $owner_name=$form_data['owner_name'];
	$follower=$form_data['follower'];

	if($form_data['repeat']=='Weekly'){
		//print_r($form_data['weekly_interval']);
		$interval=implode(',',$form_data['weekly_interval']);
	} else if($form_data['repeat']=='Periodically'){
		$interval=$form_data['periodic_interval'];
	} else if($form_data['repeat']=='Monthly'){
		$interval=$form_data['monthly_interval'];
	} else {
		$interval='';
	}

	$contact = array();

	if(isset($form_data['self_assigned'])){
		if($form_data['self_assigned'] =='self'){
			$contact[count($contact)]=$this->session->userdata('session_id');
		}
	}

	$contact_id=$form_data['contact'];
	for($i=0; $i<count($contact_id); $i++){
		if($contact_id[$i]!=null && $contact_id[$i]!=''){
			$contact[count($contact)]=$contact_id[$i];
		}
	}

	$from_date = FormatDate($form_data['from_date']);
	$to_date = FormatDate($form_data['to_date']);
	$due_date = date('Y-m-d');
	$cur_date = date('Y-m-d');

	if($repeat=="Weekly") {
		$week_day="";

		if (isset($form_data['weekly_interval'][$week_index])) {
			$week_day=$form_data['weekly_interval'][$week_index];
			$week_index=$week_index+1;
			if (! isset($form_data['weekly_interval'][$week_index])) {
				$week_index=0;
			}
		}

		if($week_day=="Mon") $week_day="monday";
		else if($week_day=="Tue") $week_day="tuesday";
		else if($week_day=="Wed") $week_day="wednesday";
		else if($week_day=="Thu") $week_day="thursday";
		else if($week_day=="Fri") $week_day="friday";
		else if($week_day=="Sat") $week_day="saturday";
		else if($week_day=="Sun") $week_day="sunday";

		if($week_day!=''){
			$date = new DateTime($due_date);
			$date->modify('next ' . $week_day);
			$due_date = $date->format('Y-m-d');
		}
	} else if($repeat=="Monthly") {
		$date = explode('-',$due_date);
		$due_date = $date[0] . '-' . strval(intval($date[1])+intval($interval)) . '-' . $interval2;
		$d = DateTime::createFromFormat("Y-m-d", $due_date);
		$due_date = strval($d->format('Y-m-d'));
	}

	if($form_data['task_id'] == '' || $form_data['task_id'] == null){
		$insertArray=array(
			'task' => $form_data['subject_detail']
		);
		$this->db->insert('user_task_id',$insertArray);
		$task_id=$this->db->insert_id();
	} else {
		$task_id=$form_data['task_id'];

		$this->db->query("delete from user_task_detail where task_id='$task_id' and due_date>='$cur_date'");
	}

	$week_index=0;

	while($due_date<=$to_date) {
		if($due_date>=$cur_date) {
			for($i=0; $i<count($contact); $i++) {
				$assign_to=$contact[$i];
				$insertArray=array(
								'user_id' =>$assign_to,
								'task_id' =>$task_id,
								'subject_detail' => $subject_detail,
								'message_detail' => $description,
								'task_status' => $task_status,
								'priority' => $priority,
								'from_date' => $from_date,
								'from_time' => $from_time,
								'to_date' => $to_date,
								'to_time' => $to_time,
								'due_date' => $due_date,
								'repeat_status' => $repeat,
								'period_interval'=>$interval,
								'monthly_repeat'=>$interval2,
								'status'=>'1',
								// 'property_id'=>$property,
								// 'sub_property_id'=>$sub_property,
								// 'owner_id'=>$owner_name,
								'maker_remark'=>$form_data['maker_remark']
							);

				$query=$this->db->query("select * from user_task_detail where task_id='$task_id' and due_date='$due_date' and user_id='$assign_to'");
				if($query->num_rows()==0){
					$insertExtra=array(
						'created_by' => $this->session->userdata('session_id'),
						'created_on' => date('Y-m-d H:i:s')
						);
					$newArray=array_merge($insertArray,$insertExtra);
					$this->db->insert('user_task_detail',$newArray);

					$logarray['table_id']=$this->db->insert_id();
				    $logarray['module_name']='Task';
				    $logarray['cnt_name']='Task';
				    $logarray['action']='Task Record Inserted';
				    $this->user_access_log_model->insertAccessLog($logarray);
				}
			}
		}

		if($due_date>=$cur_date) {
			//print_r($follower);
			if(!empty($follower)){
				for($i=0; $i<count($follower); $i++) {
					$follower_id=$follower[$i];
					//exit;
					if($follower_id!=null && $follower_id!=''){
						$insertArray=array(
										'user_id' =>$follower_id,
										'task_id' =>$task_id,
										'follower'=>'Yes',
										'subject_detail' => $subject_detail,
										'message_detail' => $description,
										'task_status' => $task_status,
										'priority' => $priority,
										'from_date' => $from_date,
										'from_time' => $from_time,
										'to_date' => $to_date,
										'to_time' => $to_time,
										'due_date' => $due_date,
										'repeat_status' => $repeat,
										'period_interval'=>$interval,
										'monthly_repeat'=>$interval2,
										'status'=>'1',
										// 'property_id'=>$property,
										// 'sub_property_id'=>$sub_property,
										// 'owner_id'=>$owner_name,
										'maker_remark'=>$form_data['maker_remark']
									);

						$query=$this->db->query("select * from user_task_detail where task_id='$task_id' and due_date='$due_date' and user_id='$follower_id'");
						if($query->num_rows()==0){
							$insertExtra=array(
								'created_by' => $this->session->userdata('session_id'),
								'created_on' => date('Y-m-d H:i:s')
								);
							$newArray=array_merge($insertArray,$insertExtra);
							$this->db->insert('user_task_detail',$newArray);

							$logarray['table_id']=$this->db->insert_id();
						    $logarray['module_name']='Task';
						    $logarray['cnt_name']='Task';
						    $logarray['action']='Task Record Inserted';
						    $this->user_access_log_model->insertAccessLog($logarray);
						}
					}
				}
			}
		}

		if($repeat=="Never") {
			break;
		} else if($repeat=="Daily") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+1 days"));
		} else if($repeat=="Periodically") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+".$interval." days"));
		} else if($repeat=="Weekly") {
			$week_day="";

			if (isset($form_data['weekly_interval'][$week_index])) {
				$week_day=$form_data['weekly_interval'][$week_index];
				$week_index=$week_index+1;
				if (! isset($form_data['weekly_interval'][$week_index])) {
					$week_index=0;
				}
			}

			if($week_day=="Mon") $week_day="monday";
			else if($week_day=="Tue") $week_day="tuesday";
			else if($week_day=="Wed") $week_day="wednesday";
			else if($week_day=="Thu") $week_day="thursday";
			else if($week_day=="Fri") $week_day="friday";
			else if($week_day=="Sat") $week_day="saturday";
			else if($week_day=="Sun") $week_day="sunday";

			if($week_day!=''){
				$date = new DateTime($due_date);
				$date->modify('next ' . $week_day);
				$due_date = $date->format('Y-m-d');
			}
		} else if($repeat=="Monthly") {
			$date = explode('-',$due_date);
			$due_date = $date[0] . '-' . strval(intval($date[1])+intval($interval)) . '-' . $interval2;
			$d = DateTime::createFromFormat("Y-m-d", $due_date);
			$due_date = strval($d->format('Y-m-d'));
		} else if($repeat=="Yearly") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+1 years"));
		}
	}

	$assignee_names="";
	for($i=0; $i<count($contact); $i++) {
		$assign_to=$contact[$i];
		$result=$this->get_contact_details($assign_to);
		if(count($result)>0){
			$assignee_name="";
	        if(isset($result[0]->first_name)){
	            $assignee_name=$result[0]->first_name;
	        }
	        if(isset($result[0]->last_name)){
	            $assignee_name=$assignee_name.' '.$result[0]->last_name;
	        }
	        $assignee_names=$assignee_names.$assignee_name.', ';
			$assignee_email=$result[0]->email_id;

		    $from_email = 'cs@eatanytime.co.in';
            $from_email_sender = 'Wholesome Habits Pvt Ltd';
		    $subject = 'Task Intimation';
		    // $assignee_email = 'prasad.bhisale@pecanreams.com';
		    $bcc = 'prasad.bhisale@pecanreams.com, dhaval.maru@pecanreams.com';

		    $table=$this->get_task_list_table($subject_detail, $assignee_name, $priority, $repeat, $from_date, $to_date, 'Pending');

		    $message = '<html><head></head><body>Dear '.$assignee_name.'<br /><br />
		                We would like to bring to your notice that a New Task Entry has been assigned to you. 
		                The Task details are as follows.<br /><br />' . $table . '<br /><br />
		                If the above Task is incorrectly assigned to you please reject the same immediately.<br /><br />Thanks</body></html>';
		    $mailSent=send_email_new($from_email,  $from_email_sender, $assignee_email, $subject, $message, $bcc);
		    // print_r($mailSent);
		}
	}

	if(strpos($assignee_names, ', ')>0){
        $assignee_names=substr($assignee_names,0,strripos($assignee_names, ', '));
    }

	$assigner=$this->session->userdata('session_id');
	$result=$this->get_contact_details($assigner);
	if(count($result)>0){
		$assigner_name="";
        if(isset($result[0]->first_name)){
            $assigner_name=$result[0]->first_name;
        }
        if(isset($result[0]->last_name)){
            $assigner_name=$assigner_name.' '.$result[0]->last_name;
        }
		$assigner_email=$result[0]->email_id;

		$group_owner_names="";
		// $group_owners=$this->purchase_model->get_group_owners($gid);
		// if(count($group_owners)>0){
		// 	for($i=0;$i<count($group_owners);$i++){
		// 		$owner_name="";
		// 		if(isset($group_owners[$i]->first_name)){
		// 			$owner_name=$group_owners[$i]->first_name;
		// 		}
		// 		if(isset($group_owners[$i]->last_name)){
		// 			$owner_name=$owner_name.' '.$group_owners[$i]->last_name;
		// 		}
		// 		$group_owner_names=$group_owner_names.$owner_name.', ';
		// 	}
		// 	if(strpos($group_owner_names, ', ')>0){
		// 		$group_owner_names=substr($group_owner_names,0,strripos($group_owner_names, ', '));
		// 	}
		// }

	    $from_email = 'cs@eatanytime.co.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
	    $subject = 'Task Intimation';
	    // $assigner_email = 'prasad.bhisale@pecanreams.com';
	    $bcc = 'prasad.bhisale@pecanreams.com, dhaval.maru@pecanreams.com';

	    $table=$this->get_task_list_table($subject_detail, $assignee_names, $priority, $repeat, $from_date, $to_date, 'Pending');

	    $message = '<html><head></head><body>Dear '.$assigner_name.'<br /><br />
	                We would like to bring to your notice that a New Task Entry has been created by you for '.$group_owner_names.'. 
	                The Task details are as follows.<br /><br />' . $table . '<br /><br />
	                If the above Task is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
	    $mailSent=send_email_new($from_email,  $from_email_sender, $assigner_email, $subject, $message, $bcc);
    	// print_r($mailSent);
	}

	for($i=0; $i<count($follower); $i++) {
		$follower_id=$follower[$i];
 		$result=$this->get_contact_details($follower_id);
		if(count($result)>0){
			$follower_name="";
	        if(isset($result[0]->first_name)){
	            $follower_name=$result[0]->first_name;
	        }
	        if(isset($result[0]->last_name)){
	            $follower_name=$follower_name.' '.$result[0]->last_name;
	        }
			$follower_email=$result[0]->email_id;

		    $from_email = 'cs@eatanytime.co.in';
	        $from_email_sender = 'Wholesome Habits Pvt Ltd';
		    $subject = 'Task Intimation';
		    // $follower_email = 'prasad.bhisale@pecanreams.com';
		    $bcc = 'prasad.bhisale@pecanreams.com, dhaval.maru@pecanreams.com';

		    $table=$this->get_task_list_table($subject_detail, $assignee_names, $priority, $repeat, $from_date, $to_date, 'Pending');

		    $message = '<html><head></head><body>Dear '.$follower_name.'<br /><br />
		                We would like to bring to your notice that a New Task Entry has been created where you are given viewing rights. 
		                The Task details are as follows.<br /><br />' . $table . '<br /><br />
		                If the above Task is incorrectly assigned to you please reject the same immediately.<br /><br />Thanks</body></html>';
		    $mailSent=send_email_new($from_email,  $from_email_sender, $follower_email, $subject, $message, $bcc);
		    // print_r($mailSent);
		}
	}

	//print_r($insertArray);
	// if($form_data['task_id'] != ''){
	// 	$array_update=array(
	// 		'updated_by'=>$this->session->userdata('session_id'));
	// 	$newArray=array_merge($insertArray,$array_update);		
	// 	$this->db->where('task_id = "'.$form_data['task_id'].'" ');
	// 	$this->db->update('user_task_detail',$newArray);
	// }else{
	// 	$insertExtra=array(
	// 		'created_by' => $this->session->userdata('session_id'),
	// 		'task_status' => 'Pending'
	// 		);
	// 	$newArray=array_merge($insertArray,$insertExtra);		

	// 	$this->db->insert('user_task_detail',$newArray);
	// }
}

function getTaskList($user_id, $task_type, $view=''){
	if(strtoupper(trim($task_type))=='MYTASK' ||  $task_type==false){
		$cond=" and (user_id='$user_id')";
	} else if(strtoupper(trim($task_type))=='PENDING'){
		$cond=" and (created_by='$user_id' or user_id='$user_id') and task_status = 'pending'";
	} else if(strtoupper(trim($task_type))=='ASSIGNED'){
		$cond=" and (created_by='$user_id' and user_id!='$user_id')";
	} else if(strtoupper(trim($task_type))=='COMPLETED'){
		$cond=" and (created_by='$user_id' or user_id='$user_id') and task_status = 'completed'";
	} else if(strtoupper(trim($task_type))=='ALL'){
		$cond=" and (created_by='$user_id' or user_id='$user_id')";
	} else {
		$cond="";
	}

	$cond2=" where A.no_of_days > 0";
	if($view=='dashboard'){
		$cond2=" where A.no_of_days < 5";
	}

    $roleid=$this->session->userdata('role_id');
    
    $sql="select C.* from 
    		(select A.*, concat_ws(' ', B.first_name, B.last_name) as created_by_name from 
			(select A.*, concat_ws(' ', B.first_name, B.last_name) as name from 
			(select *, datediff(due_date, CURDATE()) AS no_of_days, updated_on as completed_on 
				from user_task_detail where status='1' ".$cond.") A 
			left join 
			(select * from user_master) B 
			on (A.user_id=B.id)) A 
			left join 
			(select * from user_master) B 
			on (A.created_by=B.id)) C 
			left join 
			(select user_id, min(due_date) as due_date, min(no_of_days) as min_no_of_days from 
			(select user_id, due_date, datediff(due_date, CURDATE()) AS no_of_days 
				from user_task_detail where status='1' ".$cond.") A ".$cond2." 
			group by user_id) D 
			on (C.user_id=D.user_id and C.due_date=D.due_date) 
			where C.no_of_days <= 0 or D.due_date is not null 
			order by due_date, name";
    $query=$this->db->query($sql);
    return $query->result();
}

function getTaskDetail($task_id){
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select C.* from 
		(select A.*, concat(B.first_name, ' ', B.last_name) as name from 
		(select * from user_task_detail where id='$task_id') A 
		left join 
		(select * from user_master) B 
		on (A.user_id=B.id)) C";
	$query=$this->db->query($sql);
    $result=$query->row();
    return $result;
}

function getTaskUsers($task_id){
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select A.user_id, concat(B.first_name,' ',B.last_name) as name from 
		(select distinct user_id from user_task_detail where task_id='$task_id' and follower = 'No' and user_id!='$session_id') A 
		left join 
		(select * from user_master) B 
		on (A.user_id=B.id) 
		order by B.first_name, A.user_id";

	$query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getTaskFollower($task_id){
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select A.user_id, concat(B.first_name,' ',B.last_name) as name from 
		(select distinct user_id from user_task_detail where task_id='$task_id' and follower = 'Yes'  and user_id!='$session_id') A 
		left join 
		(select * from user_master) B 
		on (A.user_id=B.id) 
		order by B.first_name, A.user_id";

	$query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function checkSelfTask($task_id){
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select * from user_task_detail where task_id='$task_id' and user_id='$session_id'";
	$query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getTaskCount($tasktype){
	// echo $tasktype . '<br>';

	$task_count=0;
	$all_task=0;
	$mytask=0;
	if($tasktype=='all' || $tasktype=='pending'){
		$this->db->select('count(id) as cnt ');
		$this->db->from('user_task_detail');
		$this->db->where('created_by = '.$this->session->userdata("session_id").' and status = "1" ');
		if($tasktype=='pending'){
			$this->db->where('task_status = "pending" ');
		}
		if($tasktype !='all'){
			$this->db->where('follower = "No" ');
		}
		$result=$this->db->get();

		// echo $this->db->last_query() . '<br>';
		$all_task=$result->row()->cnt;
	}
	if($tasktype=='all' || $tasktype=='mytask'){
		$this->db->select('count(id) as cnt ');
		$this->db->from('user_task_detail');
		if($tasktype=='all'){
			$this->db->where(' user_id = '.$this->session->userdata("session_id").' and created_by != '.$this->session->userdata("session_id").' ');
		}else{
			$this->db->where(' user_id = '.$this->session->userdata("session_id").' ');
		}
		if($tasktype !='all'){
			$this->db->where('follower = "No" ');
		}
		$result2=$this->db->get();
		// echo $this->db->last_query() . '<br>';
		$mytask=$result2->row()->cnt;
	}
	
	$task_count=$all_task + $mytask;

	return $task_count;
}

function deleteRecord($task_id){
	$this->db->select('id');
	$this->db->from('user_task_detail');
	$this->db->where('id = '.$task_id.' and status = "1" ');
	$result=$this->db->get();
	if($result->num_rows() > 0){
		$update_array=array(
			"status" => "3",
			"updated_by" => $this->session->userdata('session_id'));
		$this->db->where('id = '.$task_id.' ');
		$this->db->update('user_task_detail',$update_array);
		$logarray['table_id']=$task_id;
	    $logarray['module_name']='Task';
	    $logarray['cnt_name']='Task';
	    $logarray['action']='Task Record Deleted';
	    $this->user_access_log_model->insertAccessLog($logarray);
		$response=array("status"=>true,"msg"=>"Record Deleted Successfully");
	}else{
		$response=array("status"=>false,"msg"=>"unable to delete record");
	}
	return $response;
}

function completeTask($task_id){
	$this->db->select('id');
	$this->db->from('user_task_detail');
	$this->db->where('id = '.$task_id.' and status = "1" ');
	$result=$this->db->get();
	if($result->num_rows() > 0){
		$update_array=array(
			"task_status" => "Completed",
			"updated_by" => $this->session->userdata('session_id'),
			"updated_on" => date('Y-m-d H:i:s'));
		$this->db->where('id = '.$task_id.' ');
		$this->db->update('user_task_detail',$update_array);
		$response=array("status"=>true,"msg"=>"Task Completed Successfully");
	}else{
		$response=array("status"=>false,"msg"=>"unable to complete task");
	}
	return $response;
}

function addCommentTask($comm_array){
	$this->db->insert('user_task_comment',$comm_array);
}

function getCommentDetail($task_id){
	$this->db->select("concat_ws(' ',cm.first_name,cm.last_name) name,u.comment");
	$this->db->from('user_master cm, user_task_comment u');
	$this->db->where('cm.id = u.user_id  and u.task_id = '.$task_id.'  ');
	$result=$this->db->get();
	return $result->result();
}

}
?>