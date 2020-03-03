<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend>Profil Investor</legend>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('name', '&nbsp;', '&nbsp;');
			  echo form_error('pno', '&nbsp;', '&nbsp;');
			  echo form_error('pos', '&nbsp;', '&nbsp;');
			  echo form_error('pass', '&nbsp;', '&nbsp;');
			  echo form_error('repass', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>
							<form name="pegawai_form" method="post" action="<?php echo $form_pegawai; ?>" accept-charset="utf-8">
								<table width='100%'>
									<tr>
										<td width='15%'>Nama*</td>
										<td>
											<input type="text" name="name" size="40" value="<?php echo set_value('name', isset($default['name']) ? $default['name'] : ''); ?>" readonly />
										</td>
									</tr>
									<tr>
										<td>No. Tlp*</td>
										<td>
											<input type="text" name="pno" size="20" value="<?php echo set_value('pno', isset($default['pno']) ? $default['pno'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td style='vertical-align:top'>Alamat</td>
										<td><textarea name='add' rows='3' cols='40'><?php echo set_value('add', isset($default['add']) ? $default['add'] : ''); ?></textarea></td>
									</tr>
								</table>
								<input type="hidden" name="pos" value="2"/>
								<input type="hidden" name="outlet" value="<?php echo set_value('outlet', isset($default['outlet']) ? $default['outlet'] : ''); ?>"/>
								<table width='45%'>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.pegawai_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
							<form name="form_pass" method="post" action="<?php echo $form_pass; ?>" accept-charset="utf-8">
								<table width='45%'>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td width='33%'>Password</td>
										<td>
											<input type="password" maxlength="20" name="pass" size="20" />
										</td>
									</tr>
									<tr>
										<td>Re-Type Password</td>
										<td>
											<input type="password" maxlength="20" name="repass" size="20" />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.form_pass.submit()">Ubah Password</a></td>
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