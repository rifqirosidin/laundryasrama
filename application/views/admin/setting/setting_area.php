<div id="area-form" title="Master Area">
	<form name="set_area" action="<?php echo $set_area; ?>" method="post">
		<?php echo ! empty($tabelArea) ? $tabelArea : ''; ?>
		<div class="cleared"></div><br/>
		<div class="list-ui">TAMBAH MASTER AREA</div>
		<table width="100%" style="font-weight:bold;padding-top:10px;">
			<tr>
				<td width="20%" style="padding-left:10px;">Kode</td>
				<td><input type="text" name="kode_area" id="kode_area" size="3" maxlength="3"/></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">Nama</td>
				<td><input type="text" name="nama_area" id="nama_area" size="20"/></td>
			</tr>
			<tr>
				<td style="padding-left:10px;">Kota</td>
				<td>
					<select id="areazona" name="zona">
						<option value="">Pilih Zona</option>
				<?php foreach ($dbzona->result() as $zo) : ?>
						<option value="<?php echo $zo->id_zona; ?>"><?php echo $zo->zona_name; ?></option>
				<?php endforeach; ?>
					</select>
					<select id="areacity" name="city_id">
						<option value="">Pilih Kota</option>
				<?php foreach ($dbcity->result() as $ct) : ?>
						<option value="<?php echo $ct->id_city; ?>" class="<?php echo $ct->id_zona; ?>"><?php echo $ct->city_name; ?></option>
				<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nkode = $( "#kode_area" ),
			allFields = $( [] ).add( nkode ),
			tips = $( ".validateTips" );
		var nnama = $( "#nama_area" ),
			allFields = $( [] ).add( nkode ),
			tips = $( ".validateTips" );
		var ncity = $( "#areacity" ),
			allFields = $( [] ).add( nkode ),
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
		
		$( "#area-form" ).dialog({
			autoOpen: false,
			height: 435,
			width: 650,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( nkode, "Kode Area" ) && checkRequired( nnama, "Nama Area" ) && checkRequired( ncity, "Kota Area" );

					if ( bValid ) {
						document.set_area.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-area" )
			.click(function() {
				$( "#area-form" ).dialog( "open" );
		});
		
	});
</script>