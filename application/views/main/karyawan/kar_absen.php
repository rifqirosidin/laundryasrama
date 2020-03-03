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
	$('#absenTable').dataTable({
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
							<fieldset><legend>Absensi Pegawai</legend>
								<table class="info" width="50%">
									<tr>
										<td width='25%'>ID Pegawai</td>
										<td width='1%'>:</td>
										<td><?php echo $ambil->nip; ?></td>
									</tr>
									<tr>
										<td>Nama</td>
										<td>:</td>
										<td><?php echo $ambil->nama_pegawai; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo $ambil->alamat_pegawai; ?></td>
									</tr>
									<tr>
										<td>No. Tlp</td>
										<td>:</td>
										<td><?php echo $ambil->tlp_pegawai; ?></td>
									</tr>
								</table><br/>
							<?php if($href !== NULL) { ?>
								<table width="50%">
									<tr>
										<td colspan="3" style="text-align:center;"><?php echo $href; ?></td>
									</tr>
								</table>
							<?php } ?>
								<br/><br/>
								<form name="tgl_form" action="<?php echo $tampil_action; ?>" method="post" >
									Dari Tanggal <input type="text" name="from" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
									<input type="text" name="to" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
									<a class="tombol" href="javascript:document.tgl_form.submit()">Tampilkan</a>
								</form><br/>
								<?php echo ! empty($tabelAbsen) ? $tabelAbsen : ''; ?>
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
<?php echo $this->load->view('main/karyawan/kar_absen_form'); ?>