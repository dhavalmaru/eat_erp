<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Attendance extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('attendence_model');
        $this->load->model('distributor_model');
        $this->load->model('sales_rep_model');
        $this->load->model('area_model');
        $this->load->model('distributor_type_model');
        $this->load->model('zone_model');
        $this->load->model('location_model');
        $this->load->database();
    }

    public function index() {
        $result=$this->attendence_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            // $data['data'] = $this->attendence_model->get_data();

            load_view('attendance/upload', $data);
        } else {
            echo "You donot have access to this page.";
        }
    }

    public function upload_file() {
        $path=FCPATH.'assets/uploads/excel_upload/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => "xlsx",
            'overwrite' => TRUE,
            'max_size' => "2048000", 
            'max_height' => "768",
            'max_width' => "1024"
        );
        $new_name = time().'_'.str_replace(' ', "_", $_FILES["upload"]['name']);
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')) { 
            $this->upload->display_errors();
        } else {
            $imageDetailArray = $this->upload->data();
        }

        $file = $path.$new_name;
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);
        $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        // $objPHPExcel->getActiveSheet()->setCellValue('E', 'Error Remark');
        // $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objerror = 0;
        $error_line = '';
        $batch_array = [];
   
        for($i=2;$i<=$highestrow;$i++) {
            //$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
            $distributor = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
           /* $area = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
            $zone = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
            $location = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();*/
            $sales_rep = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
            $frequency = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
            $sequence = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
            $error = '';


            $sales_rep = trim($sales_rep);


            $sql = "select K.*,L.store_name from(select I.*,j.sales_rep_name,
                    j.id as sales_reps_id from 
                     (select G.*,H.distributor_type from (select E.*,F.location from(Select C.*,D.zone from (select A.* from (select * from sr_mapping Where type_id=3 ) A 
                    ) C 
                    left join (select * from zone_master) D on D.id=C.zone_id) E 
                    left join (select * from location_master)F on F.id=E.location_id)G 
                    left join (select * from distributor_type_master)H on H.id=G.type_id)I 
                    left join (select * from sales_rep_master)j on (j.id=I.reporting_manager_id OR j.id=I.sales_rep_id1 OR j.id=I.sales_rep_id2))K 
                    left join (select * from relationship_master)L on L.id=K.area_id1 
                    WHERE sales_rep_name='$sales_rep' order by K.modified_on desc";

                $result = $this->db->query($sql)->result();  

                if(count($result)>0)
                {
                    $flag=0;
                    for ($m=0; $m <count($result) ; $m++){ 
                        $location_id = $result[$m]->location_id;
                        $area_id = $result[$m]->area_id;
                        $zone_id = $result[$m]->zone_id;
                        $sales_rep_id = $result[$m]->sales_reps_id;

                        $sql_dist = "select * from distributor_master Where type_id=3 and area_id='$area_id' and zone_id='$zone_id' and distributor_name='$distributor'";
                        // and  location_id='$location_id'  and status='Aprroved'
                        $result_dist = $this->db->query($sql_dist)->result();


                        if(count($result_dist)>0)
                        {
                            $now=date('Y-m-d H:i:s');
                            $curusr=$this->session->userdata('session_id');
                            $store_id = 'd_'.$result_dist[0]->id;
                            $area_id = $result_dist[0]->area_id;
                            $zone_id = $result_dist[0]->zone_id;
                            $location_id = $result_dist[0]->location_id;

                            /*$where_array = array(
                                                 "store_id"=>$store_id,
                                                 "zone_id"=>$zone_id,
                                                 "location_id"=>$location_id,
                                                 "sales_rep_id"=>$sales_rep_id,
                                                 "frequency"=>$frequency,
                                                 "area_id"=>$area_id
                                            );*/

                           /* $res1 = $this->db->select("*")->where($where_array)->get("sales_rep_beat_plan")->result();
                            $res2 = $this->db->select("*")->where($where_array)->get("admin_sales_rep_beat_plan")->result();*/
                            $data = array(
                                        'store_id' =>$store_id,
                                        'zone_id' => $zone_id,
                                        'location_id' => $location_id,
                                        'sales_rep_id' =>$sales_rep_id,
                                        'frequency' => $frequency,
                                        'sequence' => $sequence,
                                        'status' => 'Approved',
                                        "area_id"=>$area_id,
                                        'modified_by' => $curusr,
                                        'modified_on' => $now
                             );
                            $data['created_by']=$curusr;
                            $data['created_on']=$now;
                            
                            $batch_array[] =$data;

                            /*if(count($res1)>0)
                            {
                               $id = $res1[0]->id;
                               $this->db->where($where_array)->update('sales_rep_beat_plan ',$data);   
                            }
                            else
                            {
                                $batch_array[] =$data;
                            }*/
                            $flag=1;    
                            break;
                        }
                        /*else
                        {
                            $error .='Sales Rep Combination does not matched';
                            $objerror =1;
                            $error_line .= $i.',';
                        }*/
                    }

                    if($flag==0)
                    {
                        $error .='Sales Rep Combination does not matched';
                        $objerror =1;
                        $error_line .= $i.',';
                    }
                }
                else
                {
                    $error .='SR Mapping Combination does not matched';
                    $objerror =1;
                    $error_line .= $i.',';
                    
                }

                if($error!="")
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $error);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setWrapText(true);  
                }
        }

        

        if($objerror==1)
        {


            $objPHPExcel->setActiveSheetIndex(1);
            $sqlqueries = "select * from distributor_master where class='normal' and type_id=3 and status='Approved'";
             $row = 1;

            $distributor_result  = $this->db->query($sqlqueries)->result();
            foreach($distributor_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->distributor_name);
                $row = $row+1;
            }
            
            /*$an = 1;
            $sqlzone = "select area from area_master where (type_id='3') order by area desc";

            $area_result  = $this->db->query($sqlzone)->result();             
             foreach($area_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$an,$dist->area);
                $an = $an+1;
            }


            $zn = 1;
            $sqlzone = "select A.zone from 
                        (select * from zone_master where (type_id='3')) A 
                        left join 
                        (select * from distributor_type_master) B 
                        on (A.type_id=B.id) where A.status='Approved'  order by A.zone desc";

            $zone_result  = $this->db->query($sqlzone)->result();             
             foreach($zone_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$zn,$dist->zone);
                $zn = $zn+1;
            }

          
            
            $ln = 1;
            $sqllocation = "Select D.location from 
                        (select * from store_master) A 
                        left join 
                        (select * from location_master) D 
                        on (A.location_id=D.id) GROUP BY  D.location ";

            $location_result  = $this->db->query($sqllocation)->result();             
             foreach($location_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ln,$dist->location);
                $ln = $ln+1;
            }
            */
            $sr = 1;
            $sqlsr = "select * from sales_rep_master where sr_type='Sales Representative' order by sales_rep_name desc";

            $sr_result  = $this->db->query($sqlsr)->result();             
             foreach($sr_result  as $sr1)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sr,$sr1->sales_rep_name);
                $sr = $sr+1;
            }
           
            $fq = 1;
            $sqlfq = "SELECT * FROM frequency_master";
            $fq_result  = $this->db->query($sqlfq)->result();             
             foreach($fq_result  as $freq)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$fq,$freq->frequency);
                $fq = $fq+1;
            }
           
         
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);

            for($j=2;$j<=100;$j++)
            {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($row-1));

                /*$objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.($an-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.($zn-1));


                $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$D$1:$D$'.($ln-1));*/

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.($sr-1));
                
                  $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.($fq-1));
            }


            $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
            $filename='sales_rep_beat_upload1.xlsx';
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            sleep(0.50);
            redirect(base_url().'index.php/Sales_rep_beat_plan');
        }
        else
        {
            $unique_array = array();
            for ($j=0; $j<count($batch_array); $j++) { 

                $store_id = $batch_array[$j]['store_id'];
                $zone_id = $batch_array[$j]['zone_id'];
                $location_id = $batch_array[$j]['location_id'];
                $sales_rep_id = $batch_array[$j]['sales_rep_id'];
                $frequency = $batch_array[$j]['frequency'];
                $area_id = $batch_array[$j]['area_id'];

                if (strpos($frequency, 'Every') !== false) {
                    echo "entered";
                    if(array_search($frequency, array_column($unique_array, 'frequency')) !== false && array_search($sales_rep_id, array_column($unique_array, 'sales_rep_id')) !== false) {
                         'value is in multidim array';
                    }
                    else {
                        $unique_array[]=array("frequency"=>$frequency,"sales_rep_id"=>$sales_rep_id);
                    }
                }
                


                $now1=date('Y-m-d');    
                $where_array = array(
                                         /*"store_id"=>$store_id,
                                         "area_id"=>$area_id,
                                         "zone_id"=>$zone_id,
                                         "location_id"=>$location_id,*/
                                         "sales_rep_id"=>$sales_rep_id,
                                         "frequency"=>$frequency,
                                         /*"area_id"=>$area_id*/
                                        );

                $this->db->where($where_array)->delete('sales_rep_beat_plan');
                $this->db->where($where_array)->delete('admin_sales_rep_beat_plan');
            }

            $this->db->insert_batch('sales_rep_beat_plan ',$batch_array);
            $this->db->insert_batch('admin_sales_rep_beat_plan',$batch_array);


            $batch_unique_array = [];    
            for ($k=0; $k<count($unique_array); $k++) { 

                $where_array = array(
                                        "sales_rep_id"=>$unique_array[$k]['sales_rep_id'],
                                         "frequency"=>$unique_array[$k]['frequency']
                                        );
                $result = $this->db->select('*')->where($where_array)->get('sales_rep_beat_plan')->result_array();
                for($l=0;$l<count($result);$l++)
                {
                    $store_id = $result[$l]['store_id'];
                    $zone_id = $result[$l]['zone_id'];
                    $location_id = $result[$l]['location_id'];
                    $sales_rep_id = $result[$l]['sales_rep_id'];
                    $frequency = $result[$l]['frequency'];
                    $area_id = $result[$l]['area_id'];
                    $sequence = $result[$l]['sequence'];
                    $explode_frequency = explode(' ',$frequency);
                    $new_frequency = 'Alternate '.$explode_frequency[1];
                    $data = array(
                                    'store_id' =>$store_id,
                                    'zone_id' => $zone_id,
                                    'location_id' => $location_id,
                                    'sales_rep_id' =>$sales_rep_id,
                                    'frequency' => $new_frequency,
                                    'sequence' => $sequence,
                                    'status' => 'Approved',
                                    "area_id"=>$area_id,
                                    'modified_by' => $curusr,
                                    'modified_on' => $now
                         );
                    $data['created_by']=$curusr;
                    $data['created_on']=$now;
                    
                    $batch_unique_array[] =$data; 

                     $where_unique_array = array(
                                        "sales_rep_id"=>$unique_array[$k]['sales_rep_id'],
                                         "frequency"=>$new_frequency,
                                         'modified_on<>'=>$now1,
                                        );


                    /*$this->db->where($where_unique_array)->delete('sales_rep_beat_plan');
                    $this->db->where($where_unique_array)->delete('admin_sales_rep_beat_plan');*/    
                }
            }

            $this->db->insert_batch('sales_rep_beat_plan ',$batch_unique_array);
            $this->db->insert_batch('admin_sales_rep_beat_plan',$batch_unique_array);
            redirect(base_url().'index.php/Sales_rep_beat_plan');
        } 
    }

    public function checkstatus($status=''){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;

            if($status=='Approved'){
                $data['data']=$this->distributor_model->get_distributor_data($status,'','super stockist');
            } else if($status=='Retailer'){
                $data['data']=$this->distributor_model->get_distributor_data('Approved','','normal');
            } else {
                $data['data']=$this->distributor_model->get_distributor_data($status);
            }

            $count_data=$this->distributor_model->get_distributor_data();
            $active=0;
            $inactive=0;
            $pending=0;
            $retailer=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->class))=="SUPER STOCKIST")
                        $active=$active+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->class))=="NORMAL")
                        $retailer=$retailer+1;
                }
            }

            $data['active']=$active;
            $data['inactive']=$inactive;
            $data['pending']=$pending;
            $data['retailer']=$retailer;
            $data['all']=count($count_data);

            load_view('distributor/distributor_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function locations($status=''){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            
            load_view_without_data('distributor/distributor_loc_map');

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
    public function single_locations($status=''){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            
            load_view_without_data('distributor/distributor_single_loc_map');

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->distributor_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->distributor_name;
            $data['sell_out'] = $result[0]->sell_out;
            $data['state'] = $result[0]->state;
            $data['state_code'] = $result[0]->state_code;
            $data['sales_rep_id'] = $result[0]->sales_rep_id;
            $data['credit_period'] = $result[0]->credit_period;
            $data['class'] = $result[0]->class;
        }

        echo json_encode($data);
    }

    public function get_distributor_locations(){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            $query=$this->distributor_model->get_data();
            if(count($query)>0) {
                for($i=0; $i<count($query); $i++){
                    $data[$i][0] = $query[$i]->distributor_name;
                    $data[$i][1] = $query[$i]->google_address;
                    $data[$i][2] = 'Location 1 URL';
                }
            }

            echo json_encode($data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	public function get_distributor_single_locations(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->distributor_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['google_address'] = $result[0]->google_address;
            $data['latitude'] = $result[0]->latitude;
            $data['longitude'] = $result[0]->longitude;
           
        }

        echo json_encode($data);
    }
	
    public function add(){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->zone_model->get_data('Approved');
                $data['location'] = $this->location_model->get_data('Approved');

                load_view('distributor/distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($d_id){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->distributor_model->get_distributor_data('', $d_id);
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
                $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->zone_model->get_data('Approved');
                $data['location'] = $this->location_model->get_data('Approved');
                if(strrpos($d_id, "d_") !== false){
                    $id = substr($d_id, 2);
                    $data['distributor_contacts'] = $this->distributor_model->get_distributor_contacts($id);
                    $data['distributor_consignee'] = $this->distributor_model->get_distributor_consignee($id);
                }

                load_view('distributor/distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_model->save_data();
        redirect(base_url().'index.php/distributor');
    }

    public function update($id){
        $this->distributor_model->save_data($id);
        redirect(base_url().'index.php/distributor');
    }

    public function check_distributor_availablity(){
        $result = $this->distributor_model->check_distributor_availablity();
        echo $result;
    }

	public function get_zone(){ 
        $postData = $this->input->post();

        $data = $this->area_model->get_zone($postData);
        echo json_encode($data); 
	}

	public function get_area(){ 
        $postData = $this->input->post();

        $data = $this->location_model->get_area($postData);
        echo json_encode($data); 
	}
	
    public function get_shipping_state() {
        $id=$this->input->post('id');
        // $id=1;
		$data=array();
        $result=$this->distributor_model->get_shipping_state($id);
        if(count($result)>0) {
            $data['state'] = $result[0]->con_state;
            $data['state_code'] = $result[0]->con_state_code;
        }
        // if(count($result)>0) {
        //     $data['result'] = 1;
        //     $data['product_name'] = $result[0]->distributor_name;
        //     $data['sell_out'] = $result[0]->sell_out;
        //     $data['state'] = $result[0]->state;
        //     $data['sales_rep_id'] = $result[0]->sales_rep_id;
        //     $data['credit_period'] = $result[0]->credit_period;
        //     $data['class'] = $result[0]->class;
        // }

        echo json_encode($data);
    }
}
?>