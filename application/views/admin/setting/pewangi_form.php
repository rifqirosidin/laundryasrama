<div id="wangi-form" title="Tambah Pewangi">
	<form name="wangi_form" method="post" action="<?php echo $form_wangi; ?>" >
		<table width='100%' style="font-weight:bold;" >
			<tr>
				<td width='35%'>Kode</td>
				<td>
					<input type="text" id="kode" name="kode" size="3" maxlength="3" />
				</td>
			</tr>
			<tr>
				<td>Nama Pewangi</td>
				<td>
					<input type="text" id="nama" name="nama" size="25" />
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
		
		$( "#wangi-form" ).dialog({
			autoOpen: false,
			height: 170,
			width: 370,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( akode, "Kode Pewangi" ) && checkRequired( anama, "Nama Pewangi" );

					if ( bValid ) {
						document.wangi_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-wangi" )
			.click(function() {
				$( "#wangi-form" ).dialog( "open" );
		});
		
	});
</script>