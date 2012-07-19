<?php
class AdminDao extends Dao{
	function insert_pic($data) {
		if(!$data) return false;
		$rs=$this->insert($data,"pics");
		return $rs;
	}

	function list_pic($belong_to,$limit="") {
		if($belong_to){
			$where="belong_to='{$belong_to}'";
		}
		$rs=$this->read("*","pics",$where,$limit);
		return $rs;
	}
	
	function get_cover() {
		$rs=$this->read("location,albulm_id","pics","is_cover=1");
		return $rs;
	}
	function get_pics($where) {
		$rs=$this->read("*","pics",$where);
		return $rs;
	}
	function delete_pic($idstr) {
		$where="1=1";
		if($idstr){
			$where.=" and id in ({$idstr})";
		}
		$rs=$this->delete("pics",$where);
		return $rs;
	}

	function get_category($field="",$where="") {
		if(!$field) $field="*";
		$rs=$this->read($field,"category",$where);
		return $rs;
	}

	function add_albulm($data=array()) {
		if(!$data) return false;
		$rs=$this->insert($data,"albulm",true);
		return $rs;
	}

	function get_albulm($field="",$where="") {
		if(!$field) $field="*";
		$rs=$this->read($field,"albulm",$where);
		if(!$rs) return false;
		return $rs;
	}
}
