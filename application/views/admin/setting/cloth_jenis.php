<div id="jenis-form" title="Jenis Pakaian">
	<form name="cloth_jenis" action="<?php echo $cloth_jenis; ?>" method="post">
		<?php echo ! empty($tableCloth) ? $tableCloth : ''; ?>
		<div class="cleared"></div><br/>
		<div class="list-ui">TAMBAH JENIS PAKAIAN</div>
		<table width="100%" style="font-weight:bold;padding-top:10px;">
			<tr>
				<td width="20%" style="padding-left:10px;">Jenis</td>
				<td><input type="text" name="nama_cloth" id="nama_cloth" size="20"/></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">Variabel</td>
				<td><input type="text" name="var_cloth" id="var_cloth" size="5"/></td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var ncloth = $( "#nama_cloth" ),
			allFields = $( [] ).add( ncloth ),
			tips = $( ".validateTips" );
			
		var vcloth = $( "#var_cloth" ),
			allFields = $( [] ).add( vcloth ),
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

					bValid = bValid && checkRequired( ncloth, "Jenis" ) && checkRequired( vcloth, "Variabel" );

					if ( bValid ) {
						document.cloth_jenis.submit();
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