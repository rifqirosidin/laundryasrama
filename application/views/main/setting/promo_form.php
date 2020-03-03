<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#start" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#promoTable').dataTable({
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
							
							<fieldset><legend><?php echo $tLegend; ?> Promo</legend>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nama', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('jenis', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('ptg', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('start', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('end', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('jum', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<form name="promo_form" method="post" action="<?php echo $form_promo; ?>" accept-charset="utf-8">
								<table width='60%'>
									<tr>
										<td width='22%'>Nama Promo</td>
										<td>
											<input type="text" name="nama" size="50" value="<?php echo set_value('nama', isset($default['nama']) ? $default['nama'] : ''); ?>" autofocus />
										</td>
									</tr>
									<tr>
										<td>Ket. Promo</td>
										<td>
											<textarea name="ket" rows="3" cols="40"><?php echo set_value('ket', isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Jenis Promo</td>
										<td>
								<?php if($tLegend == "Tambah"){ ?>
											<select name="jenis">
												<option value="">-- Pilih Jenis--</option>
												<option value="Diskon">Potongan Diskon</option>
												<option value="Rupiah">Potongan Harga</option>
												<option value="Kiloan">Potongan Kilo</option>
											</select>
								<?php }else{ ?>
											<input type="hidden" name="jenis" value="<?php echo set_value('jenis', isset($default['jenis']) ? $default['jenis'] : ''); ?>"/>
											: <?php echo set_value('jenis', isset($default['jenis']) ? $default['jenis'] : ''); ?>
								<?php } ?>
										</td>
									</tr>
									<tr>
										<td>Potongan</td>
										<td>
											<input type="text" name="ptg" size="15" value="<?php echo set_value('ptg', isset($default['ptg']) ? $default['ptg'] : ''); ?>" style="text-align:right;"/>
										</td>
									</tr>
									<tr>
										<td>Tgl Aktif</td>
										<td>
											<input type="text" name="start" id="start" size="10" value="<?php echo set_value('start', isset($default['start']) ? $default['start'] : ''); ?>" readonly /> s/d <input type="text" name="end" id="end" size="10" value="<?php echo set_value('end', isset($default['end']) ? $default['end'] : ''); ?>" readonly />
										</td>
									</tr>
									<tr>
							<?php if($tLegend == "Tambah"){ ?>
										<td>Jumlah</td>
										<td>
											<input type="text" name="jum" size="3" value="<?php echo set_value('jum', isset($default['jum']) ? $default['jum'] : ''); ?>"/>
										</td>
							<?php }else{ ?>
										<td>Status</td>
										<td>
											<input type="hidden" name="jum" value="<?php echo set_value('jum', isset($default['jum']) ? $default['jum'] : ''); ?>"/>
											<select name="stat">
												<option value="Ya">Aktif</option>
												<option value="Tidak">Tidak Aktif</option>
											</select>
										</td>
								<?php } ?>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><?php echo $link; ?></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.promo_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
<?php if($tLegend == "Ubah"){ ?>
							<br/>
							<div class="list">LIST PROMO</div><br/>
							<?php echo ! empty($list_promo) ? $list_promo : ''; ?>
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