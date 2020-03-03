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
								<br/><div class="cleared"></div>
								<table width="50%" class="info" style="float:left;">
									<tr>
										<td>No Resi</td>
										<td>:</td>
										<td><?php echo $tRow->resi; ?></td>
									</tr>
									<tr>
										<td width="30%">Nama Pelanggan</td>
										<td width="3%">:</td>
										<td><?php echo $tRow->nama; ?></td>
									</tr>
									<tr>
										<td>Alamat Pelanggan</td>
										<td>:</td>
										<td><?php echo $tRow->alamat; ?></td>
									</tr>
									<tr>
										<td>No.Tlp Pelanggan</td>
										<td>:</td>
										<td><?php echo $tRow->no_tlp; ?></td>
									</tr>
									<tr>
										<td>Jumlah Cucian</td>
										<td>:</td>
										<td>
											<?php if($tRow->jenis == "Kiloan"){
														echo $tRow->jumlah_kiloan . " Kg";
													}else{
														echo $tRow->jumlah_kiloan . " Buah";
											} ?>
										</td>
									</tr>
									<tr>
										<td>Jenis Cucian</td>
										<td>:</td>
										<td><?php echo $tRow->nama_laundry; ?></td>
									</tr>
									<tr>
										<td>Pewangi</td>
										<td>:</td>
										<td><?php echo $tRow->nama_pewangi; ?></td>
									</tr>
									<tr>
										<td>Catatan</td>
										<td>:</td>
										<td><?php echo $tRow->cat_trans; ?></td>
									</tr>
									<tr>
										<td>Total Harga</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->total, 0, ',', '.'); ?>,-</td>
									</tr>
									<tr>
										<td>Status Pembayaran</td>
										<td>:</td>
										<td><?php echo $tRow->status_bayar; ?></td>
									</tr>
							<?php if ($tRow->status_bayar == "BELUM") {?>
									<tr>
										<td>DP Bayar</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->dp_bayar, 0, ',', '.'); ?>,-</td>
									</tr>
									<tr>
										<td>Sisa Bayar</td>
										<td>:</td>
										<td>Rp <?php echo number_format($tRow->sisa_bayar, 0, ',', '.'); ?>,-</td>
									</tr>
							<?php } ?>
								</table>
								<table width="45%" style="float:right;" class="detail">
									<tr>
										<td colspan="3" style="border:none;padding-top:10px;text-align:left;">
											<div class="list">DETAIL CEKLIST</div>
										</td>
									</tr>
									<tr>
										<th width="5%">No</th>
										<th>Pakaian</th>
										<th width="15%">Jumlah</th>
									</tr>
						<?php $i=0; foreach($dbCeklist as $cek){
										if($cek->q_cloth > 0){ ?>
									<tr>
										<td><?php echo ++$i; ?></td>
										<td style="text-align:left;padding-left:10px;"><?php echo $cek->nama_cloth; ?></td>
										<td><?php echo $cek->q_cloth; ?></td>
									</tr>
						<?php } } ?>
									<tr>
										<td colspan="3" style="border:none;padding-top:10px;">
											<a href="<?php echo $cetakCek; ?>" class="tombol" style="font-size:20px;" target="_blank">Cetak Nota Ceklist</a>
										</td>
									</tr>
								</table>
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