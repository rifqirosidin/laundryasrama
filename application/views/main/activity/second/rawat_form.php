<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#asetTable').dataTable({
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
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('rawat', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
								<table width="70%">
									<tr>
										<td width="20%">Kode Aset</td>
										<td style="font-weight:bold;"><?php echo $tRow->kode_aset; ?></td>
									</tr>
									<tr>
										<td>Jenis Aset</td>
										<td style="font-weight:bold;"><?php echo $tRow->nama_jenis; ?></td>
									</tr>
									<tr>
										<td>Perawatan</td>
										<td>
											<select name="rawat">
									<?php foreach($dbRawat as $row){ 
											if($row->perawatan == set_value('rawat', isset($default['rawat']) ? $default['rawat'] : '') ){ ?>
												<option value="<?php echo $row->perawatan; ?>" selected ><?php echo $row->perawatan; ?></option>
									<?php 	}else{ ?>
												<option value="<?php echo $row->perawatan; ?>"><?php echo $row->perawatan; ?></option>
									<?php }} ?>
												<option value="Maintenance">Maintenance</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Catatan</td>
										<td>
											<textarea name="cat" cols="40" rows="3"><?php echo set_value('cat', isset($default['cat']) ? $default['cat'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td>ID Pegawai</td>
										<td>
											<input type="password" name="nip" size="10"/>
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
								<div class="list">HISTORI PERAWATAN</div><br/>
								<?php echo ! empty($tabelAset) ? $tabelAset : ''; ?>
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