<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
						
							<fieldset>
								<legend>Detail Transaksi</legend>
						<?php if($this->session->userdata('user') == "USER"){ ?>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?><br/><div class="cleared"></div>
						<?php } ?>
								<table width="50%" class="info" style="float:left;">
									<tr>
										<td colspan="3">
											<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'aktivitas','jobMonitor',array($tRow->resi) ); ?>" class="view">Monitoring Cucian</a>&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="<?php echo site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cetakCekKopi",array($tRow->resi,0)) )?>" class="print" target="_blank">Copy Ceklist</a>
										</td>
									</tr>
									<tr>
										<td>No. Resi</td>
										<td>:</td>
										<td><?php echo $tRow->resi; ?></td>
									</tr>
									<tr>
										<td width="30%">Nama Pelanggan</td>
										<td width="3%">:</td>
										<td><?php echo $tRow->nama; ?></td>
									</tr>
									<tr>
										<td>Alamat Pelanggan</td>
										<td>:</td>
										<td><?php echo $tRow->alamat; ?></td>
									</tr>
									<tr>
										<td>No.Tlp Pelanggan</td>
										<td>:</td>
										<td><?php echo $tRow->no_tlp; ?></td>
									</tr>
									<tr>
										<td>Jenis Cucian</td>
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
									<tr>
										<td>Total Harga</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->total, 0, ',', '.'); ?>,-</td>
									</tr>
									<tr>
										<td>Status Pembayaran</td>
										<td>:</td>
										<td><?php echo $tRow->status_bayar; ?></td>
									</tr>
							<?php if ($tRow->status_bayar == "BELUM") {?>
									<tr>
										<td>DP Bayar</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->dp_bayar, 0, ',', '.'); ?>,-</td>
									</tr>
									<tr>
										<td>Sisa Bayar</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->sisa_bayar, 0, ',', '.'); ?>,-</td>
									</tr>
							<?php } ?>
									<tr>
										<td>Metode Pembayaran</td>
										<td>:</td>
										<td><?php echo $tRow->metode_bayar; ?></td>
									</tr>
							<?php if(($tRow->komplain !== NULL)){ ?>
									<tr>
										<td>Komplain</td>
										<td>:</td>
										<td><?php echo $tRow->komplain; ?></td>
									</tr>
							<?php } ?>
								</table>
						<?php if ($tRow->jenis == "Non" || $tRow->extra == "Ya") {?>
								<table width="45%" style="float:right;" class="detail">
									<tr>
										<td colspan="4" style="border:none;padding-top:10px;text-align:left;">
											<div class="list">CUCIAN / TAMBAHAN</div>
										</td>
									</tr>
									<tr>
										<th width="5%">No</th>
										<th>Item</th>
										<th>Harga Satuan</th>
										<th width="15%">Jumlah</th>
									</tr>
								<?php $i=0; foreach($dbDetail as $det){ ?>
									<tr>
										<td><?php echo ++$i; ?></td>
										<td style="text-align:left;padding-left:10px;"><?php echo $det->nama_laundry; ?></td>
										<td style="text-align:right;padding-right:10px;"><?php echo number_format($det->harga_laundry,0,',','.'); ?></td>
										<td><?php echo $det->jum_non; ?></td>
									</tr>
								<?php } ?>
								<?php foreach($dbExtra as $ex){ ?>
									<tr>
										<td><?php echo ++$i; ?></td>
										<td style="text-align:left;padding-left:10px;"><?php echo $ex->nama_laundry; ?></td>
										<td style="text-align:right;padding-right:10px;"><?php echo number_format($ex->harga_laundry,0,',','.'); ?></td>
										<td><?php echo $ex->jum_extra; ?></td>
									</tr>
								<?php } ?>
									<tr>
										<td colspan="4" style="border:none;padding-top:10px;">
											<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'aktivitas','cetakTransaksi',array($tRow->resi) ); ?>" class="tombol" style="font-size:20px;" target="_blank">Cetak Resi Transaksi</a>
										</td>
									</tr>
								</table>
						<?php }else{ ?>
								<table width="45%" style="float:right;text-align:center;">
									<tr>
										<td>
											<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'aktivitas','cetakTransaksi',array($tRow->resi) ); ?>" class="tombol" style="font-size:20px;" target="_blank">Cetak Resi Transaksi</a>
										</td>
									</tr>
								</table>
						<?php } ?>
								<div class="cleared"></div><br/>
								<?php echo anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','index',array("NO")),'Kembali',array('class' => 'back')); ?>
						<?php if(($tRow->status == "SELESAI") && ($tRow->komplain == NULL) && ($this->session->userdata('user') == "USER")){ ?>
								<br/><br/>
								<div class="list">FORMULIR KOMPLAIN</div><br/>
							<form name="komplain_form" action="<?php echo $form_komplain; ?>" method="post">
								<table width="40%" style="font-weight:bold;">
									<tr>
										<td width="36%" style="vertical-align:top;">Komplain</td>
										<td>
											<input type="hidden" name="notlp" value="<?php echo $tRow->no_tlp; ?>"/>
											<textarea name="ket" cols="30" rows="3"><?php echo set_value('ket', isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td>ID Pegawai</td>
										<td>
											<input type="password" name="nip" size="10"/>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.komplain_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
						<?php } ?>
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