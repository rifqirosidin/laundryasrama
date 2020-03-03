<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.chained.mini.js"></script>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("#city").chained("#zona");
		$("#area").chained("#city");
	});
	$(function(){
		$("#newcity").chained("#newzona");
		$("#newarea").chained("#newcity");
	});
	$(function(){
		$("#areacity").chained("#areazona");
	});
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.tables.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#cakupanTable').dataTable({
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
							
							<fieldset><legend>Outlet</legend>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('name', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('code', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('area', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('username', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('pass', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('repass', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<a class="add" id="add-out">Daftar Outlet Baru</a> &nbsp; &nbsp; <a class="add" id="add-area">Master Area</a><br/><br/>
					<?php if ($tLegend == "Ubah"){ ?>
							<table style="float:right;width:40%;text-align:center;">
								<tr>
									<td width="30%">
										<img src="<?php echo base_url(); ?>themes/img/home-menu/1-laundry.png" width="100px" title="Layanan"/><br/>
										<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("administrator","layanan",array($idOut)); ?>" >Layanan</a>
									</td>
									<td width="40%">
										<img src="<?php echo base_url(); ?>themes/img/home-menu/7-parfume.png" width="100px" title="Pewangi"/><br/>
										<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("administrator","pewangi",array($idOut)); ?>" >Pewangi</a>
									</td>
									<td>
										<img src="<?php echo base_url(); ?>themes/img/home-menu/5-karyawan.png" width="100px" title="Pegawai"/><br/>
										<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("administrator","user",array($idOut)); ?>" >Pegawai</a>
									</td>
								</tr>
								<tr>
									<td colspan="3">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3">&nbsp;</td>
								</tr>
								<tr>
									<td>
										<img src="<?php echo base_url(); ?>themes/img/home-menu/2-aset.png" width="100px" title="Aset"/><br/>
										<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("administrator","aset",array($idOut)); ?>">Aset</a>
									</td>
									<td>
										<img src="<?php echo base_url(); ?>themes/img/home-menu/3-inventori.png" width="100px" title="Inventori"/><br/>
										<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("administrator","inventori",array($idOut)); ?>" >Inventori</a>
									</td>
									<td>
										<img src="<?php echo base_url(); ?>themes/img/home-menu/8-event.png" width="100px" title="Event"/><br/>
										<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("administrator","promo",array($idOut)); ?>" >Event</a>
									</td>
								</tr>
							</table>
					<?php } ?>
							<form name="form_outlet" method="post" action="<?php echo $form_outlet; ?>" class="dataform" accept-charset="utf-8">
								<table width='50%'>
									<tr>
										<td width='35%'>Nama Outlet*</td>
										<td>
											<input type="text" name="name" size="40" value="<?php echo set_value('name', isset($default['name']) ? $default['name'] : ''); ?>" autofocus />
										</td>
									</tr>
						<?php if ($tLegend == "Tambah"){ ?>
									<tr>
										<td>Area*</td>
										<td>
											<select id="zona" name="zona">
												<option value="">Pilih Zona</option>
									<?php foreach ($dbzona->result() as $zo) :
											if ($zo->id_zona == set_value('zona', isset($default['zona']) ? $default['zona'] : '')) { ?>
												<option value="<?php echo $zo->id_zona; ?>" selected>
													<?php echo $zo->zona_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $zo->id_zona; ?>"><?php echo $zo->zona_name; ?></option>
									<?php } endforeach; ?>
											</select>
											<select id="city" name="city">
												<option value="">Pilih Kota</option>
									<?php foreach ($dbcity->result() as $ct) :
											if ($ct->id_city == set_value('city', isset($default['city']) ? $default['city'] : '')) { ?>
												<option value="<?php echo $ct->id_city; ?>" class="<?php echo $ct->id_zona; ?>" selected >
													<?php echo $ct->city_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $ct->id_city; ?>" class="<?php echo $ct->id_zona; ?>">
													<?php echo $ct->city_name; ?>
												</option>
									<?php } endforeach; ?>
											</select>
											<select id="area" name="area">
												<option value="">Pilih Area</option>
									<?php foreach ($dbarea->result() as $row) :
											if ($row->area_code == set_value('area', isset($default['area']) ? $default['area'] : '')) { ?>
												<option value="<?php echo $row->area_code; ?>" class="<?php echo $row->id_city; ?>" selected >
													<?php echo $row->area_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $row->area_code; ?>" class="<?php echo $row->id_city; ?>">
													<?php echo $row->area_name; ?>
												</option>
									<?php } endforeach; ?>
											</select>
										</td>
									</tr>
						<?php } ?>
									<tr>
										<td style='vertical-align:top'>Alamat Outlet</td>
										<td><textarea name='address' rows='3' cols='40'><?php echo set_value('address', isset($default['address']) ? $default['address'] : ''); ?></textarea></td>
									</tr>
									<tr>
										<td>No. Tlp Outlet</td>
										<td>
											<input type="text" name="phone" size="20" value="<?php echo set_value('phone', isset($default['phone']) ? $default['phone'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td>Jenis Member</td>
										<td>
											<select name="jmember">
												<option value="Kiloan" <?php if($jmember == "Kiloan") echo "selected" ?> >Member Bulanan (Kiloan)</option>
												<option value="Rupiah" <?php if($jmember == "Rupiah") echo "selected" ?> >Member Voucher (Rupiah)</option>
												<option value="Asrut" <?php if($jmember == "Asrut") echo "selected" ?> >Member Asrama Untel</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style='vertical-align:top'>Resi Footer</td>
										<td><textarea name='foot' rows='3' cols='40'><?php echo set_value('foot', isset($default['foot']) ? $default['foot'] : ''); ?></textarea></td>
									</tr>
									<tr>
										<td>Username*</td>
										<td><input type="text" name="username" size="15" value="<?php echo set_value('username', isset($default['username']) ? $default['username'] : ''); ?>"/></td>
									</tr>
						<?php if ($tLegend == "Tambah"){ ?>
									<tr>
										<td>Password*</td>
										<td>
											<input type="password" name="pass" size="20" />
										</td>
									</tr>
									<tr>
										<td>Re-Type Password*</td>
										<td>
											<input type="password" name="repass" size="20" />
										</td>
									</tr>
						<?php } ?>
									<tr>
										<td>&nbsp;</td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.form_outlet.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
						<?php if ($tLegend == "Ubah"){ ?>
							<form name="form_pass" method="post" action="<?php echo $form_pass; ?>" accept-charset="utf-8">
								<table width='50%'>
									<tr>
										<td> &nbsp; </td>
										<td> &nbsp; </td>
									</tr>
									<tr>
										<td width='35%'>Password</td>
										<td>
											<input type="password" name="pass" size="20" />
										</td>
									</tr>
									<tr>
										<td>Re-Password</td>
										<td>
											<input type="password" name="repass" size="20" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.form_pass.submit()">Ubah Password</a></td>
									</tr>
								</table>
							</form>
						<?php } ?>
				<?php if ($tLegend == "Ubah"){ ?>
							<div class="cleared"></div><br/><br/>
							<div class="list">CAKUPAN AREA</div><br/>
							<form name="cakupan_form" method="post" action="<?php echo $form_cakupan; ?>">
								<table>
									<tr>
										<td width="30%">
											<input type="hidden" name="ccity" value="<?php echo $ccity; ?>"/>
											<select name="carea">
												<option value="">Pilih Cakupan Area</option>
									<?php foreach ($dbcarea->result() as $row) { ?>
												<option value="<?php echo $row->id_area; ?>">
													<?php echo $row->area_name; ?>
												</option>
									<?php } ?>
											</select>
										</td>
										<td><a class="tombol" href="javascript:document.cakupan_form.submit()">Tambah Cakupan</a></td>
									</tr>
								</table>
							</form><br/><br/>
							<?php echo ! empty($tabelCakupan) ? $tabelCakupan : ''; ?>
				<?php } ?>
								<?php $this->load->view('admin/setting/outlet_add'); ?>
								<?php $this->load->view('admin/setting/setting_area'); ?>
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