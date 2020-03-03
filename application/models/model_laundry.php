<?php
class Model_laundry extends CI_Model{
	function __construct(){

		parent::__construct();
	}
	
	function ambilAktivitas($status,$id,$from,$to){
		$this->db->from("sx_aktivitas a, sx_customer c, sx_invoice i, sx_job_monitor j");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = i.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.status",$status);
		$this->db->where("a.outlet_id",$id);
		$this->db->where('j.tgl_trans BETWEEN "'.$from.'" AND "'.$to.'"');
		return $this->db->get();
	}
	function ambilTransaksi($id,$kolom,$param){
		$this->db->from("sx_aktivitas a, sx_customer c, sx_invoice i, sx_job_monitor j, wl_laundry l, wl_pewangi p");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = i.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.jenis_laundry = l.kode_laundry");
		$this->db->where("a.outlet_id = l.outlet_id");
		$this->db->where("a.jenis_pewangi = p.kode_pewangi");
		$this->db->where("a.outlet_id = p.outlet_id");
		$this->db->where("a.outlet_id",$id);
		$this->db->where("a.$kolom",$param);
		return $this->db->get();
	}
	function ambilTransNon($kolom,$param){
		$this->db->from("sx_aktivitas_non a, wl_laundry l");
		$this->db->where("a.item_non = l.kode_laundry");
		$this->db->where("a.outlet_id = l.outlet_id");
		$this->db->where("a.$kolom",$param);
		return $this->db->get();
	}
	function ambilExtra($kolom,$param){
		$this->db->from("sx_aktivitas_ex a, wl_laundry l");
		$this->db->where("a.item_extra = l.kode_laundry");
		$this->db->where("a.outlet_id = l.outlet_id");
		$this->db->where("a.$kolom",$param);
		return $this->db->get();
	}
	function ambilCeklist($kolom,$param){
		$this->db->from("sx_aktivitas a, sx_customer c, sx_invoice i, sx_ceklist ck, sx_job_monitor j, wl_laundry l, wl_pewangi p");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = i.resi");
		$this->db->where("a.resi = ck.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.jenis_laundry = l.kode_laundry");
		$this->db->where("a.outlet_id = l.outlet_id");
		$this->db->where("a.jenis_pewangi = p.kode_pewangi");
		$this->db->where("a.$kolom",$param);
		return $this->db->get();
	}
	function ambilCeklistDetail($kolom,$param){
		$this->db->from("sx_ceklist c, sx_ceklist_detail d");
		$this->db->where("c.resi = d.resi");
		$this->db->where("c.$kolom",$param);
		return $this->db->get();
	}
	function ambilCeklistMesin($kolom,$param){
		$this->db->from("sx_ceklist c, sx_job_cuker jc");
		$this->db->where("c.resi = jc.resi");
		$this->db->where("c.$kolom",$param);
		return $this->db->get();
	}
	
	function ambilMember($id){
		$this->db->where("outlet_id",$id);
		$this->db->order_by("nama_member","asc");
		return $this->db->get("wl_member");
	}
	function ambilCustomer($id){
		$this->db->where("outlet_id",$id);
		$this->db->order_by("nama_non","asc");
		return $this->db->get("wl_member_non");
	}
	function ambilDeposit($resi){
		$this->db->from("wl_member m, sx_deposit d");
		$this->db->where("d.id_member = m.id_member");
		$this->db->where("d.dresi",$resi);
		return $this->db->get();
	}
	
