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
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.chained.mini.js"></script>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("#city").chained("#zona");
		$("#area").chained("#city");
		$("#outlet").chained("#area");
	});
</script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend><?php echo $tLegend; ?> Pegawai</legend>
<?php if ($error == 'YES') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('name', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('pno', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('outlet', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('pos', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?><br/>
							<form name="pegawai_form" method="post" action="<?php echo $form_pegawai; ?>" enctype="multipart/form-data" class="dataform" accept-charset="utf-8">
								<table width='100%'>
									<tr>
										<td width='15%'>Nama*</td>
										<td width='44%'>
											<input type="text" name="name" size="40" value="<?php echo set_value('name', isset($default['name']) ? $default['name'] : ''); ?>" autofocus />
										</td>
										<td width='20%' rowspan='8' style='text-align:center;' >
									<?php if ($tLegend == 'Ubah'){ ?>
											<img src="<?php echo base_url();?><?php echo $photo; ?>" style='border:double;height:200px;padding:5px;'/>
									<?php } ?>
											<input type="hidden" name="photo" id="photo" value="<?php echo $photo; ?>"/>
										</td>
										<td rowspan='8'> &nbsp; </td>
									</tr>
									<tr>
										<td>No. Tlp*</td>
										<td>
											<input type="text" name="pno" size="20" value="<?php echo set_value('pno', isset($default['pno']) ? $default['pno'] : ''); ?>"/>
										</td>
									</tr>
									<tr>
										<td style='vertical-align:top'>Alamat</td>
										<td><textarea name='add' rows='3' cols='40'><?php echo set_value('add', isset($default['add']) ? $default['add'] : ''); ?></textarea></td>
									</tr>
									<tr>
										<td>Tempat Lahir</td>
										<td><input type="text" name="bplace" size="30" value="<?php echo set_value('bplace', isset($default['bplace']) ? $default['bplace'] : ''); ?>"/></td>
									</tr>
									<tr>
										<td>Tanggal Lahir</td>
										<td><input type="text" name="bdate" size="10" id='datepicker' value="<?php echo set_value('bdate', isset($default['bdate']) ? $default['bdate'] : ''); ?>" /></td>
									</tr>
									<tr>
										<td>Foto</td>
										<td><input type="file" name="file" id="file" size="40"/></td>
									</tr>
									<tr>
										<td>Jabatan*</td>
										<td>
											<select name="pos" >
												<option value="">Pilih Jabatan</option>
									<?php foreach ($dbpos->result() as $row) :
											if ($row->position_id == set_value('pos', isset($default['pos']) ? $default['pos'] : '')) { ?>
												<option value="<?php echo $row->position_id; ?>" selected >
													<?php echo $row->position_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $row->position_id; ?>"><?php echo $row->position_name; ?></option>
									<?php } endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Outlet*</td>
										<td>
							<?php if ($tLegend == 'Ubah'){ ?>
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
											<select id="outlet" name="outlet" >
												<option value="">Pilih Outlet</option>
									<?php foreach ($dbout->result() as $out) :
											if ($out->outlet_id == set_value('outlet', isset($default['outlet']) ? $default['outlet'] : '')) { ?>
												<option value="<?php echo $out->outlet_id; ?>" class="<?php echo $out->area_code; ?>" selected >
													<?php echo $out->outlet_name; ?>
												</option>
											<?php } else { ?>
												<option value="<?php echo $out->outlet_id; ?>" class="<?php echo $out->area_code; ?>" >
													<?php echo $out->outlet_name; ?>
												</option>
									<?php } endforeach; ?>
											</select>
							<?php }else{ ?>
											<input type="hidden" name="outlet" value="<?php echo set_value('outlet', isset($default['outlet']) ? $default['outlet'] : ''); ?>"/>
											<?php echo $nama_outlet; ?>
							<?php } ?>
										</td>
									</tr>
								</table>
								<table width='45%'>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><?php echo $link; ?></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.pegawai_form.submit()">Simpan</a></td>
									</tr>
								</table>
							</form>
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