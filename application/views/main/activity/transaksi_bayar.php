<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<form name="bayar_form" action="<?php echo $bayar_action; ?>" method="post">	
							<fieldset>
								<legend>Detail Transaksi</legend>
<?php if ($error == 'PROMO') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, KODE PROMO YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?><br/><div class="cleared"></div>
								<table width="50%" class="info" style="float:left;">
									<tr>
										<td>No Resi</td>
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
										<td>Jumlah Cucian</td>
										<td>:</td>
										<td>
											<?php if($tRow->jenis == "Kiloan"){
														echo $tRow->jumlah_kiloan . " Kg";
													}else{
														echo $tRow->jumlah_kiloan . " Buah";
											} ?>
										</td>
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
										<td>DP Bayar</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->dp_bayar, 0, ',', '.'); ?>,-</td>
									</tr>
									<tr>
										<td>Sisa Bayar</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->sisa_bayar, 0, ',', '.'); ?>,-</td>
									</tr>
									<tr>
										<td>Metode Pembayaran</td>
										<td>:</td>
										<td>
											<select name="metode" id="metode" onChange="tampil(this.value,'depe','kartu')" >
												<option value="1">Tunai</option>
												<option value="2">Debit/Kredit</option>
											</select>
											<input type="text" name="depe" id="depe" value="<?php echo set_value('depe', isset($default['depe']) ? $default['depe'] : ''); ?>" size="20" style="display:none;text-align:right;"/>
											<div id="kartu" style="display:none;" >
												<select name="bank" >
													<option value="BCA">BCA</option>
													<option value="BNI">BNI</option>
													<option value="BRI">BRI</option>
													<option value="Mandiri">Mandiri</option>
												</select>
												<input type="text" name="kartu" value="<?php echo set_value('kartu', isset($default['kartu']) ? $default['kartu'] : ''); ?>" size="20"/>
											</div>
										</td>
									</tr>
									<tr>
										<td>Delivery Antar</td>
										<td>:</td>
										<td>
											<input type="radio" name="deliver" value="Ya">Ya &nbsp;
											<input type="radio" name="deliver" value="Tidak" checked >Tidak
											<input type="hidden" name="nohp" value="<?php echo $tRow->no_tlp; ?>">
										</td>
									</tr>
									<tr>
										<td>Kode Promosi</td>
										<td>:</td>
										<td>
											<input type="text" name="promo" value="<?php echo set_value('promo', isset($default['promo']) ? $default['promo'] : ''); ?>" size="30"/>
										</td>
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
								<table width="50%" class="info">
									<tr>
										<td width="30%">ID Pegawai</td>
										<td width="3%">:</td>
										<td>
											<input type="password" name="nip" size="10" autofocus />
										</td>
									</tr>
								</table><br/>
					<?php echo anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','index',array("NO")),'Kembali',array('class' => 'back')); ?>
								<a class="tombol" href="javascript:document.bayar_form.submit()">Selesai</a>
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
<script type="text/javascript">
<!--
    function tampil(metode,id,id2) {
       var e = document.getElementById(id);
       var f = document.getElementById(id2);
       if(metode == '2'){
          e.style.display = 'none';
          f.style.display = 'inline';
       }else if(metode == '3'){
          e.style.display = 'inline';
          f.style.display = 'none';
       }else{
          e.style.display = 'none';
          f.style.display = 'none';
	   }
    }
//-->
</script>