<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#uiTable').dataTable({
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered ){
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ){
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		},
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 0 ] }
		],
		"aaSorting": [[ 1, 'asc' ]]
	});
} );
</script>

<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							<fieldset><legend>LAYANAN</legend>
							<form name="laundry_form" method="post" action="<?php echo $layan_ubah; ?>" accept-charset="utf-8" onSubmit="notEmpty();">
								<?php echo $link; ?> &nbsp; &nbsp; <a id="add-layanan" class="add">Tambah Layanan</a> &nbsp; &nbsp; <a id="add-jenis" class="add">Jenis Pakaian</a><br/><br/>
								<table style="text-align:center;" width="65%" class="form-admin">
									<tr style="border-bottom:solid 1px;">
										<th width="12%">KODE</th>
										<th>NAMA LAYANAN</th>
										<th width="10%">JENIS</th>
										<th width="15%">PROSES</th>
										<th width="15%">HARGA</th>
									</tr>
									<tr>
										<td colspan="4"></td>
									</tr>
						<?php $i=0; foreach($dbKilo->result() as $lon){ ?>
									<tr>
										<td><b><?php echo $lon->kode_laundry; ?></b></td>
										<td><input type="text" name="nama<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->nama_laundry; ?>" size="40" id="nama<?php echo $lon->id_laundry; ?>"/></td>
										<td>
											<select name="jenis<?php echo $lon->id_laundry; ?>">
												<option value="Kiloan" <?php if("Kiloan" == $lon->jenis) { ?> selected <?php } ?> >Kiloan</option>
												<option value="Non" <?php if("Non" == $lon->jenis) { ?> selected <?php } ?> >Non Kiloan</option>
												<option value="Satuan" <?php if("Satuan" == $lon->jenis) { ?> selected <?php } ?> >Satuan</option>
												<option value="Extra" <?php if("Extra" == $lon->jenis) { ?> selected <?php } ?> >Extra</option>
												<option value="Deposit" <?php if("Deposit" == $lon->jenis) { ?> selected <?php } ?> >Deposit</option>
												<option value="Masa" <?php if("Masa" == $lon->jenis) { ?> selected <?php } ?> >Masa Aktif</option>
											</select>
										</td>
										<td>
											<select name="proses<?php echo $lon->id_laundry; ?>">
												<option value="+2 days" <?php if("+2 days" == $lon->proses) { ?> selected <?php } ?> >2 Hari</option>
												<option value="+1 days" <?php if("+1 days" == $lon->proses) { ?> selected <?php } ?> >1 Hari</option>
												<option value="+12 hours" <?php if("+12 hours" == $lon->proses) { ?> selected <?php } ?> >12 Jam</option>
												<option value="+4 hours" <?php if("+4 hours" == $lon->proses) { ?> selected <?php } ?> >4 Jam</option>
												<option value="-" <?php if("-" == $lon->proses) { ?> selected <?php } ?> >-</option>
											</select>
										</td>
										<td><input type="text" name="harga<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->harga_laundry; ?>" size="10" style="text-align:right;"/></td>
									</tr>
						<?php $i++; } ?>
						<?php $i=0; foreach($dbNon->result() as $lon){ ?>
									<tr>
										<td><b><?php echo $lon->kode_laundry; ?></b></td>
										<td><input type="text" name="nama<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->nama_laundry; ?>" size="40" id="nama<?php echo $lon->id_laundry; ?>"/></td>
										<td>
											<select name="jenis<?php echo $lon->id_laundry; ?>">
												<option value="Kiloan" <?php if("Kiloan" == $lon->jenis) { ?> selected <?php } ?> >Kiloan</option>
												<option value="Non" <?php if("Non" == $lon->jenis) { ?> selected <?php } ?> >Non Kiloan</option>
												<option value="Satuan" <?php if("Satuan" == $lon->jenis) { ?> selected <?php } ?> >Satuan</option>
												<option value="Extra" <?php if("Extra" == $lon->jenis) { ?> selected <?php } ?> >Extra</option>
												<option value="Deposit" <?php if("Deposit" == $lon->jenis) { ?> selected <?php } ?> >Deposit</option>
												<option value="Masa" <?php if("Masa" == $lon->jenis) { ?> selected <?php } ?> >Masa Aktif</option>
											</select>
										</td>
										<td>
											<select name="proses<?php echo $lon->id_laundry; ?>">
												<option value="+2 days" <?php if("+2 days" == $lon->proses) { ?> selected <?php } ?> >2 Hari</option>
												<option value="+1 days" <?php if("+1 days" == $lon->proses) { ?> selected <?php } ?> >1 Hari</option>
												<option value="+12 hours" <?php if("+12 hours" == $lon->proses) { ?> selected <?php } ?> >12 Jam</option>
												<option value="+4 hours" <?php if("+4 hours" == $lon->proses) { ?> selected <?php } ?> >4 Jam</option>
												<option value="-" <?php if("-" == $lon->proses) { ?> selected <?php } ?> >-</option>
											</select>
										</td>
										<td><input type="text" name="harga<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->harga_laundry; ?>" size="10" style="text-align:right;"/></td>
									</tr>
						<?php $i++; } ?>
						<?php $i=0; foreach($dbSatu->result() as $lon){ ?>
									<tr>
										<td><b><?php echo $lon->kode_laundry; ?></b></td>
										<td><input type="text" name="nama<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->nama_laundry; ?>" size="40" id="nama<?php echo $lon->id_laundry; ?>"/></td>
										<td>
											<select name="jenis<?php echo $lon->id_laundry; ?>">
												<option value="Kiloan" <?php if("Kiloan" == $lon->jenis) { ?> selected <?php } ?> >Kiloan</option>
												<option value="Non" <?php if("Non" == $lon->jenis) { ?> selected <?php } ?> >Non Kiloan</option>
												<option value="Satuan" <?php if("Satuan" == $lon->jenis) { ?> selected <?php } ?> >Satuan</option>
												<option value="Extra" <?php if("Extra" == $lon->jenis) { ?> selected <?php } ?> >Extra</option>
												<option value="Deposit" <?php if("Deposit" == $lon->jenis) { ?> selected <?php } ?> >Deposit</option>
												<option value="Masa" <?php if("Masa" == $lon->jenis) { ?> selected <?php } ?> >Masa Aktif</option>
											</select>
										</td>
										<td>
											<select name="proses<?php echo $lon->id_laundry; ?>">
												<option value="+2 days" <?php if("+2 days" == $lon->proses) { ?> selected <?php } ?> >2 Hari</option>
												<option value="+1 days" <?php if("+1 days" == $lon->proses) { ?> selected <?php } ?> >1 Hari</option>
												<option value="+12 hours" <?php if("+12 hours" == $lon->proses) { ?> selected <?php } ?> >12 Jam</option>
												<option value="+4 hours" <?php if("+4 hours" == $lon->proses) { ?> selected <?php } ?> >4 Jam</option>
												<option value="-" <?php if("-" == $lon->proses) { ?> selected <?php } ?> >-</option>
											</select>
										</td>
										<td><input type="text" name="harga<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->harga_laundry; ?>" size="10" style="text-align:right;"/></td>
									</tr>
						<?php $i++; } ?>
						<?php $i=0; foreach($dbEx->result() as $lon){ ?>
									<tr>
										<td><b><?php echo $lon->kode_laundry; ?></b></td>
										<td><input type="text" name="nama<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->nama_laundry; ?>" size="40" id="nama<?php echo $lon->id_laundry; ?>"/></td>
										<td>
											<select name="jenis<?php echo $lon->id_laundry; ?>">
												<option value="Kiloan" <?php if("Kiloan" == $lon->jenis) { ?> selected <?php } ?> >Kiloan</option>
												<option value="Non" <?php if("Non" == $lon->jenis) { ?> selected <?php } ?> >Non Kiloan</option>
												<option value="Satuan" <?php if("Satuan" == $lon->jenis) { ?> selected <?php } ?> >Satuan</option>
												<option value="Extra" <?php if("Extra" == $lon->jenis) { ?> selected <?php } ?> >Extra</option>
												<option value="Deposit" <?php if("Deposit" == $lon->jenis) { ?> selected <?php } ?> >Deposit</option>
												<option value="Masa" <?php if("Masa" == $lon->jenis) { ?> selected <?php } ?> >Masa Aktif</option>
											</select>
										</td>
										<td>
											<select name="proses<?php echo $lon->id_laundry; ?>">
												<option value="+2 days" <?php if("+2 days" == $lon->proses) { ?> selected <?php } ?> >2 Hari</option>
												<option value="+1 days" <?php if("+1 days" == $lon->proses) { ?> selected <?php } ?> >1 Hari</option>
												<option value="+12 hours" <?php if("+12 hours" == $lon->proses) { ?> selected <?php } ?> >12 Jam</option>
												<option value="+4 hours" <?php if("+4 hours" == $lon->proses) { ?> selected <?php } ?> >4 Jam</option>
												<option value="-" <?php if("-" == $lon->proses) { ?> selected <?php } ?> >-</option>
											</select>
										</td>
										<td><input type="text" name="harga<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->harga_laundry; ?>" size="10" style="text-align:right;"/></td>
									</tr>
						<?php $i++; } ?>
						<?php $i=0; foreach($dbDepo->result() as $lon){ ?>
									<tr>
										<td><b><?php echo $lon->kode_laundry; ?></b></td>
										<td><input type="text" name="nama<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->nama_laundry; ?>" size="40" id="nama<?php echo $lon->id_laundry; ?>"/></td>
										<td>
											<select name="jenis<?php echo $lon->id_laundry; ?>">
												<option value="Kiloan" <?php if("Kiloan" == $lon->jenis) { ?> selected <?php } ?> >Kiloan</option>
												<option value="Non" <?php if("Non" == $lon->jenis) { ?> selected <?php } ?> >Non Kiloan</option>
												<option value="Satuan" <?php if("Satuan" == $lon->jenis) { ?> selected <?php } ?> >Satuan</option>
												<option value="Extra" <?php if("Extra" == $lon->jenis) { ?> selected <?php } ?> >Extra</option>
												<option value="Deposit" <?php if("Deposit" == $lon->jenis) { ?> selected <?php } ?> >Deposit</option>
												<option value="Masa" <?php if("Masa" == $lon->jenis) { ?> selected <?php } ?> >Masa Aktif</option>
											</select>
										</td>
										<td>
											<select name="proses<?php echo $lon->id_laundry; ?>">
												<option value="+2 days" <?php if("+2 days" == $lon->proses) { ?> selected <?php } ?> >2 Hari</option>
												<option value="+1 days" <?php if("+1 days" == $lon->proses) { ?> selected <?php } ?> >1 Hari</option>
												<option value="+12 hours" <?php if("+12 hours" == $lon->proses) { ?> selected <?php } ?> >12 Jam</option>
												<option value="+4 hours" <?php if("+4 hours" == $lon->proses) { ?> selected <?php } ?> >4 Jam</option>
												<option value="-" <?php if("-" == $lon->proses) { ?> selected <?php } ?> >-</option>
											</select>
										</td>
										<td><input type="text" name="harga<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->harga_laundry; ?>" size="10" style="text-align:right;"/></td>
									</tr>
						<?php $i++; } ?>
						<?php $i=0; foreach($dbMasa->result() as $lon){ ?>
									<tr>
										<td><b><?php echo $lon->kode_laundry; ?></b></td>
										<td><input type="text" name="nama<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->nama_laundry; ?>" size="40" id="nama<?php echo $lon->id_laundry; ?>"/></td>
										<td>
											<select name="jenis<?php echo $lon->id_laundry; ?>">
												<option value="Kiloan" <?php if("Kiloan" == $lon->jenis) { ?> selected <?php } ?> >Kiloan</option>
												<option value="Non" <?php if("Non" == $lon->jenis) { ?> selected <?php } ?> >Non Kiloan</option>
												<option value="Satuan" <?php if("Satuan" == $lon->jenis) { ?> selected <?php } ?> >Satuan</option>
												<option value="Extra" <?php if("Extra" == $lon->jenis) { ?> selected <?php } ?> >Extra</option>
												<option value="Deposit" <?php if("Deposit" == $lon->jenis) { ?> selected <?php } ?> >Deposit</option>
												<option value="Masa" <?php if("Masa" == $lon->jenis) { ?> selected <?php } ?> >Masa Aktif</option>
											</select>
										</td>
										<td>
											<select name="proses<?php echo $lon->id_laundry; ?>">
												<option value="+2 days" <?php if("+2 days" == $lon->proses) { ?> selected <?php } ?> >2 Hari</option>
												<option value="+1 days" <?php if("+1 days" == $lon->proses) { ?> selected <?php } ?> >1 Hari</option>
												<option value="+12 hours" <?php if("+12 hours" == $lon->proses) { ?> selected <?php } ?> >12 Jam</option>
												<option value="+4 hours" <?php if("+4 hours" == $lon->proses) { ?> selected <?php } ?> >4 Jam</option>
												<option value="-" <?php if("-" == $lon->proses) { ?> selected <?php } ?> >-</option>
											</select>
										</td>
										<td><input type="text" name="harga<?php echo $lon->id_laundry; ?>" value="<?php echo $lon->harga_laundry; ?>" size="10" style="text-align:right;"/></td>
									</tr>
						<?php $i++; } ?>
								</table>
								<table width="100%">
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.laundry_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
							<?php $this->load->view('admin/setting/layanan_form'); ?>
							<?php $this->load->view('admin/setting/cloth_jenis'); ?>
							</fieldset>
						
				<!-- AKHIR KONTEN -->
							<div class="cleared"></div>
						</div>
						<div class="cleared"></div>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
		</div>
	</div>
</div>
<div class="cleared"></div>
<script type='text/javascript'>
	function notEmpty(){
		if(
	<?php $j=1; foreach($dbLaundry->result() as $xlon){
			if($j == $i){ ?>
				document.getElementById('nama<?php echo $xlon->id_laundry; ?>').value.length == 0
		<?php }else{ ?>
				document.getElementById('nama<?php echo $xlon->id_laundry; ?>').value.length == 0 || 
	<?php } $j++; } ?>
		){
			alert("Nama Layanan tidak boleh kosong.");
			return false;
		}
		return true;
	}
</script>