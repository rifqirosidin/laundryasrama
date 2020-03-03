<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
$(document).ready(function() {
	$('#invList').dataTable({
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
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.chained.mini.js"></script>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("#city").chained("#zona");
		$("#area").chained("#city");
		$("#newoutlet").chained("#area");
	});
</script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							<fieldset>
								<a class="add" id="add-inv">Daftar Investor Baru</a><br/><br/>
								<legend><?php echo $tLegend; ?></legend>
								<?php echo ! empty($tabelInvest) ? $tabelInvest : ''; ?>
							</fieldset>
							<?php $this->load->view('admin/investor/invest_add'); ?>
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