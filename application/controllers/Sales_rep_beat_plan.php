<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_beat_plan extends CI_Controller{

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
        $this->load->model('sr_beat_plan_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sr_beat_plan_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sr_beat_plan_model->get_data();

             load_view('sales_rep_beat_plan/beat_plan_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sr_beat_plan_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sr_beat_plan_model->get_access();
                $data['distributor'] = $this->sr_beat_plan_model->get_distributor_details();
                $data['sales_rep'] = $this->sr_beat_plan_model->get_sales_rep_details();
             

                load_view('sales_rep_beat_plan/beat_plan_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    /*public function download_csv()
    {
            $template_path=$this->config->item('template_path');
            $file = $template_path.'sale_rep_beat_upload.xlsx';
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(1);
            $row = 1;
            $sqlqueries = "
			select * from distributor_master order by distributor_name desc";

            $distributor_result  = $this->db->query($sqlqueries)->result();
            foreach($distributor_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->distributor_name);
                $row = $row+1;
            }
             
            $zn = 1;
            $sqlzone = "select * from sales_rep_master order by sales_rep_name desc";

            $zone_result  = $this->db->query($sqlzone)->result();             
             foreach($zone_result  as $dist)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$zn,$dist->sales_rep_name);
                $zn = $zn+1;
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
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        

            for($j=2;$j<=100;$j++)
            {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('A'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$A$1:$A$'.($row-1));

                $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$B$1:$B$'.($zn-1));
				
				$objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$j)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('\'Sheet2\'!$C$1:$C$'.($fq-1));

            }

            

			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
            $filename='sale_rep_beat_upload.xlsx';
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
    }*/

    public function download_csv()
    {
            $template_path=$this->config->item('template_path');
            $file = $template_path.'sales_rep_beat_upload1.xlsx';
            $this->load->library('excel');

            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(1);
            $row = 1;
            $sqlqueries = "select * from distributor_master where class='normal' and type_id=3 and status='Approved'";

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
    }
    /*public function upload_file()
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

       
       
            for($i=2;$i<=$highestrow;$i++)
            {
                //$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                $distributor = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                $sales_rep = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                $frequency = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
                $sequence = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
					
					  $sql = "select C.*, D.sales_rep_name from (select A.*, B.distributor_name from 
						(select * from sales_rep_beat_plan".$cond.") A 
						left join 
						(select * from distributor_master) B 
						on (A.distributor_id=B.id))C
						left join 
						(select * from sales_rep_master) D 
						on (C.sales_rep_id=D.id)
						where C.status='Approved' order by C.modified_on desc";
						
					$result = $this->db->query($sql)->result();   
					$distributor_id = $result[0]->distributor_id;
                    $sales_rep_id = $result[0]->sales_rep_id;
              
						
						
                    $now=date('Y-m-d H:i:s');
                    $curusr=$this->session->userdata('session_id');
                    $date_of_processing=date('Y-m-d');

                    $where_array = array("date_of_processing"=>$date_of_processing,
                                         "distributor_id"=>$distributor,
                                         "sales_rep_id"=>$sales_rep,
                                         "sequence"=>$sequence,
                                         "frequency"=>$frequency
                                    );

                    $res1 = $this->db->select("*")->where($where_array)->get("sales_rep_beat_plan")->result();
                    if(count($res1)>0)
                    {
                        //$total_amount = $total_amount+$res1[0]->amount;
                        $id = $res1[0]->id;
                    }
                    else
                    {
                        $data = array(
                       
								'date_of_processing' => $date_of_processing,
								'distributor_id' => $distributor_id,
								'sales_rep_id' =>$sales_rep_id,
								'frequency' => $frequency,
								'sequence' => $sequence,
								'status' => 'Approved',
								'modified_by' => $curusr,
								'modified_on' => $now,
						
						
                         );
                        $data['created_by']=$curusr;
                        $data['created_on']=$now;
                         $this->db->insert('sales_rep_beat_plan ',$data);
                        $this->db->last_query();
                        $id = $this->db->insert_id();
                    }

                  
                   
                    if(count($res1)>0)
                    {       
                        
                        $this->db->where($where_array)->update('sales_rep_beat_plan ',$data);   
                    }
            }
               redirect(base_url().'index.php/Sales_rep_beat_plan'); 
    }*/

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
        $result=$this->sr_beat_plan_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sr_beat_plan_model->get_access();
                $data['data'] = $this->sr_beat_plan_model->get_data('', $id);
				$data['distributor'] = $this->sr_beat_plan_model->get_distributor_details('Approved',$id);
				$data['sales_rep'] = $this->sr_beat_plan_model->get_sales_rep_details('Approved',$id);
             
              
				  
                load_view('Sales_rep_beat_plan/beat_plan_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->sr_beat_plan_model->save_data();
        redirect(base_url().'index.php/Sales_rep_beat_plan');
    }

    public function update($id){
        $this->sr_beat_plan_model->save_data($id);
        redirect(base_url().'index.php/Sales_rep_beat_plan');
    }

   
}
?>