<div id="aset-form" title="Tambah Aset">
	<form name="aset_form" method="post" action="<?php echo $form_aset; ?>" >
		<table width='100%' style="font-weight:bold;" >
			<tr>
				<td width='35%'>Jenis Aset</td>
				<td>
					<select  id="jenis" name="jenis">
						<option value="">Pilih Jenis Aset</option>
				<?php foreach ($dbAset as $row){ ?>
						<option value="<?php echo $row->kode_jenis; ?>" >
							<?php echo $row->nama_jenis; ?>
						</option>
				<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Jumlah</td>
				<td>
					<input type="text" name="jum" size="3" value="<?php echo set_value('jum', isset($default['jum']) ? $default['jum'] : ''); ?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var ajenis = $( "#jenis" ),
			allFields = $( [] ).add( ajenis ),
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
		
		$( "#aset-form" ).dialog({
			autoOpen: false,
			height: 160,
			width: 320,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( ajenis, "Jenis Aset" );

					if ( bValid ) {
						document.aset_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-aset" )
			.click(function() {
				$( "#aset-form" ).dialog( "open" );
		});
		
	});
</script>