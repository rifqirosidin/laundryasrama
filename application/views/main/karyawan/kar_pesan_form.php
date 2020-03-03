<div id="pesan-form" title="Kirim Pesan">
	<form name="pesan_form" action="<?php echo $form_kirim; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<table width="100%">
			<tr>
				<td width="28%">Subyek</td>
				<td>
					<select name="subyek" id="subyek" >
						<option value="">Pilih Subyek</option>
						<option value="Bahan Baku">Bahan Baku</option>
						<option value="Harapan">Harapan</option>
						<option value="Kendala">Kendala</option>
						<option value="Peralatan">Peralatan</option>
						<option value="Perlengkapan">Perlengkapan</option>
						<option value="SDM">SDM</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Judul Pesan</td>
				<td>
					<input type="text" name="judul" size="30"/>
				</td>
			</tr>
			<tr>
				<td>Pesan</td>
				<td>
					<textarea name="pesan" id="pesan" cols="30" rows="3"></textarea>
				</td>
			</tr>
			<tr>
				<td>Upload Gambar</td>
				<td>
					<input type="file" name="photo" size="30"/>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var subyek = $( "#subyek" ),
			allFields = $( [] ).add( subyek ),
			tips = $( ".validateTips" );
		var pesan = $( "#pesan" ),
			allFields = $( [] ).add( pesan ),
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
		
		$( "#pesan-form" ).dialog({
			autoOpen: false,
			height: 265,
			width: 450,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( subyek, "Subyek" ) && checkRequired( pesan, "Pesan" );

					if ( bValid ) {
						document.pesan_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#pesan-button" )
			.click(function() {
				$( "#pesan-form" ).dialog( "open" );
		});
		
	});
</script>