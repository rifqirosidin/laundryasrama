<div id="jenis-form" title="Jenis Aset">
	<form name="aset_jenis" action="<?php echo $aset_jenis; ?>" method="post">
		<?php echo ! empty($table_aset_jenis) ? $table_aset_jenis : ''; ?>
		<div class="cleared"></div><br/>
		<div class="list-ui">TAMBAH JENIS ASET</div>
		<table width="100%" style="font-weight:bold;padding-top:10px;">
			<tr>
				<td width="20%" style="padding-left:10px;">Nama Jenis</td>
				<td><input type="text" name="nama_jenis" id="nama_jenis" size="20"/></td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var njenis = $( "#nama_jenis" ),
			allFields = $( [] ).add( njenis ),
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
		
		$( "#jenis-form" ).dialog({
			autoOpen: false,
			height: 435,
			width: 650,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( njenis, "Nama Jenis" );

					if ( bValid ) {
						document.aset_jenis.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-jenis" )
			.click(function() {
				$( "#jenis-form" ).dialog( "open" );
		});
		
	});
</script>