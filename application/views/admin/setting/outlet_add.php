<div id="out-form" title="Daftar Outlet">
	<form name="out_form" method="post" action="<?php echo $add_out; ?>" >
		<table width='100%' style="font-weight:bold;" >
			<tr>
				<td>Kode Outlet</td>
				<td><input type="text" id="newcode" name="code" size="5" maxlength="5" style="text-transform:uppercase" /></td>
			</tr>
			<tr>
				<td width='35%'>Nama Outlet*</td>
				<td><input type="text" id="newname" name="name" size="40"/></td>
			</tr>
			<tr>
				<td>Area*</td>
				<td>
					<select id="newzona" name="zona">
	<?php foreach ($dbzona->result() as $zo){ ?><option value="<?php echo $zo->id_zona; ?>"><?php echo $zo->zona_name; ?></option><?php } ?>
					</select>
					<select id="newcity" name="city">
	<?php foreach ($dbcity->result() as $ct){ ?><option value="<?php echo $ct->id_city; ?>" class="<?php echo $ct->id_zona; ?>"><?php echo $ct->city_name; ?></option><?php } ?>
					</select>
					<select id="newarea" name="area">
	<?php foreach ($dbarea->result() as $row){ ?><option value="<?php echo $row->area_code; ?>" class="<?php echo $row->id_city; ?>"><?php echo $row->area_name; ?></option><?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td style='vertical-align:top'>Alamat</td>
				<td><textarea name='address' rows='3' cols='40'></textarea></td>
			</tr>
			<tr>
				<td>No. Tlp</td>
				<td><input type="text" name="phone" size="20"/></td>
			</tr>
			<tr>
				<td>Jenis Member*</td>
				<td>
					<select id="newjmember" name="jmember">
						<option value="Kiloan">Member Bulanan (Kiloan)</option>
						<option value="Rupiah">Member Voucher (Rupiah)</option>
						<option value="Asrut">Member Asrama Untel</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style='vertical-align:top'>Resi Footer</td>
				<td><textarea name='foot' rows='3' cols='40'></textarea></td>
			</tr>
			<tr>
				<td>Username*</td>
				<td><input type="text" id="newusername" name="username" size="15"/></td>
			</tr>
			<tr>
				<td>Password*</td>
				<td><input type="password" id="newpass" name="pass" size="20" /></td>
			</tr>
			<tr>
				<td>Re-Type*</td>
				<td><input type="password" id="newrepass" name="repass" size="20" /></td>
			</tr>
		</table>
	</form>
</div>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var newname = $( "#newname" ),
			allFields = $( [] ).add( newname ),
			tips = $( ".validateTips" );
		var newcode = $( "#newcode" ),
			allFields = $( [] ).add( newcode ),
			tips = $( ".validateTips" );
		var newarea = $( "#newarea" ),
			allFields = $( [] ).add( newarea ),
			tips = $( ".validateTips" );
		var newjmember = $( "#newjmember" ),
			allFields = $( [] ).add( newjmember ),
			tips = $( ".validateTips" );
		var newusername = $( "#newusername" ),
			allFields = $( [] ).add( newusername ),
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
		
		$( "#out-form" ).dialog({
			autoOpen: false,
			height: 490,
			width: 570,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( newname, "Nama" ) && checkRequired( newcode, "Kode" ) && checkRequired( newarea, "Area" ) && checkRequired( newjmember, "Jenis" ) && checkRequired( newusername, "Username" ) && checkRequired( newpass, "Password" ) && checkRequired( newrepass, "Re-Password" );

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

		$( "#add-out" )
			.click(function() {
				$( "#out-form" ).dialog( "open" );
		});
		
	});
</script>