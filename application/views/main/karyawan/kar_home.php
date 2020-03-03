<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							
							<fieldset>
							<div class="welcome">Selamat datang, <?php echo $ambil->nama_pegawai; ?>.</div>
								<table class="home-menu" style="float:right;width:50%;border-left:solid 1px #ccc;">
									<tr>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/kar-menu/2-profil.png" title="Profil"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('karyawan','profil',array($nip,'NO'));?>">Profil</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/kar-menu/3-pesan.png" title="Pesan"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'karyawan','pesan',array($nip,0) ); ?>">Pesan</a>
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/kar-menu/1-absensi.png" title="Absensi"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('karyawan','absensi',array($nip,'NO'));?>">Absensi</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/kar-menu/4-kinerja.png" title="Logout"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'karyawan','kinerja',array($nip) ); ?>">Kinerja</a>
										</td>
									</tr>
								</table>
								<table style="float:left;width:45%;font-weight:bold;">
									<tr>
										<td width='20%' rowspan='7' style='text-align:center;' >
											<img src="<?php echo base_url();?><?php echo $ambil->foto_pegawai; ?>" style='border:solid;height:200px;padding:5px;'/>
										</td>
										<td width='25%'>ID Pegawai</td>
										<td width='2%'>:</td>
										<td><?php echo $ambil->nip; ?></td>
									</tr>
									<tr>
										<td>Nama</td>
										<td>:</td>
										<td><?php echo $ambil->nama_pegawai; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo $ambil->alamat_pegawai; ?></td>
									</tr>
									<tr>
										<td>No. Tlp</td>
										<td>:</td>
										<td><?php echo $ambil->tlp_pegawai; ?></td>
									</tr>
									<tr>
										<td>Tempat Lahir</td>
										<td>:</td>
										<td><?php echo $ambil->lhr_pegawai; ?></td>
									</tr>
									<tr>
										<td>Tanggal Lahir</td>
										<td>:</td>
										<td><?php echo ubahTanggal("d F Y", $ambil->tgl_pegawai); ?></td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="4">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="4">
											<div class="pesan" style="text-align:center;font-weight:bold;font-size:18px;color:purple;">
												Anda memiliki <font color="green"><?php echo $pesan; ?></font> pesan masuk.
											<div>
										</td>
									</tr>
								</table>
							</fieldset>
							
							<div class="cleared"></div>
						</div>
				<!-- AKHIR KONTEN -->
						<div class="cleared"></div>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
		</div>
	</div>
</div>
<div class="cleared"></div>
<?php
	function ubahTanggal($format,$nilai="now"){
		$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday",
					"January","February", "March","April","May","June","July","August","September","October","November","December");
		$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
					"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return str_replace($en,$id,date($format,strtotime($nilai)));
	}
?>