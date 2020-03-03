<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#stokTable').dataTable({
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered ){
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ){
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		},
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 0 ] }
		],
		"aaSorting": [[ 1, 'asc' ]]
	});
} );
</script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<form name="rawat_form" action="<?php echo $form_action; ?>" method="post">
							<fieldset>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'PASS') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, PASSWORD YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'GUDANG') {?>
	<div class="attention" style="width:95%;">
		<b>STOK GUDANG TIDAK MENCUKUPI!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('act', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('stok', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
								<table width="50%">
									<tr>
										<td width="30%">Kode Inventori</td>
										<td style="font-weight:bold;" colspan="2"><?php echo $tRow->kode_stock; ?></td>
									</tr>
									<tr>
										<td>Jenis Inventori</td>
										<td style="font-weight:bold;" colspan="2"><?php echo $tRow->nama_stock; ?></td>
									</tr>
									<tr>
										<td>Stock</td>
										<td style="font-weight:bold;" width="25%">
											<input type="hidden" name="gudang" value="<?php echo $tRow->stock_gudang; ?>"/>
											<input type="hidden" name="inv" value="<?php echo $tRow->stock; ?>"/>
											Outlet : <?php echo $tRow->stock; ?> Kg
										</td>
										<td style="font-weight:bold;">Gudang : <?php echo $tRow->stock_gudang; ?> Kg<td>
									</tr>
									<tr>
										<td>Aktivitas</td>
										<td colspan="2">
											<select name="act">
												<option value="">Pilih Aktivitas</option>
												<option value="1">Stock Akhir</option>
												<option value="2">Re-Stock</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Jumlah Stock</td>
										<td style="font-weight:bold;" colspan="2">
											<input type="text" name="stok" size="3" value="<?php echo set_value('stok', isset($default['stok']) ? $default['stok'] : ''); ?>"/> Kg
										</td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Catatan</td>
										<td colspan="2">
											<textarea name="cat" cols="40" rows="3"><?php echo set_value('cat', isset($default['cat']) ? $default['cat'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td width="20%">ID Pegawai</td>
										<td colspan="2">
											<input type="password" name="nip" size="10"/>
										</td>
									</tr>
									<tr>
										<td>Password</td>
										<td colspan="2">
											<input type="password" name="pass" size="10" />
										</td>
									</tr>
								</table>
								<table width="100%">
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.rawat_form.submit()">Simpan</a></td>
									</tr>
								</table>
								<br/><br/>
								<div class="list">HISTORI AKTIVITAS</div><br/>
								<?php echo ! empty($tabelStok) ? $tabelStok : ''; ?>
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