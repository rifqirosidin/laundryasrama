<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							
							<fieldset>
							<div class="welcome">Selamat datang, <?php echo $ambil->invest_name; ?>.</div>
								<table class="home-menu" style="float:right;width:50%;border-left:solid 1px #ccc;">
									<tr>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/kar-menu/5-investor.png" title="Profil"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('investor','profil',array('NO'));?>">Profil</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/kar-menu/3-pesan.png" title="Pesan"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'investor','pesan',array(0) ); ?>">Pesan</a>
										</td>
									</tr>
								</table>
								<table style="float:left;width:45%;font-weight:bold;">
									<tr>
										<td width='20%'>Nama</td>
										<td>:</td>
										<td><?php echo $ambil->invest_name; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo $ambil->inv_alamat; ?></td>
									</tr>
									<tr>
										<td>No. Tlp</td>
										<td>:</td>
										<td><?php echo $ambil->inv_tlp; ?></td>
									</tr>
									<tr>
										<td>Outlet</td>
										<td>:</td>
										<td><?php echo $outlet; ?></td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="3">
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