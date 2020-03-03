<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#pesanTable').dataTable({
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
								<?php if($form_kirim !== NULL) {
									echo "<a id='pesan-button' class='pesan'>Kirim Pesan</a><div class='cleared'></div><br/>";
								} ?>
								<div style="float:left;width:50%;">
									<?php echo ! empty($tabelPesan) ? $tabelPesan : ''; ?>
								</div>
								<div class="pesan" style="float:right;width:45%;">
							<?php if($pesan !== NULL) { ?>
									<div class="judul"><?php echo $pesan->judul_pesan; ?></div>
									<div class="isi"><?php echo $pesan->isi_pesan; ?></div>
							<?php }else{ ?>
									<div class="kosong">- PILIH JUDUL UNTUK MELIHAT ISI PESAN ANDA -</div>
							<?php } ?>
								</div>
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
<?php if($form_kirim !== NULL) {
	echo $this->load->view('main/karyawan/kar_pesan_form');
} ?>