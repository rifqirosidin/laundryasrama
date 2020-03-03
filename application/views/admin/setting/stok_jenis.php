<div id="jstok-form" title="Jenis Inventori">
	<form name="aset_jstok" action="<?php echo $stok_jenis; ?>" method="post">
		<?php echo ! empty($table_stok_jenis) ? $table_stok_jenis : ''; ?>
		<div class="cleared"></div><br/>
		<div class="list-ui">TAMBAH JENIS INVENTORI</div>
		<table width="100%" style="font-weight:bold;padding-top:10px;">
			<tr>
				<td width="20%" style="padding-left:10px;">Nama Jenis</td>
				<td><input type="text" name="nama_jstok" id="nama_jstok" size="40"/></td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var njstok = $( "#nama_jstok" ),
			allFields = $( [] ).add( njstok ),
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
		
		$( "#jstok-form" ).dialog({
			autoOpen: false,
			height: 425,
			width: 650,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( njstok, "Nama Jenis" );

					if ( bValid ) {
						document.aset_jstok.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-jstok" )
			.click(function() {
				$( "#jstok-form" ).dialog( "open" );
		});
		
	});
</script>