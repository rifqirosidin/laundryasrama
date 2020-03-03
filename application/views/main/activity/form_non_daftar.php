
	<div id="daftar-non" title="Daftar Non Member Baru">
		<form name="daftar_non" method="post" action="<?php echo $non_action; ?>" accept-charset="utf-8">
			<table width='100%'>
				<tr>
					<td width='30%'>Nama*</td>
					<td><input type="text" name="namanonbaru" id="namanonbaru" size="30"/></td>
				</tr>
				<tr>
					<td style='vertical-align:top'>Alamat</td>
					<td><textarea name='alamatnonbaru' rows='3' cols='35'></textarea></td>
				</tr>
				<tr>
					<td>Area*</td>
					<td>
						<select name="areanonbaru">
				<?php foreach ($dbarea->result() as $row){ ?>
							<option value="<?php echo $row->id_area; ?>">
								<?php echo $row->area_name; ?>
							</option>
				<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>No. HP*</td>
					<td><input type="text" name="nohpnonbaru" id="nohpnonbaru" size="20"/></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>ID Pegawai*</td>
					<td>
						<input type="password" name="nip" size="10" id="nip6" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<script>
		$(function() {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			var namanon = $( "#namanonbaru" ),
				allFields = $( [] ).add( namanon ),
				tips = $( ".validateTips" );
			var nohpnon = $( "#nohpnonbaru" ),
				allFields = $( [] ).add( nohpnon ),
				tips = $( ".validateTips" );
			var nip6 = $( "#nip6" ),
				allFields = $( [] ).add( nip6 ),
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
			
			$( "#daftar-non" ).dialog({
				autoOpen: false,
				height: 310,
				width: 515,
				modal: true,
				buttons: {
					"Simpan": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );

						bValid = bValid && checkRequired(namanon,"Nama Pelanggan") && checkRequired(nohpnon,"No. HP") && checkRequired(nip6, "ID Pegawai");

						if ( bValid ) {
							document.daftar_non.submit();
							$( this ).dialog( "close" );
						}
					}
				},
				close: function() {
					allFields.val( "" ).removeClass( "ui-state-error" );
				}
			});
			
			$( "#add-non" )
				.click(function() {
					$( "#daftar-non" ).dialog( "open" );
			});
			
		});
	</script>