<form name="msatu_form" action="<?php echo $member_satu; ?>" method="post">
<div class="total" style="float:right;margin-top:-125px;margin-right:-15px;">
	<table style="width:350px;">
		<tr>
			<td style="text-align:right;">
				TOTAL &nbsp; Rp <input type="text" name="totalHarga" size="10" readonly />
			</td>
		</tr>
	</table>
</div>
<script>
	function startmnCalc(){
		intmn = setInterval("mncalc()",1);
	}
	function mncalc(){
		<?php $j=0; foreach($dbSatu as $row){
			echo "mnhsatu" . $j . " = (document.msatu_form.hsatu" . $j . ".value * 1) * (document.msatu_form.jum" . $j . ".value * 1); \n";
			$j++;
		} ?>
		
		mnlayan = document.msatu_form.laundry.value.substring(3);
		
		<?php $x=0; foreach($dbExtra as $row){
			echo "mnextra" . $x . " = (document.msatu_form.harga" . $x . ".value * 1) * (document.msatu_form.jex" . $x . ".value * 1); \n";
			$x++;
		} ?>
		
		document.msatu_form.totalHarga.value = ((
		<?php $i=1; foreach($dbSatu as $row){
			if($i == $j)
				echo "mnhsatu" . ($i-1);
			else
				echo "mnhsatu" . ($i-1) . " + ";
			$i++;
		} ?>
		) * (mnlayan * 1)) + 
		<?php $i=1; foreach($dbExtra as $row){
			if($i == $x)
				echo "mnextra" . ($i-1) . ";\n";
			else
				echo "mnextra" . ($i-1) . " + ";
			$i++;
		} ?>
		mnCommas(document.msatu_form.totalHarga.value);
	}
	function stopmnCalc(){
		clearInterval(intmn);
	}
	function mnCommas(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? ',' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		document.msatu_form.totalHarga.value = x1 + x2;
	}
</script>
	<table width="50%" style="float:left;">
		<tr>
			<td width="25%">Member ID</td>
			<td>
				<input type="text" name="id" id="mid" value="<?php echo set_value('id', isset($default['id']) ? $default['id'] : ''); ?>" size="20" onkeyup="showMem('member',this.value)" readonly />
			</td>
		</tr>
	</table>
	<table width="50%" style="float:left;">
		<tr>
			<td width="25%">Nama</td>
			<td>
				<input type="text" name="cust" value="<?php echo set_value('cust', isset($default['cust']) ? $default['cust'] : ''); ?>" size="40" id="member" onkeypress="showCust('nmem','member',this.value,<?php echo $this->session->userdata('id'); ?>)" />
			</td>
		</tr>
	</table>
