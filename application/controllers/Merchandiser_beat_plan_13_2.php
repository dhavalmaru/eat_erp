<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Merchandiser_beat_plan extends CI_Controller{

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
        $this->load->model('relationship_model');
        $this->load->model('Merchandiser_beat_plan_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
        $result=$this->Merchandiser_beat_plan_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->Merchandiser_beat_plan_model->get_beatplan();

             load_view('Merchandiser_beat_plan/beat_plan_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->Merchandiser_beat_plan_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->Merchandiser_beat_plan_model->get_access();
                $data['store'] = $this->Merchandiser_beat_plan_model->get_distributor_details();
                $data['sales_rep'] = $this->Merchandiser_beat_plan_model->get_sales_rep_details();
             

                load_view('Merchandiser_beat_plan/beat_plan_details', $data);
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
            $file = $template_path.'merchandiser_beat_upload1.xlsx';
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(1);
            /*$row = 1;
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
            }*/
             
            $zn = 1;
            $sqlzone = "select A.zone  from 
                        (select * from zone_master where (type_id='4' or type_id='7')) A 
                        left join 
                        (select * from distributor_type_master) B 
                        on (A.type_id=B.id) where A.status='Approved'  order by A.zone desc";

            $zone_result  = $this->db->query($sqlzone)->result();             
             foreach($zone_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$zn,$dist->zone);
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
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$rn,$dist->store_name);
                $rn = $rn+1;
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
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ln,$dist->location);
                $ln = $ln+1;
            }

            
              $sr = 1;
            $sqlsr = "select * from sales_rep_master order by sales_rep_name desc";

            $sr_result  = $this->db->query($sqlsr)->result();             
             foreach($sr_result  as $sr1)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$sr,$sr1->sales_rep_name);
                $sr = $sr+1;
            }
           
            $fq = 1;
            $sqlfq = "SELECT * FROM frequency_master";
            $fq_result  = $this->db->query($sqlfq)->result();             
             foreach($fq_result  as $freq)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$fq,$freq->frequency);
                $fq = $fq+1;
            }
           
         
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);

            for($j=2;$j<=100;$j++)
            {
                /*$objValidation = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($row-1));*/

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($zn-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.($rn-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.($ln-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$D$1:$D$'.($sr-1));
                
                  $objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$E$1:$E$'.($fq-1));
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
            $filename='merchandiser_beat_upload1.xlsx';
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
            // $objPHPExcel->getActiveSheet()->setCellValue('E', 'Error Remark');
            // $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objerror = 0;
            $error_line = '';
            $batch_array = [];
       
       
           for($i=2;$i<=$highestrow;$i++)
            {
                    //$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                    //$distributor = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                    $zone = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                    $relation = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                    $location = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
                    $sales_rep = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
                    $frequency = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
                    $sequence = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
                    $error = '';

                    $sql = "select G.*,H.location from (select E.*, F.store_name 
                        from(
                        select A.zone,A.type_id,A.id as zoneid,D.id, D.store_id,D.location_id from 
                        (select * from zone_master where type_id='4' or type_id='7' ) A
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
                        // $store_id = $result[0]->store_id;
                        // $sales_rep_id = $result[0]->sales_rep_id;
                       /* $sql ="Select id,`distributor_name` from distributor_master Where distributor_name='$distributor'";

                        $result_dist = $this->db->query($sql)->result(); 

                        $distributor_id = $result_dist[0]->id;*/
                    
                    
                        
                        $sql ="Select id,`sales_rep_name` from sales_rep_master Where sales_rep_name='$sales_rep'";

                        $result_sales_rep = $this->db->query($sql)->result(); 

                        $sales_rep_id = $result_sales_rep[0]->id;
                            
                        $now=date('Y-m-d H:i:s');
                        $curusr=$this->session->userdata('session_id');
                      

                        /*$where_array = array(
                                             "store_id"=>$store_id,
                                             "zone_id"=>$zone_id,
                                             "location_id"=>$location_id,
                                             "sales_rep_id"=>$sales_rep_id,
                                             "sequence"=>$sequence,
                                             "frequency"=>$frequency
                                        );*/

                       /* $res1 = $this->db->select("*")->where($where_array)->get("merchandiser_beat_plan")->result();
                        $res2 = $this->db->select("*")->where($where_array)->get("admin_merchendizer_beat_plan")->result();*/
                        $data = array(
                           
                                    
                                    'store_id' => $store_id,
                                    'zone_id' => $zone_id,
                                    'location_id' => $location_id,
                                    'sales_rep_id' =>$sales_rep_id,
                                    'frequency' => $frequency,
                                    'sequence' => $sequence,
                                    'status' => 'Approved',
                                    'modified_by' => $curusr,
                                    'modified_on' => $now,
                            
                        
                         );
                        $data['created_by']=$curusr;
                        $data['created_on']=$now;
                       /* if(count($res1)>0)
                        {
                           $id = $res1[0]->id;
                           $this->db->where($where_array)->update('merchandiser_beat_plan ',$data);   
                        }*/

                        /*if(count($res2)>0)
                        {
                            //$total_amount = $total_amount+$res1[0]->amount;
                            $id = $res2[0]->id;
                            $abc= $this->db->where($where_array)->update('admin_merchendizer_beat_plan ',$data);   
                        }
                        else
                        {
                           
                            $this->db->insert('merchandiser_beat_plan ',$data);
                            $abc=$this->db->insert('admin_merchendizer_beat_plan ',$data);
                             
                            $this->db->last_query();
                            $id = $this->db->insert_id();
                        }*/
                        $batch_array[] =$data;
                    }
                    else
                    {
                        $error .='Combination does not matched';
                        $objerror =1;
                        $error_line .= $i.',';
                        
                    }

                    if($error!="")
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $error);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);  
                    }
            }
            
            if($objerror==1)
            {
                $objPHPExcel->setActiveSheetIndex(1);
                /*$row = 1;
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
                }*/
                 
                $zn = 1;
                $sqlzone = "select A.zone  from 
                            (select * from zone_master where (type_id='4' or type_id='7')) A 
                            left join 
                            (select * from distributor_type_master) B 
                            on (A.type_id=B.id) where A.status='Approved'  order by A.zone desc";

                $zone_result  = $this->db->query($sqlzone)->result();             
                 foreach($zone_result  as $dist)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$zn,$dist->zone);
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
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$rn,$dist->store_name);
                    $rn = $rn+1;
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
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$ln,$dist->location);
                    $ln = $ln+1;
                }

                
                  $sr = 1;
                $sqlsr = "select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc";

                $sr_result  = $this->db->query($sqlsr)->result();             
                 foreach($sr_result  as $sr1)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$sr,$sr1->sales_rep_name);
                    $sr = $sr+1;
                }
               
                $fq = 1;
                $sqlfq = "SELECT * FROM frequency_master";
                $fq_result  = $this->db->query($sqlfq)->result();             
                 foreach($fq_result  as $freq)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$fq,$freq->frequency);
                    $fq = $fq+1;
                }
               
             
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);

                for($j=2;$j<=100;$j++)
                {
                    /*$objValidation = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getDataValidation();
                    $this->common_excel($objValidation);
                    $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($row-1));*/

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getDataValidation();
                    $this->common_excel($objValidation);
                    $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($zn-1));

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getDataValidation();
                    $this->common_excel($objValidation);
                    $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.($rn-1));

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getDataValidation();
                    $this->common_excel($objValidation);
                    $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.($ln-1));

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$j)->getDataValidation();
                    $this->common_excel($objValidation);
                    $objValidation->setFormula1('\'Sheet2\'!$D$1:$D$'.($sr-1));
                    
                      $objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.$j)->getDataValidation();
                    $this->common_excel($objValidation);
                    $objValidation->setFormula1('\'Sheet2\'!$E$1:$E$'.($fq-1));
                }
                $filename='merchendizer_upload_errors'.'_'.time().'.xlsx';
                header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                sleep(0.50);
                redirect(base_url().'index.php/Merchandiser_beat_plan');
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
                    /*If Frequency contain Every Push in array*/    
                    if (strpos($frequency, 'Every') !== false) {

                         /*Search Frequency and sales rep id in array if exsist dont push else push*/     

                        if(array_search($frequency, array_column($unique_array, 'frequency')) !== false && array_search($sales_rep_id, array_column($unique_array, 'sales_rep_id')) !== false) {
                             'value is in multidim array';
                        }
                        else {
                            $unique_array[]=array("frequency"=>$frequency,"sales_rep_id"=>$sales_rep_id);
                        }
                    }
                


                     $where_array = array(
                                             /*"store_id"=>$store_id,
                                             "zone_id"=>$zone_id,
                                             "location_id"=>$location_id,*/
                                             "sales_rep_id"=>$sales_rep_id,
                                             //"sequence"=>$sequence,
                                             "frequency"=>$frequency
                                        );
                    /*Check sales_rep_id and frequency and delete previous entries for Every*/      
                    $this->db->where($where_array)->delete('merchandiser_beat_plan');
                    $this->db->where($where_array)->delete('admin_merchendizer_beat_plan');
                }

                /*Insert Entries For Every Frequency*/
                $this->db->insert_batch('merchandiser_beat_plan ',$batch_array);
                $this->db->insert_batch('admin_merchendizer_beat_plan ',$batch_array);

                $batch_unique_array = [];    
                /*Unique array Run for loop to get data for every frequency beatplan*/
				
				
                for ($k=0; $k<count($unique_array); $k++) { 
                    $where_array = array(
                                            "sales_rep_id"=>$unique_array[$k]['sales_rep_id'],
                                             "frequency"=>$unique_array[$k]['frequency']
                                            );
                    $result = $this->db->select('*')->where($where_array)->get('merchandiser_beat_plan')->result();
					echo '<br>'.$this->db->last_query();
                   /*Fetched result from merchendiser beat plan for perticular sales_rep_id and frequency*/     


                    for($l=0;$l<count($result);$l++)
                    {
                        /*batch_unique_array is created for ALternate Frequency */

                        $sequence = $result[$l]->sequence;
						$frequency = $result[$l]->frequency;
                        $explode_frequency = explode(' ',$frequency);
                        $new_frequency = 'Alternate '.$explode_frequency[1];

                        $where_unique_array = array(
                                            "sales_rep_id"=>$result[$l]->sales_rep_id,
                                             "frequency"=>$new_frequency
                                            );


                        $this->db->where($where_unique_array)->delete('merchandiser_beat_plan');
                        $this->db->where($where_unique_array)->delete('admin_merchendizer_beat_plan');
                        
                        $data = array(
                                    'store_id' => $result[$l]->store_id,
                                    'zone_id' => $result[$l]->zone_id,
                                    'location_id' => $result[$l]->location_id,
                                    'sales_rep_id' =>$result[$l]->sales_rep_id,
                                    'frequency' => $new_frequency,
                                    'sequence' => $sequence,
                                    'status' => 'Approved',
                                    'modified_by' => $curusr,
                                    'modified_on' => $now
                         );
                        $data['created_by']=$curusr;
                        $data['created_on']=$now;
						
												
                        $batch_unique_array[] =$data; 
                        /*Data is push in batch unique array */
                    }
                }

                $this->db->insert_batch('merchandiser_beat_plan ',$batch_unique_array);
                $this->db->insert_batch('admin_merchendizer_beat_plan',$batch_unique_array);
                    
                redirect(base_url().'index.php/Merchandiser_beat_plan');

            } 
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

   

  

    // public function get_location_data(){ 

    // $postData = $this->input->post();

    // $data = $this->distributor_sale_model->get_location_data($postData);
    // echo json_encode($data); 
    // }
    

    public function edit($id){
        $result=$this->Merchandiser_beat_plan_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->Merchandiser_beat_plan_model->get_access();
                $data['data'] = $this->Merchandiser_beat_plan_model->get_data('', $id);
                $data['store'] = $this->Merchandiser_beat_plan_model->get_distributor_details('Approved',$id);
                $data['sales_rep'] = $this->Merchandiser_beat_plan_model->get_sales_rep_details('Approved',$id);
             
              
                  
                load_view('Merchandiser_beat_plan/beat_plan_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->Merchandiser_beat_plan_model->save_data();
        redirect(base_url().'index.php/Merchandiser_beat_plan');
    }

    public function update($id){
        $this->Merchandiser_beat_plan_model->save_data($id);
        redirect(base_url().'index.php/Merchandiser_beat_plan');
    } 


    public function change_admin_sequence($id='')
    {
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $frequency = '';

        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }

       
			$result=$this->Merchandiser_beat_plan_model->get_access();    
               if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
             $data['access'] = $this->Merchandiser_beat_plan_model->get_access();
           
            $sales_rep = $this->db->query("select * from sales_rep_master where sr_type='Merchandizer' and status='Approved' order by sales_rep_name desc")->result();
            if($id!="")
            {
                $sql = "select Distinct G.*,B.location from (select E.*,F.sales_rep_name from(select C.*, D.google_address,D.latitude,D.longitude from (select A.*,B.store_name from 
                    (Select * from  merchandiser_beat_plan Where frequency='$frequency' and sales_rep_id=$id)  A 
                    left join 
                    (SELECT * FROM relationship_master where type_id ='4' or type_id='7') B 
                    on (A.store_id=B.id))C
                    left join 
                    (select * from store_master) D 
                    on (C.store_id=D.store_id))E
                     left join 
                    (select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc ) F 
                    on (E.sales_rep_id=F.id))G
                    left join
                    (select * from location_master) B 
                     on (G.location_id=B.id)
                    order by G.sequence asc,G.modified_on Desc
                    ";
                $detailed_beat_plan = $this->db->query($sql)->result_array();

                $sql = "select Distinct G.* ,B.location  from (select E.*,F.sales_rep_name from(select C.*, D.google_address,D.latitude,D.longitude from (select A.*,B.store_name from 
                    (Select * from  admin_merchendizer_beat_plan Where frequency='$frequency' and sales_rep_id=$id) A 
                    left join 
                    (SELECT * FROM relationship_master where type_id ='4' or type_id='7') B 
                    on (A.store_id=B.id))C
                    left join 
                    (select * from store_master) D 
                    on (C.store_id=D.store_id))E
                     left join 
                    (select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc ) F 
                    on (E.sales_rep_id=F.id))G
                    left join
                    (select * from location_master) B 
                     on (G.location_id=B.id)
                    order by G.sequence asc,G.modified_on Desc
                    ";
                $admin_merchendizer_beat_plan = $this->db->query($sql)->result_array(); 


                $data['beat_plan']=$detailed_beat_plan;
                $data['admin_beat_plan']=$admin_merchendizer_beat_plan;
                $data['sales_rep_id']=$id;        
            }
            else
            {
              $data['beat_plan']=[];
              $data['admin_beat_plan']=[];  
              $data['sales_rep_id']='';
            }
            $data['sales_rep']=$sales_rep; 
            $data['frequency']=$frequency;
            
            load_view('Merchandiser_beat_plan/edit_beat_plan', $data);
            //$this->load->view('Merchandiser_beat_plan/edit_beat_plan',$data);

        }  else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }       
    }}

    public function get_alternate($day,$m,$year)
    {
        
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate) 
        {
            return true;
        }
        elseif($date2==$todaysdate)
        {
            return true;
        }
        else
        {
           return false;
        }
    }

    public function save_changesequence()
    {
       $ispermanent = $this->input->post('ispermenant');
       $resultb= $this->Merchandiser_beat_plan_model->change_sequence($ispermanent);

       $id = $this->input->post('sales_rep_id');
       $this->change_admin_sequence($id);
    }
	
	public function merchandizer_not_mapped($status='')
    {
       $result = $this->db->query('Select DISTINCT sales_rep_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

        if(count($result)>0)
        {
            $sales_rep_id =  implode(" ,", $sales_rep_id);
           $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='merchandizer' and id NOT IN($sales_rep_id)")->result();
           $this->db->last_query();
        }
        else
        {
           $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='merchandizer'")->result();
           $this->db->last_query(); 
        }

       
       $template_path=$this->config->item('template_path');
       $file = $template_path.'merchandiser.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='merchandiser.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }
	
	  public function store_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT store_id from merchandiser_beat_plan')->result();

        $store_id = array();
        foreach ($result as $data) {
            $store_id[]=$data->store_id;
        }

       $store_id =  implode(" ,", $store_id);

        if(count($result)>0)
        {
            $result = $this->db->query("select * from relationship_master Where status='Approved' and id NOT IN($store_id)")->result();
        } else
        {
           $result = $this->db->query("Select * from relationship_master Where  status='Approved'")->result();
           $this->db->last_query(); 
        }
       
       $template_path=$this->config->item('template_path');
       $file = $template_path.'store.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->store_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='store.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }
	
	
	public function zone_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT zone_id from merchandiser_beat_plan')->result();

        $zone_id = array();
		$count=count($result);
		if($count>2)
		{
        foreach ($result as $data) {
            $zone_id[]=$data->zone_id;
				
        }
		
		$zone_id =  implode(",", $zone_id);
		}
		else
		{
		foreach ($result as $data) {
            $zone_id=$data->zone_id;
				
        }
        			
       
		}

      // $zone_id =  implode(" ,", $zone_id);
       if(count($result)>0)
        {
            $result = $this->db->query("select * from zone_master Where status='Approved' and id NOT IN($zone_id)")->result();
        }
        else
        {
            $result = $this->db->query("select * from zone_master Where status='Approved'")->result();
        }

       
       $template_path=$this->config->item('template_path');
       $file = $template_path.'zone.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->zone);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='zone.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }
	
	/*public function retailer_not_mapped($status='')
		{
		   $result = $this->db->query('Select DISTINCT distributor_id from merchandiser_beat_plan')->result();
			
			$distributor_id = array();
			$count=count($result);
			if($count>2)
			{
			foreach ($result as $data) {
				$distributor_id[]=$data->distributor_id;
					
			}
			
			$distributor_id =  implode(",", $distributor_id);
			}
			else
			{
			foreach ($result as $data) {
				$distributor_id=$data->distributor_id;
					
			}
				$distributor_id=$data->distributor_id;
					
		   
			}
		   $result = $this->db->query("SELECT * from distributor_master Where class='Super Stockist' and status='Approved' and id NOT IN($distributor_id)")->result();
		   $template_path=$this->config->item('template_path');
		   $file = $template_path.'retailers.xls';
		   $this->load->library('excel');
		   $objPHPExcel = PHPExcel_IOFactory::load($file);
		   $objPHPExcel->setActiveSheetIndex(0);
		   $row = 3;
		   foreach($result  as $dist)
			{
			   $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->distributor_name);
			   $row = $row+1;
			}

			if(count($result)>0)
			{
				$filename='retailers.xls';
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}
		}*/
