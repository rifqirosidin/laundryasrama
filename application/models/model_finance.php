<?php
class Model_finance extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function ambilJurnal($from,$to){
		$this->db->where('tgl_jurnal BETWEEN "'.$from.'" AND "'.$to.'"');
		return $this->db->get("ak_jurnal");
	}
	function ambilJurnalBy($from,$to,$outlet){
		$this->db->where('tgl_jurnal BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("outlet_id",$outlet);
		return $this->db->get("ak_jurnal");
	}
	function ambilJurnalTemp(){
		$this->db->from("ak_jurnal_temp j, wl_outlet o");
		$this->db->where("j.outlet_id = o.outlet_id ");
		return $this->db->get();
	}
	
	function ambilLR($from,$to,$akun){
		$this->db->where("tgl_jurnal BETWEEN '$from' AND '$to' AND (debit_jurnal = '$akun' OR kredit_jurnal = '$akun')");
		return $this->db->get("ak_jurnal");
	}
	function ambilLRBy($from,$to,$outlet,$akun,$jenis){
		$this->db->where("tgl_jurnal BETWEEN '$from' AND '$to' AND (debit_jurnal = '$akun' OR kredit_jurnal = '$akun')");
		$this->db->where("outlet_id",$outlet);
		
		if($jenis !== 0)
			$this->db->like("ket_jurnal",$jenis);
		
		return $this->db->get("ak_jurnal");
	}
	
}