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

	/*public function download_csv(){
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

	public function download_csv(){
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

	/*public function upload_file(){
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

	public function upload_file(){
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


				$sql = "select K.*,L.area from(select I.*,j.sales_rep_name,
						j.id as sales_reps_id from 
						 (select G.*,H.distributor_type from (select E.*,F.location from(Select C.*,D.zone from (select A.* from (select * from sr_mapping Where type_id=3 ) A 
						) C 
						left join (select * from zone_master) D on D.id=C.zone_id) E 
						left join (select * from location_master)F on F.id=E.location_id)G 
						left join (select * from distributor_type_master)H on H.id=G.type_id)I 
						left join (select * from sales_rep_master)j on (j.id=I.reporting_manager_id OR j.id=I.sales_rep_id1 OR j.id=I.sales_rep_id2))K 
						left join (select * from area_master)L on L.id=K.area_id 
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
						
						if (strpos($frequency, 'Every') !== false) {
							$new_frequency = 'Alternate '.$explode_frequency[1];
							$where_unique_array = array(
											"sales_rep_id"=>$unique_array[$k]['sales_rep_id'],
											 "frequency"=>$new_frequency,
											 'modified_on<>'=>$now1,
											);


							$this->db->where($where_unique_array)->delete('sales_rep_beat_plan');
							$this->db->where($where_unique_array)->delete('admin_sales_rep_beat_plan');   
						

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
							$new_frequency1 = 'Alternate2 '.$explode_frequency[1];

							$where_unique_array1 = array(
												"sales_rep_id"=>$unique_array[$k]['sales_rep_id'],
												 "frequency"=>$new_frequency1,
												 'modified_on<>'=>$now1,
												);


							$this->db->where($where_unique_array1)->delete('sales_rep_beat_plan');
							$this->db->where($where_unique_array1)->delete('admin_sales_rep_beat_plan'); 

							$data1 = array(
											'store_id' =>$store_id,
											'zone_id' => $zone_id,
											'location_id' => $location_id,
											'sales_rep_id' =>$sales_rep_id,
											'frequency' => $new_frequency1,
											'sequence' => $sequence,
											'status' => 'Approved',
											"area_id"=>$area_id,
											'modified_by' => $curusr,
											'modified_on' => $now
								 );
							$data1['created_by']=$curusr;
							$data1['created_on']=$now;
							
							$batch_unique_array[] =$data1;    
						}
						  
					}
				}


				if(count($batch_unique_array)>0)
				{
				  $this->db->insert_batch('sales_rep_beat_plan ',$batch_unique_array);
				  $this->db->insert_batch('admin_sales_rep_beat_plan',$batch_unique_array);  
				}
				
				redirect(base_url().'index.php/Sales_rep_beat_plan');
			} 
	}
	
	public function common_excel($objValidation){
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

	public function get_sales_rep_email(){
		$frequency='';
		$data = $this->sr_beat_plan_model->get_sales_rep_email($frequency);
		$result1 = $this->sr_beat_plan_model->get_sales_rep_daily_route_plan($frequency);
		$data1 = $this->sr_beat_plan_model->get_sales_rep1_email($frequency);
		$data2 = $this->sr_beat_plan_model->get_sales_rep2_email($frequency);
		$orders= $this->sr_beat_plan_model->get_sales_rep_order_email();
		$total_visits = $this->sr_beat_plan_model->get_sales_rep_total_visits_email($frequency);
		$tbody ='';
		$from_email = 'cs@eatanytime.co.in';
		$from_email_sender = 'Wholesome Habits Pvt Ltd';
	   
		 //$to_email = "rishit.sanghvi@eatanytime.in,sales@eatanytime.co.in,manorma@eatanytime.in,raveer66@gmail.com";
		$to_email = "prasad.bhisale@otbconsulting.co.in";
		 $bcc = "dhaval.maru@otbconsulting.co.in";
	 //$bcc = "swapnil.darekar@eatanytime.in";
	
		$subject = 'Daily Performance Report For Sales Representative-'.date("d F Y",strtotime("now"));

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
						  <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tr>
							  <td style="padding-top:15px; padding-bottom:15px;>
						<![endif]-->     
						<table bgcolor="#ffffff" class="content" style="max-width: 600px;" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
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
							   <table class="table upper_table" style="width:765px;border-collapse: collapse;margin: 0 auto;" >
									<tr>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">ATTENDANCE</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ;
										 if(count($data2)>0)
											{ 
												 $tbody.=$data2[0]->present_sales_rep ;
											}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/' ;
										if(count($data1)>0)
										{
											
											$tbody.=$data1[0]->total_sales_rep;
										}
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Visits</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
										if(count($total_visits)>=0)
										{
											
											$tbody .=(isset($total_visits[2]->unplan)?$total_visits[2]->unplan:0);		
										}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/'; 	
										if(count($total_visits)>=0)
										{
											
											$tbody .=(isset($total_visits[1]->unplan)?$total_visits[1]->unplan:0);	
										}
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Unplanned Visits
													</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">';
										if(count($total_visits)>=0)
										{ 
										
											$tbody .=(isset($total_visits[0]->unplan)?$total_visits[0]->unplan:0);	
										}
										$tbody .='</span></td>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Calls
										</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
										if(count($total_visits)>=0)
										{
											if(isset($total_visits[0]->unplan)|| ($total_visits[2]->unplan)){
											
											$total_calls=$total_visits[0]->unplan + $total_visits[2]->unplan;
											$tbody.=$total_calls;
											}
											else
											{
												$total_calls=0;
												$tbody.=$total_calls;	
											}
										
										
										}
										$tbody .='</span></td>
								  <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Order Units


								</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
								
								if(count($orders)>0){ 
								$tbody .=(isset($orders[0]->od_units)?$orders[0]->od_units:0);									
								}
								$tbody .='</span></td>
								  <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Order Value


								</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
								if(count($orders)>0){  
								$od_value=format_money($orders[0]->od_value,2);
								$tbody .=(isset($orders[0]->od_value)?$od_value:0);	
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
				
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align:left;width:500px">Name Of Employee</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Attendence</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Beat Name</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Planned Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Acutal Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Unplanned Visits</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Total Calls</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Deviation %</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Productive Calls</th>
						  <th style="padding: 8px;text-align: left;">% Productivity</th>
					
						  
						  
						</tr>
					</thead>
					<tbody style="border:1px solid #ddd;
									background-color: #fdfbfb;
									color: #656d78;">
				  '; 
						
						if(count($data)>0) {
							
							for($i=0; $i<count($data); $i++){
								if($data[$i]->sales_rep_id <>'')
								{	
										
										$div=($data[$i]->planned_count)/($data[$i]->actual_count);
										if($div> 0 )
										{
											$deviation=(1-($data[$i]->planned_count)/($data[$i]->actual_count))*100;
										}
										else
										{
											$deviation='0';
										}
										
										$single_total_calls=$data[$i]->planned_count + $data[$i]->unplanned_count;
										$productivity=($data[$i]->p_call/$single_total_calls)*100;
								
										$tbody.= ' <tr>
											
											
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222;">'.$data[$i]->sales_rep_name.'
											</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color: #881818; text-transform: UPPERCASE;font-size: 12px;">'.$data[$i]->emp_status.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->frequency.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->actual_count.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->planned_count.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->unplanned_count.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$single_total_calls.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($deviation,2).'%</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.(isset($data[$i]->p_call)?$data[$i]->p_call:0).'</td>
										
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($productivity,2). '%</td>
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
			if(count($result1)>0)
			{
				$template_path=$this->config->item('template_path');
				$file = $template_path.'sales_rep_route_plan_daily_report.xls';
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				$objPHPExcel->setActiveSheetIndex(0);
				$row=7;

				for($j=0;$j<count($result1);$j++)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($j+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result1[$j]->distributor_name);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result1[$j]->sales_rep_name);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result1[$j]->frequency);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result1[$j]->betweennooforders);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result1[$j]->od_units); 
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result1[$j]->plan_status);                 

					$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(

						'borders' => array(

							'allborders' => array(

								'style' => PHPExcel_Style_Border::BORDER_THIN

							)

						)

					));

					$row = $row+1;
				}

				for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				}
				

				$filename='sales_rep_daily_route_plan_'.date('Y-F-d').'.xls';
				$path  = '/home/eatangcp/public_html/test/assets/uploads/daily_sales_rep_reports/';
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
				$objWriter->save($path.$filename);   
			}
			
		  echo $attachment = $path.$filename;

		  echo 'mailsent'.$mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody, $bcc,'',$attachment);
		  if ($mailSent==1) {
			  echo "Send";
		  } else {
			  echo "NOT Send".$mailSent;
		  }

		//load_view('invoice/emailer', $data);
	}
	
   	public function get_sales_rep_byemail_old($value=''){
		$frequency ='$frequency';
		$sql = "Select A.*,Z.zone,E.p_call,D.actual_count,Case When F.check_in_time IS NULL THEN 'Absent' Else 'Present' end as emp_status
			,O.od_units,'' as od_value
			from (
			SELECT A.sales_rep_name,A.id,B.planned_count,C.unplanned_count,C.sales_rep_id,C.zone_id From
			(SELECT * from sales_rep_master Where status='Approved' and sr_type='Sales Representative')A
			Left join
			(SELECT count(*) as planned_count,sales_rep_id,zone_id from sales_rep_beat_plan A Where store_id 
			In ( Select store_id from sales_rep_detailed_beat_plan Where frequency='$frequency'  and sales_rep_id=A.sales_rep_id and is_edit='edit' and date(date_of_visit)=date(now()) and bit_plan_id!=0) 
			and date(created_on)<>date(now()) and frequency='$frequency' GROUP By sales_rep_id,zone_id) B On A.id=B.sales_rep_id
			Left join
			(
				SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id,zone_id from 
				(SELECT count(*) as unplanned_count,sales_rep_id,zone_id from sales_rep_beat_plan A Where store_id 
				In (Select store_id from sales_rep_detailed_beat_plan Where frequency='$frequency'  and sales_rep_id=A.sales_rep_id and is_edit='edit' and bit_plan_id!=0) and date(created_on)=date(now())
				GROUP By sales_rep_id,zone_id
				UNION
				SELECT count(*) as unplanned_count,sales_rep_id,zone_id from sales_rep_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)=date(now()) and bit_plan_id=0 GROUP By sales_rep_id,zone_id
				Union
				Select count(*) as unplanned_count,sales_rep_id,zone_id from sales_rep_location Where followup_date IS NOT NULL and date(date_of_visit)=date(now()) GROUP By sales_rep_id,zone_id) A GROUP BY sales_rep_id,zone_id
			) C on A.id=C.sales_rep_id
			) A
			Left join 
			(Select * from zone_master Where status='Approved') Z On A.zone_id=Z.id
			left join 
			(SELECT count(id) as p_call,sales_rep_id from sales_rep_orders Where id IN (Select sales_rep_order_id From sales_rep_order_items)) E 
			On A.sales_rep_id=E.sales_rep_id
			LEFT Join
			(select sum(B.qty)as od_units,sales_rep_id from 
			(select * from sales_rep_orders where date(date_of_processing) = date(now()) )A 
			left join (select * from sales_rep_order_items) B on (A.id=B.sales_rep_order_id)
			GROUP By sales_rep_id) O on A.sales_rep_id=O.sales_rep_id
			LEFT JOIN ( 
				SELECT count(*) as actual_count,sales_rep_id from sales_rep_beat_plan Where frequency= '$frequency' Group By sales_rep_id
			) D 
			on D.sales_rep_id=A.sales_rep_id
			Left Join 
			(Select * from sales_attendence Where date(check_in_time)=date(now())) F On A.sales_rep_id=F.sales_rep_id
			ORDER By zone DESC";
		$data=$this->db->query($sql)->result();

		$sql2 = "Select sum((Case When A.unplanned_count IS NULL THEN 0  Else A.unplanned_count end)) as unplanned_count ,((sum(Case When A.unplanned_count IS NULL THEN 0  Else A.unplanned_count end))+sum((Case When A.planned_count IS NULL THEN 0 Else A.unplanned_count end ))) as total_visit ,Sum(Case When F.check_in_time IS NULL THEN 1 Else 0  end) as absent,Sum(Case When F.check_in_time IS NOT  NULL THEN 1 Else 0  end) as present,sum(Case WHEN O.od_units IS NULL Then 0 Else O.od_units end) as od_units,'' as od_value ,sum((Case When A.planned_count IS NULL THEN 0  Else A.planned_count end)) as planned_count,sum(actual_count) as actual_count
		from (
		SELECT A.sales_rep_name,A.id,B.planned_count,C.unplanned_count,C.sales_rep_id,C.zone_id From
		(SELECT * from sales_rep_master Where status='Approved' and sr_type='Sales Representative')A
		Left join
		(SELECT count(*) as planned_count,sales_rep_id,zone_id from sales_rep_beat_plan A Where store_id 
		In ( Select store_id from sales_rep_detailed_beat_plan Where frequency='$frequency'  and sales_rep_id=A.sales_rep_id and is_edit='edit' and date(date_of_visit)=date(now()) and bit_plan_id!=0) 
		and date(created_on)<>date(now()) and frequency='$frequency' GROUP By sales_rep_id,zone_id) B On A.id=B.sales_rep_id
		Left join
		(
			SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id,zone_id from 
			(SELECT count(*) as unplanned_count,sales_rep_id,zone_id from sales_rep_beat_plan A Where store_id 
			In (Select store_id from sales_rep_detailed_beat_plan Where frequency='$frequency'  and sales_rep_id=A.sales_rep_id and is_edit='edit' and bit_plan_id!=0) and date(created_on)=date(now())
			GROUP By sales_rep_id,zone_id
			UNION
			SELECT count(*) as unplanned_count,sales_rep_id,zone_id from sales_rep_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)=date(now()) and bit_plan_id=0 GROUP By sales_rep_id,zone_id
			Union
			Select count(*) as unplanned_count,sales_rep_id,zone_id from sales_rep_location Where followup_date IS NOT NULL and date(date_of_visit)=date(now()) GROUP By sales_rep_id,zone_id) A GROUP BY sales_rep_id,zone_id
		) C on A.id=C.sales_rep_id
		) A
		Left join 
		(Select * from zone_master Where status='Approved') Z On A.zone_id=Z.id
		left join 
		(SELECT count(id) as p_call,sales_rep_id from sales_rep_orders Where id IN (Select sales_rep_order_id From sales_rep_order_items)) E 
		On A.sales_rep_id=E.sales_rep_id
		LEFT Join
		(select sum(B.qty)as od_units,sales_rep_id from 
		(select * from sales_rep_orders where date(date_of_processing) = date(now()) )A 
		left join (select * from sales_rep_order_items) B on (A.id=B.sales_rep_order_id)
		GROUP By sales_rep_id) O on A.sales_rep_id=O.sales_rep_id
		LEFT JOIN ( 
			SELECT count(*) as actual_count,sales_rep_id from sales_rep_beat_plan Where frequency= '$frequency' Group By sales_rep_id
		) D 
		on D.sales_rep_id=A.sales_rep_id
		Left Join 
		(Select * from sales_attendence Where date(check_in_time)=date(now())) F On A.sales_rep_id=F.sales_rep_id
		ORDER By zone DESC";

	   $data2=$this->db->query($sql2)->result();

	   $tbody ='';
	  
		$to_email = "prasad.bhisale@otbconsulting.co.in";
		$bcc = "prasad.bhisale@otbconsulting.co.in";
		/*$bcc = "dhaval.maru@otbconsulting.co.in,swapnil.darekar@eatanytime.in";*/

		$subject = 'Daily Performance Report For Sales Representative-'.date("d F Y",strtotime("now"));

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
						  <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tr>
							  <td style="padding-top:15px; padding-bottom:15px;>
						<![endif]-->     
						<table bgcolor="#ffffff" class="content" style="max-width: 600px;" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
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
							   <table class="table upper_table" style="width:765px;border-collapse: collapse;margin: 0 auto;" >
									<tr>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">ATTENDANCE</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ;
										
											if(count($data2)>0)
											{ 
												 $tbody.=$data2[0]->present ;
											}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/' ;
											if(count($data2)>0)
											{
												
												$tbody.=$data2[0]->present+$data2[0]->absent;
											}
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Visits</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->total_visit;
										}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/';     
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->actual_count;
										}    
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Unplanned Visits
													</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">';
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->unplanned_count;
										}
										$tbody .='</span></td>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Calls
										</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->planned_count+$data2[0]->unplanned_count;
										}
										$tbody .='</span></td>
								  <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Order Units


								</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
								if(count($data2)>0)
								{
									
									$tbody.=$data2[0]->od_units;
								}
							   
								$tbody .='</span></td>
								  <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Order Value


								</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
								if(count($data2)>0)
								{
									
									$tbody.=$data2[0]->od_value;
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
				
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align:left;width:500px">Name Of Employee</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Attendence</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Beat Name</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Region</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Planned Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Acutal Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Unplanned Visits</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Total Calls</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Deviation %</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Productive Calls</th>
						  <th style="padding: 8px;text-align: left;">% Productivity</th>
					
						  
						  
						</tr>
					</thead>
					<tbody style="border:1px solid #ddd;
									background-color: #fdfbfb;
									color: #656d78;">
				  '; 
						
						if(count($data)>0) {
							
							for($i=0; $i<count($data); $i++){
								/*if($data[$i]->sales_rep_id <>'')
								{*/   
										if($data[$i]->planned_count==0 || $data[$i]->actual_count==0)
										{
											 $div = 0;
										}
										else
										{
											$div=($data[$i]->planned_count)/($data[$i]->actual_count);
										}
										
										if($div> 0 )
										{
											$deviation=(1-($data[$i]->planned_count)/($data[$i]->actual_count))*100;
										}
										else
										{
											$deviation='0';
										}
									
										$single_total_calls=$data[$i]->planned_count + $data[$i]->unplanned_count;
										if($data[$i]->p_call!=0)
										{
										  $productivity=($data[$i]->p_call/$single_total_calls)*100;
										}
										else
										{
											$productivity=0;
										}

										
								
										$tbody.= ' <tr>
											
											
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222;">'.$data[$i]->sales_rep_name.'
											</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color: #881818; text-transform: UPPERCASE;font-size: 12px;">'.$data[$i]->emp_status.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$frequency.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->zone.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->actual_count.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->planned_count.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->unplanned_count.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$single_total_calls.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($deviation,2).'%</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.(isset($data[$i]->p_call)?$data[$i]->p_call:0).'</td>
										
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($productivity,2). '%</td>
											</tr>';
								  /*}*/
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

		echo $tbody;
		 echo 'mailsent'.$mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody, $bcc,'',$attachment);
		  if ($mailSent==1) {
			  echo "Send";
		  } else {
			  echo "NOT Send".$mailSent;
		  }
	}             
   	
   	public function get_sales_rep_byemail($value=''){
		$sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
			OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
			THEN CONCAT('Every ',DAYNAME(date(now()))) 
			WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4)
			THEN  CONCAT('Alternate ',DAYNAME(date(now()))) end  as frequency";
		$result = $this->db->query($sql)->result();
		$frequency = $result[0]->frequency;

		$sql = "Select A.sales_rep_name,A.id,
			Case When emp_status='Present' Then A.planned_count Else 0 end as planned_count ,IFNULL(A.unplanned_count,0) as unplanned_count,A.sales_rep_id,A.zone,A.emp_status,IFNULL (A.actual_count,0) as actual_count ,IFNULL(A.p_call,0) as p_call  from (
		    Select  A.*,D.actual_count,Case When (F.check_in_time IS NULL OR F.working_status='Absent') THEN 'Absent' Else 'Present' end as emp_status
			from (
				SELECT A.sales_rep_name,A.id,IFNULL(B.planned_count,0) as planned_count,C.unplanned_count,C.sales_rep_id,A.zone,E.p_call From
				(SELECT * from sales_rep_master Where status='Approved' and sr_type IN ('Sales Representative'))A
				Left join
				(SELECT sum(Case When A.created_by=U.id and date(A.created_on)=date(now()) Then 0 Else 1  end) as planned_count,A.sales_rep_id from sales_rep_beat_plan A
				Left join user_master U On A.created_by=U.id
				Where A.frequency='$frequency' GROUP By A.sales_rep_id) B On A.id=B.sales_rep_id
				Left join
				(
					SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id from 
					(
					SELECT count(*) as unplanned_count,A.sales_rep_id from
					(Select * from sales_rep_beat_plan Where frequency='$frequency' and date(created_on)=date(now())) A
					Left join
					(Select * from sales_rep_detailed_beat_plan Where frequency='$frequency'  and is_edit='edit' and bit_plan_id!=0 )B
					On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
					GROUP By A.sales_rep_id
					UNION
					SELECT count(*) as unplanned_count,sales_rep_id from sales_rep_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)=date(now()) and bit_plan_id=0 GROUP By sales_rep_id
					Union
					Select count(*) as unplanned_count,sales_rep_id from sales_rep_location Where followup_date IS NOT NULL and date(date_of_visit)=date(now()) GROUP By sales_rep_id) A GROUP BY sales_rep_id
			) C on A.id=C.sales_rep_id
			Left join 
			(SELECT count(*) as p_call,sales_rep_id from sales_rep_orders Where id IN (Select sales_rep_order_id From sales_rep_order_items) and date(created_on)=date(now()) 
			Group By sales_rep_id
			) E 
			On A.id=E.sales_rep_id
			) A
		LEFT JOIN ( 
			SELECT  count(A.store_id) as actual_count ,A.sales_rep_id from 
				(SELECT store_id,location_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan Where frequency= '$frequency' 
				and bit_plan_id!=0 and is_edit='edit' and date(date_of_visit)=date(now()))A
				left join
				(
					SELECT store_id,location_id,A.sales_rep_id,U.id
					from sales_rep_beat_plan  A
					left join user_master U On A.created_by=U.id
					Where (A.frequency='$frequency' and date(A.created_on)=date(now()) and A.created_by<>U.id) or 
					(A.frequency='$frequency'  and date(A.created_on)<>date(now()))

				) B On 
				(A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
				Where B.store_id is not null
				GROUP BY A.sales_rep_id 
		) D 
		on D.sales_rep_id=A.id
		Left Join 
		(Select * from sales_attendence Where date(check_in_time)=date(now())) F On A.id=F.sales_rep_id
		 ) A ORDER By emp_status DESC ,zone ASC ";
		$data=$this->db->query($sql)->result();

		$sql2 = "Select  sum((Case When C.unplanned_count IS NULL THEN 0  Else C.unplanned_count end)) as unplanned_count ,
			((sum(Case When C.unplanned_count IS NULL THEN 0  Else C.unplanned_count end))+sum((Case When actual_count IS NULL THEN 0 Else actual_count end ))) as total_visit ,
			Sum(Case When F.check_in_time IS NULL OR  F.working_status='Absent' THEN 1 Else 0  end) as absent,
			Sum(Case When F.check_in_time IS NOT  NULL and F.working_status='Present' THEN 1 Else 0  end) as present,sum(Case WHEN V.od_units IS NULL Then 0 Else V.od_units end) as od_units
			,sum(Case WHEN V.od_value IS NULL Then 0 Else V.od_value end) as od_value ,sum((
			Case When B.planned_count IS NULL THEN 0 
			When F.check_in_time IS NOT  NULL and F.working_status='Present' Then B.planned_count 
			Else 0
			end)) as planned_count,
			sum(Case When actual_count IS NULL THEN 0 Else actual_count end ) as actual_count
			 from 
			(SELECT * from sales_rep_master Where status='Approved' and sr_type='Sales Representative')A
			Left join
			(
				SELECT sum(Case When A.created_by=U.id and date(A.created_on)=date(now()) Then 0 Else 1  end) as planned_count,A.sales_rep_id from sales_rep_beat_plan A
				Left join user_master U On A.created_by=U.id
				Where A.frequency='$frequency' GROUP By A.sales_rep_id
			) B On A.id=B.sales_rep_id
			Left join
			(
				SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id from 
				(
				SELECT count(*) as unplanned_count,A.sales_rep_id from
				(Select * from sales_rep_beat_plan Where frequency='$frequency' and date(created_on)=date(now())) A
				Left join
				(Select * from sales_rep_detailed_beat_plan Where frequency='$frequency'  and is_edit='edit' and bit_plan_id!=0 )B
				On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
				GROUP By A.sales_rep_id
				UNION
				SELECT count(*) as unplanned_count,sales_rep_id from sales_rep_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)=date(now()) and bit_plan_id=0 GROUP By sales_rep_id
				Union
				Select count(*) as unplanned_count,sales_rep_id from sales_rep_location Where followup_date IS NOT NULL and date(date_of_visit)=date(now()) GROUP By sales_rep_id) A GROUP BY sales_rep_id
			) C On  A.id=C.sales_rep_id
			Left join 
			(SELECT count(*) as p_call,sales_rep_id from sales_rep_orders Where id IN (Select sales_rep_order_id From sales_rep_order_items) and date(created_on)=date(now()) 
			Group By sales_rep_id
			) E 
			On A.id=E.sales_rep_id
			LEFT Join
			(SELECT sum( Case When E.rate is not null Then (E.rate*E.qty) else 0 end ) as od_value,sales_rep_id,SUM(E.qty) as od_units  from 
				(SELECT * from sales_rep_orders WHERE date(created_on)=date(now())) A
				Left join 
				(   SELECT Case When E.type='Box' Then F.rate Else G.rate end as rate ,
					E.sales_rep_order_id ,E.qty
					from 
					(select * from sales_rep_order_items)E
					left join box_master F On (E.type='Box' and (E.item_id=F.id))
					left join product_master G On (E.type='Bar' and (E.item_id=G.id))
				 ) E On A.id=E.sales_rep_order_id 
				GROUP BY sales_rep_id
			) V on A.id=V.sales_rep_id
			LEFT JOIN ( 
				SELECT  count(A.store_id) as actual_count ,A.sales_rep_id from 
				(SELECT store_id,location_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan Where frequency= '$frequency' 
				and bit_plan_id!=0 and is_edit='edit' and date(date_of_visit)=date(now()))A
				left join
				(
					SELECT store_id,location_id,A.sales_rep_id,U.id
					from sales_rep_beat_plan  A
					left join user_master U On A.created_by=U.id
					Where (A.frequency='$frequency'  and date(A.created_on)=date(now()) and A.created_by<>U.id) or 
					(A.frequency='$frequency'   and date(A.created_on)<>date(now()))

				) B On 
				(A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
				Where B.store_id is not null
				GROUP BY A.sales_rep_id 
			) D 
			on D.sales_rep_id=A.id
			Left Join 
			(Select * from sales_attendence Where date(check_in_time)=date(now())) F On A.id=F.sales_rep_id
			ORDER By zone DESC";

	   $data2=$this->db->query($sql2)->result();
	   $to_email = "ravi.hirode@eatanytime.co.in, manorama.mishra@eatanytime.co.in, mahesh.ms@eatanytime.co.in, yash.doshi@eatanytime.in, darshan.dhany@eatanytime.co.in, girish.rai@eatanytime.in, nitin.kumar@eatanytime.co.in, mohil.telawade@eatanytime.co.in";
		$bcc = "dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";
		$cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, operations@eatanytime.in";
		/*$to_email = "prasad.bhisale@otbconsulting.co.in,dhaval.maru@otbconsulting.co.in";
		$bcc = "prasad.bhisale@otbconsulting.co.in";
		$cc = "prasad.bhisale@otbconsulting.co.in";*/
			
		//$bcc = "dhaval.maru@otbconsulting.co.in,swapnil.darekar@eatanytime.in";

		$subject = 'Daily Performance Report For Sales Representative-'.date("d F Y",strtotime("now"));

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
						  <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tr>
							  <td style="padding-top:15px; padding-bottom:15px;>
						<![endif]-->     
						<table bgcolor="#ffffff" class="content" style="max-width: 600px;" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
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
							   <table class="table upper_table" style="width:765px;border-collapse: collapse;margin: 0 auto;" >
									<tr>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">ATTENDANCE</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ;
										
											if(count($data2)>0)
											{ 
												 $tbody.=$data2[0]->present ;
											}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/' ;
											if(count($data2)>0)
											{
												
												$tbody.=$data2[0]->present+$data2[0]->absent;
											}
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Visits</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
										if(count($data2)>0)
										{
											
											$tbody.= ($data2[0]->actual_count==NULL || $data2[0]->actual_count==''?0:$data2[0]->actual_count);
										}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/';     
										if(count($data2)>0)
										{
											$tbody.=($data2[0]->planned_count==''?0:$data2[0]->planned_count);
											/*$tbody.=$data2[0]->actual_coun*/;
										}    
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Unplanned Visits
													</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">';
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->unplanned_count;
										}
										$tbody .='</span></td>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Calls
										</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
										if(count($data2)>0)
										{
											
											$tbody.=($data2[0]->total_visit==NULL || $data2[0]->total_visit==''?0:$data2[0]->total_visit);
										}

										$tbody .='</span></td>
								  <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Order Units


								</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
								if(count($data2)>0)
								{
									
									$tbody.=(($data2[0]->od_units==NULL || $data2[0]->od_units=='') ?'0':$data2[0]->od_units);
								}
							   
								$tbody .='</span></td>
								  <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Order Value


								</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
								if(count($data2)>0)
								{
									
									$tbody.= (($data2[0]->od_value==NULL || $data2[0]->od_value=='') ?'0':$data2[0]->od_value);
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
				
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align:left;width:500px">Name Of Employee</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Attendence</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Beat Name</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Region</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Planned Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Acutal Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Unplanned Visits</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Total Calls</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Deviation %</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Productive Calls</th>
						  <th style="padding: 8px;text-align: left;">% Productivity</th>
					
						  
						  
						</tr>
					</thead>
					<tbody style="border:1px solid #ddd;
									background-color: #fdfbfb;
									color: #656d78;">
				  '; 
						
						if(count($data)>0) {
							
							for($i=0; $i<count($data); $i++){
								/*if($data[$i]->sales_rep_id <>'')
								{*/   
										if($data[$i]->planned_count==0 || $data[$i]->actual_count==0)
										{
											 $div = 0;
										}
										else
										{
											$div=($data[$i]->actual_count)/($data[$i]->planned_count);
										}
										
										if($div> 0 )
										{
											$deviation=(1-($data[$i]->actual_count/$data[$i]->planned_count))*100;
										}
										else
										{
											if($data[$i]->planned_count!=0 && $data[$i]->actual_count==0)
											   $deviation='100';
											else
											  $deviation='0';
										}
									
										$single_total_calls=$data[$i]->actual_count + $data[$i]->unplanned_count;
										if($data[$i]->p_call!=0)
										{
										  $productivity=($data[$i]->p_call/$single_total_calls)*100;
										}
										else
										{
											$productivity=0;
										}

										
								
										$tbody.= ' <tr>
											
											
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222;">'.$data[$i]->sales_rep_name.'
											</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color: #881818; text-transform: UPPERCASE;font-size: 12px;">'.$data[$i]->emp_status.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$frequency.'</td>
											<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->zone.'</td>';
											if($data[$i]->planned_count==0 && $data[$i]->actual_count==0 && $data[$i]->unplanned_count==0)
											{
												$tbody.='<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222"> </td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222"> </td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222"> </td>
												';

											}
											else
											{
												$tbody.='<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->planned_count.'</td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->actual_count.'</td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->unplanned_count.'</td>';
											}

											$tbody.='<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$single_total_calls.'</td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($deviation,2).'%</td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.(isset($data[$i]->p_call)?$data[$i]->p_call:0).'</td>
												<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($productivity,2). '%</td></tr>';
								  /*}*/
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

		/*$result1 = $this->sr_beat_plan_model->get_sales_rep_daily_route_plan($frequency);   
		if(count($result1)>0)
			{
				$template_path=$this->config->item('template_path');
				$file = $template_path.'sales_rep_route_plan_daily_report.xls';
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				$objPHPExcel->setActiveSheetIndex(0);
				$row=7;

				for($j=0;$j<count($result1);$j++)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($j+1));
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result1[$j]->distributor_name);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result1[$j]->sales_rep_name);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result1[$j]->frequency);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result1[$j]->betweennooforders);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result1[$j]->od_units); 
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result1[$j]->plan_status);                 

					$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(

						'borders' => array(

							'allborders' => array(

								'style' => PHPExcel_Style_Border::BORDER_THIN

							)

						)

					));

					$row = $row+1;
				}

				for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
					$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
				}
				

				$filename='sales_rep_daily_route_plan_'.date('Y-F-d').'.xls';
				$path  = '/home/eatangcp/public_html/test/assets/uploads/daily_sales_rep_reports/';
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
				$objWriter->save($path.$filename);   
			}*/
			
		  echo $tbody; 
		 /* $attachment = $path.$filename;*/
		  $from_email = 'cs@eatanytime.co.in';
		  $from_email_sender = 'Wholesome Habits Pvt Ltd';  
		  echo $tbody;
		  echo 'mailsent'.$mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody, $bcc, $cc, '');
		  if ($mailSent==1) {
			  echo "Send";
		  } else {
			  echo "NOT Send".$mailSent;
		  }
	}

	public function get_promoter_byemail($value=''){
		$sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
			OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
			THEN CONCAT('Every ',DAYNAME(date(now()))) 
			WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4)
			THEN  CONCAT('Alternate ',DAYNAME(date(now()))) end  as frequency";
		$result = $this->db->query($sql)->result();
		$frequency = $result[0]->frequency;
		$sql = "Select A.sales_rep_name,A.id,Case When emp_status='Present' Then A.planned_count Else 0 end as planned_count ,IFNULL(A.unplanned_count,0) as unplanned_count ,A.sales_rep_id,A.zone,A.emp_status,IFNULL(A.actual_count,0) as actual_count  from (
		    Select  A.*,D.actual_count,Case When (F.check_in_time IS NULL OR F.working_status='Absent') THEN 'Absent' Else 'Present' end as emp_status
			from (
				SELECT A.sales_rep_name,A.id,IFNULL(B.planned_count,0) as planned_count,C.unplanned_count,C.sales_rep_id,A.zone From
				(SELECT * from sales_rep_master Where status='Approved' and sr_type IN ('Merchandizer'))A
				Left join
				(SELECT sum(Case When A.created_by=U.id and date(A.created_on)=date(now()) Then 0 Else 1  end) as planned_count,A.sales_rep_id from merchandiser_beat_plan A
				Left join user_master U On A.created_by=U.id
				Where A.frequency='$frequency' GROUP By A.sales_rep_id) B On A.id=B.sales_rep_id
				Left join
				(
					SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id from 
					(
					SELECT count(*) as unplanned_count,A.sales_rep_id from
					(Select * from merchandiser_beat_plan Where frequency='$frequency' and date(created_on)=date(now())) A
					Left join
					(Select * from merchandiser_detailed_beat_plan Where frequency='$frequency'  and is_edit='edit' and bit_plan_id!=0 )B
					On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
					GROUP By A.sales_rep_id
					UNION
					SELECT count(*) as unplanned_count,sales_rep_id from merchandiser_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)=date(now()) and bit_plan_id=0 GROUP By sales_rep_id
					Union
					Select count(*) as unplanned_count,m_id as sales_rep_id from merchandiser_stock Where followup_date IS NOT NULL and date(date_of_visit)=date(now()) GROUP By m_id) A GROUP BY sales_rep_id
			) C on A.id=C.sales_rep_id
			) A
		LEFT JOIN ( 
			SELECT  count(A.store_id) as actual_count ,A.sales_rep_id from 
				(SELECT store_id,location_id,sales_rep_id,date_of_visit from merchandiser_detailed_beat_plan Where frequency= '$frequency' 
				and bit_plan_id!=0 and is_edit='edit' and date(date_of_visit)=date(now()))A
				left join
				(
					SELECT store_id,location_id,A.sales_rep_id,U.id
					from merchandiser_beat_plan  A
					left join user_master U On A.created_by=U.id
					Where (A.frequency='$frequency' and date(A.created_on)=date(now()) and A.created_by<>U.id) or 
					(A.frequency='$frequency'  and date(A.created_on)<>date(now()))

				) B On 
				(A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
				Where B.store_id is not null
				GROUP BY A.sales_rep_id 
		) D 
		on D.sales_rep_id=A.id
		Left Join 
		(Select * from sales_attendence Where date(check_in_time)=date(now())) F On A.id=F.sales_rep_id
		 ) A ORDER By emp_status DESC ,zone ASC";
		$data=$this->db->query($sql)->result();

		$sql2 = "Select sum((Case When A.unplanned_count IS NULL THEN 0  Else A.unplanned_count end)) as unplanned_count ,
			((sum(Case When A.unplanned_count IS NULL THEN 0  Else A.unplanned_count end))+sum((Case When actual_count IS NULL THEN 0 Else actual_count end ))) as total_visit ,
			Sum(Case When F.check_in_time IS NULL OR  F.working_status='Absent' THEN 1 Else 0  end) as absent,
			Sum(Case When F.check_in_time IS NOT  NULL and F.working_status='Present' THEN 1 Else 0  end) as present
			,sum((Case When A.planned_count IS NULL THEN 0 When F.check_in_time IS NOT  NULL and F.working_status='Present' Then A.planned_count  Else 0 end)) as planned_count,
			sum(actual_count) as actual_count
						from (
				SELECT A.sales_rep_name,A.id,B.planned_count,C.unplanned_count,C.sales_rep_id,A.zone From
				(SELECT * from sales_rep_master Where status='Approved' and sr_type IN ('Merchandizer'))A
				Left join
				(SELECT sum(Case When created_by=sales_rep_id and (created_on)=now() Then 0 Else 1  end) as planned_count,sales_rep_id from merchandiser_beat_plan A Where frequency='$frequency' GROUP By sales_rep_id) B On A.id=B.sales_rep_id
				Left join
				(
					SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id from 
					(
					SELECT count(*) as unplanned_count,A.sales_rep_id from
					(Select * from merchandiser_beat_plan Where frequency='$frequency' and date(created_on)=date(now())) A
					Left join
						(Select * from merchandiser_detailed_beat_plan Where frequency='$frequency'  and is_edit='edit' and bit_plan_id!=0 )B
						On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
						GROUP By A.sales_rep_id
						UNION
						SELECT count(*) as unplanned_count,sales_rep_id from merchandiser_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)=date(now()) and bit_plan_id=0 GROUP By sales_rep_id
						Union
						Select count(*) as unplanned_count,m_id as sales_rep_id from merchandiser_stock Where followup_date IS NOT NULL and date(date_of_visit)=date(now()) GROUP By m_id) A GROUP BY sales_rep_id
				) C on A.id=C.sales_rep_id
			) A
		LEFT JOIN ( 
			SELECT  count(A.store_id) as actual_count ,A.sales_rep_id from 
				(SELECT store_id,location_id,sales_rep_id,date_of_visit from merchandiser_detailed_beat_plan Where frequency= '$frequency' 
				and bit_plan_id!=0 and is_edit='edit' and date(date_of_visit)=date(now()))A
				left join
				(
					SELECT store_id,location_id,A.sales_rep_id,U.id
					from merchandiser_beat_plan  A
					left join user_master U On A.created_by=U.id
					Where (A.frequency='$frequency' and date(A.created_on)=date(now()) and A.created_by<>U.id) or 
					(A.frequency='$frequency'  and date(A.created_on)<>date(now()))

				) B On 
				(A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
				Where B.store_id is not null
				GROUP BY A.sales_rep_id 
		) D 
		on D.sales_rep_id=A.id
		Left Join 
		(Select * from sales_attendence Where date(check_in_time)=date(now())) F On A.id=F.sales_rep_id
		ORDER By zone DESC";

	   $data2=$this->db->query($sql2)->result();

	   $tbody ='';
		$to_email = "mukesh.yadav@eatanytime.co.in, sulochana.waghmare@eatanytime.co.in, sachin.pal@eatanytime.co.in, urvi.bhayani@eatanytime.co.in";
		$bcc = "dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";
		$cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, operations@eatanytime.in";
		/*$to_email = "prasad.bhisale@otbconsulting.co.in,dhaval.maru@otbconsulting.co.in";
		$bcc = "prasad.bhisale@otbconsulting.co.in";
	    $cc = "prasad.bhisale@otbconsulting.co.in";*/

		$subject = 'Daily Performance Report For Merchandiser -'.date("d F Y",strtotime("now"));

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
						  <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tr>
							  <td style="padding-top:15px; padding-bottom:15px;>
						<![endif]-->     
						<table bgcolor="#ffffff" class="content" style="max-width: 600px;" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
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
							   <table class="table upper_table" style="width:765px;border-collapse: collapse;margin: 0 auto;" >
									  <tr>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">ATTENDANCE</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ;
										
											if(count($data2)>0)
											{ 
												 $tbody.=$data2[0]->present ;
											}
										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/' ;
											if(count($data2)>0)
											{
												
												$tbody.=$data2[0]->present+$data2[0]->absent;
											}
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Visits</span> <br><br> <span class="total" style="color: #333333;font-size: 28px;">'; 
										if(count($data2)>0)
										{
											
											$tbody.=($data2[0]->actual_count==NULL || $data2[0]->actual_count==''?0:$data2[0]->actual_count);
										}

										$tbody .='</span><span class="used" style="color: #666666;font-size: 20px;">/';     
										if(count($data2)>0)
										{
											$tbody.=($data2[0]->planned_count==''?0:$data2[0]->planned_count);
											/*$tbody.=$data2[0]->actual_coun*/;
										}    
										$tbody .='</span></td>
													<td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Unplanned Visits
													</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">';
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->unplanned_count;
										}
										$tbody .='</span></td>
										 <td align="center" valign="top" style="border:1px solid #ddd;text-align:center; padding: 10px;"><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase;">Total Calls
										</span>  <br><br> <span class="total" style="color: #333333;font-size: 28px;">' ; 
										if(count($data2)>0)
										{
											
											$tbody.=$data2[0]->total_visit;
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
				
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align:left;width:500px">Name Of Employee</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Attendence</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Beat Name</th>
						  <th width="500" style="border-right: 1px solid #ddd;padding: 8px;text-align: left;width:500px">Region</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">UnPlanned Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Planned Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Acutal Vists</th>
						  <th style="border-right: 1px solid #ddd;padding: 8px;text-align: left;">Deviation %</th>
						</tr>
					</thead>
					<tbody style="border:1px solid #ddd;
									background-color: #fdfbfb;
									color: #656d78;">
				  '; 
						
						if(count($data)>0) {
							
							for($i=0; $i<count($data); $i++){
								/*if($data[$i]->sales_rep_id <>'')
								{*/   
										if($data[$i]->planned_count==0 || $data[$i]->actual_count==0)
										{
											 $div = 0;
										}
										else
										{
											$div=($data[$i]->actual_count)/($data[$i]->planned_count);
										}
										
										if($div> 0 )
										{
											$deviation=(1-($data[$i]->actual_count)/($data[$i]->planned_count))*100;
										}
										else
										{
											if($data[$i]->planned_count!=0 && $data[$i]->actual_count==0)
											   $deviation='100';
											else
											  $deviation='0';
										}
										
								
										$tbody.= ' <tr>
									
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222;">'.$data[$i]->sales_rep_name.'
									</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color: #881818; text-transform: UPPERCASE;font-size: 12px;">'.$data[$i]->emp_status.'</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$frequency.'</td>
									<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->zone.'</td>';
									
									if($data[$i]->unplanned_count==0 && $data[$i]->planned_count==0 && $data[$i]->actual_count==0)
									{
										$tbody.='<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222"> </td>
										<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222"> </td>
										<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222"> </td>';
									}
									else
									{
										$tbody.='<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->unplanned_count.'</td>
										<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->planned_count.'</td>
										<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.$data[$i]->actual_count.'</td>';
									}
								
									$tbody.='<td style="border-right: 1px solid #ddd;padding: 8px;text-align: left;color:#222">'.round($deviation,2).'%</td>
								
									</tr>';
								  /*}*/
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

		echo $tbody;
		  $from_email = 'cs@eatanytime.co.in';
		  $from_email_sender = 'Wholesome Habits Pvt Ltd';
		 echo 'mailsent'.$mailSent=send_email_new($from_email,$from_email_sender, $to_email, $subject, $tbody, $bcc, $cc,'');
		  if ($mailSent==1) {
			  echo "Send";
		  } else {
			  echo "NOT Send".$mailSent;
		  }
	}
}


?>