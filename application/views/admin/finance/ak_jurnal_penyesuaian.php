<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#tgl" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
</script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('dejum', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('krjum', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<form name="jurnal_form" method="post" action="<?php echo $form_jurnal; ?>" accept-charset="utf-8">
								<table width='60%' style='font-weight:bold;'>
									<tr>
										<td width='30%'>Outlet</td>
										<td><?php echo $nama_outlet; ?></td>
									</tr>
									<tr>
										<td>Item Debit</td>
										<td>
											<select name="debit" >
									<?php foreach ($dbkel->result() as $kel){ ?>
												<option value="<?php echo $kel->nama_akun; ?>" ><?php echo $kel->kode_akun . " | " . $kel->nama_akun; ?></option>
									<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Item Kredit</td>
										<td>
											<select name="kredit" >
									<?php foreach ($dbkel->result() as $kel){ ?>
												<option value="<?php echo $kel->nama_akun; ?>" ><?php echo $kel->kode_akun . " | " . $kel->nama_akun; ?></option>
									<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Jumlah</td>
										<td>
											<input type="text" name="krjum" size="25" value="<?php echo $krjum; ?>" style="text-align:right;" />
										</td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Keterangan</td>
										<td>
											<textarea name="ket" cols="40" rows="5"><?php echo $ket; ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Tanggal</td>
										<td>
											<input type="text" name="tgl" id="tgl" size="10" value="<?php echo $tgl; ?>" readonly />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.jurnal_form.submit()">Tambah</a></td>
									</tr>
								</table>
							</form><br/>
							<div class="list">JURNAL</div><br/>
							<?php echo ! empty($tabelJurnal) ? $tabelJurnal : ''; ?>
								<br/>
								<table width="100%">
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;">
							<?php if( $tempJurnal != NULL ){ ?>
											<a class="tombol" href="<?php echo $simpan; ?>">Simpan</a>
							<?php } ?>
										</td>
									</tr>
								</table>
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