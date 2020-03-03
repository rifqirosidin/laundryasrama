<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#memberTable').dataTable({
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
	$('#kompTable').dataTable({
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
							
							<fieldset><legend><?php echo $tLegend; ?> Data Member</legend><br/>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('nama', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('tlp', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('area', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('jenis', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<?php echo $link; ?><br/><br/>
							<form name="member_form" method="post" action="<?php echo $form_member; ?>" accept-charset="utf-8">
								<table width='60%'>
								<?php if($tLegend !== "Tambah") { ?>
									<tr>
										<td>ID Member</td>
										<td>
											<input type="hidden" name="kode" value="<?php echo set_value('kode', isset($default['kode']) ? $default['kode'] : ''); ?>"/>
											<b><?php echo set_value('kode', isset($default['kode']) ? $default['kode'] : ''); ?></b>
										</td>
									</tr>
								<?php } ?>
									<tr>
										<td width='24%'>Nama*</td>
										<td>
											<input type="text" name="namabaru" size="30" value="<?php echo set_value('namabaru', isset($default['namabaru']) ? $default['namabaru'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td style='vertical-align:top'>Alamat</td>
										<td><textarea name='alamatbaru' rows='3' cols='40'><?php echo set_value('alamatbaru', isset($default['alamatbaru']) ? $default['alamatbaru'] : ''); ?></textarea></td>
									</tr>
									<tr>
										<td>Area*</td>
										<td>
											<select name="areabaru">
												<option value="">Pilih Area</option>
									<?php foreach ($dbarea->result() as $row) :
											if ($row->id_area == set_value('areabaru', isset($default['areabaru']) ? $default['areabaru'] : '')) { ?>
												<option value="<?php echo $row->id_area; ?>" selected >
													<?php echo $row->area_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $row->id_area; ?>">
													<?php echo $row->area_name; ?>
												</option>
									<?php } endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>No. HP*</td>
										<td>
											<input type="text" name="nohpbaru" size="20" value="<?php echo set_value('nohpbaru', isset($default['nohpbaru']) ? $default['nohpbaru'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td>Tempat Lahir</td>
										<td>
											<input type="text" name="tmptbaru" size="30" value="<?php echo set_value('tmptbaru', isset($default['tmptbaru']) ? $default['tmptbaru'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td>Tanggal Lahir</td>
										<td>
											<input type="text" name="tglbaru" size="10" id='datepicker' value="<?php echo set_value('tglbaru', isset($default['tglbaru']) ? $default['tglbaru'] : ''); ?>" />
										</td>
									</tr>
									<tr>
										<td>Agama</td>
										<td>
											<input type="text" name="agamabaru" size="20" value="<?php echo set_value('agamabaru', isset($default['agamabaru']) ? $default['agamabaru'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td>Jenis Member</td>
										<td>
											<input type="hidden" name="jenisbaru" value="<?php echo set_value('jenisbaru', isset($default['jenisbaru']) ? $default['jenisbaru'] : ''); ?>"/><b>
									<?php if(set_value('jenisbaru', isset($default['jenisbaru']) ? $default['jenisbaru'] : '') == "Asrut" && $tLegend == "Tambah"){?>
											<select name="deposit" >
										<?php foreach ($dbMasa as $row){ ?>
												<option value="<?php echo $row->kode_laundry . $row->id_laundry; ?>"><?php echo substr($row->nama_laundry,11); ?></option>
										<?php } ?>
											</select>
									<?php }else{?>
											<?php echo set_value('jenisbaru', isset($default['jenisbaru']) ? $default['jenisbaru'] : ''); ?></b>
									<?php }?>
										</td>
									</tr>
								<?php if($tLegend !== "Tambah") { ?>
									<tr>
										<td>Saldo</td>
										<td>
									<?php if(set_value('jenisbaru', isset($default['jenisbaru']) ? $default['jenisbaru'] : '') == "Kiloan"){ ?>
											<input type="hidden" name="kilo" value="<?php echo set_value('kilo', isset($default['kilo']) ? $default['kilo'] : ''); ?>"/><b>
											<?php echo set_value('kilo', isset($default['kilo']) ? $default['kilo'] : ''); ?> &nbsp; <a id='add-kilo' class='add'>Beli Voucher</a></b>
									<?php }else if(set_value('jenisbaru', isset($default['jenisbaru']) ? $default['jenisbaru'] : '') == "Rupiah"){ ?>
											<input type="hidden" name="rup" value="<?php echo set_value('rup', isset($default['rup']) ? $default['rup'] : ''); ?>"/><b>
											<?php echo set_value('rup', isset($default['rup']) ? $default['rup'] : ''); ?> &nbsp; <a id='add-depo' class='add'>Tambah Deposit</a></b>
									<?php }else if(set_value('jenisbaru', isset($default['jenisbaru']) ? $default['jenisbaru'] : '') == "Asrut"){ ?>
											<input type="hidden" name="asr" value="<?php echo set_value('asr', isset($default['asr']) ? $default['asr'] : ''); ?>"/><b>
											<?php echo set_value('asr', isset($default['asr']) ? $default['asr'] : ''); ?> &nbsp; <a id='add-asr' class='add'>Tambah Masa Aktif</a></b>
									<?php } ?>
										</td>
									</tr>
								<?php } ?>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.member_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
<?php if($tLegend == "Ubah"){ ?>
								<br/><br/>
								<div class="list">HISTORI TRANSAKSI</div><br/>
								<?php echo $hist . " &nbsp;  &nbsp;  &nbsp; " . $depo; ?><br/><br/>
								<?php echo ! empty($tabelMember) ? $tabelMember : ''; ?>
								<br/><br/><br/>
								<div class="list">HISTORI KOMPLAIN</div><br/>
								<?php echo ! empty($tabelKomplain) ? $tabelKomplain : ''; ?>
<?php } ?>
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
<?php if($tLegend !== "Tambah") { echo $this->load->view('main/customer/deposit_form'); } ?>