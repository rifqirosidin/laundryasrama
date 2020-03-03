<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
				'login' => array(
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'trim|xss_clean|required'
									),
									array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'trim|xss_clean|required'
									)
								),
				'tMember' => array(
									array(
										'field' => 'id',
										'label' => 'ID Member',
										'rules' => 'required'
									),
									array(
										'field' => 'cust',
										'label' => 'Nama Pelanggan',
										'rules' => 'required'
									),
									array(
										'field' => 'kiloan',
										'label' => 'Jumlah Kiloan',
										'rules' => 'required'
									),
									array(
										'field' => 'laundry',
										'label' => 'Jenis Layanan',
										'rules' => 'required'
									),
									array(
										'field' => 'pewangi',
										'label' => 'Jenis Pewangi',
										'rules' => 'required'
									),
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									)
								),
				'tNon' => array(
									array(
										'field' => 'cust',
										'label' => 'Nama Pelanggan',
										'rules' => 'required'
									),
									array(
										'field' => 'nohp',
										'label' => 'No. HP',
										'rules' => 'numeric|required'
									),
									array(
										'field' => 'kiloan',
										'label' => 'Jumlah Kiloan',
										'rules' => 'numeric|required'
									),
									array(
										'field' => 'laundry',
										'label' => 'Jenis Layanan',
										'rules' => 'required'
									),
									array(
										'field' => 'pewangi',
										'label' => 'Jenis Pewangi',
										'rules' => 'required'
									),
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									)
								),
				'tKartu' => array(
									array(
										'field' => 'kartu',
										'label' => 'Nomor Kartu',
										'rules' => 'required'
									)
								),
				'tDepe' => array(
									array(
										'field' => 'depe',
										'label' => 'DP',
										'rules' => 'is_natural|required'
									)
								),
				'tCek' => array(
									array(
										'field' => 'nip',
										'label' => 'Pegawai',
										'rules' => 'required'
									),
									array(
										'field' => 'jum',
										'label' => 'Jumlah Mesin',
										'rules' => 'is_natural_no_zero|required'
									),
									array(
										'field' => 'jum_cloth',
										'label' => 'Jumlah Pakaian',
										'rules' => 'is_natural_no_zero|required'
									)
								),
				'tCuci' => array(
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									)
								),
				'tAmbil' => array(
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									),
									array(
										'field' => 'deliver',
										'label' => 'Delivery',
										'rules' => 'required'
									)
								),
				'tKas' => array(
									array(
										'field' => 'item',
										'label' => 'Item Pengeluaran',
										'rules' => 'required'
									),
									array(
										'field' => 'jum',
										'label' => 'Jumlah Pengeluaran',
										'rules' => 'numeric|is_natural_no_zero|required'
									),
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									)
								),
				'tTabung' => array(
									array(
										'field' => 'trans',
										'label' => 'Jumlah Transfer',
										'rules' => 'numeric|is_natural_no_zero|required'
									),
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									),
									array(
										'field' => 'pass',
										'label' => 'Password',
										'rules' => 'required'
									)
								),
				'tRawat' => array(
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									),
									array(
										'field' => 'rawat',
										'label' => 'Jenis Perawatan',
										'rules' => 'required'
									)
								),
				'tStok' => array(
									array(
										'field' => 'nip',
										'label' => 'ID Pegawai',
										'rules' => 'required'
									),
									array(
										'field' => 'act',
										'label' => 'Aktivitas',
										'rules' => 'required'
									),
									array(
										'field' => 'stok',
										'label' => 'Stock Akhir',
										'rules' => 'numeric|required'
									)
								),
				'fJurnal' => array(
									array(
										'field' => 'krjum',
										'label' => 'Jumlah Kredit',
										'rules' => 'numeric|required'
									)
								),
				'fMember' => array(
									array(
										'field' => 'namabaru',
										'label' => 'Nama',
										'rules' => 'required'
									),
									array(
										'field' => 'nohpbaru',
										'label' => 'No. HP',
										'rules' => 'numeric|required'
									),
									array(
										'field' => 'areabaru',
										'label' => 'Area Member',
										'rules' => 'required'
									),
									array(
										'field' => 'jenisbaru',
										'label' => 'Jenis Member',
										'rules' => 'required'
									)
								),
				'fNon' => array(
									array(
										'field' => 'nama',
										'label' => 'Nama',
										'rules' => 'required'
									),
									array(
										'field' => 'tlp',
										'label' => 'No. HP',
										'rules' => 'numeric|required'
									),
									array(
										'field' => 'area',
										'label' => 'Area Pelanggan',
										'rules' => 'required'
									)
								),
				'fLaundry' => array(
									array(
										'field' => 'kode',
										'label' => 'Kode Layanan',
										'rules' => 'max_length[3]|required'
									),
									array(
										'field' => 'nama',
										'label' => 'Nama Jenis Layanan',
										'rules' => 'required'
									),
									array(
										'field' => 'harga',
										'label' => 'Harga Layanan',
										'rules' => 'numeric|required'
									)
								),
				'fPewangi' => array(
									array(
										'field' => 'kode',
										'label' => 'Kode Pewangi',
										'rules' => 'max_length[3]|required'
									),
									array(
										'field' => 'nama',
										'label' => 'Nama Pewangi',
										'rules' => 'required'
									)
								),
				'fPromo' => array(
									array(
										'field' => 'nama',
										'label' => 'Nama Promo',
										'rules' => 'required'
									),
									array(
										'field' => 'jenis',
										'label' => 'Jenis Promo',
										'rules' => 'required'
									),
									array(
										'field' => 'ptg',
										'label' => 'Potongan Promo',
										'rules' => 'is_natural_no_zero|required'
									),
									array(
										'field' => 'start',
										'label' => 'Tanggal Mulai',
										'rules' => 'required'
									),
									array(
										'field' => 'end',
										'label' => 'Tanggal Berakhir',
										'rules' => 'required'
									),
									array(
										'field' => 'jum',
										'label' => 'Jumlah Promo dikeluarkan',
										'rules' => 'is_natural_no_zero|required'
									)
								),
				'pegawai' => array(
									array(
										'field' => 'name',
										'label' => 'Nama',
										'rules' => 'required'
									),
									array(
										'field' => 'pno',
										'label' => 'No. HP',
										'rules' => 'numeric|required'
									),
									array(
										'field' => 'outlet',
										'label' => 'Outlet',
										'rules' => 'required'
									),
									array(
										'field' => 'pos',
										'label' => 'Jabatan',
										'rules' => 'required'
									)
								),
				'pegawaiPass' => array(
									array(
										'field' => 'pass',
										'label' => 'Password',
										'rules' => 'min_length[6]|max_length[20]|required'
									),
									array(
										'field' => 'repass',
										'label' => 'Re-Password',
										'rules' => 'matches[pass]|required'
									)
								),
				'fAset' => array(
									array(
										'field' => 'jenis',
										'label' => 'Jenis Aset',
										'rules' => 'required'
									),
									array(
										'field' => 'jum',
										'label' => 'Jumlah Aset',
										'rules' => 'is_natural_no_zero|required'
									)
								),
				'fStok' => array(
									array(
										'field' => 'jenis',
										'label' => 'Jenis Inventori',
										'rules' => 'required'
									),
									array(
										'field' => 'stok',
										'label' => 'Jumlah Stok',
										'rules' => 'numeric|required'
									)
								),
				'fOutletTambah' => array(
									array(
										'field' => 'name',
										'label' => 'Nama Outlet',
										'rules' => 'required'
									),
									array(
										'field' => 'code',
										'label' => 'Kode Outlet',
										'rules' => 'required|max_length[5]|is_unique[wl_outlet.outlet_code]'
									),
									array(
										'field' => 'area',
										'label' => 'Area Outlet',
										'rules' => 'required'
									),
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'is_unique[wl_outlet.username]|min_length[4]|max_length[15]|required'
									),
									array(
										'field' => 'pass',
										'label' => 'Password',
										'rules' => 'min_length[6]|max_length[20]|required'
									),
									array(
										'field' => 'repass',
										'label' => 'Re-Password',
										'rules' => 'matches[pass]|required'
									)
								),
				'fOutletUbah' => array(
									array(
										'field' => 'name',
										'label' => 'Nama',
										'rules' => 'required'
									)
								),
				'fOutletPass' => array(
									array(
										'field' => 'pass',
										'label' => 'Password',
										'rules' => 'min_length[6]|max_length[20]|required'
									),
									array(
										'field' => 'repass',
										'label' => 'Re-Password',
										'rules' => 'matches[pass]|required'
									)
								),
				'sms' => array(
									array(
										'field' => 'isi',
										'label' => 'Isi Pesan',
										'rules' => 'required'
									),
									array(
										'field' => 'selang',
										'label' => 'Selang Pesan',
										'rules' => 'required'
									)
								),
				'sms_send' => array(
									array(
										'field' => 'isisms',
										'label' => 'Isi Pesan',
										'rules' => 'required'
									),
									array(
										'field' => 'notlp',
										'label' => 'Nomor Telepon',
										'rules' => 'numeric|required'
									)
								),
				'sms_broadcast' => array(
									array(
										'field' => 'nama',
										'label' => 'Nama Broadcast',
										'rules' => 'required'
									),
									array(
										'field' => 'jenis',
										'label' => 'Jenis Broadcast',
										'rules' => 'required'
									),
									array(
										'field' => 'tgl',
										'label' => 'Tgl Kirim',
										'rules' => 'required'
									),
									array(
										'field' => 'isi',
										'label' => 'Isi Pesan',
										'rules' => 'required'
									)
								)
			);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */