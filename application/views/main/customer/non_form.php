<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#memberTable').dataTable({
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
	$('#kompTable').dataTable({
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
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend><?php echo $tLegend; ?> Data Pelanggan</legend><br/>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nama', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('tlp', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('area', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<form name="member_form" method="post" action="<?php echo $form_member; ?>" accept-charset="utf-8">
								<table width='60%'>
									<tr>
										<td width='24%'>Nama*</td>
										<td>
											<input type="text" name="nama" size="30" value="<?php echo set_value('nama', isset($default['nama']) ? $default['nama'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td style='vertical-align:top'>Alamat</td>
										<td><textarea name='add' rows='3' cols='40'><?php echo set_value('add', isset($default['add']) ? $default['add'] : ''); ?></textarea></td>
									</tr>
									<tr>
										<td>Area*</td>
										<td>
											<select name="area">
												<option value="">Pilih Area</option>
									<?php foreach ($dbarea->result() as $row) :
											if ($row->id_area == set_value('area', isset($default['area']) ? $default['area'] : '')) { ?>
												<option value="<?php echo $row->id_area; ?>" selected >
													<?php echo $row->area_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $row->id_area; ?>">
													<?php echo $row->area_name; ?>
												</option>
									<?php } endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>No. HP*</td>
										<td>
											<input type="text" name="tlp" size="20" value="<?php echo set_value('tlp', isset($default['tlp']) ? $default['tlp'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><?php echo $link; ?></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.member_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
<?php if($tLegend == "Ubah"){ ?>
								<br/><br/>
								<div class="list">HISTORI TRANSAKSI</div><br/>
								<?php echo $hist; ?><br/><br/>
								<?php echo ! empty($tabelMember) ? $tabelMember : ''; ?>
								<br/><br/><br/>
								<div class="list">HISTORI KOMPLAIN</div><br/>
								<?php echo ! empty($tabelKomplain) ? $tabelKomplain : ''; ?>
<?php } ?>
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