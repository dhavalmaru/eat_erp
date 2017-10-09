<?php 
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard_model extends CI_Model {
    public function __construct() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        parent::__construct();
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Dashboard' AND 
                                role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_raw_material_stock() {
        $sql="select H.*, I.rm_name from
            (select F.*, G.depot_name from 
            (select E.depot_id, E.raw_material_id, sum(tot_qty) as tot_qty from 
            (select C.depot_id, C.raw_material_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
            (select AA.depot_id, AA.raw_material_id, sum(AA.qty) as qty_in from 
            (select A.depot_id, B.raw_material_id, B.qty from 
            (select * from raw_material_in where status = 'Approved') A 
            inner join 
            (select * from raw_material_stock) B 
            on (A.id = B.raw_material_in_id) 
            union all 
            select A.depot_in_id as depot_id, B.item_id as raw_material_id, B.qty from 
            (select * from depot_transfer where status = 'Approved') A 
            inner join 
            (select * from depot_transfer_items where type = 'Raw Material') B 
            on (A.id = B.depot_transfer_id)) AA group by AA.depot_id, AA.raw_material_id) C 
            left join 
            (select BB.depot_id, BB.raw_material_id, sum(BB.qty) as qty_out from 
            (select A.depot_id, B.raw_material_id, B.qty from 
            (select * from batch_processing where status = 'Approved') A 
            inner join 
            (select * from batch_raw_material) B 
            on (A.id = B.batch_processing_id) 
            union all 
            select A.depot_out_id as depot_id, B.item_id as raw_material_id, B.qty from 
            (select * from depot_transfer where status = 'Approved') A 
            inner join 
            (select * from depot_transfer_items where type = 'Raw Material') B 
            on (A.id = B.depot_transfer_id)) BB group by BB.depot_id, BB.raw_material_id) D 
            on (C.depot_id=D.depot_id and C.raw_material_id=D.raw_material_id)) E 
            group by E.depot_id, E.raw_material_id) F 
            left join 
            (select * from depot_master where status = 'Approved') G 
            on (F.depot_id=G.id)) H 
            left join 
            (select * from raw_material_master where status = 'Approved') I 
            on (H.raw_material_id=I.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_product_stock() {
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
            (select * from box_to_bar where status = 'Approved') A 
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
            (select * from bar_to_box where status = 'Approved') A 
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
            on (H.product_id=I.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_box_stock() {
        $sql="select H.*, I.box_name from
            (select F.*, G.depot_name from 
            (select E.depot_id, E.box_id, sum(tot_qty) as tot_qty from 
            (select C.depot_id, C.box_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
            (select AA.depot_id, AA.box_id, sum(AA.qty) as qty_in from 
            (select A.depot_in_id as depot_id, B.item_id as box_id, B.qty from 
            (select * from depot_transfer where status = 'Approved') A 
            inner join 
            (select * from depot_transfer_items where type = 'Box') B 
            on (A.id = B.depot_transfer_id) 
            union all 
            select A.depot_id, B.item_id as box_id, B.qty from 
            (select * from distributor_in where status = 'Approved') A 
            inner join 
            (select * from distributor_in_items where type = 'Box') B 
            on (A.id = B.distributor_in_id) 
            union all 
            select A.depot_id, B.box_id, B.qty from 
            (select * from bar_to_box where status = 'Approved') A 
            inner join 
            (select * from bar_to_box_qty) B 
            on (A.id = B.bar_to_box_id)) AA group by AA.depot_id, AA.box_id) C 
            left join 
            (select BB.depot_id, BB.box_id, sum(BB.qty) as qty_out from 
            (select A.depot_out_id as depot_id, B.item_id as box_id, B.qty from 
            (select * from depot_transfer where status = 'Approved') A 
            inner join 
            (select * from depot_transfer_items where type = 'Box') B 
            on (A.id = B.depot_transfer_id) 
            union all 
            select A.depot_id, B.item_id as box_id, B.qty from 
            (select * from distributor_out where status = 'Approved') A 
            inner join 
            (select * from distributor_out_items where type = 'Box') B 
            on (A.id = B.distributor_out_id) 
            union all 
            select A.depot_id, B.box_id, B.qty from 
            (select * from box_to_bar where status = 'Approved') A 
            inner join 
            (select * from box_to_bar_qty) B 
            on (A.id = B.box_to_bar_id)) BB group by BB.depot_id, BB.box_id) D 
            on (C.depot_id=D.depot_id and C.box_id=D.box_id)) E 
            group by E.depot_id, E.box_id) F 
            left join 
            (select * from depot_master where status = 'Approved') G 
            on (F.depot_id=G.id)) H 
            left join 
            (select * from box_master where status = 'Approved') I 
            on (H.box_id=I.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_total_product_stock() {
        $sql="select DD.depot_id, DD.product_id, sum(DD.tot_qty) as tot_qty, DD.depot_name, DD.product_name, DD.denominations, sum(DD.total_bars) as total_bars from 

            (select H.*, I.product_name, 1 as denominations, tot_qty as total_bars from 
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
            (select * from box_to_bar where status = 'Approved') A 
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
            (select * from bar_to_box where status = 'Approved') A 
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
            on (H.product_id=I.id)

            union all 

            select CC.depot_id, CC.product_id, sum(CC.tot_qty) as tot_qty, CC.depot_name, CC.product_name, CC.denominations, sum(CC.total_bars) as total_bars from 
            (select AA.depot_id, BB.product_id, AA.tot_qty, AA.depot_name, BB.product_name, BB.qty as denominations, ifnull(AA.tot_qty,0)*ifnull(BB.qty,0) as total_bars from 
            (select H.*, I.box_name from
            (select F.*, G.depot_name from 
            (select E.depot_id, E.box_id, sum(tot_qty) as tot_qty from 
            (select C.depot_id, C.box_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
            (select AA.depot_id, AA.box_id, sum(AA.qty) as qty_in from 
            (select A.depot_in_id as depot_id, B.item_id as box_id, B.qty from 
            (select * from depot_transfer where status = 'Approved') A 
            inner join 
            (select * from depot_transfer_items where type = 'Box') B 
            on (A.id = B.depot_transfer_id) 
            union all 
            select A.depot_id, B.item_id as box_id, B.qty from 
            (select * from distributor_in where status = 'Approved') A 
            inner join 
            (select * from distributor_in_items where type = 'Box') B 
            on (A.id = B.distributor_in_id) 
            union all 
            select A.depot_id, B.box_id, B.qty from 
            (select * from bar_to_box where status = 'Approved') A 
            inner join 
            (select * from bar_to_box_qty) B 
            on (A.id = B.bar_to_box_id)) AA group by AA.depot_id, AA.box_id) C 
            left join 
            (select BB.depot_id, BB.box_id, sum(BB.qty) as qty_out from 
            (select A.depot_out_id as depot_id, B.item_id as box_id, B.qty from 
            (select * from depot_transfer where status = 'Approved') A 
            inner join 
            (select * from depot_transfer_items where type = 'Box') B 
            on (A.id = B.depot_transfer_id) 
            union all 
            select A.depot_id, B.item_id as box_id, B.qty from 
            (select * from distributor_out where status = 'Approved') A 
            inner join 
            (select * from distributor_out_items where type = 'Box') B 
            on (A.id = B.distributor_out_id) 
            union all 
            select A.depot_id, B.box_id, B.qty from 
            (select * from box_to_bar where status = 'Approved') A 
            inner join 
            (select * from box_to_bar_qty) B 
            on (A.id = B.box_to_bar_id)) BB group by BB.depot_id, BB.box_id) D 
            on (C.depot_id=D.depot_id and C.box_id=D.box_id)) E 
            group by E.depot_id, E.box_id) F 
            left join 
            (select * from depot_master where status = 'Approved') G 
            on (F.depot_id=G.id)) H 
            left join 
            (select * from box_master where status = 'Approved') I 
            on (H.box_id=I.id)) AA 
            left join 
            (select A.*, B.product_name from box_product A left join product_master B on (A.product_id = B.id)) BB 
            on (AA.box_id = BB.box_id)) CC 
            where CC.tot_qty > 0
            group by CC.depot_id, CC.product_id, CC.depot_name, CC.product_name, CC.denominations) DD 

            where DD.tot_qty > 0
            group by DD.depot_id, DD.product_id, DD.depot_name, DD.product_name, DD.denominations 
            order by DD.product_id, DD.depot_id, DD.denominations";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_product_stock_for_distributor() {
        $sql="select J.*, K.product_name from 
            (select H.*, I.distributor_name from 
            (select F.*, G.sale_qty, ifnull(F.tot_qty,0)-ifnull(G.sale_qty,0) as bal_qty from 
            (select E.distributor_id, E.product_id, sum(tot_qty) as tot_qty from 
            (select C.distributor_id, C.product_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
            (select AA.distributor_id, AA.product_id, sum(AA.qty) as qty_in from 
            (select A.distributor_in_id as distributor_id, B.item_id as product_id, B.qty from 
            (select * from distributor_transfer where status = 'Approved') A 
            inner join 
            (select * from distributor_transfer_items where type = 'Bar') B 
            on (A.id = B.distributor_transfer_id) 
            union all 
            select A.distributor_id, B.item_id as product_id, B.qty from 
            (select * from distributor_out where status = 'Approved') A 
            inner join 
            (select * from distributor_out_items where type = 'Bar') B 
            on (A.id = B.distributor_out_id)) AA group by AA.distributor_id, AA.product_id) C 
            left join 
            (select BB.distributor_id, BB.product_id, sum(BB.qty) as qty_out from 
            (select A.distributor_out_id as distributor_id, B.item_id as product_id, B.qty from 
            (select * from distributor_transfer where status = 'Approved') A 
            inner join 
            (select * from distributor_transfer_items where type = 'Bar') B 
            on (A.id = B.distributor_transfer_id) 
            union all 
            select A.distributor_id, B.item_id as product_id, B.qty from 
            (select * from distributor_in where status = 'Approved') A 
            inner join 
            (select * from distributor_in_items where type = 'Bar') B 
            on (A.id = B.distributor_in_id)) BB group by BB.distributor_id, BB.product_id) D 
            on (C.distributor_id=D.distributor_id and C.product_id=D.product_id)) E 
            group by E.distributor_id, E.product_id) F 
            left join 
            (select A.distributor_id, B.item_id as product_id, sum(B.qty) as sale_qty from 
            (select * from distributor_sale where status = 'Approved') A 
            inner join 
            (select * from distributor_sale_items where type = 'Bar') B 
            on (A.id = B.distributor_sale_id) group by A.distributor_id, B.item_id) G 
            on (F.distributor_id=G.distributor_id)) H 
            left join 
            (select * from distributor_master where status = 'Approved' and class = 'super stockist') I 
            on (H.distributor_id=I.id) where distributor_name is not null) J 
            left join 
            (select * from product_master where status = 'Approved') K 
            on (J.product_id=K.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_box_stock_for_distributor() {
        $sql="select J.*, K.box_name from 
            (select H.*, I.distributor_name from 
            (select F.*, G.sale_qty, ifnull(F.tot_qty,0)-ifnull(G.sale_qty,0) as bal_qty from 
            (select E.distributor_id, E.box_id, sum(tot_qty) as tot_qty from 
            (select C.distributor_id, C.box_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
            (select AA.distributor_id, AA.box_id, sum(AA.qty) as qty_in from 
            (select A.distributor_in_id as distributor_id, B.item_id as box_id, B.qty from 
            (select * from distributor_transfer where status = 'Approved') A 
            inner join 
            (select * from distributor_transfer_items where type = 'Box') B 
            on (A.id = B.distributor_transfer_id) 
            union all 
            select A.distributor_id, B.item_id as box_id, B.qty from 
            (select * from distributor_out where status = 'Approved') A 
            inner join 
            (select * from distributor_out_items where type = 'Box') B 
            on (A.id = B.distributor_out_id)) AA group by AA.distributor_id, AA.box_id) C 
            left join 
            (select BB.distributor_id, BB.box_id, sum(BB.qty) as qty_out from 
            (select A.distributor_out_id as distributor_id, B.item_id as box_id, B.qty from 
            (select * from distributor_transfer where status = 'Approved') A 
            inner join 
            (select * from distributor_transfer_items where type = 'Box') B 
            on (A.id = B.distributor_transfer_id) 
            union all 
            select A.distributor_id, B.item_id as box_id, B.qty from 
            (select * from distributor_in where status = 'Approved') A 
            inner join 
            (select * from distributor_in_items where type = 'Box') B 
            on (A.id = B.distributor_in_id)) BB group by BB.distributor_id, BB.box_id) D 
            on (C.distributor_id=D.distributor_id and C.box_id=D.box_id)) E 
            group by E.distributor_id, E.box_id) F 
            left join 
            (select A.distributor_id, B.item_id as box_id, sum(B.qty) as sale_qty from 
            (select * from distributor_sale where status = 'Approved') A 
            inner join 
            (select * from distributor_sale_items where type = 'Box') B 
            on (A.id = B.distributor_sale_id) group by A.distributor_id, B.item_id) G 
            on (F.distributor_id=G.distributor_id and F.box_id=G.box_id)) H 
            left join 
            (select * from distributor_master where status = 'Approved' and class = 'super stockist') I 
            on (H.distributor_id=I.id) where distributor_name is not null) J 
            left join 
            (select * from box_master where status = 'Approved') K 
            on (J.box_id=K.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_total_sale() {
        $sql="select AA.total_amount, BB.total_bar, BB.total_box from 
            (select A.temp_col, round(ifnull(A.total_amount,0)-ifnull(B.total_amount,0),0) as total_amount from 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_in where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) B 
            on (A.temp_col = B.temp_col)) AA 
            left join 
            (select C.temp_col, ifnull(C.total_bar,0)-ifnull(D.total_bar,0) as total_bar, ifnull(C.total_box,0)-ifnull(D.total_box,0) as total_box from 
            (select '1' as temp_col, sum(B.bar_qty) as total_bar, sum(B.box_qty) as total_box from 
            (select id from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select distributor_out_id, case when type='Bar' then qty else 0 end as bar_qty, 
            case when type='Box' then qty else 0 end as box_qty from distributor_out_items) B 
            on (A.id=B.distributor_out_id)) C 
            left join 
            (select '1' as temp_col, sum(B.bar_qty) as total_bar, sum(B.box_qty) as total_box from 
            (select id from distributor_in where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select A.distributor_in_id, case when A.type='Bar' then A.qty else ifnull(A.qty,0)*ifnull(B.qty,0) end as bar_qty, 
                        case when A.type='Box' then A.qty else 0 end as box_qty 
            from distributor_in_items A left join box_product B 
            on (A.type = 'Box' and A.item_id = B.box_id)) B 
            on (A.id=B.distributor_in_id)) D 
            on (C.temp_col=D.temp_col)) BB 
            on (AA.temp_col = BB.temp_col)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_total_distributor() {
        $sql="select (B.tot_g_trade+B.tot_m_trade+B.tot_e_com) as tot_dist, B.tot_g_trade, B.tot_m_trade, B.tot_e_com from 
            (select count(A.id) as tot_dist, sum(A.g_trade) as tot_g_trade, sum(A.m_trade) as tot_m_trade, 
            sum(A.e_com) as tot_e_com from (select id, case when type_id='3' then 1 else 0 end as g_trade, 
            case when type_id='7' then 1 else 0 end as m_trade, 
            case when type_id='4' then 1 else 0 end as e_com 
            from distributor_master where status = 'Approved') A) B";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_total_stock() {
        $bar_stock=$this->get_product_stock();
        $box_stock=$this->get_box_stock();

        $tot_bar=0;
        for($i=0; $i<count($bar_stock); $i++){
            $tot_bar=$tot_bar+floatval($bar_stock[$i]->tot_qty);
        }

        $tot_box=0;
        for($i=0; $i<count($box_stock); $i++){
            $tot_box=$tot_box+floatval($box_stock[$i]->tot_qty);
        }

        $tot_stock['tot_bar']=$tot_bar;
        $tot_stock['tot_box']=$tot_box;

        return $tot_stock;
    }

    function get_total_receivable() {
        $sql="select ifnull(C.total_amount,0)-ifnull(D.total_amount,0) as total_receivable from 
            (select A.temp_col, round(ifnull(A.total_amount,0)-ifnull(B.total_amount,0),0) as total_amount from 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_in where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) B 
            on (A.temp_col = B.temp_col)) C 
            left join 
            (select '1' as temp_col, sum(total_amount) as total_amount from payment_details where status = 'Approved') D 
            on (C.temp_col=D.temp_col)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_sales_trend_in_rs($from_date, $to_date) {
        $sql="select * from (select date_of_processing, sum(amount) as total_amount from distributor_out 
            where status = 'Approved' and 
            distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
            date(date_of_processing) >= date('" . $from_date . "') and 
            date(date_of_processing) <= date('" . $to_date . "') group by date_of_processing) A 
            where A.total_amount>0";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_avg_day_sale_in_rs($from_date, $to_date) {
        $sql="select * from (select date_of_processing, avg(amount) as total_amount from distributor_out 
            where status = 'Approved' and 
            distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
            date(date_of_processing) >= date('" . $from_date . "') and 
            date(date_of_processing) <= date('" . $to_date . "') group by date_of_processing) A 
            where A.total_amount>0";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_avg_total_sale_in_rs($from_date, $to_date) {
        $sql="select distinct C.date_of_processing, C.total_amount from (select A.date_of_processing, 
            (select avg(B.amount) from distributor_out B where B.status = 'Approved' and 
            B.distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
            B.date_of_processing<=A.date_of_processing) as total_amount 
            from distributor_out A where A.status = 'Approved' and 
            A.distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
            date(A.date_of_processing) >= date('" . $from_date . "') and 
            date(A.date_of_processing) <= date('" . $to_date . "')) C 
            where C.total_amount>0";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_sales_trend($from_date, $to_date, $type) {
        if($type=='Bar'){
            $sql="select * from 
                (select A.date_of_processing, sum(B.qty) as total_qty from 
                (select id, date_of_processing from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
                left join 
                (select A.distributor_out_id, case when A.type = 'Box' then ifnull(A.qty,0)*ifnull(B.qty,0) else A.qty end as qty 
                    from distributor_out_items A left join box_product B 
                    on (A.type = 'Box' and A.item_id = B.box_id)) B 
                on (A.id = B.distributor_out_id) 
                group by A.date_of_processing) C 
                where C.total_qty>0";
        } else {
            $sql="select * from 
                (select A.date_of_processing, sum(B.qty) as total_qty from 
                (select id, date_of_processing from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
                left join 
                (select distributor_out_id, qty from distributor_out_items where type = '".$type."') B 
                on (A.id = B.distributor_out_id) 
                group by A.date_of_processing) C 
                where C.total_qty>0";
        }
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_avg_day_sale($from_date, $to_date, $type) {
        if($type=='Bar'){
            $sql="select * from 
            (select A.date_of_processing, avg(B.qty) as total_qty from 
            (select id, date_of_processing from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                date(date_of_processing) >= date('" . $from_date . "') and 
                date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select A.distributor_out_id, case when A.type = 'Box' then ifnull(A.qty,0)*ifnull(B.qty,0) else A.qty end as qty 
                from distributor_out_items A left join box_product B 
                on (A.type = 'Box' and A.item_id = B.box_id)) B 
            on (A.id = B.distributor_out_id) 
            group by A.date_of_processing) C 
            where C.total_qty>0";
        } else {
            $sql="select * from 
                (select A.date_of_processing, avg(B.qty) as total_qty from 
                (select id, date_of_processing from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
                left join 
                (select distributor_out_id, qty from distributor_out_items where type = '".$type."') B 
                on (A.id = B.distributor_out_id) 
                group by A.date_of_processing) C 
                where C.total_qty>0";
        }
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_avg_total_sale($from_date, $to_date, $type) {
        if($type=='Bar'){
            $sql="select distinct C.date_of_processing, C.total_qty from (select A.date_of_processing, (select avg(B.qty) from 
                    (select * from 
                            (select A.date_of_processing, B.qty from 
                            (select id, date_of_processing from distributor_out where status = 'Approved' and 
                                distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                                date(date_of_processing) >= date('" . $from_date . "') and 
                                date(date_of_processing) <= date('" . $to_date . "')) A 
                            left join 
                            (select A.distributor_out_id, case when A.type = 'Box' then ifnull(A.qty,0)*ifnull(B.qty,0) else A.qty end as qty 
                                from distributor_out_items A left join box_product B 
                                on (A.type = 'Box' and A.item_id = B.box_id)) B 
                            on (A.id = B.distributor_out_id)) C 
                            where C.qty>0) B 
                where B.date_of_processing<=A.date_of_processing) as total_qty 
                from (select * from 
                    (select A.date_of_processing, B.qty from 
                    (select id, date_of_processing from distributor_out where status = 'Approved' and 
                        distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                        date(date_of_processing) >= date('" . $from_date . "') and 
                        date(date_of_processing) <= date('" . $to_date . "')) A 
                    left join 
                    (select A.distributor_out_id, case when A.type = 'Box' then ifnull(A.qty,0)*ifnull(B.qty,0) else A.qty end as qty 
                        from distributor_out_items A left join box_product B 
                        on (A.type = 'Box' and A.item_id = B.box_id)) B 
                    on (A.id = B.distributor_out_id)) C 
                    where C.qty>0) A where date(A.date_of_processing) >= date('" . $from_date . "') and 
                date(A.date_of_processing) <= date('" . $to_date . "')) C 
                where C.total_qty>0";
        } else {
            $sql="select distinct C.date_of_processing, C.total_qty from (select A.date_of_processing, (select avg(B.qty) from 
                    (select * from 
                            (select A.date_of_processing, B.qty from 
                            (select id, date_of_processing from distributor_out where status = 'Approved' and 
                                distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                                date(date_of_processing) >= date('" . $from_date . "') and 
                                date(date_of_processing) <= date('" . $to_date . "')) A 
                            left join 
                            (select distributor_out_id, qty from distributor_out_items where type = '".$type."') B 
                            on (A.id = B.distributor_out_id)) C 
                            where C.qty>0) B 
                where B.date_of_processing<=A.date_of_processing) as total_qty 
                from (select * from 
                    (select A.date_of_processing, B.qty from 
                    (select id, date_of_processing from distributor_out where status = 'Approved' and 
                        distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                        date(date_of_processing) >= date('" . $from_date . "') and 
                        date(date_of_processing) <= date('" . $to_date . "')) A 
                    left join 
                    (select distributor_out_id, qty from distributor_out_items where type = '".$type."') B 
                    on (A.id = B.distributor_out_id)) C 
                    where C.qty>0) A where date(A.date_of_processing) >= date('" . $from_date . "') and 
                date(A.date_of_processing) <= date('" . $to_date . "')) C 
                where C.total_qty>0";
        }
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_product_wise_sale_in_bar($from_date, $to_date) {
        $sql="select D.item_id, E.product_name, D.total_qty from 
            (select C.item_id, sum(C.qty) as total_qty from 
            (select A.id, A.month_name, B.item_id, B.qty from 
            (select id, date_format(date_of_processing,'%b-%y') as month_name from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                date(date_of_processing) >= date('" . $from_date . "') and 
                date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Bar' 
            union all 
            select A.distributor_out_id, A.item_id, ifnull(A.qty,0)*ifnull(B.qty,0) as qty from 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') A 
            left join 
            (select * from box_product) B 
            on (A.item_id = B.box_id)) B 
            on (A.id=B.distributor_out_id)) C 
            group by C.item_id) D 
            left join 
            (select * from product_master) E 
            on (D.item_id = E.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_product_wise_sale_in_box($from_date, $to_date) {
        $sql="select D.item_id, E.box_name, D.total_qty from 
            (select C.item_id, sum(C.qty) as total_qty from 
            (select A.id, A.month_name, B.item_id, B.qty from 
            (select id, date_format(date_of_processing,'%b-%y') as month_name from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                date(date_of_processing) >= date('" . $from_date . "') and 
                date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') B 
            on (A.id=B.distributor_out_id)) C 
            group by C.item_id) D 
            left join 
            (select * from box_master) E 
            on (D.item_id = E.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_months($from_date, $to_date) {
        $sql="select * from 
            (select distinct month(date_of_processing) as month_no, date_format(date_of_processing,'%b-%y') as month_name 
            from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                date(date_of_processing) >= date('" . $from_date . "') and 
                date(date_of_processing) <= date('" . $to_date . "')) A";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_month_wise_sale_in_box($from_date, $to_date) {
        $sql="select D.item_id, D.month_no, D.month_name, E.box_name, D.total_qty from 
            (select C.item_id, C.month_no, C.month_name, sum(C.qty) as total_qty from 
            (select A.id, A.month_no, A.month_name, B.item_id, B.qty from 
            (select id, month(date_of_processing) as month_no, date_format(date_of_processing,'%b-%y') as month_name 
                from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') B 
            on (A.id=B.distributor_out_id)) C 
            group by C.item_id, C.month_no, C.month_name) D 
            left join 
            (select * from box_master) E 
            on (D.item_id = E.id) where D.total_qty is not null order by D.item_id, D.month_no";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_month_wise_sale_in_bar($from_date, $to_date) {
        $sql="select D.item_id, D.month_no, D.month_name, E.product_name, D.total_qty from 
            (select C.item_id, C.month_no, C.month_name, sum(C.qty) as total_qty from 
            (select A.id, A.month_no, A.month_name, B.item_id, B.qty from 
            (select id, month(date_of_processing) as month_no, date_format(date_of_processing,'%b-%y') as month_name 
                from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "') order by date_of_processing) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Bar' 
            union all 
            select A.distributor_out_id, A.item_id, ifnull(A.qty,0)*ifnull(B.qty,0) as qty from 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') A 
            left join 
            (select * from box_product) B 
            on (A.item_id = B.box_id)) B 
            on (A.id=B.distributor_out_id)) C 
            group by C.item_id, C.month_no, C.month_name) D 
            left join 
            (select * from product_master) E 
            on (D.item_id = E.id) where D.total_qty is not null order by D.item_id, D.month_no";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_sm_wise_sale_in_bar($from_date, $to_date) {
        $sql="select D.sales_rep_id, E.sales_rep_name, D.total_qty from 
            (select C.sales_rep_id, sum(C.qty) as total_qty from 
            (select A.id, A.sales_rep_id, A.month_name, B.item_id, B.qty from 
            (select id, sales_rep_id, date_format(date_of_processing,'%b-%y') as month_name 
                from distributor_out where status = 'Approved' and sales_rep_id != '2' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Bar' 
            union all 
            select A.distributor_out_id, A.item_id, ifnull(A.qty,0)*ifnull(B.qty,0) as qty from 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') A 
            left join 
            (select * from box_product) B 
            on (A.item_id = B.box_id)) B 
            on (A.id=B.distributor_out_id)) C 
            group by C.sales_rep_id) D 
            left join 
            (select * from sales_rep_master) E 
            on (D.sales_rep_id = E.id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_gt_month_wise_sale_in_bar($from_date, $to_date) {
        $sql="select E.distributor_id, E.month_no, E.month_name, E.distributor_name, sum(E.qty) as total_qty from 
            (select C.distributor_id, C.month_no, C.month_name, D.type_id, D.distributor_name, C.qty from 
            (select A.id, A.distributor_id, A.month_no, A.month_name, B.item_id, B.qty from 
            (select id, distributor_id, month(date_of_processing) as month_no, date_format(date_of_processing,'%b-%y') as month_name 
                from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Bar' 
            union all 
            select A.distributor_out_id, A.item_id, ifnull(A.qty,0)*ifnull(B.qty,0) as qty from 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') A 
            left join 
            (select * from box_product) B 
            on (A.item_id = B.box_id)) B 
            on (A.id=B.distributor_out_id)) C 
            left join 
            (select * from distributor_master where status='Approved' and type_id='3') D 
            on (C.distributor_id = D.id) where D.distributor_name is not null) E 
            group by E.distributor_id, E.month_no, E.month_name, E.distributor_name 
            having sum(E.qty) is not null order by E.distributor_id, E.month_no";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_category_wise_sale_in_bar($from_date, $to_date) {
        $sql="select E.type_id, E.distributor_type, sum(E.qty) as total_qty from 
            (select C.distributor_id, D.type_id, D.distributor_type, C.qty from 
            (select A.id, A.distributor_id, A.month_name, B.item_id, B.qty from 
            (select id, distributor_id, date_format(date_of_processing,'%b-%y') as month_name 
                from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Bar' 
            union all 
            select A.distributor_out_id, A.item_id, ifnull(A.qty,0)*ifnull(B.qty,0) as qty from 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') A 
            left join 
            (select * from box_product) B 
            on (A.item_id = B.box_id)) B 
            on (A.id=B.distributor_out_id)) C 
            left join 
            (select A.*, B.distributor_type from 
            (select * from distributor_master where status='Approved') A 
            left join 
            (select * from distributor_type_master where status='Approved') B
            on (A.type_id=B.id)) D 
            on (C.distributor_id = D.id)) E group by E.type_id, E.distributor_type";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_category_month_wise_sale_in_bar($from_date, $to_date) {
        $sql="select E.type_id, E.month_no, E.month_name, E.distributor_type, sum(E.qty) as total_qty from 
            (select C.distributor_id, C.month_no, C.month_name, D.type_id, D.distributor_type, C.qty from 
            (select A.id, A.distributor_id, A.month_no, A.month_name, B.item_id, B.qty from 
            (select id, distributor_id, month(date_of_processing) as month_no, date_format(date_of_processing,'%b-%y') as month_name 
                from distributor_out where status = 'Approved' and 
                    distributor_id not in (select distinct id from distributor_master where class = 'sample') and 
                    date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "')) A 
            left join 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Bar' 
            union all 
            select A.distributor_out_id, A.item_id, ifnull(A.qty,0)*ifnull(B.qty,0) as qty from 
            (select distributor_out_id, item_id, qty from distributor_out_items where type = 'Box') A 
            left join 
            (select * from box_product) B 
            on (A.item_id = B.box_id)) B 
            on (A.id=B.distributor_out_id)) C 
            left join 
            (select A.*, B.distributor_type from 
            (select * from distributor_master where status='Approved') A 
            left join 
            (select * from distributor_type_master where status='Approved') B
            on (A.type_id=B.id)) D 
            on (C.distributor_id = D.id)) E group by E.type_id, E.month_no, E.month_name, E.distributor_type 
            having sum(E.qty) is not null order by E.type_id, E.month_no";
        $query=$this->db->query($sql);
        return $query->result();
    }

}
?>