<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/deleteTable.js"></script>
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
								<div class="list">PACKING</div><br/>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'ASET') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, KODE SETRIKA YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('mesin[]', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
								<div class="info" style="width:40%;float:right;">
									<a href="<?php echo site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cetakCekKopi",array($tRow->resi,0)) )?>" class="print" target="_blank">Copy Ceklist</a>
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
								<a href="javascript:addRow('myTable')" class="add">Tambah Setrika</a> &nbsp;  &nbsp;  &nbsp;  
								<a href="javascript:deleteRow('myTable')" class="delete">Hapus Setrika</a><br/><br/>
								<table id="myTable" style="width:52%;float:left;">
									<tr>
										<td width="5%"><input type="checkbox" name="chk"/></td>
										<td>
											<table width="100%">
												<tr>
													<td width="21%">ID Setrika</td>
													<td colspan="3">
														<select name="mesin[]">
												<?php $j=0;  foreach($mstr as $bot){ ?>
															<option value="<?php echo $bot->kode_aset; ?>">Setrika <?php echo ++$j; ?></option>
												<?php } ?>
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<table style="width:52%;float:left;">
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td width="25%" style="vertical-align:top;">Keterangan</td>
										<td>
											<textarea name="ket" cols="30" rows="3"><?php echo set_value('ket', isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Pegawai</td>
										<td>
											<select name="nip">
									<?php foreach($staff as $tampil){ ?>
												<option value="<?php echo $tampil->nip; ?>"><?php echo $tampil->nama_pegawai; ?></option>
									<?php } ?>
											</select>
											<input type="hidden" name="nohp" value="<?php echo $tRow->no_tlp; ?>">
											<input type="hidden" name="cust" value="<?php echo $tRow->nama; ?>">
										</td>
									</tr>
								</table>
								<div class="cleared"></div><br/>
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