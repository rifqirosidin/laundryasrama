<div id="layanan-form" title="Tambah Layanan">
	<form name="layanan_form" method="post" action="<?php echo $layan_tambah; ?>" accept-charset="utf-8">
		<table width='100%'>
			<tr>
				<td width='35%'>Kode</td>
				<td>
					<input type="text" name="kode" id="kode" size="3" maxlength="3" style="text-transform:uppercase"/>
				</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>
					<input type="text" name="nama" id="nama" size="30"/>
				</td>
			</tr>
			<tr>
				<td>Jenis</td>
				<td>
					<select name="jenis">
						<option value="Kiloan">Kiloan</option>
						<option value="Non">Non Kiloan</option>
						<option value="Satuan">Satuan</option>
						<option value="Extra">Extra</option>
						<option value="Deposit">Deposit</option>
						<option value="Masa">Masa Aktif</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Proses</td>
				<td>
					<select name="proses">
						<option value="+2 days">2 Hari</option>
						<option value="+1 days">1 Hari</option>
						<option value="+12 hours">12 Jam</option>
						<option value="+4 hours">4 Jam</option>
						<option value="-">-</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Harga</td>
				<td>
					<input type="text" name="harga" id="harga" size="20"/>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var akode = $( "#kode" ),
			allFields = $( [] ).add( akode ),
			tips = $( ".validateTips" );
			
		var anama = $( "#nama" ),
			allFields = $( [] ).add( anama ),
			tips = $( ".validateTips" );
			
		var aharga = $( "#harga" ),
			allFields = $( [] ).add( aharga ),
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
		
		$( "#layanan-form" ).dialog({
			autoOpen: false,
			height: 250,
			width: 410,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( akode, "Kode Layanan" ) && checkRequired( anama, "Nama Layanan" ) && checkRequired( aharga, "Harga Layanan" );

					if ( bValid ) {
						document.layanan_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-layanan" )
			.click(function() {
				$( "#layanan-form" ).dialog( "open" );
		});
		
	});
</script>