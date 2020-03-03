	<div id="absen-form" title="Absen Harian">
		<form name="absen_action" method="post" action="<?php echo $absen_masuk; ?>" accept-charset="utf-8">
			<table width='100%'>
				<tr>
					<td width='40%'>Shift</td>
					<td>
						<select name="shift">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td>
						<select name="ket" id="absen">
							<option value="Masuk">Masuk</option>
							<option value="Cuti">Cuti</option>
							<option value="Sakit">Sakit</option>
							<option value="Alpha">Alpha</option>
						</select>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<script>
		$(function() {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			var absen = $( "#absen" ),
				allFields = $( [] ).add( absen ),
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
			
			$( "#absen-form" ).dialog({
				autoOpen: false,
				height: 160,
				width: 300,
				modal: true,
				buttons: {
					"Absen": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );

						bValid = bValid && checkRequired(absen,"Keterangan Absen");

						if ( bValid ) {
							document.absen_action.submit();
							$( this ).dialog( "close" );
						}
					}
				},
				close: function() {
					allFields.val( "" ).removeClass( "ui-state-error" );
				}
			});
			
			$( "#absen-button" )
				.click(function() {
					$( "#absen-form" ).dialog( "open" );
			});
			
		});
	</script>