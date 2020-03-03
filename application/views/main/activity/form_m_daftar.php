	<script>
		$(function() {
			$( "#datepicker" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		});
	</script>

	<div id="daftar-member" title="Daftar Member Baru">
		<form name="member_action" method="post" action="<?php echo $member_action; ?>" accept-charset="utf-8">
			<table width='100%'>
				<tr>
					<td width='30%'>Nama*</td>
					<td><input type="text" name="namabaru" id="namamember" size="30"/></td>
				</tr>
				<tr>
					<td style='vertical-align:top'>Alamat</td>
					<td><textarea name='alamatbaru' rows='3' cols='35'></textarea></td>
				</tr>
				<tr>
					<td>Area*</td>
					<td>
						<select name="areabaru">
				<?php foreach ($dbarea->result() as $row){ ?>
							<option value="<?php echo $row->id_area; ?>">
								<?php echo $row->area_name; ?>
							</option>
				<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>No. HP*</td>
					<td><input type="text" name="nohpbaru" id="nohpbaru" size="20"/></td>
				</tr>
				<tr>
					<td>Tempat Lahir</td>
					<td><input type="text" name="tmptbaru" size="30"/></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td><input type="text" name="tglbaru" size="10" id='datepicker'/></td>
				</tr>
				<tr>
					<td>Agama</td>
					<td>
						<select name="agamabaru">
							<option value="Buddha">Buddha</option>
							<option value="Hindu">Hindu</option>
							<option value="Islam">Islam</option>
							<option value="Kristen Katolik">Kristen Katolik</option>
							<option value="Kristen Protestan">Kristen Protestan</option>
							<option value="Lainnya">Lainnya</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Jenis Member</td>
					<td>
						<input type="hidden" name="jenisbaru" value="<?php echo $jmember->jmember; ?>"/>
			<?php if($jmember->jmember == "Asrut"){?>
						<select name="deposit" >
				<?php foreach ($dbMasa as $row){ ?>
							<option value="<?php echo $row->kode_laundry . $row->id_laundry; ?>"><?php echo substr($row->nama_laundry,11); ?></option>
				<?php } ?>
						</select>
			<?php }else{?>
						<b><?php echo $jmember->jmember; ?></b>
			<?php }?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>ID Pegawai*</td>
					<td>
						<input type="password" name="nip" size="10" id="nip5" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<script>
		$(function() {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			var namamember = $( "#namamember" ),
				allFields = $( [] ).add( namamember ),
				tips = $( ".validateTips" );
			var nohpmember = $( "#nohpbaru" ),
				allFields = $( [] ).add( nohpmember ),
				tips = $( ".validateTips" );
			var nip5 = $( "#nip5" ),
				allFields = $( [] ).add( nip5 ),
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
			
			$( "#daftar-member" ).dialog({
				autoOpen: false,
				height: 425,
				width: 515,
				modal: true,
				buttons: {
					"Simpan": function() {
						var bValid = true;
						allFields.removeClass( "ui-state-error" );

						bValid = bValid && checkRequired(namamember,"Nama Member") && checkRequired(nohpmember,"No. HP") && checkRequired(nip5, "ID Pegawai");

						if ( bValid ) {
							document.member_action.submit();
							$( this ).dialog( "close" );
						}
					}
				},
				close: function() {
					allFields.val( "" ).removeClass( "ui-state-error" );
				}
			});
			
			$( "#add-member" )
				.click(function() {
					$( "#daftar-member" ).dialog( "open" );
			});
			
		});
	</script>