<div id="kilo-form" title="Beli Voucher">
	<form name="kiloan_form" action="<?php echo $deposit_action; ?>" method="post">
		<table width="100%">
			<tr>
				<td width="25%">Voucher</td>
				<td>
					<input type="hidden" name="jenis" value="Kiloan" />
					<select name="deposit" >
				<?php foreach ($dbDeposit as $row){ ?>
						<option value="<?php echo $row->id_laundry; ?>"><?php echo substr($row->kode_laundry,1,2); ?> Kg</option>
				<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Pembayaran</td>
				<td>
					<select name="metode" id="metode" onChange="tampil(this.value,'kartu1')" >
						<option value="Tunai">Tunai</option>
						<option value="Debit/Kredit">Debit/Kredit</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<div id="kartu1" style="display:none;" >
						<select name="bank" >
							<option value="BCA">BCA</option>
							<option value="BNI">BNI</option>
							<option value="BRI">BRI</option>
							<option value="Mandiri">Mandiri</option>
						</select>
						<input type="text" name="kartu" value="<?php echo set_value('kartu', isset($default['kartu']) ? $default['kartu'] : ''); ?>" size="20"/>
					</div>
				</td>
			</tr>
			<tr>
				<td>ID Pegawai</td>
				<td>
					<input type="password" name="nip" size="10" id="nip1" />
				</td>
			</tr>
		</table>
	</form>
</div>
<div id="depo-form" title="Tambah Deposit">
	<form name="deposit_form" action="<?php echo $deposit_action; ?>" method="post">
		<table width="100%">
			<tr>
				<td width="25%">Jumlah</td>
				<td>
					<input type="hidden" name="jenis" value="Rupiah" />
					<input type="text" name="deposit" id="deposit" size="20" style="text-align:right;" />
				</td>
			</tr>
			<tr>
				<td>Pembayaran</td>
				<td>
					<select name="metode" id="metode" onChange="tampil(this.value,'kartu2')" >
						<option value="Tunai">Tunai</option>
						<option value="Debit/Kredit">Debit/Kredit</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<div id="kartu2" style="display:none;" >
						<select name="bank" >
							<option value="BCA">BCA</option>
							<option value="BNI">BNI</option>
							<option value="BRI">BRI</option>
							<option value="Mandiri">Mandiri</option>
						</select>
						<input type="text" name="kartu" value="<?php echo set_value('kartu', isset($default['kartu']) ? $default['kartu'] : ''); ?>" size="20"/>
					</div>
				</td>
			</tr>
			<tr>
				<td>ID Pegawai</td>
				<td>
					<input type="password" name="nip" size="10" id="nip2" />
				</td>
			</tr>
		</table>
	</form>
</div>
<div id="asr-form" title="Tambah Masa Aktif">
	<form name="asr_form" action="<?php echo $deposit_action; ?>" method="post">
		<table width="100%">
			<tr>
				<td width="25%">Layanan</td>
				<td>
					<input type="hidden" name="jenis" value="Masa" />
					<select name="deposit" >
			<?php foreach ($dbMasa as $row){ ?>
						<option value="<?php echo $row->kode_laundry . $row->id_laundry; ?>"><?php echo substr($row->nama_laundry,11); ?></option>
			<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Pembayaran</td>
				<td>
					<select name="metode" id="metode" onChange="muncul(this.value,'kartu3')" >
						<option value="Tunai">Tunai</option>
						<option value="Debit/Kredit">Debit/Kredit</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<div id="kartu3" style="display:none;" >
						<select name="bank" >
							<option value="BCA">BCA</option>
							<option value="BNI">BNI</option>
							<option value="BRI">BRI</option>
							<option value="Mandiri">Mandiri</option>
						</select>
						<input type="text" name="kartu" value="<?php echo set_value('kartu', isset($default['kartu']) ? $default['kartu'] : ''); ?>" size="20"/>
					</div>
				</td>
			</tr>
			<tr>
				<td>ID Pegawai</td>
				<td>
					<input type="password" name="nip" size="10" id="nip3" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
<!--
    function tampil(metode,id) {
       var e = document.getElementById(id);
       if(metode == 'Debit/Kredit')
          e.style.display = 'inline';
       else
          e.style.display = 'none';
    }
//-->
</script>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nipkilo = $( "#nip1" ),
			allFields = $( [] ).add( nipkilo ),
			tips = $( ".validateTips1" );
		var nipdepo = $( "#nip2" ),
			allFields = $( [] ).add( nipdepo ),
			tips = $( ".validateTips2" );
		var jumdepo = $( "#deposit" ),
			allFields = $( [] ).add( jumdepo ),
			tips = $( ".validateTips2" );
		var nipasr = $( "#nip3" ),
			allFields = $( [] ).add( nipasr ),
			tips = $( ".validateTips3" );

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
		
		$( "#kilo-form" ).dialog({
			autoOpen: false,
			height: 210,
			width: 400,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( nipkilo, "ID Pegawai" );

					if ( bValid ) {
						document.kiloan_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-kilo" )
			.click(function() {
				$( "#kilo-form" ).dialog( "open" );
		});
		
		$( "#depo-form" ).dialog({
			autoOpen: false,
			height: 210,
			width: 400,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( jumdepo, "Jumlah Deposit" ) && checkRequired( nipdepo, "ID Pegawai" );

					if ( bValid ) {
						document.deposit_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-depo" )
			.click(function() {
				$( "#depo-form" ).dialog( "open" );
		});
		
		$( "#asr-form" ).dialog({
			autoOpen: false,
			height: 210,
			width: 400,
			modal: true,
			buttons: {
				"Simpan": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkRequired( nipasr, "ID Pegawai" );

					if ( bValid ) {
						document.asr_form.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#add-asr" )
			.click(function() {
				$( "#asr-form" ).dialog( "open" );
		});
		
	});
</script>