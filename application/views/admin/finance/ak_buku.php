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
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><br/>
							<form name="buku_form" method="post" action="<?php echo $form_buku; ?>" accept-charset="utf-8">
								<table width='45%' style='font-weight:bold;'>
									<tr>
										<td width='30%'>Outlet</td>
										<td><?php echo $nama_outlet; ?></td>
									</tr>
									<tr>
										<td>Akun</td>
										<td>
											<select name="akun" >
									<?php foreach ($dbkel->result() as $kel) :
											if ($kel->nama_akun == $akun) { ?>
												<option value="<?php echo $kel->nama_akun; ?>" selected ><?php echo $kel->nama_akun; ?></option>
											<?php } else { ?>
												<option value="<?php echo $kel->nama_akun; ?>" ><?php echo $kel->nama_akun; ?></option>
									<?php } endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Dari Tanggal</td>
										<td>
											<input type="text" name="dari" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
											<input type="text" name="sampai" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td><a href="<?php echo $back; ?>" class="back">Kembali</a></td>
										<td style="text-align:right;"><a class="tombol" href="javascript:document.buku_form.submit()">Tampilkan</a></td>
									</tr>
								</table>
							</form><br/>
							<div class="list">BUKU BESAR : AKUN <?php echo $akun; ?></div><br/>
							<?php echo ! empty($tabelBuku) ? $tabelBuku : ''; ?>
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