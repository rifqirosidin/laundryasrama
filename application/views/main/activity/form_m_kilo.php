<form name="mkilo_form" action="<?php echo $member_kilo; ?>" method="post">
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
	function startmkCalc(){
		intmk = setInterval("mkcalc()",1);
	}
	function mkcalc(){
		mkkilo  = document.mkilo_form.kiloan.value;
		mklayan = document.mkilo_form.laundry.value.substring(3);
		
		<?php $x=0; foreach($dbExtra as $row){
			echo "mkextra" . $x . " = (document.mkilo_form.harga" . $x . ".value * 1) * (document.mkilo_form.jex" . $x . ".value * 1); \n";
			$x++;
		} ?>
		
		document.mkilo_form.totalHarga.value = ((mklayan * 1) * (mkkilo * 1)) + 
		<?php $i = 1; foreach($dbExtra as $row){
			if($i == $x)
				echo "mkextra" . ($i-1) . ";\n";
			else
				echo "mkextra" . ($i-1) . " + ";
			$i++;
		} ?>
		mkCommas(document.mkilo_form.totalHarga.value);
	}
	function stopmkCalc(){
		clearInterval(intmk);
	}
	function mkCommas(nStr){
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? ',' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		document.mkilo_form.totalHarga.value = x1 + x2;
	}
</script>
	<table width="50%" style="float:left;">
		<tr>
			<td width="25%">Member ID</td>
			<td>
				<input type="text" name="id" id="idm" value="<?php echo set_value('id', isset($default['id']) ? $default['id'] : ''); ?>" size="20" onkeyup="showMem('kmember',this.value)" readonly />
			</td>
		</tr>
	</table>
	<table width="50%" style="float:left;">
		<tr>
			<td width="25%">Nama</td>
			<td>
				<input type="text" name="cust" value="<?php echo set_value('cust', isset($default['cust']) ? $default['cust'] : ''); ?>" size="40" id="kmember" onkeypress="showCust('knmem','kmember',this.value,<?php echo $this->session->userdata('id'); ?>)" autofocus />
			</td>
		</tr>
	</table>
<div id="knmem">
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
	<table width="50%">
		<tr>
			<td width="25%">Layanan</td>
			<td>
				<select name="laundry">
					<option value="">Pilih Layanan</option>
		<?php foreach($dbKilo as $row){ 
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
			<td>Jumlah Cucian</td>
			<td>
				<input type="text" name="kiloan" size="5" value="<?php echo set_value('kiloan', isset($default['kiloan']) ? $default['kiloan'] : ''); ?>" maxlength="4" onFocus="startmkCalc();" onBlur="stopmkCalc();" style="text-align:right;" /> Kg
			</td>
		</tr>
		<tr>
			<td style="vertical-align:top;">Layanan Tambahan</td>
			<td>
				<table width="100%">
		<?php $i=0; foreach($dbExtra as $row){ ?>
					<tr>
						<td width="40%"><input type="hidden" name="extra<?php echo $i; ?>" value="<?php echo $row->kode_laundry; ?>" /><?php echo $row->nama_laundry; ?></td>
						<td style="font-weight:bold;">
							@ <input type="text" name="harga<?php echo $i; ?>" size="6" class="harga" value="<?php echo $row->harga_laundry; ?>" disabled /> 
							<input type="text" name="jex<?php echo $i; ?>" size="2" maxlength="2" style="text-align:right;" onFocus="startmkCalc();" onBlur="stopmkCalc();"/>
						</td>
					</tr>
		<?php $i++; } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td>Catatan</td>
			<td>
				<input type="hidden" name="tambahan" value="<?php echo $i; ?>"/>
				<textarea name="cat" cols="40" rows="3"><?php echo set_value('cat', isset($default['cat']) ? $default['cat'] : ''); ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="25%">ID Pegawai</td>
			<td>
				<input type="password" name="nip" size="10" />
			</td>
		</tr>
	</table><div class="cleared"></div><br/>
	<table width="100%">
		<tr>
			<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
			<td style="text-align:right;"><a class="tombol" href="javascript:document.mkilo_form.submit()">Simpan</a></td>
		</tr>
	</table>
</form>