<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend>Profil Pegawai</legend>
								<table width='100%'>
									<tr>
										<td width='20%' rowspan='6' style='text-align:center;' >
											<img src="<?php echo base_url();?><?php echo $pegawai->foto_pegawai; ?>" style='border:solid;height:200px;padding:5px;'/>
										</td>
										<td width='15%'>Nama</td>
										<td width='1%'>:</td>
										<td><?php echo $pegawai->nama_pegawai; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo $pegawai->alamat_pegawai; ?></td>
									</tr>
									<tr>
										<td>No. Tlp</td>
										<td>:</td>
										<td><?php echo $pegawai->tlp_pegawai; ?></td>
									</tr>
									<tr>
										<td>Tempat, Tanggal Lahir</td>
										<td>:</td>
										<td><?php echo $pegawai->lhr_pegawai . ', '. ubahTanggal("d F Y", $pegawai->tgl_pegawai); ?></td>
									</tr>
									<tr>
										<td>Jabatan</td>
										<td>:</td>
										<td><?php echo $pegawai->position_name; ?></td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
								</table><br/>
								<?php echo $link ?>
							</fieldset>
							
				<!-- AKHIR KONTEN -->
							<div class="cleared"></div>
						</div>
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