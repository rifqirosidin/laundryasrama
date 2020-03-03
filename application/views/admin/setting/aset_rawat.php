<div id="rawat-form" title="Jenis Perawatan Aset">
	<form name="aset_rawat" action="<?php echo $aset_rawat; ?>" method="post">
		<?php echo ! empty($table_aset_rawat) ? $table_aset_rawat : ''; ?>
		<div class="cleared"></div><br/>
		<div class="list-ui">TAMBAH JENIS PERAWATAN ASET</div>
		<table width="100%" style="font-weight:bold;padding-top:10px;">
			<tr>
				<td width='20%' style="padding-left:10px;">Jenis Aset</td>
				<td>
					<select  id="jenis" name="jenis">
				<?php foreach ($dbAset as $row){ ?>
						<option value="<?php echo $row->kode_jenis; ?>" >
							<?php echo $row->nama_jenis; ?>
						</option>
				<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">Perawatan</td>
				<td><input type="text" name="rawat" id="rawat" size="45"/></td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nrawat = $( "#rawat" ),
			allFields = $( [] ).add( nrawat ),
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
		
		$( "#rawat-form" ).dialog({
			autoOpen: false,
			height: 425,
			width: 700,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( nrawat, "Perawatan" );

					if ( bValid ) {
						document.aset_rawat.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-rawat" )
			.click(function() {
				$( "#rawat-form" ).dialog( "open" );
		});
		
	});
</script>