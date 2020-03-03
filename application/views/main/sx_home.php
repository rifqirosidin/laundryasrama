<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.4.2.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.jgrowl.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.jgrowl.js"></script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
							
							<fieldset>
								<legend>Menu Utama</legend>
<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'PASS') {?>
	<div class="attention" style="width:95%;">
		<b>PASSWORD YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
								<table class="home-menu" width="100%">
									<tr>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/home-menu/1-laundry.png" title="Laundry"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")); ?>">Laundry</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/home-menu/2-aset.png" title="Aset"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('aset','index',array('NO'));?>">Aset</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/home-menu/3-inventori.png" title="Inventori"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('inventori','index',array('NO'));?>">Inventori</a>
										</td>
									</tr>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/home-menu/4-member.png" title="Member"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'customer','member' ); ?>" href="javascript:void(0)">Member</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/home-menu/5-karyawan.png" title="Pegawai"/><br/>
											<a class="tombol" id='kar-button' href="javascript:void(0)">Pegawai</a>
										</td>
										<td>
											<img src="<?php echo base_url(); ?>themes/img/home-menu/6-konfigurasi.png" title="Konfigurasi"/><br/>
											<a class="tombol" href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'setting','index' ); ?>">Konfigurasi</a>
										</td>
									</tr>
								</table>
							</fieldset>
<?php if( $pengeluaran > 0 ) { ?>
	<script type="text/javascript">
		// In case you don't have firebug...
		if(typeof console === "undefined") {
		    console = { log: function() { } };
		}

		(function($){
			$(document).ready(function(){
				// This value can be true, false or a function to be used as a callback when the closer is clciked
				$.jGrowl("Terdapat <b><?php echo $pengeluaran; ?></b> pengeluaran yang harus di konfirmasi.", {
					beforeClose: function() {
						return false;
					},
					theme: 'custom'
				});
			});
		})(jQuery);
	</script>
<?php } ?>
							<div class="cleared"></div>
						</div>
				<!-- AKHIR KONTEN -->
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
<?php $this->load->view("main/karyawan/kar_login"); ?>