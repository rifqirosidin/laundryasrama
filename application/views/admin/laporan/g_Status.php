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
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.tables.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#actTable').dataTable({
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
							
							<fieldset><legend>Status Transaksi</legend><br/>
								<form name="g_form" method="post" action="<?php echo $g_form; ?>" accept-charset="utf-8">
									<table width='55%'>
										<tr>
											<td width='25%'>Oulet</td>
											<td><?php echo $outlet; ?></td>
										</tr>
										<tr>
											<td>Dari Tanggal</td>
											<td>
												<input type="text" name="dari" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
												<input type="text" name="sampai" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
												<a class="tombol" href="javascript:document.g_form.submit()">Tampilkan</a>
											</td>
										</tr>
									</table>
								</form><br/>
								<?php echo ! empty($tabelAktivitas) ? $tabelAktivitas : ''; ?>
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
<style>
	table.crmLink{
<?php if (empty($tableArea)){ ?>
		display : none;
<?php }?>
	}	
</style>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var tgl = $( "#date" ),
			allFields = $( [] ).add( tgl ),
			tips = $( ".validateTips" );
		var isisms = $( "#isisms" ),
			allFields = $( [] ).add( isisms ),
			tips = $( ".validateTips" );
		
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
			height: 500,
			width: 500,
			modal: true,
			buttons: {
				"Kirim": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
						bValid = bValid && checkRequired( tgl, "Tgl. Kirim" ) && checkRequired( isisms, "Isi Pesan" );
						if ( bValid ) {
						document.s_Send.submit();
						$( this ).dialog( "close" );
					}
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