<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#start" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#kasTable').dataTable({
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
							
							<fieldset><legend>Pengeluaran</legend>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('item', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('jum', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<form name="kas_form" method="post" action="<?php echo $form_kas; ?>" accept-charset="utf-8">
								<table width='40%'>
									<tr>
										<td width='45%'>Jenis Pengeluaran</td>
										<td>
											<select name="item">
												<option value="">Pilih Item</option>
									<?php foreach ($dbKeluar->result() as $row) :
											if ($row->id_keluar == set_value('item', isset($default['item']) ? $default['item'] : '')) { ?>
												<option value="<?php echo $row->id_keluar; ?>" selected >
													<?php echo $row->nama_akun; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $row->id_keluar; ?>">
													<?php echo $row->nama_akun; ?>
												</option>
									<?php } endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="vertical-align:top;">Keterangan</td>
										<td>
											<textarea name="ket" cols="30" rows="3"><?php echo set_value('ket', isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Jumlah Pengeluaran</td>
										<td>
											<input type="text" name="jum" size="20" style="text-align:right;" value="<?php echo set_value('jum', isset($default['jum']) ? $default['jum'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td>ID Pegawai</td>
										<td>
											<input type="password" name="nip" size="10" />
										</td>
									</tr>
									<tr>
										<td>Password</td>
										<td>
											<input type="password" name="pass" size="10" />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.kas_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
							<br/><br/>
							<div class="list">HISTORI PENGELUARAN</div><br/>
<form name="tgl_form" action="<?php echo $status_action; ?>" method="post" >
	Dari Tanggal <input type="text" name="from" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
	<input type="text" name="to" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
	<a class="tombol" href="javascript:document.tgl_form.submit()">Tampilkan</a><br/><br/>
</form>
							<?php echo ! empty($tabelKeluar) ? $tabelKeluar : ''; ?>
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
<?php echo $this->load->view('main/activity/second/kas_approval'); ?>