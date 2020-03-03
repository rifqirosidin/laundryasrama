<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script type="text/javascript">
$(function() {
    $('#month').datepicker( {
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy/mm',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});
</script>
<style>
.ui-datepicker-calendar {
	display: none;
}
</style>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							<fieldset><legend>Kinerja Pegawai</legend>
								<form name="kinerja_f" action="<?php echo $kinerja_f; ?>" method="post" >
									<table class="info" width="50%">
										<tr>
											<td width='25%'>ID Pegawai</td>
											<td width='1%'>:</td>
											<td><?php echo $ambil->nip; ?></td>
										</tr>
										<tr>
											<td>Nama</td>
											<td>:</td>
											<td><?php echo $ambil->nama_pegawai; ?></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>:</td>
											<td><?php echo $ambil->alamat_pegawai; ?></td>
										</tr>
										<tr>
											<td>No. Tlp</td>
											<td>:</td>
											<td><?php echo $ambil->tlp_pegawai; ?></td>
										</tr>
										<tr>
											<td>Periode Bulan</td>
											<td>:</td>
											<td>
												<input type="text" name="periode" id="month" size="7" value="<?php echo $periode; ?>" readonly />
												&nbsp;&nbsp;<a class="tombol" href="javascript:document.kinerja_f.submit()">Tampilkan</a>
											</td>
										</tr>
									</table>
								</form><br/><br/>
								<div class="list"><?php echo $bulan; ?></div><br/>
								<div style="width:50%;float:left;">
									<div class="kinerja">Aktivitas Utama</div>
									<?php echo ! empty($tabelMain) ? $tabelMain : ''; ?>
								</div>
								<div style="width:45%;float:right;">
									<div class="kinerja">Aktivitas Tambahan</div>
									<?php echo ! empty($tabelSupport) ? $tabelSupport : ''; ?>
								</div>
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