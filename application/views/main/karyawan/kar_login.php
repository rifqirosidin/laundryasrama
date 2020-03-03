<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<div id="kar-form" title="Login Pegawai">
	<form name="kar_form" action="<?php echo $kar_form; ?>" method="post">
		<table width="100%">
			<tr>
				<td width="35%">ID Pegawai</td>
				<td>
					<input type="password" name="nip" size="10" id="nip" />
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>
					<input type="password" name="pass" maxlength="20" size="20" id="pass" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nipkar = $( "#nip" ),
			allFields = $( [] ).add( nipkar ),
			tips = $( ".validateTips" );
		var passkar = $( "#pass" ),
			allFields = $( [] ).add( passkar ),
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
		
		$( "#kar-form" ).dialog({
			autoOpen: false,
			height: 160,
			width: 350,
			modal: true,
			buttons: {
				"Login": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( nipkar, "ID Pegawai" ) && checkRequired( passkar, "Password" );

					if ( bValid ) {
						document.kar_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#kar-button" )
			.click(function() {
				$( "#kar-form" ).dialog( "open" );
		});
		
	});
</script>