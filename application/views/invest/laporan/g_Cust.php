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
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.tables.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#smsTable').dataTable({
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
				
							<fieldset><legend>Frekuensi Transaksi Pelanggan</legend>
								<form name="sms_form" method="post" action="<?= $form_sms; ?>" accept-charset="utf-8">
								<table width='55%' style="float:left;font-weight:bold;">
									<tr>
										<td width='28%' style="vertical-align:top;">Pelanggan</td>
										<td>
											<input type="checkbox" name="member" value="Yes" <?php if(set_value('member', isset($default['member']) ? $default['member'] : '') == "Yes") echo "checked"; ?> /> Member&nbsp;&nbsp;<input type="checkbox" name="non" value="Yes" <?php if(set_value('non', isset($default['non']) ? $default['non'] : '') == "Yes") echo "checked"; ?> /> Non Member
										</td>
									</tr>
									<tr>
										<td>Area</td>
										<td>
											<select name="area">
												<option value="-1">Semua Area</option>
									<?php foreach ($dbarea->result() as $row) {
											if( set_value('area', isset($default['area']) ? $default['area'] : '') == $row->id_area ){ ?>
												<option value="<?php echo $row->id_area; ?>" selected ><?php echo $row->area_name; ?></option>
									<?php }else{ ?>
												<option value="<?php echo $row->id_area; ?>"><?php echo $row->area_name; ?></option>
									<?php } } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Dari Tanggal</td>
										<td><input type="text" name="dari" value="<?= set_value('dari', isset($default['dari']) ? $default['dari'] : '') ?>" id="start" size="10"/> s/d <input type="text" name="ke" value="<?= set_value('ke', isset($default['ke']) ? $default['ke'] : '') ?>" id="end" size="10"/></td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:right;" colspan="2"><a class="tombol" href="javascript:document.sms_form.submit()">Tampilkan</a></td>
									</tr>
								</table>
								</form>
								<div class="cleared"></div><br/><br/>
								<?php echo ! empty($tableCust) ? $tableCust : ''; ?>
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