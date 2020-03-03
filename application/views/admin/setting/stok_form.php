<div id="stok-form" title="Tambah Stok Gudang">
	<form name="stok_form" method="post" action="<?php echo $form_stok; ?>" >
		<table width='100%' style="font-weight:bold;" >
			<tr>
				<td width='35%'>Jenis Stok</td>
				<td>
					<select  id="jenis" name="jenis">
						<option value="">Pilih Jenis Stok</option>
				<?php foreach ($dbStok as $row){ ?>
						<option value="<?php echo $row->id_mstock; ?>" >
							<?php echo $row->nama_stock; ?>
						</option>
				<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Jumlah</td>
				<td>
					<input type="text" name="stok" size="3" value="<?php echo set_value('stok', isset($default['stok']) ? $default['stok'] : ''); ?>" /> Kg
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
		
		$( "#stok-form" ).dialog({
			autoOpen: false,
			height: 160,
			width: 320,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( ajenis, "Jenis Inventori" );

					if ( bValid ) {
						document.stok_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-stok" )
			.click(function() {
				$( "#stok-form" ).dialog( "open" );
		});
		
	});
</script>