<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
				
							<fieldset><legend>UBAH ISI SMS</legend><br/>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:99%;">
		<?= form_error('isi', '&nbsp;', '&nbsp;'); ?>
		<?= form_error('selang', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>
								<form name="sms_form" method="post" action="<?= $form_sms; ?>" accept-charset="utf-8">
								<table width='55%' style="font-weight:bold;">
									<tr>
										<td width='28%'>Kode</td>
										<td><?= $sms->tipe_pesan; ?></td>
									</tr>
									<tr>
										<td>Judul Pesan</td>
										<td><?= $sms->nama_pesan; ?></td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Isi Pesan</td>
										<td>
											<textarea name="isi" style="width:100%;height:100px;"><?= set_value('isi', isset($default['isi']) ? $default['isi'] : '') ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Selang Pesan</td>
										<td><input type="text" name="selang" value="<?= set_value('selang', isset($default['selang']) ? $default['selang'] : '') ?>" size="15"/></td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><?= $link; ?></td>
										<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.sms_form.submit()">Simpan</a></td>
									</tr>
								</table>
								</form>
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