<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Stock_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function check_raw_material_availablity(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');
    $raw_material_id=$this->input->post('raw_material_id');

    $depot_transfer_cond="";
    if($module=="depot_transfer"){
        $depot_transfer_cond=" and id<>'$id'";
    }
    
    $sql="select id from raw_material_in 
        where status = 'Approved' and depot_id = '$depot_id' and 
        id in (select distinct raw_material_in_id from raw_material_stock where raw_material_id = '$raw_material_id') 
        union all 
        select id from depot_transfer 
        where status = 'Approved' and depot_in_id = '$depot_id' and 
        id in (select distinct depot_transfer_id from depot_transfer_items where type = 'Raw Material' and 
            item_id = '$raw_material_id')".$depot_transfer_cond;
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_raw_material_qty_availablity(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');
    $raw_material_id=$this->input->post('raw_material_id');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=4;
    // $module="depot_transfer";
    // $depot_id=4;
    // $raw_material_id=5;
    // $qty=floatval(format_number('1,00,00,000'));

    $batch_processing_cond="";
    if($module=="batch_processing"){
        $batch_processing_cond=" and id<>'$id'";
    }
    
    $depot_transfer_cond="";
    if($module=="depot_transfer"){
        $depot_transfer_cond=" and id<>'$id'";
    }
    
    $sql="select sum(A.tot_qty) as tot_qty_in from 
        (select sum(qty) as tot_qty from raw_material_stock 
        where raw_material_id = '$raw_material_id' and raw_material_in_id in (select distinct id from raw_material_in 
            where status = 'Approved' and depot_id = '$depot_id') 
        union all 
        select sum(qty) as tot_qty from depot_transfer_items 
        where item_id = '$raw_material_id' and type = 'Raw Material' and depot_transfer_id in (select distinct id from depot_transfer 
            where status = 'Approved' and depot_in_id = '$depot_id'".$depot_transfer_cond.")) A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in=floatval($result[0]->tot_qty_in);
    } else {
        $tot_qty_in=0;
    }

    $sql="select sum(A.tot_qty) as tot_qty_out from 
        (select sum(qty) as tot_qty from batch_raw_material 
        where raw_material_id = '$raw_material_id' and batch_processing_id in (select distinct id from batch_processing 
            where status = 'Approved' and depot_id = '$depot_id'".$batch_processing_cond.") 
        union all 
        select sum(qty) as tot_qty from depot_transfer_items 
        where item_id = '$raw_material_id' and type = 'Raw Material' and depot_transfer_id in (select distinct id from depot_transfer 
            where status = 'Approved' and depot_out_id = '$depot_id'".$depot_transfer_cond.")) A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }

    if (($tot_qty_in-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function check_bar_availablity_for_depot(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');
    $product_id=$this->input->post('product_id');

    $depot_transfer_cond="";
    if($module=="depot_transfer"){
        $depot_transfer_cond=" and id<>'$id' ";
    }
    $distributor_in_cond="";
    if($module=="distributor_in"){
        $distributor_in_cond=" and id<>'$id' ";
    }
    $box_to_bar_cond="";
    if($module=="box_to_bar"){
        $box_to_bar_cond=" and id<>'$id' ";
    }
    
    $sql="select id from batch_processing 
        where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' 
        union all 
        select id from depot_transfer 
        where status = 'Approved' and depot_in_id = '$depot_id' and 
        id in (select distinct depot_transfer_id from depot_transfer_items where type = 'Bar' and item_id = '$product_id') ".$depot_transfer_cond."
        union all 
        select id from distributor_in 
        where status = 'Approved' and depot_id = '$depot_id' and 
        id in (select distinct distributor_in_id from distributor_in_items where type = 'Bar' and item_id = '$product_id') ".$distributor_in_cond."
        union all 
        select id from box_to_bar 
        where status = 'Approved' and depot_id = '$depot_id' and 
        id in (select distinct box_to_bar_id from box_to_bar_qty where box_id in 
            (select distinct box_id from box_product where product_id = '$product_id')".$box_to_bar_cond.")";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_bar_qty_availablity_for_depot(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');
    $product_id=$this->input->post('product_id');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=4;
    // $module="depot_transfer";
    // $depot_id=4;
    // $raw_material_id=5;
    // $qty=floatval(format_number('1,00,00,000'));
    
    $depot_transfer_cond="";
    if($module=="depot_transfer"){
        $depot_transfer_cond=" and id<>'$id'";
    }
    $distributor_in_cond="";
    if($module=="distributor_in"){
        $distributor_in_cond=" and id<>'$id'";
    }
    $box_to_bar_cond="";
    if($module=="box_to_bar"){
        $box_to_bar_cond=" and id<>'$id'";
    }
    $distributor_out_cond="";
    if($module=="distributor_out"){
        $distributor_out_cond=" and id<>'$id'";
    }
    $bar_to_box_cond="";
    if($module=="bar_to_box"){
        $bar_to_box_cond=" and id<>'$id'";
    }
    
    
    $sql="select sum(D.tot_qty) as tot_qty_in from 
        (select sum(qty_in_bar) as tot_qty from batch_processing where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' 
        union all 
        select sum(qty) as tot_qty from depot_transfer_items 
        where item_id = '$product_id' and type = 'Bar' and depot_transfer_id in (select distinct id from depot_transfer 
            where status = 'Approved' and depot_in_id = '$depot_id'".$depot_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_in_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_in_id in (select distinct id from distributor_in 
            where status = 'Approved' and depot_id = '$depot_id'".$distributor_in_cond.") 
        union all 
        select sum(tot_qty) as tot_qty from 
        (select A.box_id, B.product_id, ifnull(A.qty,0)*ifnull(B.qty,0) as tot_qty from 
        (select * from box_to_bar_qty where box_to_bar_id in (select distinct id from box_to_bar 
            where status = 'Approved' and depot_id = '$depot_id'".$box_to_bar_cond.")) A 
        left join 
        (select * from box_product where product_id = '$product_id') B 
        on (A.box_id = B.box_id)) C where C.product_id = '$product_id') D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in=floatval($result[0]->tot_qty_in);
    } else {
        $tot_qty_in=0;
    }

    $sql="select sum(D.tot_qty) as tot_qty_out from 
        (select sum(qty) as tot_qty from depot_transfer_items 
        where item_id = '$product_id' and type = 'Bar' and depot_transfer_id in (select distinct id from depot_transfer 
            where status = 'Approved' and depot_out_id = '$depot_id'".$depot_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_out_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_out_id in (select distinct id from distributor_out 
            where status = 'Approved' and depot_id = '$depot_id'".$distributor_out_cond.") 
        union all 
        select sum(tot_qty) as tot_qty from 
        (select A.box_id, B.product_id, ifnull(A.qty,0)*ifnull(B.qty,0) as tot_qty from 
        (select * from bar_to_box_qty where bar_to_box_id in (select distinct id from bar_to_box 
            where status = 'Approved' and depot_id = '$depot_id'".$bar_to_box_cond.")) A 
        left join 
        (select * from box_product where product_id = '$product_id') B 
        on (A.box_id = B.box_id)) C where C.product_id = '$product_id') D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }

    if (($tot_qty_in-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function check_box_availablity_for_depot(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');
    $box_id=$this->input->post('box_id');

    $depot_transfer_cond="";
    if($module=="depot_transfer"){
        $depot_transfer_cond=" and id<>'$id'";
    }
    $distributor_in_cond="";
    if($module=="distributor_in"){
        $distributor_in_cond=" and id<>'$id'";
    }
    $bar_to_box_cond="";
    if($module=="bar_to_box"){
        $bar_to_box_cond=" and id<>'$id'";
    }
    
    $sql="select id from depot_transfer 
        where status = 'Approved' and depot_in_id = '$depot_id' and 
        id in (select distinct depot_transfer_id from depot_transfer_items where type = 'Box' and item_id = '$box_id') ".$depot_transfer_cond." 
        union all 
        select id from distributor_in 
        where status = 'Approved' and depot_id = '$depot_id' and 
        id in (select distinct distributor_in_id from distributor_in_items where type = 'Box' and item_id = '$box_id') ".$distributor_in_cond." 
        union all 
        select id from bar_to_box 
        where status = 'Approved' and depot_id = '$depot_id' and 
        id in (select distinct bar_to_box_id from bar_to_box_qty where box_id = '$box_id') ".$bar_to_box_cond;
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_box_qty_availablity_for_depot(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');
    $box_id=$this->input->post('box_id');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=4;
    // $module="depot_transfer";
    // $depot_id=4;
    // $raw_material_id=5;
    // $qty=floatval(format_number('1,00,00,000'));
    
    $depot_transfer_cond="";
    if($module=="depot_transfer"){
        $depot_transfer_cond=" and id<>'$id'";
    }
    $distributor_in_cond="";
    if($module=="distributor_in"){
        $distributor_in_cond=" and id<>'$id'";
    }
    $box_to_bar_cond="";
    if($module=="box_to_bar"){
        $box_to_bar_cond=" and id<>'$id'";
    }
    $distributor_out_cond="";
    if($module=="distributor_out"){
        $distributor_out_cond=" and id<>'$id'";
    }
    $bar_to_box_cond="";
    if($module=="bar_to_box"){
        $bar_to_box_cond=" and id<>'$id'";
    }
    
    
    $sql="select sum(A.tot_qty) as tot_qty_in from 
        (select sum(qty) as tot_qty from depot_transfer_items 
        where item_id = '$box_id' and type = 'Box' and depot_transfer_id in (select distinct id from depot_transfer 
            where status = 'Approved' and depot_in_id = '$depot_id'".$depot_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_in_items 
        where item_id = '$box_id' and type = 'Box' and distributor_in_id in (select distinct id from distributor_in 
            where status = 'Approved' and depot_id = '$depot_id'".$distributor_in_cond.") 
        union all 
        select sum(qty) as tot_qty from bar_to_box_qty where box_id = '$box_id' and bar_to_box_id in (select distinct id from bar_to_box 
            where status = 'Approved' and depot_id = '$depot_id'".$bar_to_box_cond.")) A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in=floatval($result[0]->tot_qty_in);
    } else {
        $tot_qty_in=0;
    }

    $sql="select sum(D.tot_qty) as tot_qty_out from 
        (select sum(qty) as tot_qty from depot_transfer_items 
        where item_id = '$box_id' and type = 'Box' and depot_transfer_id in (select distinct id from depot_transfer 
            where status = 'Approved' and depot_out_id = '$depot_id'".$depot_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_out_items 
        where item_id = '$box_id' and type = 'Box' and distributor_out_id in (select distinct id from distributor_out 
            where status = 'Approved' and depot_id = '$depot_id'".$distributor_out_cond.") 
        union all 
        select sum(qty) as tot_qty from box_to_bar_qty where box_id = '$box_id' and box_to_bar_id in (select distinct id from box_to_bar 
            where status = 'Approved' and depot_id = '$depot_id'".$box_to_bar_cond.")) D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }

    if (($tot_qty_in-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function check_bar_availablity_for_distributor(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $distributor_id=$this->input->post('distributor_id');
    $product_id=$this->input->post('product_id');

    $distributor_transfer_cond="";
    if($module=="distributor_transfer"){
        $distributor_transfer_cond=" and id<>'$id' ";
    }
    $distributor_out_cond="";
    if($module=="distributor_out"){
        $distributor_out_cond=" and id<>'$id' ";
    }
    
    $sql="select id from distributor_transfer 
        where status = 'Approved' and distributor_in_id = '$distributor_id' and 
        id in (select distinct distributor_transfer_id from distributor_transfer_items where type = 'Bar' and item_id = '$product_id') ".$distributor_transfer_cond."
        union all 
        select id from distributor_out 
        where status = 'Approved' and distributor_id = '$distributor_id' and 
        id in (select distinct distributor_out_id from distributor_out_items where type = 'Bar' and item_id = '$product_id') ".$distributor_out_cond;
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_bar_qty_availablity_for_distributor(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $distributor_id=$this->input->post('distributor_id');
    $product_id=$this->input->post('product_id');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=4;
    // $module="distributor_transfer";
    // $distributor_id=4;
    // $raw_material_id=5;
    // $qty=floatval(format_number('1,00,00,000'));
    
    $distributor_transfer_cond="";
    if($module=="distributor_transfer"){
        $distributor_transfer_cond=" and id<>'$id'";
    }
    $distributor_out_cond="";
    if($module=="distributor_out"){
        $distributor_out_cond=" and id<>'$id'";
    }
    $distributor_in_cond="";
    if($module=="distributor_in"){
        $distributor_in_cond=" and id<>'$id'";
    }
    $distributor_sale_cond="";
    if($module=="distributor_sale"){
        $distributor_sale_cond=" and id<>'$id'";
    }
    
    
    $sql="select sum(D.tot_qty) as tot_qty_in from 
        (select sum(qty) as tot_qty from distributor_transfer_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_transfer_id in (select distinct id from distributor_transfer 
            where status = 'Approved' and distributor_in_id = '$distributor_id'".$distributor_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_out_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_out_id in (select distinct id from distributor_out 
            where status = 'Approved' and distributor_id = '$distributor_id'".$distributor_out_cond.")) D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in=floatval($result[0]->tot_qty_in);
    } else {
        $tot_qty_in=0;
    }

    $sql="select sum(D.tot_qty) as tot_qty_out from 
        (select sum(qty) as tot_qty from distributor_transfer_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_transfer_id in (select distinct id from distributor_transfer 
            where status = 'Approved' and distributor_out_id = '$distributor_id'".$distributor_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_in_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_in_id in (select distinct id from distributor_in 
            where status = 'Approved' and distributor_id = '$distributor_id'".$distributor_in_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_sale_items 
        where item_id = '$product_id' and type = 'Bar' and distributor_sale_id in (select distinct id from distributor_sale 
            where status = 'Approved' and distributor_id = '$distributor_id'".$distributor_sale_cond.")) D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }

    if (($tot_qty_in-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function check_box_availablity_for_distributor(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $distributor_id=$this->input->post('distributor_id');
    $box_id=$this->input->post('box_id');

    $distributor_transfer_cond="";
    if($module=="distributor_transfer"){
        $distributor_transfer_cond=" and id<>'$id' ";
    }
    $distributor_out_cond="";
    if($module=="distributor_out"){
        $distributor_out_cond=" and id<>'$id' ";
    }
    
    $sql="select id from distributor_transfer 
        where status = 'Approved' and distributor_in_id = '$distributor_id' and 
        id in (select distinct distributor_transfer_id from distributor_transfer_items 
            where type = 'Box' and item_id = '$product_id') ".$distributor_transfer_cond."
        union all 
        select id from distributor_out 
        where status = 'Approved' and distributor_id = '$distributor_id' and 
        id in (select distinct distributor_out_id from distributor_out_items 
            where type = 'Box' and item_id = '$product_id') ".$distributor_out_cond;
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_box_qty_availablity_for_distributor(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $distributor_id=$this->input->post('distributor_id');
    $box_id=$this->input->post('box_id');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=4;
    // $module="distributor_transfer";
    // $distributor_id=4;
    // $raw_material_id=5;
    // $qty=floatval(format_number('1,00,00,000'));
    
    $distributor_transfer_cond="";
    if($module=="distributor_transfer"){
        $distributor_transfer_cond=" and id<>'$id'";
    }
    $distributor_out_cond="";
    if($module=="distributor_out"){
        $distributor_out_cond=" and id<>'$id'";
    }
    $distributor_in_cond="";
    if($module=="distributor_in"){
        $distributor_in_cond=" and id<>'$id'";
    }
    $distributor_sale_cond="";
    if($module=="distributor_sale"){
        $distributor_sale_cond=" and id<>'$id'";
    }
    
    
    $sql="select sum(D.tot_qty) as tot_qty_in from 
        (select sum(qty) as tot_qty from distributor_transfer_items 
        where item_id = '$product_id' and type = 'Box' and distributor_transfer_id in (select distinct id from distributor_transfer 
            where status = 'Approved' and distributor_in_id = '$distributor_id'".$distributor_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_out_items 
        where item_id = '$product_id' and type = 'Box' and distributor_out_id in (select distinct id from distributor_out 
            where status = 'Approved' and distributor_id = '$distributor_id'".$distributor_out_cond.")) D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in=floatval($result[0]->tot_qty_in);
    } else {
        $tot_qty_in=0;
    }

    $sql="select sum(D.tot_qty) as tot_qty_out from 
        (select sum(qty) as tot_qty from distributor_transfer_items 
        where item_id = '$product_id' and type = 'Box' and distributor_transfer_id in (select distinct id from distributor_transfer 
            where status = 'Approved' and distributor_out_id = '$distributor_id'".$distributor_transfer_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_in_items 
        where item_id = '$product_id' and type = 'Box' and distributor_in_id in (select distinct id from distributor_in 
            where status = 'Approved' and distributor_id = '$distributor_id'".$distributor_in_cond.") 
        union all 
        select sum(qty) as tot_qty from distributor_sale_items 
        where item_id = '$product_id' and type = 'Box' and distributor_sale_id in (select distinct id from distributor_sale 
            where status = 'Approved' and distributor_id = '$distributor_id'".$distributor_sale_cond.")) D";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }

    if (($tot_qty_in-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function get_depot_bar_qty(){
    $id=$this->input->post('id');
    $module=$this->input->post('module');
    $depot_id=$this->input->post('depot_id');

    // $id=4;
    // $module="depot_transfer";
    // $depot_id=4;
    // $raw_material_id=5;
    // $qty=floatval(format_number('1,00,00,000'));
    
    $bar_to_box_cond="";
    if($module=="bar_to_box"){
        $bar_to_box_cond=" and id<>'$id'";
    }
    
    $box_to_bar_cond="";
    if($module=="box_to_bar"){
        $box_to_bar_cond=" and id<>'$id'";
    }
    
    
    $sql="select H.*, I.product_name from
        (select F.*, G.depot_name from 
        (select E.depot_id, E.product_id, sum(tot_qty) as tot_qty from 
        (select C.depot_id, C.product_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
        (select AA.depot_id, AA.product_id, sum(AA.qty) as qty_in from 
        (select depot_id, product_id, qty_in_bar as qty from batch_processing where status = 'Approved' 
        union all 
        select A.depot_in_id as depot_id, B.item_id as product_id, B.qty from 
        (select * from depot_transfer where status = 'Approved') A 
        inner join 
        (select * from depot_transfer_items where type = 'Bar') B 
        on (A.id = B.depot_transfer_id) 
        union all 
        select A.depot_id, B.item_id as product_id, B.qty from 
        (select * from distributor_in where status = 'Approved') A 
        inner join 
        (select * from distributor_in_items where type = 'Bar') B 
        on (A.id = B.distributor_in_id) 
        union all 
        select C.depot_id, D.product_id, ifnull(C.qty,0)*ifnull(D.qty,0) as qty from 
        (select A.depot_id, B.box_id, B.qty from 
        (select * from box_to_bar where status = 'Approved'".$box_to_bar_cond.") A 
        inner join 
        (select * from box_to_bar_qty) B 
        on (A.id = B.box_to_bar_id)) C 
        inner join 
        (select * from box_product) D 
        on (C.box_id = D.box_id)) AA group by AA.depot_id, AA.product_id) C 
        left join 
        (select BB.depot_id, BB.product_id, sum(BB.qty) as qty_out from 
        (select A.depot_out_id as depot_id, B.item_id as product_id, B.qty from 
        (select * from depot_transfer where status = 'Approved') A 
        inner join 
        (select * from depot_transfer_items where type = 'Bar') B 
        on (A.id = B.depot_transfer_id) 
        union all 
        select A.depot_id, B.item_id as product_id, B.qty from 
        (select * from distributor_out where status = 'Approved') A 
        inner join 
        (select * from distributor_out_items where type = 'Bar') B 
        on (A.id = B.distributor_out_id) 
        union all 
        select C.depot_id, D.product_id, ifnull(C.qty,0)*ifnull(D.qty,0) as qty from 
        (select A.depot_id, B.box_id, B.qty from 
        (select * from bar_to_box where status = 'Approved'".$bar_to_box_cond.") A 
        inner join 
        (select * from bar_to_box_qty) B 
        on (A.id = B.bar_to_box_id)) C 
        inner join 
        (select * from box_product) D 
        on (C.box_id = D.box_id)) BB group by BB.depot_id, BB.product_id) D 
        on (C.depot_id=D.depot_id and C.product_id=D.product_id)) E 
        group by E.depot_id, E.product_id) F 
        left join 
        (select * from depot_master where status = 'Approved') G 
        on (F.depot_id=G.id)) H 
        left join 
        (select * from product_master where status = 'Approved') I 
        on (H.product_id=I.id) where depot_id = '$depot_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

}
?>