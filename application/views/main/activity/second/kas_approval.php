<?php for($i=0;$i<$jumlah;$i++){ ?>
	<div id="app-form<?php echo $i; ?>" title="Approve Pengeluaran">
		<form name="app_form<?php echo $i; ?>" action="<?php echo $form_app["$i"]; ?>" method="post" >
			<table width="100%">
				<tr>
					<td width="38%">Approval</td>
					<td>
						<select name="approve" >
							<option value="1">Terima</option>
							<option value="2">Tolak</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>ID Pegawai</td>
					<td>
						<input type="password" name="nip" size="10" id="nip<?php echo $i; ?>" />
					</td>
				</tr>
				<tr>
					<td>Password</td>
					<td>
						<input type="password" name="pass" maxlength="20" size="20" id="pass<?php echo $i; ?>" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<script>
		$(function() {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			var nip<?php echo $i; ?> = $( "#nip<?php echo $i; ?>" ),
				allFields = $( [] ).add( nip<?php echo $i; ?> ),
				tips = $( ".validateTips<?php echo $i; ?>" );
			var pass<?php echo $i; ?> = $( "#pass<?php echo $i; ?>" ),
				allFields = $( [] ).add( pass<?php echo $i; ?> ),
				tips = $( ".validateTips<?php echo $i; ?>" );
				
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
			
			$( "#app-form<?php echo $i; ?>" ).dialog({
				autoOpen: false,
				height: 215,
				width: 340,
				modal: true,
				buttons: {
					"Simpan": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );

						bValid = bValid && checkRequired( nip<?php echo $i; ?>, "ID Pegawai" ) && checkRequired( pass<?php echo $i; ?>, "Password" );

						if ( bValid ) {
							<?php echo "document.app_form" . $i . ".submit();"; ?>
							$( this ).dialog( "close" );
						}
					}
				},
				close: function() {
					allFields.val( "" ).removeClass( "ui-state-error" );
				}
			});

			$( "#app-button<?php echo $i; ?>" )
				.click(function() {
					$( "#app-form<?php echo $i; ?>" ).dialog( "open" );
			});
			
		});
	</script>
<?php } ?>