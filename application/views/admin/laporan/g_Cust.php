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
								<table width='40%' class="crmLink" style="float:right;text-align:center;">
									<tr>
										<td><img src="<?php echo base_url(); ?>themes/img/home-menu/send.png" width="100px"/></td>
									</tr>
									<tr>
										<td><a id="sendButt" class="tombol" style="font-size:16px;">Kirim SMS</a></td>
									</tr>
								</table>
								<div class="cleared"></div><br/><br/>
								<div id="sendForm" title="Kirim SMS">
									<form name="crm_form" action="<?php echo $form_crm; ?>" method="post">
										<table width="100%">
											<tr>
												<td colspan="2">
													<input type="hidden" name="kmem" value="<?= set_value('member', isset($default['member']) ? $default['member'] : ''); ?>" />
													<input type="hidden" name="knon" value="<?= set_value('non', isset($default['non']) ? $default['non'] : ''); ?>" />
													<input type="hidden" name="kare" value="<?= set_value('area', isset($default['area']) ? $default['area'] : ''); ?>" />
													<input type="hidden" name="kope" value="<?= set_value('oper', isset($default['oper']) ? $default['oper'] : ''); ?>" />
													<input type="hidden" name="kjum" value="<?= set_value('jum', isset($default['jum']) ? $default['jum'] : ''); ?>" />
													<input type="hidden" name="kdar" value="<?= set_value('dari', isset($default['dari']) ? $default['dari'] : ''); ?>" />
													<input type="hidden" name="kake" value="<?= set_value('ke', isset($default['ke']) ? $default['ke'] : ''); ?>" />
												</td>
											</tr>
											<tr>
												<td>Jumlah Transaksi</td>
												<td>
													<select name="kope">
														<option value="1">=</option>
														<option value="2">></option>
														<option value="3"><</option>
													</select>
													<input type="text" name="jum" size="3" value="<?= set_value('jum', isset($default['jum']) ? $default['jum'] : '') ?>" style="text-align:right;"/> kali
												</td>
											</tr>
											<tr>
												<td>Tgl Kirim</td>
												<td><input type="text" name="tgl" id="date" size="10"/></td>
											</tr>
											<tr>
												<td style="vertical-align:top;" width='28%'>Isi Pesan</td>
												<td><textarea name="isi" id="isisms" style="width:100%;height:100px;"></textarea></td>
											</tr>
										</table>
									</form>
								</div>
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
<style>
	table.crmLink{
		<?php if (empty($tableCust)){ ?>
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
			height: 280,
			width: 500,
			modal: true,
			buttons: {
				"Kirim": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
						bValid = bValid && checkRequired( tgl, "Tgl. Kirim" ) && checkRequired( isisms, "Isi Pesan" );
						if ( bValid ) {
						document.crm_form.submit();
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