<?php
class Model_report extends CI_Model{
	
	function getCuci($area,$from,$to,$jenis){
		if($jenis == "Non" || $jenis == "Produk" || $jenis == "perProduk"){
			$this->db->from("sx_aktivitas a, sx_aktivitas_non an, sx_customer c, sx_job_monitor j");
			$this->db->where("a.resi = an.resi");
			
			if($area !== "-1")
				$this->db->where("an.item_non",$area);
		}else{
			$this->db->from("sx_aktivitas a, sx_customer c, sx_job_monitor j, zona_area za");
			$this->db->where("za.id_area = c.areanya");
			
			if($area > 0)
				$this->db->where("za.id_area",$area);
			else
				$this->db->where("za.id_area <> 0");
		}
		
		if($jenis == "Area"){
			$this->db->group_by("c.areanya");
		}else{
			if($jenis == "Produk"){
				$this->db->group_by("an.item_non");
			}else{
				if($jenis !== "perArea" && $jenis !== "perProduk")
					$this->db->group_by("j.tgl_trans");
			}
		}
		
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where('j.tgl_trans BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		return $this->db->get();
	}
	function getCuciOn($area,$date,$jenis){
		if($jenis == "Non"){
			$this->db->from("sx_aktivitas a, sx_aktivitas_non an, sx_customer c, sx_job_monitor j");
			$this->db->where("a.resi = an.resi");
			
			if($area !== "-1")
				$this->db->where("an.item_non",$area);
		}else{
			$this->db->from("sx_aktivitas a, sx_customer c, sx_job_monitor j, zona_area za");
			$this->db->where("za.id_area = c.areanya");
			
			if($area > 0)
				$this->db->where("za.id_area",$area);
			else
				$this->db->where("za.id_area <> 0");
		}
		
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		$this->db->where("j.tgl_trans",$date);
		return $this->db->get();
	}
	function getCuciGroup($area,$date,$jenis){
		if($jenis == "Non"){
			$this->db->from("sx_aktivitas a, sx_aktivitas_non an, sx_customer c, sx_job_monitor j");
			$this->db->where("a.resi = an.resi");
			$this->db->group_by("an.item_non");
			
			if($area !== "-1")
				$this->db->where("an.item_non",$area);
		}else{
			$this->db->from("sx_aktivitas a, sx_customer c, sx_job_monitor j, zona_area za");
			$this->db->where("za.id_area = c.areanya");
			$this->db->group_by("c.areanya");
			
			if($area > 0)
				$this->db->where("za.id_area",$area);
			else
				$this->db->where("za.id_area <> 0");
		}
		
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		$this->db->where("j.tgl_trans",$date);
		return $this->db->get();
	}
	function countCuci($area,$item,$date,$jenis){
		if($jenis == "Non"){
			$this->db->from("sx_aktivitas a, sx_aktivitas_non an, sx_customer c, sx_job_monitor j");
			$this->db->where("a.resi = an.resi");
			$this->db->where("an.item_non",$item);
		}else{
			$this->db->from("sx_aktivitas a, sx_customer c, sx_job_monitor j");
			$this->db->where("c.areanya",$area);
		}
		
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		$this->db->where("j.tgl_trans",$date);
		return $this->db->get()->num_rows();
	}
	function getCust($id,$area,$from,$to){
		$this->db->from("sx_aktivitas a, sx_customer c, sx_job_monitor j, zona_area za");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("za.id_area = c.areanya");
		$this->db->where("c.id_member",$id);
		$this->db->where('j.tgl_trans BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		
		if($area > 0)
			$this->db->where("za.id_area",$area);
		else
			$this->db->where("za.id_area <> 0");
		
		return $this->db->get();
	}
	function getFTProd($kode,$area,$from,$to){
		$this->db->from("sx_aktivitas a, sx_aktivitas_non an, sx_customer c, sx_job_monitor j, zona_area za");
		$this->db->where("a.resi = an.resi");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("za.id_area = c.areanya");
		$this->db->where('j.tgl_trans BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("an.item_non",$kode);
		$this->db->where("za.id_area",$area);
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		return $this->db->get();
	}
	
	function mainKinerja($job,$tgl,$nip,$tabel){
		$this->db->where("id_$job",$nip);
		$this->db->where("tgl_$job",$tgl);
		$jum = $this->db->get($tabel)->num_rows();
		if($jum == 0)
			$jum = "-";
		return $jum;
	}
	function suppKinerja($from,$to,$nip){
		$this->db->from("master_aset ma, wl_aset wa, sx_perawatan sp, wl_pegawai wp");
		$this->db->where("ma.kode_jenis = wa.jenis_aset");
		$this->db->where("wa.id_aset = sp.id_aset");
		$this->db->where("sp.nip_rawat = wp.nip");
		$this->db->where('sp.tgl_rawat BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("wp.nip",$nip);
		$this->db->where("sp.outlet_id",$this->session->userdata('out'));
		$this->db->order_by("sp.tgl_rawat");
		return $this->db->get();
	}
	
	function getOmset($from,$to){
		$this->db->from("ak_jurnal j, wl_outlet o");
		$this->db->where("j.outlet_id = o.outlet_id");
		$this->db->where("j.debit_jurnal LIKE 'Kas%'");
		$this->db->where("j.kredit_jurnal NOT LIKE 'Modal%'");
		$this->db->where('j.tgl_jurnal BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("o.outlet_id",$this->session->userdata('out'));
		$this->db->group_by("j.tgl_jurnal");
		return $this->db->get();
	}
	function getOmsetOn($date){
		$this->db->from("ak_jurnal j, wl_outlet o");
		$this->db->where("j.outlet_id = o.outlet_id");
		$this->db->where("j.debit_jurnal LIKE 'Kas%'");
		$this->db->where("j.kredit_jurnal NOT LIKE 'Modal%'");
		$this->db->where("o.outlet_id",$this->session->userdata('out'));
		$this->db->where("j.tgl_jurnal",$date);
		return $this->db->get();
	}
	function getOmsetGroup($date){
		$this->db->from("ak_jurnal j, wl_outlet o");
		$this->db->where("j.outlet_id = o.outlet_id");
		$this->db->where("j.debit_jurnal LIKE 'Kas%'");
		$this->db->where("j.kredit_jurnal NOT LIKE 'Modal%'");
		$this->db->where("j.tgl_jurnal",$date);
		$this->db->where("o.outlet_id",$this->session->userdata('out'));
		$this->db->group_by("o.outlet_id");
		return $this->db->get();
	}
	function countOmset($date){
		$this->db->select_sum("j.jum_debit_jurnal","omset");
		$this->db->from("ak_jurnal j, wl_outlet o");
		$this->db->where("j.outlet_id = o.outlet_id");
		$this->db->where("j.debit_jurnal LIKE 'Kas%'");
		$this->db->where("j.kredit_jurnal NOT LIKE 'Modal%'");
		$this->db->where("o.outlet_id",$this->session->userdata('out'));
		$this->db->where("j.tgl_jurnal",$date);
		return $this->db->get();
	}
	
	function komplain($from,$to){
		$this->db->from("sx_aktivitas a, sx_customer c, wl_outlet o");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.outlet_id = o.outlet_id");
		$this->db->where("c.komplain != ''");
		$this->db->where('c.tgl_komplain BETWEEN "'.$from.'" AND "'.$to.'"');
		$this->db->where("a.outlet_id",$this->session->userdata('out'));
		return $this->db->get();
	}
	
	function getArea(){
		$this->db->from("zona_area za, wl_outlet_area oa");
		$this->db->where("za.id_area = oa.area_id");
		$this->db->where("oa.outlet_id",$this->session->userdata('out'));
		$this->db->order_by("za.area_name");
		return $this->db->get();
	}
	function getProduk(){
		$this->db->from("wl_laundry");
		$this->db->where("jenis","Satuan");
		$this->db->where("outlet_id",$this->session->userdata('out'));
		$this->db->order_by("kode_laundry");
		return $this->db->get();
	}
	
}