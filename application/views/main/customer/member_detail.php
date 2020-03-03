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
							
							<fieldset><legend><?php echo $tLegend; ?> Member</legend><br/>
							<?php echo $link; ?><br/><br/>
								<table width='70%' class="info">
									<tr>
										<td>ID Member</td>
										<td>: <?php echo $member->id_member; ?></td>
									</tr>
									<tr>
										<td width='30%'>Nama</td>
										<td>: <?php echo $member->nama_member; ?></td>
									</tr>
									<tr>
										<td style='vertical-align:top'>Alamat</td>
										<td>: <?php echo $member->alamat_member; ?></td>
									</tr>
									<tr>
										<td>No. HP</td>
										<td>: <?php echo $member->tlp_member; ?></td>
									</tr>
									<tr>
										<td>Tempat, Tanggal Lahir</td>
										<td>: <?php echo $member->tmpt_lhr_member . ', '. ubahTanggal("d F Y", $member->tgl_lhr_member); ?></td>
									</tr>
									<tr>
										<td>Agama</td>
										<td>: <?php echo $member->agama; ?></td>
									</tr>
									<tr>
										<td>Jenis Member</td>
										<td>: <?php echo $member->jenis_member; ?></td>
									</tr>
									<tr>
										<td>Saldo</td>
										<td>: 
									<?php if($member->jenis_member == "Kiloan"){
												echo $member->saldo_kg . " Kg";
										  }else{
												echo "Rp " . number_format($member->saldo_rp, 0, ',', '.');
										  } ?>
										</td>
									</tr>
								</table>
							<br/><br/>
							<div class="list">HISTORI TRANSAKSI</div><br/>
							<?php echo $hist . " &nbsp;  &nbsp;  &nbsp; " . $depo; ?><br/><br/>
							<?php echo ! empty($tabelMember) ? $tabelMember : ''; ?>
							<br/><br/><br/>
							<div class="list">HISTORI KOMPLAIN</div><br/>
							<?php echo ! empty($tabelKomplain) ? $tabelKomplain : ''; ?>
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
<?php
	function ubahTanggal($format,$nilai="now"){
		$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday",
					"January","February", "March","April","May","June","July","August","September","October","November","December");
		$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
					"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return str_replace($en,$id,date($format,strtotime($nilai)));
	}
?>