	function histNon($id,$outlet){
		$this->db->from("sx_aktivitas a, sx_customer c, sx_invoice i, sx_job_monitor j, wl_member_non m, wl_laundry l");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = i.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.jenis_laundry = l.kode_laundry");
		$this->db->where("a.outlet_id = l.outlet_id");
		$this->db->where("c.id_member = m.id_non");
		$this->db->where("m.id_non",$id);
		$this->db->where("a.outlet_id",$outlet);
		$this->db->order_by("a.resi","desc");
		return $this->db->get();
	}
	function histMember($id,$outlet){
		$this->db->from("sx_aktivitas a, sx_customer c, sx_invoice i, sx_job_monitor j, wl_member m, wl_laundry l");
		$this->db->where("a.resi = c.resi");
		$this->db->where("a.resi = i.resi");
		$this->db->where("a.resi = j.resi");
		$this->db->where("a.jenis_laundry = l.kode_laundry");
		$this->db->where("a.outlet_id = l.outlet_id");
		$this->db->where("c.id_member = m.id_member");
		$this->db->where("m.id_member",$id);
		$this->db->where("a.outlet_id",$outlet);
		$this->db->order_by("a.resi","desc");
		return $this->db->get();
	}
	function histDeposit($member,$id){
		$this->db->from("wl_member m, sx_deposit d");
		$this->db->where("d.id_member = m.id_member");
		$this->db->where("m.id_member",$member);
		$this->db->where("d.outlet_id",$id);
		$this->db->order_by("d.dresi","desc");
		return $this->db->get();
	}
	function kompMember($member,$id){
		$this->db->from("sx_aktivitas a, sx_customer c, wl_member m");
		$this->db->where("a.resi = c.resi");
		$this->db->where("c.id_member = m.id_member");
		$this->db->where("c.komplain != ''");
		$this->db->where("m.id_member",$member);
		$this->db->where("a.outlet_id",$id);
		return $this->db->get();
	}
	function kompNon($tlp,$id){
		$this->db->from("sx_aktivitas a, sx_customer c");
		$this->db->where("a.resi = c.resi");
		$this->db->where("c.komplain != ''");
		$this->db->where("c.no_tlp",$tlp);
		$this->db->where("a.outlet_id",$id);
		return $this->db->get();
	}
	function komplain($id){
		$this->db->from("sx_aktivitas a, sx_customer c");
		$this->db->where("a.resi = c.resi");
		$this->db->where("c.komplain != ''");
		$this->db->where("a.outlet_id",$id);
		return $this->db->get();
	}
	
	function ambilOutlet(){
		$this->db->from("wl_outlet o, zona_area a, zona_city c, zona z");
		$this->db->where("o.area_code = a.area_code");
		$this->db->where("a.id_city = c.id_city");
		$this->db->where("c.id_zona = z.id_zona");
		return $this->db->get();
	}
	function ambilOutletBy($kolom,$id){
		$this->db->from("wl_outlet o, zona_area a, zona_city c, zona z");
		$this->db->where("o.area_code = a.area_code");
		$this->db->where("a.id_city = c.id_city");
		$this->db->where("c.id_zona = z.id_zona");
		$this->db->where("o.$kolom",$id);
		return $this->db->get();
	}
	function ambilCakupanBy($kolom,$id){
		$this->db->from("wl_outlet_area o, zona_area a, zona_city c, zona z");
		$this->db->where("o.area_id = a.id_area");
		$this->db->where("a.id_city = c.id_city");
		$this->db->where("c.id_zona = z.id_zona");
		$this->db->where("o.$kolom",$id);
		$this->db->order_by("a.id_area","asc");
		return $this->db->get();
	}
	
	function ambilLaundry($id){
		$this->db->from("wl_outlet o, wl_laundry l");
		$this->db->where("o.outlet_id = l.outlet_id");
		$this->db->where("l.jenis != 'Non'");
		$this->db->where("o.outlet_id",$id);
		return $this->db->get();
	}
	function ambilLaundryBy($id,$kolom,$param){
		$this->db->where("outlet_id",$id);
		$this->db->where("$kolom",$param);
		$this->db->order_by("nama_laundry");
		return $this->db->get("wl_laundry");
	}
	
	function ambilPewangi($id){
		$this->db->from("wl_outlet o, wl_pewangi p");
		$this->db->where("o.outlet_id = p.outlet_id");
		$this->db->where("o.outlet_id",$id);
		$this->db->order_by("nama_pewangi");
		return $this->db->get();
	}
	function ambilPewangiBy($id,$kolom,$param){
		$this->db->where("outlet_id",$id);
		$this->db->where("$kolom",$param);
		$this->db->order_by("nama_pewangi");
		return $this->db->get("wl_pewangi");
	}
	
	function ambilPromo($id){
		$this->db->from("wl_outlet o, wl_promo s");
		$this->db->where("o.outlet_id = s.outlet_id");
		$this->db->where("o.outlet_id",$id);
		$this->db->group_by("s.id_group");
		return $this->db->get();
	}
	
	function ambilAset($id){
		$this->db->from("master_aset mst, wl_aset ast, wl_outlet ot");
		$this->db->where("ast.jenis_aset = mst.kode_jenis");
		$this->db->where("ast.outlet_id = ot.outlet_id");
		$this->db->where("ot.outlet_id",$id);
		return $this->db->get();
	}
	function ambilAsetBy($kolom,$param){
		$this->db->from("master_aset mst, wl_aset ast");
		$this->db->where("ast.jenis_aset = mst.kode_jenis");
		$this->db->where("ast.$kolom",$param);
		return $this->db->get();
	}
	function ambilRawat(){
		$this->db->from("master_aset mst, master_rawat rwt");
		$this->db->where("rwt.kode_jenis = mst.kode_jenis");
		$this->db->order_by("rwt.kode_jenis");
		return $this->db->get();
	}
	function ambilPerawatan($kolom,$param){
		$this->db->from("master_aset ma, wl_aset wa, sx_perawatan sp, wl_pegawai wp");
		$this->db->where("ma.kode_jenis = wa.jenis_aset");
		$this->db->where("wa.id_aset = sp.id_aset");
		$this->db->where("sp.nip_rawat = wp.nip");
		$this->db->where("wa.$kolom",$param);
		$this->db->order_by("sp.tgl_rawat");
		return $this->db->get();
	}
	
