<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
						
							<fieldset>
								<legend>Detail Transaksi</legend>
								<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'customer','cetakDeposit',array($tRow->dresi) ); ?>" class="print" target="_blank">Cetak Resi Deposit</a>
								<table width="60%" class="info">
									<tr>
										<td width="35%">Nama</td>
										<td width="3%">:</td>
										<td><?php echo $tRow->nama_member; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo $tRow->alamat_member; ?></td>
									</tr>
									<tr>
										<td>No.Tlp</td>
										<td>:</td>
										<td><?php echo $tRow->tlp_member; ?></td>
									</tr>
									<tr>
										<td>Jenis Deposit</td>
										<td>:</td>
										<td><?php echo $tRow->jenis_deposit; ?></td>
									</tr>
									<tr>
										<td>Jumlah</td>
										<td>:</td>
										<td>
								<?php if ($tRow->jenis_deposit == "Kiloan"){
											echo $tRow->jumlah_deposit . " Kg";
										}else{
											echo "Rp " . number_format($tRow->jumlah_deposit,0,',','.') . ",-";
								} ?>
										</td>
									</tr>
									<tr>
										<td>Total Harga</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->bayar_deposit, 0, ',', '.'); ?>,-</td>
									</tr>
								</table><br/>
								<a href="javascript:history.back(-1)" class="back">Kembali</a>
							</fieldset>
							
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