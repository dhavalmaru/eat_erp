<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_sale extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_sale_model');
        $this->load->model('zone_model');
        $this->load->model('box_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->distributor_sale_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->distributor_sale_model->get_data();

            load_view('distributor_sale/distributor_sale_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->distributor_sale_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_sale_model->get_access();
                $data['distributor'] = $this->distributor_model->get_data('Approved', '', 'super stockist');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                //$data['store'] = $this->distributor_sale_model->get_store();
                // $data['zone'] = $this->distributor_sale_model->get_zone();
                $data['zone'] = $this->zone_model->get_data('Approved','','ss_stores');
				//$data['location'] = $this->distributor_sale_model->get_location_data();
				//$data['location'] = $this->distributor_sale_model->get_location();

                load_view('distributor_sale/distributor_sale_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function download_csv()
    {
            $template_path=$this->config->item('template_path');
            $file = $template_path.'superstockis_upload.xls';
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(1);
            $row = 1;
            $sqlqueries = "Select A.distributor_name from 
                        (select * from distributor_master where class='Super Stockist') A 
                        left join 
                        (select * from sales_rep_master) B 
                        on (A.sales_rep_id=B.id) GROUP BY  A.distributor_name order by A.distributor_name asc";

            $distributor_result  = $this->db->query($sqlqueries)->result();
            foreach($distributor_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->distributor_name);
                $row = $row+1;
            }
             
            $zn = 1;
            $sqlzone = "select A.zone  from 
                        (select * from zone_master where (type_id='4' or type_id='7')) A 
                        left join 
                        (select * from distributor_type_master) B 
                        on (A.type_id=B.id) where A.status='Approved'  order by A.zone desc";

            $zone_result  = $this->db->query($sqlzone)->result();             
             foreach($zone_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$zn,$dist->zone);
                $zn = $zn+1;
            }
            $rn = 1;
            $sqlregion = "Select E.store_id, E.store_name from(
                        Select  A.*,D.store_name,D.id as did from (select * from store_master) A 
                        left join (select * from relationship_master)D
                        on (A.store_id=D.id))E  left join 
                        (select * from zone_master)F on (E.zone_id=F.id)  
                        group by E.store_id, E.store_name";

            $region_result  = $this->db->query($sqlregion)->result();             
             foreach($region_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$rn,$dist->store_name);
                $rn = $rn+1;
            }
            
            $ln = 1;
            $sqllocation = "Select  D.location from 
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

            $pr = 1;
            $sqlprodmaster = "Select product_name from product_master 
                              union Select box_name from box_master";
            $prodmaster_result  = $this->db->query($sqlprodmaster)->result();       
            foreach($prodmaster_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$pr,$dist->product_name);
                $pr = $pr+1;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);

            for($j=2;$j<=100;$j++)
            {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($row-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.($zn-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.($rn-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$D$1:$D$'.($ln-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('F'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$E$1:$E$'.($pr-1));
            }

            /*$objValidation = $objPHPExcel->getActiveSheet()->getCell('B2')->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.$row);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C2')->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.$zn);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D2')->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.$rn);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('E2')->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('\'Sheet2\'!$D$1:$D$'.$ln);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F2')->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('\'Sheet2\'!$E$1:$E$'.$ln);*/

           /*for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }*/

            $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
            $filename='superstockis_upload.xlsx';
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
    }

    public function upload_file()
    {
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
         if(!$this->upload->do_upload('upload'))
        { 
             $this->upload->display_errors();

        }
        else
        {
            $imageDetailArray = $this->upload->data();
        }

        $file = $path.$new_name;
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);
        $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Error Remark');
        $objPHPExcel->getActiveSheet()->getColumnDimension('j')->setWidth(30);
        $objerror = 0;


        for($i=2;$i<=$highestrow;$i++)
        {   
            if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue()!="")
                $date = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP( $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue()));
            else
                $date='';
            //$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
            $distributor = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
            $zone = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
            $relation = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
            $location = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
            $item = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
            $quantity = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
            //$due_date = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
            if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue()!="")
                 $due_date = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP( $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue()));
             else
                $due_date='';
            $remark = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue();
            $error = '';

           if($date!="")
            {       
                    if($distributor=="")
                        $error .='Distributor is empty.';

                    if($due_date=="")
                        $error .='Due date Is empty.';

                     if($item=="")
                        $error .='Item Is empty.';

                     if($quantity=="")
                        $error .='Quantity Is empty';
                    if($error!='')
                    {   
                        $objerror =1;

                    }
                    else
                    {
                        $sql = "select G.*,H.location from (select E.*, F.store_name 
                            from(
                            select A.zone,A.type_id,A.id as zoneid,D.id, D.store_id,D.location_id from (
                           select * from zone_master where type_id='4' or type_id='7' ) A
                            left join
                            (select * from store_master) D
                            on (A.id=D.zone_id))E
                             left join 
                            (select * from relationship_master)F
                            on (E.store_id=F.id))G   
                            left join 
                            (select * from location_master)H
                            on (G.location_id=H.id)  
                            Where
                            G.zone = '$zone' AND 
                            G.store_name = '$relation' AND
                            H.location = '$location'";

                        $result = $this->db->query($sql)->result();   

                        if(count($result)>0)
                        {

                               
                                $location_id = $result[0]->location_id;
                                $zone_id = $result[0]->zoneid;
                                $store_id = $result[0]->store_id;

                                /* $sql = "select A.*, B.sell_out,B.distributor_name from (SELECT * FROM `distributor_sale` where status='Approved')A left join (SELECT * FROM `distributor_master` where class='Super Stockist')B on(A.distributor_id=B.id) Where B.distributor_name='$distributor'";*/
                                $sql ="Select `sell_out` ,id,`distributor_name` from distributor_master Where distributor_name='$distributor'";

                                $result_dist = $this->db->query($sql)->result(); 

                                $distributor_id = $result_dist[0]->id;
                                $sell_out = $result_dist[0]->sell_out;

                                $sql = "select * from store_master where store_id = '$store_id' and zone_id = '$zone_id' and location_id = '$location_id'";

                                $query=$this->db->query($sql);
                                $result_dist2 = $query->result();
                                $to_distributor_id = $result_dist2[0]->id;


                                $result2 = "Select * from  (select id, 'Bar' as type, product_name as item_name, rate, product_name,status,grams from product_master where status='Approved'  union all select m.id, 'Box' as type, m.box_name as item_name, m.rate,   m.box_name,status,m.grams from box_master m )A  Where  item_name= '$item'  group by A.id";
                                $result_getamount = $this->db->query($result2)->result();  

                                if(count($result_getamount)>0)
                                {
                                    $rate = $result_getamount[0]->rate;
                                    $type = $result_getamount[0]->type;
                                    $item_id = $result_getamount[0]->id;
									$grams = $result_getamount[0]->grams;
                                    
                                    $sell_rate = $rate-(($rate*$sell_out)/100);
                                    //$actual_rate = $rate-$sell_rate;
                                    $total_amount = $quantity*$sell_rate;



                                    $now=date('Y-m-d H:i:s');
                                    $curusr=$this->session->userdata('session_id');
                                    $date_of_processing=formatdate($date);

                                    $where_array = array("date_of_processing"=>$date,
                                                         "location_id"=>$location_id,
                                                         "zone_id"=>$zone_id,
                                                         "store_id"=>$store_id,
                                                         "distributor_id"=>$distributor_id
                                                    );

                                    $res1 = $this->db->select("*")->where($where_array)->get("distributor_sale")->result();
                                    if(count($res1)>0)
                                    {
                                        //$total_amount = $total_amount+$res1[0]->amount;
                                        $id = $res1[0]->id;
                                    }
                                    else
                                    {
                                        $data = array(
                                        'date_of_processing' => $date,
                                        'distributor_id' => $distributor_id,
                                        'amount' => $total_amount,
                                        'due_date' => $due_date,
                                        'status' => 'Approved',
                                        'location_id' => $location_id,
                                        'zone_id' => $zone_id,
                                        'store_id' => $store_id,
                                        'status' => 'Approved',
                                        'remarks' => $remark,
                                        'modified_by' => $curusr,
                                        'modified_on' => $now,
                                        'to_distributor_id' => $to_distributor_id
                                         );
                                        $data['created_by']=$curusr;
                                        $data['created_on']=$now;
                                        $this->db->insert('distributor_sale',$data);
                                        $id = $this->db->insert_id();
                                    }

                                    
                                    //$this->db->last_query();

                                    $data = array(
                                        'distributor_sale_id' => $id,
                                        'type' => $type,
                                        'item_id' => $item_id,
                                        'qty' => format_number($quantity,2),
                                        'sell_rate' => format_number($sell_rate,2),
                                        'grams' => format_number($grams,2),
                                        'rate' => format_number($rate,2),
                                        'amount' => format_number($total_amount,2)
                                        );

                                    $where = array('type'=>$type,'item_id'=>$item_id,'distributor_sale_id'=>$id);
                                    $result_sale_item =  $this->db->select('*')->where($where)->get('distributor_sale_items')->result();

                                    if(count($result_sale_item)>0)
                                    {
                                        $data = array(
                                        'distributor_sale_id' => $id,
                                        'type' => $type,
                                        'item_id' => $item_id,
                                        'qty' => format_number($quantity,2),
                                        'sell_rate' => format_number($sell_rate,2),
                                        'grams' => format_number($grams,2),
                                        'rate' => format_number($rate,2),
                                        'amount' => format_number($total_amount,2)
                                        );
                                       $this->db->where($where)->update('distributor_sale_items', $data);
                                       $this->db->last_query();       
                                    }else
                                    {
                                        $this->db->insert('distributor_sale_items', $data);
                                        $this->db->last_query(); 
                                    }

                                  
                                   
                                    if(count($res1)>0)
                                    {       
                                        $result_sum = $this->db->select('sum(amount) as amount')->where('distributor_sale_id',$id)->get('distributor_sale_items')->result();
                                        $data = array(
                                            'amount' => $result_sum[0]->amount
                                         );
                                        $this->db->where($where_array)->update('distributor_sale',$data);   
                                    }
									
                                }
                                else
                                {
                                    $error .='Invalid Item';
                                    $objerror =1;
                                }
                                
                        }
                        else
                        {
                            $error .='Combination does not matched';
                            $objerror =1;
                        }       

                    }

                    if($error!="")
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$date);
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$distributor);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$zone);
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$relation);
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$location);
                        $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$item);
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$quantity);
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,$due_date);
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,$remark);
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $error);
                        $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setWrapText(true);  
                    }
                 
                    $error = '';
            }
        }


        for($i=2;$i<=$highestrow;$i++)
        {
            $errorvalue = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getValue();

            if($errorvalue=='')
            {
              $objPHPExcel->getActiveSheet()->removeRow($i);

            }
        }

        if($objerror==1)
        {
            $filename='superstockis_upload_errors'.'_'.time().'.xlsx';
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            redirect(base_url().'index.php/distributor_sale');
        }
        else
        {
            redirect(base_url().'index.php/distributor_sale');
        }
    }

    public function get_distributor_details(){ 
        $postData = $this->input->post();
        $distributor_id = $postData['distributor_id'];
        $data = $this->distributor_sale_model->get_distributor_details($distributor_id);
        echo json_encode($data); 
    }

    public function common_excel($objValidation)
    {
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');/*
            $objValidation->setFormula1('"'.$distname.'"');*/
    }

    public function get_distributor_zone(){ 
        $postData = $this->input->post();
        $type_id = $postData['type_id'];
        $data = $this->distributor_sale_model->get_distributor_zone($type_id);
        echo json_encode($data); 
    }

    public function get_store(){ 
        $postData = $this->input->post();
    	$zone_id = $postData['zone_id'];
        $data = $this->distributor_sale_model->get_store($zone_id);
        echo json_encode($data); 
    }

    // public function get_location_data(){ 

    // $postData = $this->input->post();

    // $data = $this->distributor_sale_model->get_location_data($postData);
    // echo json_encode($data); 
    // }
	
	public function get_location_data(){ 
        $postData = $this->input->post();
        $zone_id = $postData['zone_id'];
        $store_id = $postData['store_id'];
        $data = $this->distributor_sale_model->get_location_data($store_id,$zone_id);
        echo json_encode($data); 
    }

    public function edit($id){
        $result=$this->distributor_sale_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_sale_model->get_access();
                $data['data'] = $this->distributor_sale_model->get_data('', $id);
				$data['distributor'] = $this->distributor_model->get_data('Approved', '', 'super stockist');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_sale_items'] = $this->distributor_sale_model->get_distributor_sale_items($id);
				$zone_id=$data['data'][0]->zone_id;
				$store_id=$data['data'][0]->store_id;
				$data['store'] = $this->distributor_sale_model->get_store($zone_id);
				$data['location'] = $this->distributor_sale_model->get_location_data($store_id,$zone_id);
				//$data['location'] = $this->distributor_sale_model->get_location_data();
				//$data['location'] = $this->distributor_sale_model->get_location();
				// $data['zone'] = $this->distributor_sale_model->get_zone();
                $data['zone'] = $this->zone_model->get_data('Approved','','ss_stores');
				  
                load_view('distributor_sale/distributor_sale_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_sale_model->save_data();
        redirect(base_url().'index.php/distributor_sale');
    }

    public function update($id){
        $this->distributor_sale_model->save_data($id);
        redirect(base_url().'index.php/distributor_sale');
    }

    public function save_super_stockist_distributor(){
        $this->distributor_sale_model->save_super_stockist_distributor();
        $data = $this->distributor_sale_model->get_super_stockist_distributor();
        $result = '<option value="">Select</option>';
        for($i=0; $i<count($data); $i++){
            $result = $result . '<option value="'.$data[$i]->id.'">'.$data[$i]->distributor_name.'</option>';
        }
        echo $result;
    }
}
?>