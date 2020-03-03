<?php
class Model_out extends CI_Model{
	// FUNGSI GENERAL //
	function insertData($tabel,$data){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->insert($tabel, $data);;
	}
	function updateData($tabel,$kolom,$id,$data){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->where("$kolom", $id);
		$pusat->update("$tabel", $data);
	}
	function updateDataWhere($tabel,$where,$data){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->where($where);
		$pusat->update("$tabel", $data);
	}
	function deleteData($tabel,$kolom,$id){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->where("$kolom", $id);
		$pusat->delete("$tabel");
	}
	function emptyTabel($tabel){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->empty_table("$tabel");
	}
	function getData($tabel,$kolom){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->order_by("$kolom", "asc");
		return $pusat->get("$tabel");	
	}
	function getGroupBy($tabel,$kolom){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->group_by("$kolom");
		$pusat->order_by("$kolom", "asc");
		return $pusat->get("$tabel");	
	}
	function getDataBy($tabel,$kolom,$param){
		$pusat = $this->load->database('pusat',TRUE);
		return $pusat->get_where("$tabel", array("$kolom" => "$param"));
	}
	function getDataLike($tabel,$kolom,$param){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->like("$kolom","$param");
		return $pusat->get("$tabel");
	}
	function getDataWhere($table,$where){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->from($table);
		$pusat->where($where);
		return $pusat->get();
	}
	function getDataWhereOrder($table,$where,$order){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->from($table);
		$pusat->where($where);
		$pusat->order_by($order, "asc");
		return $pusat->get();
	}
	function getMaxCode($tabel,$kolom,$kode){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->select_max("$kolom", "maxID");
		$pusat->like("$kolom", "$kode", "after");
		return $pusat->get("$tabel");
	}
	function countData($tabel){
		$pusat = $this->load->database('pusat',TRUE);
		return $pusat->get("$tabel")->num_rows();
	}
	function countDataWhere($tabel,$where){
		$pusat = $this->load->database('pusat',TRUE);
		$pusat->where($where);
		return $pusat->get($tabel)->num_rows();
	}
	
}