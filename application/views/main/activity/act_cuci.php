<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<form name="cuci_form" action="<?php echo $form_action; ?>" method="post">
							<fieldset>
								<div class="list">CUCI</div><br/>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'ASET') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, KODE MESIN CUCI YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
								<table style="width:52%;float:left;">
									<tr>
										<td colspan="2">No. Ceklist :</td>
									</tr>
							<?php $i=1; foreach($dataCeklist as $rowcek){ ?>
									<tr style="font-weight:bold;">
										<td width="20%" style="text-align:center;"><?php echo $rowcek->no_ceklist; ?></td>
										<td>
											<input type="hidden" name="cek<?php echo $i; ?>" value="<?php echo $rowcek->id_job_cuker; ?>"/>
											<input type="hidden" name="status<?php echo $i; ?>" value="<?php echo $rowcek->stat_cuci; ?>"/>
									<?php if($rowcek->stat_cuci == "Sudah"){ ?>
											<input type="hidden" name="mesin<?php echo $i; ?>" value="<?php echo $rowcek->aset_cuci; ?>"/><?php echo $rowcek->aset_cuci; ?>
									<?php }else{ ?>
											<select name="mesin<?php echo $i; ?>">
												<option value="">Pilih Mesin Cuci</option>
									<?php $j=0; foreach($mcuci as $bot){ ?>
												<option value="<?php echo $bot->kode_aset; ?>">Mesin Cuci <?php echo ++$j; ?></option>
									<?php } ?>
											</select>
									<?php } ?>
											&nbsp;<a href="<?php echo site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cetakCekKopi",array($rowcek->resi,$rowcek->no_ceklist)) )?>" class="print" target="_blank">Copy Ceklist</a>
										</td>
									</tr>
							<?php $i++; } ?>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td>Proses</td>
										<td>
											<input type="checkbox" name="proses" value="Ya"/> Makloon
										</td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Keterangan</td>
										<td>
											<textarea name="ket" cols="30" rows="3"><?php echo set_value('ket', isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Pegawai</td>
										<td>
											<select name="nip" >
									<?php foreach($staff as $tampil){ ?>
												<option value="<?php echo $tampil->nip; ?>"><?php echo $tampil->nama_pegawai; ?></option>
									<?php } ?>
											</select>
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