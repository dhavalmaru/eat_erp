<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class User_role_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User_Roles' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        if($status=='Approved'){
            $cond=" where status='Approved' or status='Active'";
        }
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    $sql = "select * from user_role_master".$cond;
    $query=$this->db->query($sql);

    $sql = "SELECT A.*, concat_ws(' ',ifnull(B.first_name,''),ifnull(B.last_name,'')) as user_role_by From 
            (SELECT * FROM user_role_master".$cond.") A 
            LEFT JOIN 
            (SELECT id, first_name, last_name FROM user_master) B 
            ON A.created_by = B.id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_user_role_options($id=''){
    $query=$this->db->query("SELECT * FROM user_role_options WHERE role_id = '$id' and section in('Vendors', 'Depot', 'Raw_Material', 
                            'Tax', 'Product', 'Box', 'Sales_Rep', 'Distributor', 'City_Master', 'Purchase_Order', 'Raw_Material_In', 
                            'Batch_Processing', 'Distributor_Out', 'Distributor_In', 'Depot_Transfer', 'Distributor_Transfer', 
                            'Bar_To_Box_Transfer', 'Box_To_Bar_Transfer', 'Distributor_Sale', 'User', 'User_Roles', 'Log', 'Reports',
                            'Sales_Rep_Route_Plan', 'Sales_Rep_Distributors', 'Sales_Rep_Orders', 'Sales_Rep_Payment_Receivables', 'Dashboard', 'Bank_Master', 'Area', 'Distributor_Type', 'Zone', 'Payment', 'Credit_Debit_Note', 'Sales_Rep_Target') 
                            order by id");
    $result=$query->result();
    $editoptions=array();

    if (count($result)>0) {
        for($i=0;$i<count($result);$i++) {
            if ($result[$i]->section=="Dashboard") $num=27;
            else if ($result[$i]->section=="Vendors") $num=0;
            else if ($result[$i]->section=="Depot") $num=1;
            else if ($result[$i]->section=="Raw_Material") $num=2;
            else if ($result[$i]->section=="Tax") $num=3;
            else if ($result[$i]->section=="Product") $num=4;
            else if ($result[$i]->section=="Box") $num=5;
            else if ($result[$i]->section=="Sales_Rep") $num=6;
            else if ($result[$i]->section=="Distributor") $num=7;
            else if ($result[$i]->section=="City_Master") $num=8;
            else if ($result[$i]->section=="Purchase_Order") $num=9;
            else if ($result[$i]->section=="Raw_Material_In") $num=10;
            else if ($result[$i]->section=="Batch_Processing") $num=11;
            else if ($result[$i]->section=="Distributor_Out") $num=12;
            else if ($result[$i]->section=="Distributor_In") $num=13;
            else if ($result[$i]->section=="Depot_Transfer") $num=14;
            else if ($result[$i]->section=="Distributor_Transfer") $num=15;
            else if ($result[$i]->section=="Bar_To_Box_Transfer") $num=16;
            else if ($result[$i]->section=="Box_To_Bar_Transfer") $num=17;
            else if ($result[$i]->section=="Distributor_Sale") $num=18;
            else if ($result[$i]->section=="User") $num=19;
            else if ($result[$i]->section=="User_Roles") $num=20;
            else if ($result[$i]->section=="Log") $num=21;
            else if ($result[$i]->section=="Reports") $num=22;
            else if ($result[$i]->section=="Sales_Rep_Route_Plan") $num=23;
            else if ($result[$i]->section=="Sales_Rep_Distributors") $num=24;
            else if ($result[$i]->section=="Sales_Rep_Orders") $num=25;
            else if ($result[$i]->section=="Sales_Rep_Payment_Receivables") $num=26;
            else if ($result[$i]->section=="Bank_Master") $num=28;
            else if ($result[$i]->section=="Area") $num=29;
            else if ($result[$i]->section=="Distributor_Type") $num=30;
            else if ($result[$i]->section=="Zone") $num=31;
            else if ($result[$i]->section=="Payment") $num=32;
            else if ($result[$i]->section=="Credit_Debit_Note") $num=33;
            else if ($result[$i]->section=="Sales_Rep_Target") $num=34;
            else $num=0;

            $editoptions[$num]=$result[$i];
        }
    }

    return $editoptions;
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sects=array('Vendors', 'Depot', 'Raw_Material', 
                'Tax', 'Product', 'Box', 'Sales_Rep', 'Distributor', 'City_Master', 'Purchase_Order', 'Raw_Material_In', 
                'Batch_Processing', 'Distributor_Out', 'Distributor_In', 'Depot_Transfer', 'Distributor_Transfer', 
                'Bar_To_Box_Transfer', 'Box_To_Bar_Transfer', 'Distributor_Sale', 'User', 'User_Roles', 'Log', 'Reports',
                'Sales_Rep_Route_Plan', 'Sales_Rep_Distributors', 'Sales_Rep_Orders', 'Sales_Rep_Payment_Receivables','Dashboard', 'Bank_Master', 'Area', 'Distributor_Type', 'Zone', 'Payment', 'Credit_Debit_Note', 'Sales_Rep_Target');
    $vw=$this->input->post('view[]');
    $ins=$this->input->post('insert[]');
    $upd=$this->input->post('update[]');
    $del=$this->input->post('delete[]');
    $apps=$this->input->post('approval[]');
    $exp=$this->input->post('export[]');
    
    $data = array(
        'role_name' => $this->input->post('role_name'),
        'description' => $this->input->post('description'),
        'status' => $this->input->post('status'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('user_role_master',$data);
        $id=$this->db->insert_id();
        $action='User Role Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('user_role_master',$data);
        $action='User Role Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='User_Roles';
    $logarray['cnt_name']='User_Roles';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    $a=$b=$c=$d=$e=$f=0;
    $viw=$insrt=$updt=$delt=$apprs=$expt=NULL;

    for ($i=0; $i < count($sects) ; $i++) { 
        if(count($vw)>$a){
            if($vw[$a]==$i){
                $viw[$i]=1;
                if(count($viw)>$a){
                    $a++;
                }
            } else {
                $viw[$i]=0;
            }    
        } else {
            $viw[$i]=0;
        }

        if(count($ins)>$b) {
            if($ins[$b]==$i){
                $insrt[$i]=1;
                if(count($insrt)>$b){
                    $b++;
                }
            } else {
                $insrt[$i]=0;
            }
        } else {
            $insrt[$i]=0;
        }

        if(count($upd)>$c) {
            if($upd[$c]==$i){
                $updt[$i]=1;
                if(count($updt)>$c){
                    $c++;
                }
            } else {
                $updt[$i]=0;
            }
        } else {
            $updt[$i]=0;
        }
       
        if(count($del)>$d) {
            if($del[$d]==$i){
                $delt[$i]=1;
                if(count($delt)>$d){
                    $d++;
                }
            } else {
                $delt[$i]=0;
            }
        } else {
            $delt[$i]=0;
        }

        if(count($apps)>$e) {
            if($apps[$e]==$i){
                $apprs[$i]=1;
                if(count($apprs)>$e){
                    $e++;
                }
            } else {
                $apprs[$i]=0;
            }
        } else {
            $apprs[$i]=0;
        }

        if(count($exp)>$f) {
            if($exp[$f]==$i){
                $expt[$i]=1;
                if(count($expt)>$f){
                    $f++;
                }
            } else {
                $expt[$i]=0;
            }
        } else {
            $expt[$i]=0;
        }
    }

    $this->db->where('role_id', $id);
    $this->db->delete('user_role_options');

    for ($i=0; $i < count($sects) ; $i++) {
        $data = array(
            'role_id' => $id,
            'section' => $sects[$i],
            'r_view' => $viw[$i],
            'r_insert' => $insrt[$i],
            'r_edit' => $updt[$i],
            'r_delete' => $delt[$i],
            'r_approvals' => $apprs[$i],
            'r_export' => $expt[$i]
         );
        $this->db->insert('user_role_options', $data);
    }

    $this->db->query("update report_roles set rep_view = '0', modified_by='$curusr', modified_on='$now' WHERE role_id = '$id'");
    $report=$this->input->post('report[]');
    for ($i=0; $i < count($report) ; $i++) {
        $rep_id = $report[$i];

        $query=$this->db->query("SELECT * FROM report_roles WHERE rep_id = '$rep_id' and role_id = '$id'");
        $result=$query->result();
        if (count($result)>0) {
            $this->db->query("update report_roles set rep_view = '1', modified_by='$curusr', modified_on='$now' WHERE rep_id = '$rep_id' and role_id = '$id'");
        } else {
            $this->db->query("insert into report_roles (rep_id, role_id, rep_view, created_by, created_on) values ('$rep_id','$id','1','$curusr','$now')");
        }
    }
}

function check_role_availablity(){
    $id=$this->input->post('id');
    $role_name=$this->input->post('role_name');

    // $id="6";
    // $role_name="Admin";

    $query=$this->db->query("SELECT * FROM user_role_master WHERE id!='".$id."' and role_name='".$role_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>