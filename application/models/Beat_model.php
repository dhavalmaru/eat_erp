<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Beat_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    $cond2="";
    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
        if($cond2=="") {
            $cond2=" where A.beat_id='".$id."'";
        } else {
            $cond2=$cond2." and A.beat_id='".$id."'";
        }
    }

	$sql = "select A.*, B.distributor_type, C.zone, D.area, E.store_name, F.location_id, F.location 
            from beat_master A 
            left join distributor_type_master B on (A.type_id = B.id) 
            left join zone_master C on (A.zone_id = C.id) 
            left join area_master D on (A.area_id = D.id) 
            left join relationship_master E on (A.store_id = E.id) 
            left join 
            (select A.beat_id, group_concat(A.location_id) as location_id, group_concat(B.location) as location 
                from beat_locations A left join location_master B on (A.location_id=B.id)".$cond2." group by A.beat_id) F 
            on (A.id = F.beat_id) 
            ".$cond." 
            order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_locations($id=''){
    $cond="";

    if($id!=""){
        if($cond=="") {
            $cond=" where A.beat_id='".$id."'";
        } else {
            $cond=$cond." and A.beat_id='".$id."'";
        }
    }

    $sql = "select * from beat_locations A ".$cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_type(){
    $sql = "select * from distributor_type_master where status = 'Approved' order by distributor_type";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_zone($type_id=''){
    $cond = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    $sql = "select * from zone_master where status = 'Approved'".$cond." order by zone";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_area($type_id='', $zone_id=''){
    $cond = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
    }
    $sql = "select * from area_master where status = 'Approved'".$cond." order by area";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_store($type_id='', $zone_id=''){
    $cond = "";
    if($type_id!=""){
        $cond = $cond." and A.type_id = '$type_id' and B.type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
    }
    $sql = "select distinct A.id, A.store_name from relationship_master A 
            left join store_master B on (A.id = B.store_id) 
            where A.status = 'Approved'".$cond." order by store_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_location($type_id='', $zone_id='', $area_id=''){
    $cond = "";
    $cond2 = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
        $cond2 = $cond2." and B.zone_id = '$zone_id'";
    }
    if($area_id!=""){
        $cond = $cond." and area_id = '$area_id'";
    }

    if($type_id=='7'){
        $sql = "select distinct A.id, A.location from location_master A 
                left join store_master B on (A.id = B.location_id) 
                where A.status = 'Approved'".$cond2." order by location";
    } else {
        $sql = "select * from location_master where status = 'Approved'".$cond." order by location";
    }
    
    $query=$this->db->query($sql);
    return $query->result();
}

function get_retailer($beat_id='', $type_id='', $zone_id='', $area_id='', $location_id=''){
    $cond = "";
    $cond2 = "";
    $cond3 = "";
    $cond4 = "";

    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
        $cond4 = $cond4." and zone_id = '$zone_id'";
        $cond2 = $cond2." and B.zone_id = '$zone_id'";
    }
    if($area_id!=""){
        $cond = $cond." and area_id = '$area_id'";
        $cond4 = $cond4." and area_id = '$area_id'";
    }

    if(count($location_id)>0){
        $location_id = implode(',', $location_id);
    }

    if($location_id!=""){
        $cond = $cond." and location_id in ($location_id)";
        $cond4 = $cond4." and location_id in ($location_id)";
        $cond2 = $cond2." and B.location_id in ($location_id)";
    }
    $cond3 = $cond3." where A.id = '$beat_id' and B.beat_id = '$beat_id'";

    if($type_id=='7'){
        $sql = "select A.*, case when B.dist_id is null then '0' else '1' end as is_selected, 
                    ifnull(B.sequence,'') as sequence, ifnull(C.no_of_beat,0) as no_of_beat from 
                (select distinct concat('m_', A.id) as id, A.store_name as distributor_name 
                from relationship_master A 
                left join store_master B on (A.id = B.store_id) 
                where A.status = 'Approved'".$cond2.") A 
                left join 
                (select A.id, B.dist_id, B.sequence from beat_master A 
                left join beat_details B on (A.id = B.beat_id)".$cond3.") B 
                on (A.id = B.dist_id) 
                left join 
                (select dist_id, count(id) as no_of_beat from beat_details group by dist_id) C 
                on (A.id = C.dist_id) 
                order by A.distributor_name";
    } else {
        $sql = "select A.*, case when B.dist_id is null then '0' else '1' end as is_selected, 
                    ifnull(B.sequence,'') as sequence, ifnull(C.no_of_beat,0) as no_of_beat from 
                (select concat('d_', id) as id, distributor_name from distributor_master 
                where status = 'Approved' 
                ) A 
                left join 
                (select A.id, B.dist_id, B.sequence from beat_master A 
                left join beat_details B on (A.id = B.beat_id)".$cond3.") B 
                on (A.id = B.dist_id) 
                left join 
                (select dist_id, count(id) as no_of_beat from beat_details group by dist_id) C 
                on (A.id = C.dist_id) 
                order by A.distributor_name";
    }
	//echo $sql;
	//exit;

    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_id(){
    $sql="select * from series_master where type='Beat_Plan'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $series=intval($result[0]->series)+1;
    } else {
        $series=1;
    }
    
    $beat_id = 'B'.str_pad($series, 5, '0', STR_PAD_LEFT);

    return $beat_id;
}

function set_beat_id(){
    $sql="select * from series_master where type='Beat_Plan'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $series=intval($result[0]->series)+1;

        $sql="update series_master set series = '$series' where type = 'Beat_Plan'";
        $this->db->query($sql);
    } else {
        $series=1;

        $sql="insert into series_master (type, series) values ('Beat_Plan', '$series')";
        $this->db->query($sql);
    }
    
    $beat_id = 'B'.str_pad($series, 5, '0', STR_PAD_LEFT);

    return $beat_id;
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $beat_id = $this->input->post('beat_id')==''?null:$this->input->post('beat_id');
    $beat_name = $this->input->post('beat_name')==''?null:$this->input->post('beat_name');
    $type_id = $this->input->post('type_id')==''?null:$this->input->post('type_id');
    $zone_id = $this->input->post('zone_id')==''?null:$this->input->post('zone_id');
    $area_id = $this->input->post('area_id')==''?null:$this->input->post('area_id');
    $store_id = $this->input->post('store_id')==''?null:$this->input->post('store_id');

    if($id==''){
        $beat_id = $this->set_beat_id();
    }

    $data = array(
        'beat_id' => $beat_id,
        'beat_name' => $beat_name,
        'type_id' => $type_id,
        'zone_id' => $zone_id,
        'area_id' => $area_id,
        'store_id' => $store_id,
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('beat_master',$data);
        $id=$this->db->insert_id();
        $action='Beat Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('beat_master',$data);
        $action='Beat Modified.';
    }

    $this->db->where('beat_id', $id);
    $this->db->delete('beat_locations');

    $location_id=$this->input->post('location_id[]');
    
    for ($k=0; $k<count($location_id); $k++) {
        if(isset($location_id[$k]) and $location_id[$k]!="") {
            $data = array(
                        'beat_id' => $id,
                        'location_id' => $location_id[$k]
                    );
            $this->db->insert('beat_locations', $data);
        }
    }

    $this->db->where('beat_id', $id);
    $this->db->delete('beat_details');

    $is_selected=$this->input->post('is_selected[]');
    $dist_id=$this->input->post('distributor_id[]');
    $sequence=$this->input->post('sequence[]');
    $seq = 1;
    
    for ($k=0; $k<count($dist_id); $k++) {
        if(isset($dist_id[$k])) { if($dist_id[$k]!="") { if($is_selected[$k]=="1") {
            $data = array(
                        'beat_id' => $id,
                        'dist_id' => $dist_id[$k],
                        // 'sequence' => format_number($sequence[$k],2),
                        'sequence' => $seq++
                    );
            $this->db->insert('beat_details', $data);
        }}}
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Beat_Master';
    $logarray['cnt_name']='Beat_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_beat_name_availablity(){
    $id=$this->input->post('id');
    $beat_name=$this->input->post('beat_name');

    $query=$this->db->query("select * from beat_master where id!='".$id."' and beat_name='".$beat_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function upload_file(){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $filePath='uploads/excel_upload/';
    $path = './' . $filePath;
    if(!is_dir($path)) {
        mkdir($path, 0777, TRUE);
    }

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
    if(!$this->upload->do_upload('upload')){ 
        $this->upload->display_errors();
    } else {
        $imageDetailArray = $this->upload->data();
    }

    $file = $path.$new_name;
    $this->load->library('excel');
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $objPHPExcel->setActiveSheetIndex(0);
    $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Error Remark');
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    $objerror = 0;
    $batch_array = [];
    $location_array = [];
    $retailer_array = [];
    $i = 0;
    $id = 0;

    for($row=2; $row<=$highestrow; $row++){
        $sr_no = trim($objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue());
        if($sr_no==''){
            break;
        }

        $error_line = '';
        $beat_name = trim($objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue());
        $distributor = trim($objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue());
        $type = trim($objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue());
        $zone = trim($objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue());
        $location = trim($objPHPExcel->getActiveSheet()->getCell('F'.$row)->getValue());
        $retailer = trim($objPHPExcel->getActiveSheet()->getCell('G'.$row)->getValue());
        $error = '';
        $distributor_id = 0;
        $type_id = 0;
        $zone_id = 0;
        $location_id = 0;
        $retailer_id = 0;

        if($beat_name=='' || $distributor=='' || $type=='' || $zone=='' || $location=='' || $retailer==''){
            $error_line .= 'Please insert all values. ';
        }

        $bl_found = false;
        $index = 0;
        for($j=0; $j<count($batch_array); $j++){
            if($batch_array[$j]['beat_name']==$beat_name){
                $bl_found = true;
                $index = $j;
                if($batch_array[$j]['distributor']!=$distributor || $batch_array[$j]['type']!=$type || $batch_array[$j]['zone']!=$zone){
                    $error_line .= 'Please select same distributor, type & zone for one beat. ';
                }
            }
        }
        if($bl_found == false){
            $batch_array[$i]['beat_name'] =$beat_name;
            $batch_array[$i]['distributor'] = $distributor;
            $batch_array[$i]['type'] = $type;
            $batch_array[$i]['zone'] = $zone;

            $sql = "select * from beat_master where trim(beat_name)='$beat_name'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $error_line .= 'Beat Name already exist. ';
            }

            $sql = "select * from distributor_master where status='Approved' and class='Super Stockist' and 
                    trim(distributor_name)='$distributor'";
            $result = $this->db->query($sql)->result();
            if(count($result)==0){
                $error_line .= 'Distributor Name not found. ';
            } else {
                $distributor_id = $result[0]->id;
            }

            $sql = "select * from distributor_type_master where status='Approved' and trim(distributor_type)='$type'";
            $result = $this->db->query($sql)->result();
            if(count($result)==0){
                $error_line .= 'Distributor Type not found. ';
            } else {
                $type_id = $result[0]->id;
            }

            $sql = "select * from zone_master where status='Approved' and type_id='$type_id' and trim(zone)='$zone'";
            $result = $this->db->query($sql)->result();
            if(count($result)==0){
                $error_line .= 'Zone not found. ';
            } else {
                $zone_id = $result[0]->id;
            }

            $batch_array[$i]['distributor_id'] = $distributor_id;
            $batch_array[$i]['type_id'] = $type_id;
            $batch_array[$i]['zone_id'] = $zone_id;

            $index = $i;
            $i = $i + 1;
        } else {
            $distributor_id = $batch_array[$index]['distributor_id'];
            $type_id = $batch_array[$index]['type_id'];
            $zone_id = $batch_array[$index]['zone_id'];
        }

        $sql = "select * from location_master where status='Approved' and type_id='$type_id' and 
                zone_id='$zone_id' and trim(location)='$location'";
        $result = $this->db->query($sql)->result();
        if(count($result)==0){
            $error_line .= 'Location not found. ';
        } else {
            $location_id = $result[0]->id;
        }

        $sql = "select A.* from 
                (select concat('d_',id) as id, distributor_name, type_id, zone_id, location_id 
                    from distributor_master where status = 'Approved' 
                union all 
                select concat('s_',id) as id, distributor_name, 3 as type_id, zone_id, location_id 
                    from sales_rep_distributors where status = 'Approved' or status = 'Active') A 
                where A.type_id='$type_id' and A.zone_id='$zone_id' and A.location_id='$location_id' and 
                    trim(A.distributor_name)='$retailer'";
        $result = $this->db->query($sql)->result();
        if(count($result)==0){
            $error_line .= 'Retailer not found. ';
        } else {
            $retailer_id = $result[0]->id;
        }

        $bl_found = false;
        $j=0;
        if(isset($location_array[$index])){
            for($j=0; $j<count($location_array[$index]); $j++){
                if($location_array[$index][$j]==$location_id){
                    $bl_found = true;
                    break;
                }
            }
        }
        if($bl_found == false){
            $location_array[$index][$j]=$location_id;
        }

        $bl_found = false;
        $j=0;
        if(isset($retailer_array[$index])){
            for($j=0; $j<count($retailer_array[$index]); $j++){
                if($retailer_array[$index][$j]==$retailer_id){
                    $bl_found = true;
                    break;
                }
            }
        }
        if($bl_found == false){
            $retailer_array[$index][$j]=$retailer_id;
        }

        if($error_line!=''){
            $objerror = 1;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $error_line);
    }

    if($objerror==1){
        $objPHPExcel->setActiveSheetIndex(1);
        $highestrow = $objPHPExcel->setActiveSheetIndex(1)->getHighestRow();
        $dist_cnt = 2;
        $type_cnt = 2;
        for($row=2; $row<=$highestrow; $row++){
            if(trim($objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue())==''){
                $dist_cnt = $row;
                break;
            }
        }
        for($row=2; $row<=$highestrow; $row++){
            if(trim($objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue())==''){
                $type_cnt = $row;
                break;
            }
        }

        $objPHPExcel->setActiveSheetIndex(0);
        for($row=2; $row<=100; $row++) {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$A$2:$A$'.($dist_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$C$2:$C$'.($type_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=OFFSET(Sheet2!$E$1, MATCH(D'.$row.',Sheet2!$E:$E, 0)-1, 1, COUNTIF(Sheet2!$E:$E, D'.$row.'))');

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=OFFSET(Sheet2!$J$1, MATCH(D'.$row.'&"-"&E'.$row.',Sheet2!$J:$J, 0)-1, 1, COUNTIF(Sheet2!$J:$J, D'.$row.'&"-"&E'.$row.'))');

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=OFFSET(Sheet2!$P$1, MATCH(D'.$row.'&"-"&E'.$row.'&"-"&F'.$row.',Sheet2!$P:$P, 0)-1, 1, COUNTIF(Sheet2!$P:$P, D'.$row.'&"-"&E'.$row.'&"-"&F'.$row.'))');
        }

        $filename='beat_plan_upload_errors_'.time().'.xlsx';
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        sleep(0.25);
        $this->session->set_flashdata('error', 'There are errors in file. Please check - '.$filename);
    } else {
        for($i=0; $i<count($batch_array); $i++){
            $beat_name = $batch_array[$i]['beat_name'];
            $distributor = $batch_array[$i]['distributor'];
            $type = $batch_array[$i]['type'];
            $zone = $batch_array[$i]['zone'];

            $beat_id = $this->set_beat_id();

            $data = array(
                        'beat_id' => $beat_id,
                        'beat_name' => $beat_name,
                        'type_id' => $type_id,
                        'zone_id' => $zone_id,
                        'status' => 'Approved',
                        'remarks' => '',
                        'created_by' => $curusr,
                        'created_on' => $now,
                        'modified_by' => $curusr,
                        'modified_on' => $now
                    );

            $this->db->insert('beat_master',$data);
            $id=$this->db->insert_id();

            if(isset($location_array[$i])) {
                for ($k=0; $k<count($location_array[$i]); $k++) {
                    if(isset($location_array[$i][$k]) and $location_array[$i][$k]!="") {
                        $data = array(
                                    'beat_id' => $id,
                                    'location_id' => $location_array[$i][$k]
                                );
                        $this->db->insert('beat_locations', $data);
                    }
                }
            }

            $seq = 1;
            if(isset($retailer_array[$i])) {
                for ($k=0; $k<count($retailer_array[$i]); $k++) {
                    if(isset($retailer_array[$i][$k]) and $retailer_array[$i][$k]!="") {
                        $data = array(
                                    'beat_id' => $id,
                                    'dist_id' => $retailer_array[$i][$k],
                                    'sequence' => $seq++
                                );
                        $this->db->insert('beat_details', $data);
                    }
                }
            }
        }
        $this->session->set_flashdata('success', 'File uploaded successfully.');
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Beat_Master';
    $logarray['cnt_name']='Beat_Master';
    $logarray['action']='Beat Plan File upload.';
    $this->user_access_log_model->insertAccessLog($logarray);
}

function download_csv(){
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Beat_upload_format.xlsx';
    $this->load->library('excel');

    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $objPHPExcel->setActiveSheetIndex(1);

    $row = 2;
    $sql = "select * from distributor_master where status='Approved' and class='Super Stockist' 
            order by distributor_name";
    $result  = $this->db->query($sql)->result();
    foreach($result  as $dist) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $dist->distributor_name);
        $row = $row+1;
    }
    $dist_cnt = $row;

    $row = 2;
    $sql = "select * from distributor_type_master where status='Approved' order by distributor_type";
    $result  = $this->db->query($sql)->result();
    foreach($result  as $dist) {
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dist->distributor_type);
        $row = $row+1;
    }
    $type_cnt = $row;

    $row = 2;
    $sql = "select B.distributor_type, A.zone from zone_master A left join distributor_type_master B on (A.type_id=B.id) 
            where A.status='Approved' order by B.distributor_type, A.zone";
    $result  = $this->db->query($sql)->result();
    foreach($result  as $dist) {
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dist->distributor_type);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dist->zone);
        $row = $row+1;
    }
    $zone_cnt = $row;

    $row = 2;
    $sql = "select B.distributor_type, C.zone, A.location from location_master A 
            left join distributor_type_master B on (A.type_id=B.id) 
            left join zone_master C on (A.zone_id=C.id) 
            where A.status='Approved' order by B.distributor_type, C.zone, A.location";
    $result  = $this->db->query($sql)->result();
    foreach($result  as $dist) {
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dist->distributor_type);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dist->zone);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=H'.$row.'&"-"&I'.$row);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dist->location);
        $row = $row+1;
    }
    $location_cnt = $row;

    $row = 2;
    $sql = "select B.distributor_type, C.zone, D.location, A.distributor_name from 
            (select distributor_name, type_id, zone_id, location_id from distributor_master where status = 'Approved' 
            union all 
            select distributor_name, 3 as type_id, zone_id, location_id from sales_rep_distributors where status = 'Approved' or status = 'Active') A 
            left join distributor_type_master B on (A.type_id=B.id) 
            left join zone_master C on (A.zone_id=C.id) 
            left join location_master D on (A.location_id=D.id) 
            order by B.distributor_type, C.zone, D.location, A.distributor_name";
    $result  = $this->db->query($sql)->result();
    foreach($result  as $dist) {
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dist->distributor_type);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $dist->zone);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $dist->location);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '=M'.$row.'&"-"&N'.$row.'&"-"&O'.$row);
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dist->distributor_name);
        $row = $row+1;
    }
    $retailer_cnt = $row;

    $objPHPExcel->setActiveSheetIndex(0);
    for($row=2; $row<=100; $row++) {
        $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getDataValidation();
        $this->common_excel($objValidation);
        $objValidation->setFormula1('=Sheet2!$A$2:$A$'.($dist_cnt-1));

        $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getDataValidation();
        $this->common_excel($objValidation);
        $objValidation->setFormula1('=Sheet2!$C$2:$C$'.($type_cnt-1));

        $objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getDataValidation();
        $this->common_excel($objValidation);
        $objValidation->setFormula1('=OFFSET(Sheet2!$E$1, MATCH(D'.$row.',Sheet2!$E:$E, 0)-1, 1, COUNTIF(Sheet2!$E:$E, D'.$row.'))');

        $objValidation = $objPHPExcel->getActiveSheet()->getCell('F'.$row)->getDataValidation();
        $this->common_excel($objValidation);
        $objValidation->setFormula1('=OFFSET(Sheet2!$J$1, MATCH(D'.$row.'&"-"&E'.$row.',Sheet2!$J:$J, 0)-1, 1, COUNTIF(Sheet2!$J:$J, D'.$row.'&"-"&E'.$row.'))');

        $objValidation = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getDataValidation();
        $this->common_excel($objValidation);
        $objValidation->setFormula1('=OFFSET(Sheet2!$P$1, MATCH(D'.$row.'&"-"&E'.$row.'&"-"&F'.$row.',Sheet2!$P:$P, 0)-1, 1, COUNTIF(Sheet2!$P:$P, D'.$row.'&"-"&E'.$row.'&"-"&F'.$row.'))');
    }

    $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
    $filename='beat_master.xlsx';
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}

function common_excel($objValidation){
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

}
?>