	function ambilStok($id){
		$this->db->from("master_stock ms, wl_stock ws, wl_outlet ot");
		$this->db->where("ws.id_mstock = ms.id_mstock");
		$this->db->where("ws.outlet_id = ot.outlet_id");
		$this->db->where("ot.outlet_id",$id);
		return $this->db->get();
	}
	function ambilStokBy($id,$kolom,$param){
		$this->db->from("master_stock ms, wl_stock ws");
		$this->db->where("ws.id_mstock = ms.id_mstock");
		$this->db->where("ws.$kolom",$param);
		$this->db->where("ws.outlet_id",$id);
		return $this->db->get();
	}
	function ambilHistStock($kolom,$param){
		$this->db->from("master_stock ma, wl_stock ws, sx_stock ss, wl_pegawai wp");
		$this->db->where("ma.id_mstock = ws.id_mstock");
		$this->db->where("ws.id_stock = ss.id_stock");
		$this->db->where("ss.nip_stock = wp.nip");
		$this->db->where("ws.$kolom",$param);
		$this->db->order_by("ss.tgl_stock");
		return $this->db->get();
	}
	
	function ambilKeluarApp($id){
		$this->db->from("sx_pengeluaran sp, master_akun mp, wl_pegawai wp");
		$this->db->where("sp.id_keluar = mp.id_keluar");
		$this->db->where("sp.id_pegawai = wp.nip");
		$this->db->where("sp.status_keluar = 'Approval'");
		$this->db->order_by("sp.id_keluar","asc");
		
		if($id > 0)
			$this->db->where("sp.outlet_id",$id);
		
		return $this->db->get();
	}
	function ambilKeluar($from,$to,$id){
		$this->db->from("sx_pengeluaran sp, master_akun mp, wl_pegawai wp");
		$this->db->where("sp.id_keluar = mp.id_keluar");
		$this->db->where("sp.id_pegawai = wp.nip");
		$this->db->where("sp.status_keluar != 'Approval'");
		$this->db->where("sp.tgl_keluar BETWEEN '".$from."' AND '".$to."'");
		$this->db->order_by("sp.id_keluar","asc");
		
		if($id > 0)
			$this->db->where("sp.outlet_id",$id);
		
		return $this->db->get();
	}
	function ambilKeluarBy($kolom,$param){
		$this->db->from("sx_pengeluaran sp, master_akun mp, wl_pegawai wp");
		$this->db->where("sp.id_keluar = mp.id_keluar");
		$this->db->where("sp.id_pegawai = wp.nip");
		$this->db->where("sp.$kolom",$param);
		return $this->db->get();
	}

	function ambilSaldo($outlet){
		$this->db->where("debit_jurnal = 'Kas di Tangan' OR kredit_jurnal = 'Kas di Tangan'");
		$this->db->where("outlet_id",$outlet);
		return $this->db->get("ak_jurnal");
	}
	
	function ambilJob($kolom,$param){
		$this->db->from("master_aset ma, wl_aset wa, sx_perawatan sp, wl_pegawai wp");
		$this->db->where("ma.kode_jenis = wa.jenis_aset");
		$this->db->where("wa.id_aset = sp.id_aset");
		$this->db->where("sp.nip_rawat = wp.nip");
		$this->db->where("wa.$kolom",$param);
		$this->db->order_by("sp.tgl_rawat");
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
		$this->db->where("sp.outlet_id",$this->session->userdata('id'));
		$this->db->order_by("sp.tgl_rawat");
		return $this->db->get();
	}
	
	function ambilInvestor(){
		$this->db->from("master_invest mi, wl_outlet wo");
		$this->db->where("mi.outlet_id = wo.outlet_id");
		$this->db->order_by("mi.invest_name");
		return $this->db->get();
	}
	
	function ambilArea(){
		$this->db->from("zona_area za, zona_city zc, zona z");
		$this->db->where("za.id_city = zc.id_city");
		$this->db->where("zc.id_zona = z.id_zona");
		$this->db->order_by("z.zona_name","asc");
		$this->db->order_by("zc.city_name","asc");
		$this->db->order_by("za.area_code","asc");
		return $this->db->get();
	}
	
}