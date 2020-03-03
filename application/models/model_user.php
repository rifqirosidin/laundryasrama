<?php
class Model_user extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_all_log(){
		$this->db->from("wl_outlet ot, user_log ul");
		$this->db->where("ul.profile_id = ot.outlet_id");
		$this->db->order_by("ul.log_id","desc");
		return $this->db->get();
	}
	function get_log_id($id,$date,$time){
		$this->db->select("log_id");
		$this->db->where("profile_id",$id);
		$this->db->where("log_date",$date);
		$this->db->where("log_time",$time);
		return $this->db->get("user_log");
	}
	function get_log_by($id){
		$this->db->from("wl_outlet ot, user_log ul");
		$this->db->where("ul.profile_id = ot.outlet_id");
		$this->db->where("ul.log_id",$id);
		return $this->db->get();
	}
	function get_log_act_by($id){
		$this->db->from("user_log ul, user_action ua");
		$this->db->where("ul.log_id = ua.log_id");
		$this->db->where("ul.log_id",$id);
		return $this->db->get();
	}
	
	function get_pegawai($id){
		$this->db->from("wl_pegawai peg, master_position pos, wl_outlet ot");
		$this->db->where("peg.position_id = pos.position_id");
		$this->db->where("peg.outlet_id = ot.outlet_id");
		$this->db->where("ot.outlet_id",$id);
		return $this->db->get();
	}
	function get_pegawai_by($kolom,$param){
		$this->db->from("wl_pegawai peg, master_position pos");
		$this->db->where("peg.position_id = pos.position_id");
		$this->db->where("peg.$kolom",$param);
		return $this->db->get();
	}
	
	function get_position(){
		$this->db->where("position_id > 3");
		return $this->db->get("master_position pos");
	}
	
}