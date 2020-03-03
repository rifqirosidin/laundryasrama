<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<form name="packing_form" action="<?php echo $form_action; ?>" method="post">
							<fieldset>
								<legend><?php echo $tLegend; ?></legend>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('deliver', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/><div class="cleared"></div>
								<table width="50%" class="info" style="float:left;">
									<tr>
										<td width="35%">Nama Pelanggan</td>
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
										<td>Jumlah Cucian</td>
										<td>:</td>
										<td><?php echo $tRow->jumlah_kiloan; ?> Kg</td>
									</tr>
									<tr>
										<td>Jenis Cucian</td>
										<td>:</td>
										<td><?php echo $tRow->nama_laundry; ?></td>
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
									<tr>
										<td>Metode Pembayaran</td>
										<td>:</td>
										<td><?php echo $tRow->metode_bayar; ?></td>
									</tr>
									<tr>
							<?php if($tRow->status == "SIAP AMBIL"){ ?>
										<td>Delivery Antar</td>
										<td colspan="2">
											<input type="radio" name="deliver" value="Ya">Ya &nbsp;
											<input type="radio" name="deliver" value="Tidak" checked>Tidak
											<input type="hidden" name="nohp" value="<?php echo $tRow->no_tlp; ?>">
											<input type="hidden" name="cust" value="<?php echo $tRow->nama; ?>">
										</td>
							<?php }else{ ?>
										<td colspan="3"><input type="hidden" name="deliver" value="Ya"></td>
							<?php } ?>
									</tr>
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
								</table>
						<?php } ?>
								<div class="cleared"></div><br/>
								<table width="50%">
									<tr>
										<td>ID Pegawai</td>
										<td>
											<input type="password" name="nip" size="10" autofocus />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
								</table>
								<table width="100%">
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.packing_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</fieldset>
							</form>
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