<div id="nmem">
	<table width="50%" style="float:left;">
		<tr>
			<td width="25%">Alamat</td>
			<td>
				<textarea name="alamat" cols="40" rows="3" readonly ></textarea>
			</td>
		</tr>
		<tr>
			<td>No. HP</td>
			<td>
				<input type="text" name="nohp" size="20" value="" readonly />
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</div>
	<table width="50%" style="float:left;" class="listsatu">
		<tr>
			<th>Cucian</th>
			<th>Harga</th>
			<th width="15%">Jumlah</th>
		</tr>
	<?php $i=0; foreach($dbSatu as $row){ ?>
		<tr>
			<td style="text-align:left;"><input type="hidden" name="cuci<?php echo $i; ?>" value="<?php echo $row->kode_laundry; ?>"/><?php echo $row->nama_laundry; ?></td>
			<td style="text-align:right;">
				<input type="text" name="hsatu<?php echo $i; ?>" size="6" class="harga" value="<?php echo $row->harga_laundry; ?>" style="text-align:right;" disabled />
			</td>
			<td><input type="text" name="jum<?php echo $i; ?>" size="2" maxlength="2" style="text-align:right;" onFocus="startmnCalc();" onBlur="stopmnCalc();"/></td>
		</tr>
	<?php $i++; } ?>
	</table>
	<table width="50%">
		<tr>
			<td width="25%" style="padding-left:15px;">Layanan</td>
			<td>
				<input type="hidden" name="kiloan" value="<?php echo $i; ?>"/>
				<select name="laundry">
					<option value="">Pilih Layanan</option>
		<?php foreach($dbLaundry as $row){
				if ($row->kode_laundry == set_value('laundry', isset($default['laundry']) ? $default['laundry'] : '')) {?>
					<option value="<?php echo $row->kode_laundry . $row->harga_laundry; ?>" selected ><?php echo $row->nama_laundry; ?></option>
				<?php } else { ?>
					<option value="<?php echo $row->kode_laundry . $row->harga_laundry; ?>" ><?php echo $row->nama_laundry; ?></option>
			<?php }} ?>
				</select>
				<select name="pewangi">
		<?php foreach($dbPewangi as $row){ 
				if ($row->kode_pewangi == set_value('pewangi', isset($default['pewangi']) ? $default['pewangi'] : '')) {?>
					<option value="<?php echo $row->kode_pewangi; ?>" selected ><?php echo $row->nama_pewangi; ?></option>
				<?php } else { ?>
					<option value="<?php echo $row->kode_pewangi; ?>"><?php echo $row->nama_pewangi; ?></option>
			<?php }} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td style="vertical-align:top;padding-left:15px;">Layanan Tambahan</td>
			<td>
				<table width="100%">
		<?php $i=0; foreach($dbExtra as $row){ ?>
					<tr>
						<td width="40%"><input type="hidden" name="extra<?php echo $i; ?>" value="<?php echo $row->kode_laundry; ?>" /><?php echo $row->nama_laundry; ?></td>
						<td style="font-weight:bold;">
							@ <input type="text" name="harga<?php echo $i; ?>" size="6" class="harga" value="<?php echo $row->harga_laundry; ?>" disabled /> 
							<input type="text" name="jex<?php echo $i; ?>" size="2" maxlength="2" style="text-align:right;" onFocus="startmnCalc();" onBlur="stopmnCalc();"/>
						</td>
					</tr>
		<?php $i++; } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td style="padding-left:15px;">Catatan</td>
			<td>
				<input type="hidden" name="tambahan" value="<?php echo $i; ?>"/>
				<textarea name="cat" cols="40" rows="3"><?php echo set_value('cat', isset($default['cat']) ? $default['cat'] : ''); ?></textarea>
			</td>
		</tr>
		<tr>
			<td style="padding-left:15px;">Metode Bayar</td>
			<td>
				<select name="metode" id="metode" onChange="tampilBayar(this.value,'depe2','kartu2')" >
					<option value="1">Tunai</option>
					<option value="2">Debit/Kredit</option>
					<option value="3">Akhir / DP</option>
				</select>
				<input type="text" name="depe" id="depe2" value="<?php echo set_value('depe', isset($default['depe']) ? $default['depe'] : ''); ?>" size="20" style="display:none;text-align:right;"/>
				<div id="kartu2" style="display:none;" >
					<select name="bank" >
						<option value="BCA">BCA</option>
						<option value="BNI">BNI</option>
						<option value="BRI">BRI</option>
						<option value="Mandiri">Mandiri</option>
					</select>
					<input type="text" name="kartu" value="<?php echo set_value('kartu', isset($default['kartu']) ? $default['kartu'] : ''); ?>" size="15"/>
				</div>
			</td>
		</tr>
		<tr>
			<td style="padding-left:15px;">Kode Promosi</td>
			<td>
				<input type="text" name="promo" value="<?php echo set_value('promo', isset($default['promo']) ? $default['promo'] : ''); ?>" size="30"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="25%" style="padding-left:15px;">ID Pegawai</td>
			<td>
				<input type="password" name="nip" size="10" />
			</td>
		</tr>
	</table><div class="cleared"></div><br/>
	<table width="100%">
		<tr>
			<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
			<td style="text-align:right;"><a class="tombol" href="javascript:document.msatu_form.submit()">Simpan</a></td>
		</tr>
	</table>
</form>