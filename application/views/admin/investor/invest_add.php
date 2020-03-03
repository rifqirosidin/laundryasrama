<div id="inv-form" title="Daftar Investor">
	<form name="out_form" method="post" action="<?php echo $add_inv; ?>" >
		<table width='100%' style="font-weight:bold;" >
			<tr>
				<td width='23%'>Nama*</td>
				<td><input type="text" id="newname" name="name" size="40"/></td>
			</tr>
			<tr>
				<td style='vertical-align:top'>Alamat</td>
				<td><textarea name='add' rows='3' cols='40'></textarea></td>
			</tr>
			<tr>
				<td>No. Tlp*</td>
				<td><input type="text" name="pno" size="20"/></td>
			</tr>
			<tr>
				<td>Outlet*</td>
				<td>
					<select id="zona" name="zona">
						<option value="">Pilih Zona</option>
	<?php foreach ($dbzona->result() as $zo) :
		if ($zo->id_zona == set_value('zona', isset($default['zona']) ? $default['zona'] : '')) { ?>
						<option value="<?php echo $zo->id_zona; ?>" selected><?php echo $zo->zona_name; ?></option>
	<?php } else { ?>
						<option value="<?php echo $zo->id_zona; ?>"><?php echo $zo->zona_name; ?></option>
	<?php } endforeach; ?>
					</select>
					<select id="city" name="city">
						<option value="">Pilih Kota</option>
	<?php foreach ($dbcity->result() as $ct) :
		if ($ct->id_city == set_value('city', isset($default['city']) ? $default['city'] : '')) { ?>
						<option value="<?php echo $ct->id_city; ?>" class="<?php echo $ct->id_zona; ?>" selected ><?php echo $ct->city_name; ?></option>
	<?php } else { ?>
						<option value="<?php echo $ct->id_city; ?>" class="<?php echo $ct->id_zona; ?>"><?php echo $ct->city_name; ?></option>
	<?php } endforeach; ?>
					</select>
					<select id="area" name="area">
						<option value="">Pilih Area</option>
	<?php foreach ($dbarea->result() as $row) :
		if ($row->area_code == set_value('area', isset($default['area']) ? $default['area'] : '')) { ?>
						<option value="<?php echo $row->area_code; ?>" class="<?php echo $row->id_city; ?>" selected ><?php echo $row->area_name; ?></option>
	<?php } else { ?>
						<option value="<?php echo $row->area_code; ?>" class="<?php echo $row->id_city; ?>"><?php echo $row->area_name; ?></option>
	<?php } endforeach; ?>
					</select>
					<select id="newoutlet" name="outlet">
	<?php foreach ($dbout->result() as $out) :
		if ($out->outlet_id == set_value('outlet', isset($default['outlet']) ? $default['outlet'] : '')) { ?>
						<option value="<?php echo $out->outlet_id; ?>" class="<?php echo $out->area_code; ?>" selected ><?php echo $out->outlet_name; ?></option>
	<?php } else { ?>
						<option value="<?php echo $out->outlet_id; ?>" class="<?php echo $out->area_code; ?>" ><?php echo $out->outlet_name; ?></option>
	<?php } endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Username*</td>
				<td><input type="text" id="newusername" name="username" size="15"/></td>
			</tr>
			<tr>
				<td>Password*</td>
				<td><input type="password" id="newpass" name="pass" size="20" /></td>
			</tr>
		</table>
		<input type="hidden" name="pos" value="2"/>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var newname = $( "#newname" ),
			allFields = $( [] ).add( newname ),
			tips = $( ".validateTips" );
		var newoutlet = $( "#newoutlet" ),
			allFields = $( [] ).add( newoutlet ),
			tips = $( ".validateTips" );
		var newusername = $( "#newusername" ),
			allFields = $( [] ).add( newusername ),
			tips = $( ".validateTips" );
		var newphone = $( "#newphone" ),
			allFields = $( [] ).add( newphone ),
			tips = $( ".validateTips" );
		var newpass = $( "#newpass" ),
			allFields = $( [] ).add( newpass ),
			tips = $( ".validateTips" );
		var newrepass = $( "#newrepass" ),
			allFields = $( [] ).add( newrepass ),
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
		
		$( "#inv-form" ).dialog({
			autoOpen: false,
			height: 340,
			width: 700,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( newname, "Nama" ) && checkRequired( newoutlet, "Outlet" ) && checkRequired( newphone, "Phone" )  && checkRequired( newusername, "Username" ) && checkRequired( newpass, "Password" );

					if ( bValid ) {
						document.out_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-inv" )
			.click(function() {
				$( "#inv-form" ).dialog( "open" );
		});
		
	});
</script>