<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Autocomplete_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}

function getCityList($term){
	$this->db->select('id,city_name,state_id');
	$this->db->from('city_master');
	$this->db->where('status = "1" and city_name like "%'.$term.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->city_name,"state_id"=>$row->state_id);

	}
	return $datatarray;
}

function getStateCountryByCity($state_id){
	$this->db->select('sm.state_name , cm.country_name,cm.id as country_id ');
	$this->db->from('state_master sm,country_master cm');
	$this->db->where('cm.id = sm.country_id and sm.id = '.$state_id.' ');
	$result=$this->db->get();
	//echo $this->db->last_query();
foreach($result->result() as $row){
	$response=array("status"=>true,"state_name"=>$row->state_name,"country_id"=>$row->country_id,"country_name"=>$row->country_name);
}
return $response;
}

function loadcountry($text){
	$this->db->select('id,country_name');
	$this->db->from('country_master');
	$this->db->where('status = "1" and country_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->country_name);

	}
	return $datatarray;
}

function loadState($text){
	$this->db->select('id,state_name');
	$this->db->from('state_master');
	$this->db->where('status = "1" and state_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->state_name);

	}
	return $datatarray;
}

function load_vendor($text){
	$this->db->select('*');
	$this->db->from('vendor_master');
	$this->db->where('status = "Approved" and vendor_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->vendor_name);

	}
	return $datatarray;
}

function load_distributor($text){
	$this->db->select('*');
	$this->db->from('distributor_master');
	$this->db->where('status = "Approved" and distributor_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->distributor_name);

	}
	return $datatarray;
}

function load_sales_rep($text){
	$this->db->select('*');
	$this->db->from('sales_rep_master');
	$this->db->where('status = "Approved" and sales_rep_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->sales_rep_name);

	}
	return $datatarray;
}

function load_raw_material($text){
	$this->db->select('*');
	$this->db->from('raw_material_master');
	$this->db->where('status = "Approved" and rm_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->rm_name);

	}
	return $datatarray;
}

function load_product($text){
	$this->db->select('*');
	$this->db->from('product_master');
	$this->db->where('status = "Approved" and product_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->product_name);

	}
	return $datatarray;
}

function load_depot($text){
	$this->db->select('*');
	$this->db->from('depot_master');
	$this->db->where('status = "Approved" and depot_name like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->depot_name);

	}
	return $datatarray;
}

function load_batch($text){
	$this->db->select('*');
	$this->db->from('batch_processing');
	$this->db->where('status = "Approved" and batch_id_as_per_fssai like "%'.$text.'%" ');
	$result=$this->db->get();
	//echo $this->db->last_query();
	//$datatarray[]=array();
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->batch_id_as_per_fssai);

	}
	return $datatarray;
}


}
?>