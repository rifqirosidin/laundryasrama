<?php
class Model_general extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	// FUNGSI GENERAL //
	function insertData($tabel,$data){
		$this->db->insert($tabel, $data);
	}
	function updateData($tabel,$kolom,$id,$data){
		$this->db->where("$kolom", $id);
		$this->db->update("$tabel", $data);
	}
	function updateDataWhere($tabel,$where,$data){
		$this->db->where($where);
		$this->db->update("$tabel", $data);
	}
	function deleteData($tabel,$kolom,$id){
		$this->db->where("$kolom", $id);
		$this->db->delete("$tabel");
	}
	function emptyTabel($tabel){
		$this->db->empty_table("$tabel");
	}
	function getData($tabel,$kolom){
		$this->db->order_by("$kolom", "asc");
		return $this->db->get("$tabel");	
	}
	function getGroupBy($tabel,$kolom){
		$this->db->group_by("$kolom");
		$this->db->order_by("$kolom", "asc");
		return $this->db->get("$tabel");	
	}
	function getDataBy($tabel,$kolom,$param){
		return $this->db->get_where("$tabel", array("$kolom" => "$param"));
	}
	function getDataLike($tabel,$kolom,$param){
		$this->db->like("$kolom","$param");
		return $this->db->get("$tabel");
	}
	function getDataWhere($table,$where){
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}
	function getDataWhereOrder($table,$where,$order){
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order, "asc");
		return $this->db->get();
	}
	function getMaxCode($tabel,$kolom,$kode){
		$this->db->select_max("$kolom", "maxID");
		$this->db->like("$kolom", "$kode", "after");
		return $this->db->get("$tabel");
	}
	function countData($tabel){
		return $this->db->get("$tabel")->num_rows();
	}
	function countDataWhere($tabel,$where){
		$this->db->where($where);
		return $this->db->get($tabel)->num_rows();
	}
	
}