public function get_sales_rep_email(){
		$frequency='';
        $data = $this->Merchandiser_beat_plan_model->get_sales_rep_email($frequency);
				
        $data1 = $this->Merchandiser_beat_plan_model->get_sales_rep1_email($frequency);
        $data2 = $this->Merchandiser_beat_plan_model->get_sales_rep2_email($frequency);
        //$orders= $this-Merchandiser_beat_plan_model->get_sales_rep_order_email();
        $total_visits = $this->Merchandiser_beat_plan_model->get_sales_rep_total_visits_email($frequency);
		$tbody ='';
		$from_email = 'cs@eatanytime.co.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
       
		//$to_email = "mukesh@eatanytime.in,sulochana@eatanytime.co.in";
		$to_email = "ashwini.patil@pecanreams.com";
		// $bcc = "sangeeta.yadav@pecanreams.com, dhaval.maru@pecanreams.com";
		//$bcc = "rishit.sanghvi@eatanytime.in, dhaval.maru@pecanreams.com, swapnil.darekar@eatanytime.in, mis@eatanytime.co.in, ashwini.patil@pecanreams.com, sangeeta.yadav@pecanreams.com ";
	
        $subject = 'Daily Performance Report For Merchandiser - '.date("d F Y",strtotime("now"));

         $tbody ='<!DOCTYPE html">
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					 


					  <style type="text/css">
					  body {margin: 0; padding: 20px; min-width: 100%!important;font-family "Arial,Helvetica,sans-serif";}
					  img {height: auto;}
					  .content { max-width: 600px;}
					  .header {padding:  20px;}
					  .innerpadding {padding: 30px 30px 30px 30px;}
					  .innerpadding1 {padding: 0px 30px 30px 30px;}
					  
					  .borderbottom {border-bottom: 1px solid #f2eeed;}
					  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
					  .h1, .h2, .bodycopy {color: #fff; font-family: sans-serif;}
					  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
					  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
					  .bodycopy {font-size: 16px; line-height: 22px;}
					  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
					  .button a {color: #ffffff; text-decoration: none;}
					  .footer {padding: 20px 30px 15px 30px;}
					  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
					  .footercopy a {color: #ffffff; text-decoration: underline;}

					  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
					  body[yahoo] .hide {display: none!important;}
					  body[yahoo] .buttonwrapper {background-color: transparent!important;}
					  body[yahoo] .button {padding: 0px!important;}
					  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
					  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
					  }

					  /*@media only screen and (min-device-width: 601px) {
						.content {width: 600px !important;}
						.col425 {width: 425px!important;}
						.col380 {width: 380px!important;}
						}*/
						table, th, td {
					   
						border-collapse: collapse;
					}
					th, td {
						  padding: 3px;
						text-align: left;
						
					}
					.total
						{
							color: #333333;
							font-size: 28px;
							font-family: Arial,Helvetica,sans-serif;
						}
						.used
						{
							color: #666666;
							font-size: 20px;
							font-family: Arial,Helvetica,sans-serif;
						}
						.team_head
						{
							font-size:36px;
							font-weight:normal;
							color:#fff;
							font-family: "Arial,Helvetica,sans-serif";
						}
						.date
						{
							font-size:16px;
							color:#fff;
						}
						.upper_table td
						{
							border:1px solid #ddd;
							text-align:center;
								 padding: 10px;
							
						}
						.body_table tbody 
						{
							border:1px solid #ddd;
							background-color: #fdfbfb;
							color: #656d78;
						}
					  </style>
					</head>

					<body yahoo bgcolor="#f6f8f1" style="margin-top:20px;"margin-bottom:20px;">
					<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
					<tr>
					  <td style="padding-top:30px; padding-bottom:30px;">
						<!--[if (gte mso 9)|(IE)]>
						  <table width="400" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tr>
							  <td style="padding-top:15px; padding-bottom:15px;>
						<![endif]-->     
						<table bgcolor="#ffffff" class="content" style="max-width: 400px;" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
						  <tr>
							<td bgcolor="#0c2c4e" class="header" style="padding:20px;" colspan="20" >
							 
							  <!--[if (gte mso 9)|(IE)]>
								<table width="425" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;padding-top:15px; padding-bottom:15px;">
								  <tr>
									<td style="padding-top:15px; padding-bottom:15px;">
							  <![endif]-->
							  <table class="" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%;"style="border-collapse: collapse;">  
								<tr>
								  <td height="70">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
									  <tr>
										<td class="subhead" style="padding: 0 0 0 3px;width:30%;font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;">
										   <img class="fix" src="https://www.eatanytime.in/test/img/white_logo.png" width="100" height="100" border="0" alt="" style=" height: auto;"/>
										
										</td>
								   
									 
										<td  style="width:70%;text-align:right">
											<span class="team_head" style="font-size:36px;font-weight:normal;color:#fff;">Team Activity Report</span><br>
											<small class="date" style="font-size:16px;color:#fff;">';
											$tbody.= date("d F Y",strtotime("now")).'</small>
										</td>
									  </tr>
									</table>
								  </td>
								</tr>
							  </table>
							  <!--[if (gte mso 9)|(IE)]>
									</td>
								  </tr>
							  </table>
							  <![endif]-->
							</td>
						  </tr>
						  <tr>
							<td class="innerpadding " style="padding: 30px 30px 30px 30px;" >
							   <table class="table upper_table" style="width:600px;border-collapse: collapse;" >
									<tr>
										 <td align="center" valign="top" style="border:1px solid #ddd;width:50%;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">ATTENDANCE</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ;
										 if(count($data2)>0)
											{ 
												 $tbody.=$data2[0]->present_merchandiser;
											}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/' ;
										if(count($data1)>0)
										{
											
											$tbody.=$data1[0]->total_merchandiser;
										}
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Visits</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
										if(count($total_visits)>=0)
										{
											
											$tbody .=(isset($total_visits[0]->actual)?$total_visits[0]->actual:0);		
										}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/'; 	
										if(count($total_visits)>=0)
										{
											
											$tbody .=(isset($total_visits[0]->plan)?$total_visits[0]->plan:0);	
										}
										
								$tbody .='</span></td>
    
					</tr>
           
            
			</table>
			</td>
			</tr>
    
       <td class="innerpadding1 " style="padding: 0px 30px 30px 30px;">
           <table  class="body_table" style="border-collapse: collapse;width:100%">
			<thead>
				<tr style=" background-color: #f3f3f3 ;border-bottom: 1px solid #ddd;font-weight: bold;">
				 
				  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:150px">Name Of Employee</th>
				  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Attendence</th>
				  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:120px">Beat Name</th>
				  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Planned Vists</th>
				  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Acutal Vists</th>
		
				  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Deviation %</th>
				
			
				  
				  
				</tr>
			</thead>
			<tbody style="border:1px solid #ddd;
							background-color: #fdfbfb;
							color: #656d78;">
          '; 
				
				if(count($data)>=0) {
					for($i=0; $i<count($data); $i++)
					{
						if($data[$i]->sales_rep_id <>'')
						{		
								$div=($data[$i]->actual_count)/($data[$i]->planned_count);
								if($div> 0 )
								{
									$deviation=(1-($data[$i]->actual_count)/($data[$i]->planned_count))*100;
								}
								else
								{
									$deviation='0';
								}
						
								$tbody.= ' <tr>
									
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222;">'.$data[$i]->sales_rep_name.'
									</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color: #881818; text-transform: UPPERCASE;font-size: 12px;">'.$data[$i]->emp_status.'</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->frequency.'</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->planned_count.'</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->actual_count.'</td>
								
								
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($deviation,2).'%</td>
								
									</tr>';
						  }
					}
				}
            
            $tbody.=   '</tbody>
          </table>
        </td>
	  </tr>
   
   
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>

<!--analytics-->

</body>
</html>' ;

//echo $tbody;
            
          echo 'mailsent'.$mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody, $bcc);
          if ($mailSent==1) {
              echo "Send";
          } else {
              echo "NOT Send".$mailSent;
          }

        // load_view('invoice/emailer', $data);
    }
   
}
?>