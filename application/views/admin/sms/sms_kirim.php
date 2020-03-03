<div id="sms-form" title="Kirim SMS">
	<form name="sms_form" action="<?php echo $sms_form; ?>" method="post">
		<table width="100%">
			<tr>
				<td>Penerima</td>
				<td>
					<input type="text" name="notlp" id="notlp" size="20" />
				</td>
			</tr>
			<tr>
				<td width="25%">Isi Pesan</td>
				<td>
					<textarea name="isisms" cols="40" rows="4" id="isisms"></textarea>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var notlp = $( "#notlp" ),
			allFields = $( [] ).add( notlp ),
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
		
		$( "#sms-form" ).dialog({
			autoOpen: false,
			height: 250,
			width: 500,
			modal: true,
			buttons: {
				"Kirim": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
						bValid = bValid && checkRequired( notlp, "No. Tlp" ) && checkRequired( isisms, "Isi Pesan" );
						if ( bValid ) {
						document.sms_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
			$( "#add-sms" )
			.click(function() {
				$( "#sms-form" ).dialog( "open" );
		});
		
	});
</script>