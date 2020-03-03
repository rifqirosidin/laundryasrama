<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/increment.js"></script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<form name="act_form" action="<?php echo $form_action; ?>" method="post">
							<fieldset>
								<div class="list">CEKLIST PAKAIAN</div><br/>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('jum_cloth', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('jum', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
								<table style="width:23%;float:left;">
					<?php if($tRow->jenis == "Kiloan"){
								foreach($cloth as $get){ ?>
									<tr>
										<td width="60%"><?php echo $get->nama_cloth; ?></td>
										<td>
											<div class="numbers-row">
				<input type="text" name="<?php echo $get->var_cloth; ?>" size="1" maxlength="2" onFocus="startCalc();" onBlur="stopCalc();" style="text-align:right;float:left;"/>
											</div>
										</td>
									</tr>
							<?php }
						}else{
								$jumlah = 0;
								foreach($cloth as $get){?>
									<tr>
										<td width="60%"><?php echo $get->nama_laundry; ?></td>
										<td><input type="text" size="1" style="text-align:right;float:left;" value="<?php echo $get->jum_non; ?>" readonly /></td>
									</tr>
							<?php $jumlah = $jumlah + $get->jum_non; }
					} ?>
								</table>
								<table style="width:30%;float:left;">
									<tr>
										<td>Jumlah Pakaian</td>
										<td>
									<?php if($tRow->jenis == "Kiloan"){ ?>
											<input type="text" name="jum_cloth" size="3" onFocus="startCalc();" onBlur="stopCalc();"  style="text-align:right;" readonly />
									<?php }else{ ?>
											<input type="text" name="jum_cloth" size="3" style="text-align:right;" value="<?php echo $jumlah; ?>" readonly />
									<?php } ?>
										</td>
									</tr>
									<tr>
										<td>Jumlah Mesin</td>
										<td>
											<input type="text" name="jum" size="1" value="<?php echo set_value('jum', isset($default['jum']) ? $default['jum'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td width="40%" style="vertical-align:top;">Keterangan</td>
										<td>
											<textarea name="ket" cols="20" rows="3"><?php echo set_value('ket', isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
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
										<td style="text-align:right;"><a class="tombol" href="javascript:document.act_form.submit()">Simpan</a></td>
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
<script>
	function startCalc(){
		interval = setInterval("calc()",1);
	}
	function calc(){
		<?php $x = 0; foreach($cloth as $get){
			echo $get->var_cloth . " = document.act_form." . $get->var_cloth . ".value; \n";
			$x++;
		} ?>
		
		document.act_form.jum_cloth.value = 
		<?php $i = 1; foreach($cloth as $get){
			if($i == $x)
				echo "(" . $get->var_cloth . " * 1);\n";
			else
				echo "(" . $get->var_cloth . " * 1) + ";
			$i++;
		} ?>
	}
	function stopCalc(){
		clearInterval(interval);
	}
</script>