<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>

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
							
							<fieldset><legend>Kotak Masuk</legend>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:99%;">
		<?= form_error('notlp', '&nbsp;', '&nbsp;'); ?><br/><br/>
	</div>
<?php } ?>
								<?php echo $sendSMS . "&nbsp; &nbsp; &nbsp;" . $emptySMS; ?><br/><br/>
								<div class="pesan">
							<?php if($pesan !== NULL) { ?>
									<div class="judul"><?php echo $pengirim; ?>, <?php echo $pesan->ReceivingDateTime; ?>
									<div style="float:right;"><a id="sendButt" class="move" title="Simpan ke..."> </a></div></div>
									<div class="isi"><?php echo $pesan->TextDecoded; ?></div>
									<div id="sendForm" title="Simpan ke Respon Pelanggan">
										<form name="s_Send" action="<?php echo $s_Send; ?>" method="post">
											<table width="100%">
												<tr>
													<td width="35%">Jenis</td>
													<td>
														<input type="hidden" name="idpesan" value="<?php echo $pesan->ID; ?>" />
														<select name="jenis">
															<option value="KRITIK">KRITIK</option>
															<option value="SARAN">SARAN</option>
														</select>
													</td>
												</tr>
											</table>
										</form>
									</div>
							<?php }else{ ?>
									<div class="kosong">- PILIH PESAN YANG INGIN ANDA BACA -</div>
							<?php } ?>
								</div><br/>
								<?php echo ! empty($tableInbox) ? $tableInbox : ''; ?>
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
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		
		function checkRequired( o, n ) {
			if ( o.val() == "" ) {
				o.addClass( "ui-state-error" );
				return false;
			} else {
				return true;
			}
		}
		
		$( "#sendForm" ).dialog({
			autoOpen: false,
			height: 135,
			width: 300,
			modal: true,
			buttons: {
				"Simpan": function() {
					document.s_Send.submit();
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
			$( "#sendButt" )
			.click(function() {
				$( "#sendForm" ).dialog( "open" );
		});
		
	});
</script>
<?php $this->load->view('admin/sms/sms_kirim'); ?>