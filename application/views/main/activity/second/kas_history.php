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
	$('#histTable').dataTable({
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
							
							<fieldset><br/>
							<form name="jurnal_form" method="post" action="<?php echo $form_jurnal; ?>" accept-charset="utf-8">
								<table width='45%'>
									<tr>
										<td style="vertical-align:top;">Jenis Transaksi</td>
										<td>
											<input type="radio" name="jenis" value="0" readonly /> SEMUA<br/>
											<input type="radio" name="jenis" value="MASUK" readonly /> MASUK BAYAR<br/>
											<input type="radio" name="jenis" value="AMBIL" readonly /> AMBIL BAYAR<br/>
											<input type="radio" name="jenis" value="DEPOSIT" readonly /> DEPOSIT
										</td>
									</tr>
									<tr>
										<td width='30%'>Dari Tanggal</td>
										<td>
											<input type="text" name="dari" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
											<input type="text" name="sampai" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.jurnal_form.submit()">Tampilkan</a></td>
									</tr>
								</table>
							</form><br/>
							<div class="list">HISTORI KAS</div><br/>
							<?php echo ! empty($tabelHistori) ? $tabelHistori : ''; ?>
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