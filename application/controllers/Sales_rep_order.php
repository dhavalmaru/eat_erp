<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_order extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_order_model');
        $this->load->model('Sales_location_model');
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    /*index function
    public function index(){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_order_model->get_data();

            load_view('sales_rep_order/sales_rep_order_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }*/

	public function index(){
        // $result=$this->distributor_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->distributor_model->get_data();

        //     load_view('distributor/distributor_list', $data);
        // } else {
        //     echo "You donot have access to this page.";
        // }

        $this->checkstatus();
    }
	
	
	 public function checkstatus($status=''){
        /*$result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->sales_rep_order_model->get_data($status);

            $count_data=$this->sales_rep_order_model->get_data();
            $active=0;
            $inactive=0;
            $pending=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $active=$active+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING")
                        $pending=$pending+1;
                }
            }

			$data['active']=$active;
            $data['pending']=$pending;
            $data['all']=count($count_data);

            // echo json_encode($data);

            load_view('sales_rep_order/sales_rep_order_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }*/

        $sales_rep_id = $this->session->userdata('sales_rep_id');

        $data['orders'] = $this->Sales_location_model->get_todaysorder($sales_rep_id);
        $data['pendingsorder'] = $this->Sales_location_model->get_pendingsorder($sales_rep_id);
        load_view('sales_rep_order/sales_rep_order_list', $data);
	 }

    public function add(){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_order_model->get_access();
                $data['distributor'] = $this->sales_rep_order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                load_view('sales_rep_order/sales_rep_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_order_model->get_access();
                $data['distributor'] = $this->sales_rep_order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['data'] = $this->sales_rep_order_model->get_data('', $id);
                $data['sales_rep_order_items'] = $this->sales_rep_order_model->get_sales_rep_order_items($id);

                load_view('sales_rep_order/sales_rep_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add_order($id){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_order_model->get_access();
                $data['distributor'] = $this->sales_rep_order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                // $data['distributor_id'] = 's_'.$id;
                $data['distributor_id'] = $id;
                
                load_view('sales_rep_order/sales_rep_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
        $bool = 0;
        if($this->session->userdata('posttimer')=='')
        {
           $this->session->set_userdata('posttimer',time());
           $bool = 1;
        }
        else
        {
             if ((time() - $this->session->userdata('posttimer'))>5)
             {
                $this->session->set_userdata('posttimer',time());
                $bool = 1;
             }
             else
             {
                $bool = 0;
             }
        }

        if($bool==1)
        {
            if($id == ""){
                $id = $this->sales_rep_order_model->save_data();
            } else {
                $id = substr($id, 2);
                $id = $this->sales_rep_order_model->save_data($id);
            }
        }

        redirect(base_url().'index.php/sales_rep_order');
    }

    // public function save(){
    //     $this->sales_rep_order_model->save_data();
    //     redirect(base_url().'index.php/sales_rep_order');
    // }

    // public function update($id){
    //     $this->sales_rep_order_model->save_data($id);
    //     redirect(base_url().'index.php/sales_rep_order');
    // }
    
    public function get_distributor_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->sales_rep_order_model->get_distributors('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['distributor_name'] = $result[0]->distributor_name;
            $data['sell_out'] = $result[0]->sell_out;
        }

        echo json_encode($data);
    }

    public function check_box_availablity(){
        $result = $this->sales_rep_order_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->sales_rep_order_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->sales_rep_order_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
		
        $result = $this->sales_rep_order_model->check_product_qty_availablity();
        echo $result;
    }

	function get_order_list_view(){
		$postData = $this->input->post();
			 $order_id = $postData['order_id'];
			//$order_id='660';
                      $result = $this->db->query("Select A.id as stock_id,
                        Case When type='Box' Then box_name ELSE product_name end as product_name,
                        Case When type='Box' Then CONCAT(qty,'_Box') ELSE CONCAT(qty,'_Bar') end as qty,item_id,type
                        from
                        (SELECT * from sales_rep_order_items where sales_rep_order_id=$order_id) A
                        Left join 
                        (SELECT * from box_master)B on A.item_id=B.id
                        Left join 
                        (SELECT * from product_master)C on A.item_id=C.id")->result_array();
                        $this->db->last_query();
                        
                        $order_detail = array();
                        if(count($result)>0)
                        {
                            for ($j=0; $j <count($result) ; $j++) {
                                if ($result[$j]['item_id']==37) {
                                    $order_detail['chocolate_cookies_box']=$result[$j]['qty'];
                                }
                               if ($result[$j]['item_id']==38) {
                                    $order_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==39) {
                                    $order_detail['cranberry_cookies_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==42) {
                                    $order_detail['cranberry_orange_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==41) {
                                    $order_detail['fig_raisins_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==40) {
                                    $order_detail['papaya_pineapple_box']=$result[$j]['qty'];
                                }
                                
                                if($result[$j]['item_id']==1 && $result[$j]['type']=='Bar')
                                {
                                    $order_detail['orange_bar']=$result[$j]['qty'];
                                }

                                 if($result[$j]['item_id']==1 && $result[$j]['type']=='Box')
                                {
                                    $order_detail['orange_box']=$result[$j]['qty'];
                                }

                                /*if($result[$j]['item_id']==3 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                {
                                    $order_detail['butterscotch']=$result[$j]['qty'];
                                }*/

                                if($result[$j]['item_id']==3 && $result[$j]['type']=='Box')
                                {
                                    $order_detail['butterscotch_box']=$result[$j]['qty'];
                                }
                                
                                if($result[$j]['item_id']==3 && $result[$j]['type']=='Bar')
                                {
                                    $order_detail['butterscotch_bar']=$result[$j]['qty'];
                                }

                                if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
								{
                                        $order_detail['chocopeanut_box']=$result[$j]['qty'];
                                }
                                if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
								{
                                        $order_detail['chocopeanut_bar']=$result[$j]['qty'];
								}

                                 if($result[$j]['item_id']==8 && $result[$j]['type']=='Box')
								 {
                                        $order_detail['bambaiyachaat_box']=$result[$j]['qty'];
								 }
								if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar')
							   {
                                        $order_detail['bambaiyachaat_bar']=$result[$j]['qty'];
							   }	

                                if($result[$j]['item_id']==12 && $result[$j]['type']=='Box')
								{
                                        $order_detail['mangoginger_box']=$result[$j]['qty'];
								}
                                 if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar')
								 {
                                        $order_detail['mangoginger_bar']=$result[$j]['qty'];
								 }

                                if($result[$j]['item_id']==29 && $result[$j]['type']=='Box')
								{
                                        $order_detail['berry_blast_box']=$result[$j]['qty'];
								}
                                 if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar')
								 {
                                        $order_detail['berry_blast_bar']=$result[$j]['qty'];
								 }

                                if($result[$j]['item_id']==31 && $result[$j]['type']=='Box')
								{
									$order_detail['chyawanprash_box']=$result[$j]['qty'];
								}
							
                                 if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar')
                                        $order_detail['chyawanprash_bar']=$result[$j]['qty'];

                                 if($result[$j]['item_id']==32 && $result[$j]['type']=='Box')
                                        $order_detail['variety_box']=$result[$j]['qty'];
                            }

							
							$order_data='<div class="modal-body">
                                          <br/>
                                          <div class="">
                                           <table border="1"> <tr>
											<th>Product name</th>
											<th>Bar</th>
											<th>Box</th>

											
											</tr>
											';
											if(isset($order_detail['orange_bar'])|| isset($order_detail['orange_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;
                                                            if(isset($order_detail['orange_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['orange_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['orange_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['orange_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Orange</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         }
														 
												if(isset($order_detail['butterscotch_bar'])|| isset($order_detail['butterscotch_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;

                                                            if(isset($order_detail['butterscotch_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['butterscotch_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['butterscotch_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['butterscotch_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Butterscotch</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         } 
											
											
											if(isset($order_detail['chocopeanut_bar'])|| isset($order_detail['chocopeanut_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;
                                                            if(isset($order_detail['chocopeanut_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['chocopeanut_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['chocopeanut_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['chocopeanut_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Choco Peanut Bar</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         }
														 
														 
														 if(isset($order_detail['bambaiyachaat_bar'])|| isset($order_detail['bambaiyachaat_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;
                                                            if(isset($order_detail['bambaiyachaat_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['bambaiyachaat_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['bambaiyachaat_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['bambaiyachaat_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Bambaiya Chaat</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         }
														 
														  if(isset($order_detail['mangoginger_bar'])|| isset($order_detail['mangoginger_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;

                                                            if(isset($order_detail['mangoginger_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['mangoginger_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['mangoginger_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['mangoginger_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Mango Ginger</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         }
														 
														 if(isset($order_detail['berry_blast_bar'])|| isset($order_detail['berry_blast_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;
                                                            if(isset($order_detail['berry_blast_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['berry_blast_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['berry_blast_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['berry_blast_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Berry Blast</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         }
														
														 if(isset($order_detail['chyawanprash_bar'])|| isset($order_detail['chyawanprash_box']))
                                                         {
                                                            $ex0_1 = 0;
                                                            $ex0_2 = 0;

                                                            if(isset($order_detail['chyawanprash_bar']))
                                                            {
                                                               $ex0 = explode('_',$order_detail['chyawanprash_bar']);
                                                                $ex0_1=$ex0[0];
                                                                
                                                            }
															
															if(isset($order_detail['chyawanprash_box']))
                                                            {
                                                               $ex1 = explode('_',$order_detail['chyawanprash_box']);
                                                                $ex0_2=$ex1[0];
                                                                
                                                            }
															
															$order_data.= '<tr>
														<td>Chyawanprash</td>
														<td>'.$ex0_1.'</td>
														<td>'.$ex0_2.'</td>
														
															</tr>';
											
										
                                                         }
														  
														 
														 
														 
														 
														 
														  if(isset($order_detail['variety_box']))
                                                         {
                                                            if($order_detail['variety_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['variety_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.= '<td> Variety Box</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         } 
														 
														  if(isset($order_detail['chocolate_cookies_box']))
                                                         {
                                                            if($order_detail['chocolate_cookies_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['chocolate_cookies_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.='<td> Chocolate cookies</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         } 
														 
														 
														 if(isset($order_detail['dark_chocolate_cookies_box']))
                                                         {
                                                            if($order_detail['dark_chocolate_cookies_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['dark_chocolate_cookies_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.= '<td> Dark chocolate Cookies</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         }

														if(isset($order_detail['cranberry_cookies_box']))
                                                         {
                                                            if($order_detail['cranberry_cookies_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['cranberry_cookies_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.= '<td> Cranberry Cookies</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         } 
														 
														 if(isset($order_detail['cranberry_orange_box']))
                                                         {
                                                            if($order_detail['cranberry_orange_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['cranberry_orange_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.='<td> Cranberry & Orange Zest</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         } 
														 
														  if(isset($order_detail['fig_raisins_box']))
                                                         {
                                                            if($order_detail['fig_raisins_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['fig_raisins_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.= '<td> fig & Raisins</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         } 
														 
														  
														  if(isset($order_detail['papaya_pineapple_box']))
                                                         {
                                                            if($order_detail['papaya_pineapple_box']!=NULL)
                                                            {
                                                               $ex0 = explode('_',$order_detail['papaya_pineapple_box']);
                                                                $ex0_1=$ex0[0];
                                                                $ex0_2=$ex0[1];
                                                            }
															$order_data.= '<td> papaya & pineapple</td><td> - </td>
															<td>'.$ex0_1.'</td>
																</tr>
											
																<tr>';
                                                         } 
														 
											
											
											
											$order_data.='</table>
                                          </div>
                                       </div>';

							 
                        }
							  echo $order_data;
    }

}
?>