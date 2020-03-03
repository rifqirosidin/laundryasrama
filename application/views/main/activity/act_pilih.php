<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<fieldset>
								<div class="list">PILIH AKTIVITAS</div><br/><br/>
								<table class="home-menu" style="width:52%;float:left;">
									<tr>
										<td>
							<?php if($tRow->tgl_cek == NULL){ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/1-cek.png" title="Ceklist"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","ceklist",array($tRow->resi,"NO")); ?>">Ceklist</a>
											</span>
							<?php }else{ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/1-cek-done.png" title="Ceklist"/><br/>
											<b>SUDAH CEKLIST</b>
							<?php } ?>
										</td>
										<td>
							<?php if($tRow->tgl_cuci == NULL){ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/2-wash.png" title="Cuci"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","cuci",array($tRow->resi,"NO")); ?>">Cuci</a>
							<?php }else{ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/2-wash-done.png" title="Cuci"/><br/>
											<b>SUDAH CUCI</b>
							<?php } ?>
										</td>
										<td>
							<?php if($tRow->tgl_kering == NULL){ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/3-dry.png" title="Kering"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","kering",array($tRow->resi,"NO")); ?>">Kering</a>
							<?php }else{ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/3-dry-done.png" title="Kering"/><br/>
											<b>SUDAH KERING</b>
							<?php } ?>
										</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td>
							<?php if($tRow->tgl_pack == NULL){ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/4-pack.png" title="Packing"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","packing",array($tRow->resi,"NO")); ?>">Packing</a>
							<?php }else{ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/4-pack-done.png" title="Packing"/><br/>
											<b>SUDAH PACKING</b>
							<?php } ?>
										</td>
										<td>
							<?php if($tRow->tgl_ambil == NULL){ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/5-take.png" title="Ambil"/><br/>
									<?php if($tRow->metode_bayar == "AKHIR / DP"){ ?>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","pembayaran",array($tRow->resi,"NO")); ?>">Ambil Bayar</a>
									<?php }else{ ?>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","ambil",array($tRow->resi,"NO")); ?>">Ambil</a>
									<?php }
								}else{ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/5-take-done.png" title="Ambil"/><br/>
											<b>SUDAH AMBIL</b>
							<?php } ?>
										</td>
										<td>
							<?php if($tRow->tgl_deliver == NULL){ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/6-deliver.png" title="Antar"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","antar",array($tRow->resi,"NO")); ?>">Antar</a>
							<?php }else{ ?>
											<img src="<?php echo base_url(); ?>themes/img/act-menu/6-deliver-done.png" title="Antar"/><br/>
											<b>SUDAH ANTAR</b>
							<?php } ?>
										</td>
									</tr>
								</table>
								<div class="info" style="width:40%;float:right;">
									<table width="100%" class="info">
										<tr>
											<td>No. Resi</td>
											<td>:</td>
											<td><?php echo $tRow->resi; ?></td>
										</tr>
										<tr>
											<td width="24%">Nama</td>
											<td width="1%">:</td>
											<td><?php echo $tRow->nama; ?></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>:</td>
											<td><?php echo $tRow->alamat; ?></td>
										</tr>
										<tr>
											<td>No.Tlp</td>
											<td>:</td>
											<td><?php echo $tRow->no_tlp; ?></td>
										</tr>
										<tr>
											<td>Layanan</td>
											<td>:</td>
											<td><?php echo $tRow->nama_laundry; ?></td>
										</tr>
										<tr>
											<td>Jumlah</td>
											<td>:</td>
											<td>
									<?php if ($tRow->jenis == "Kiloan"){
												echo $tRow->jumlah_kiloan . " Kg";
											}else{
												echo $tRow->jumlah_kiloan . " Buah";
									} ?>
											</td>
										</tr>
										<tr>
											<td>Pewangi</td>
											<td>:</td>
											<td><?php echo $tRow->nama_pewangi; ?></td>
										</tr>
										<tr>
											<td>Catatan</td>
											<td>:</td>
											<td><?php echo $tRow->cat_trans; ?></td>
										</tr>
									</table>
								</div>
								<div class="cleared"></div><br/>
								<table width="100%">
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.cuci_form.submit()">Simpan</a></td>
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