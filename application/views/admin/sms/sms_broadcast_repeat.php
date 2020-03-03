<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#date" ).datepicker({
			minDate: 0,
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
				
							<fieldset><legend>EVENT BROADCAST ULANG</legend>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:99%;">
		<?= form_error('nama', '&nbsp;', '&nbsp;'); ?>
		<?= form_error('tgl', '&nbsp;', '&nbsp;'); ?>
		<?= form_error('isi', '&nbsp;', '&nbsp;'); ?>
	</div><br/>
<?php } ?>
								<form name="sms_form" method="post" action="<?= $form_sms; ?>" accept-charset="utf-8">
								<table width='55%' style="font-weight:bold;">
									<tr>
										<td width='28%'>Nama</td>
										<td colspan="2"><input type="text" name="nama" value="<?= set_value('nama', isset($default['nama']) ? $default['nama'] : '') ?>" size="40"/></td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Jenis</td>
										<td width='25%'><input type="hidden" name="jenis" value="<?= set_value('jenis', isset($default['jenis']) ? $default['jenis'] : '') ?>" /><input type="hidden" name="namajenis" value="<?= set_value('namajenis', isset($default['namajenis']) ? $default['namajenis'] : '') ?>" /><?= set_value('namajenis', isset($default['namajenis']) ? $default['namajenis'] : '') ?></td>
										<td>
									<?php if(set_value('jenis', isset($default['jenis']) ? $default['jenis'] : '') == 1){ ?>
											<input type="checkbox" name="member" value="Yes" <?php if(set_value('member', isset($default['member']) ? $default['member'] : '') == "Yes") echo "checked"; ?> /> Member&nbsp;&nbsp;<input type="checkbox" name="non" value="Yes" <?php if(set_value('non', isset($default['non']) ? $default['non'] : '') == "Yes") echo "checked"; ?> /> Non Member
									<?php }else if(set_value('jenis', isset($default['jenis']) ? $default['jenis'] : '') == 2){ ?>
											<input type="hidden" name="agama" value="<?= set_value('agama', isset($default['agama']) ? $default['agama'] : '') ?>" />
											Agama : <?php echo set_value('agama', isset($default['agama']) ? $default['agama'] : ''); ?>
									<?php } ?>
										</td>
									</tr>
									<tr>
										<td width='28%'>Tgl Kirim</td>
										<td colspan="2"><input type="text" name="tgl" id="date" size="10" /></td>
									</tr>
									<tr>
										<td style="vertical-align:top;" width='28%'>Isi Pesan</td>
										<td colspan="2">
											<textarea name="isi" style="width:100%;height:100px;"><?= set_value('isi', isset($default['isi']) ? $default['isi'] : '') ?></textarea>
										</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td><?= $link; ?></td>
										<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.sms_form.submit()">Kirim</a></td>
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