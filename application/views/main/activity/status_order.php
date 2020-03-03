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
		$( "#ti" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#ka" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#ka" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#ti" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
</script>
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
<div class="tabtrans">
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")); ?>"><h2>ORDERAN</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("NO")); ?>"><h2>MEMBER</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("NO")); ?>"><h2>NON MEMBER</h2></a>
	</div>
	<div class="acttab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","statCuci",array("NO")); ?>"><h2>STATUS CUCIAN</h2></a>
	</div>
	<div class="cleared"></div>
	<fieldset style="padding-top:25px;">
		<form name="tgl_form" action="<?php echo $status_action; ?>" method="post" >
			Dari Tanggal <input type="text" name="from" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
			<input type="text" name="to" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
			<a class="tombol" href="javascript:document.tgl_form.submit()">Tampilkan</a><br/><br/>
		</form><br/>
		<a id="add-cetak" class="print">Cetak List Cucian</a><br/><br/>
		<?php echo ! empty($tabelAktivitas) ? $tabelAktivitas : ''; ?>
	</fieldset>
</div>

<div id="cetak-form" title="Monitoring Cucian">
	<form name="cetak_form" action="<?php echo $cetak; ?>" method="post">
		<table width="100%">
			<tr>
				<td style="vertical-align:top;">Pelanggan</td>
				<td colspan="2">
					<input type="checkbox" name="cust0"/>MEMBER<br/>
					<input type="checkbox" name="cust1"/>NON MEMBER
				</td>
			</tr>
			<tr style="vertical-align:top;">
				<td>Status Cucian</td>
				<td>
					<input type="checkbox" name="cuci0"/>PENDING<br/>
					<input type="checkbox" name="cuci1"/>CEKLIST<br/>
					<input type="checkbox" name="cuci2"/>WASHING<br/>
					<input type="checkbox" name="cuci3"/>DRYING
				</td>
				<td>
					<input type="checkbox" name="cuci4"/>PACKING<br/>
					<input type="checkbox" name="cuci5"/>SIAP AMBIL<br/>
					<input type="checkbox" name="cuci6"/>DELIVERY<br/>
					<input type="checkbox" name="cuci7"/>SELESAI
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;">Status Bayar</td>
				<td colspan="2">
					<input type="checkbox" name="bayar0"/>LUNAS<br/>
					<input type="checkbox" name="bayar1"/>BELUM
				</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td colspan="2">
					<input type="text" name="ti" id="ti" size="10" readonly /> s/d <input type="text" name="ka" id="ka" size="10" readonly />
				</td>
			</tr>
			<tr>
				<td width="30%">ID Pegawai</td>
				<td colspan="2">
					<input type="password" name="nip" size="10" id="nip" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nipcetak = $( "#nip" ),
			allFields = $( [] ).add( nipcetak ),
			tips = $( ".validateTips1" );

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
		
		$( "#cetak-form" ).dialog({
			autoOpen: false,
			height: 350,
			width: 430,
			modal: true,
			buttons: {
				"Cetak": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( nipcetak, "ID Pegawai" );

					if ( bValid ) {
						document.cetak_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-cetak" )
			.click(function() {
				$( "#cetak-form" ).dialog( "open" );
		});
		
	});
</script>