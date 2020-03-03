<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
				<!-- MULAI KONTEN -->
						<div class="art-postcontent">
						
							<fieldset>
								<legend>Monitoring Cucian</legend>
								<table width="50%" class="info" style="float:left;">
									<tr>
										<td>Nomor Resi</td>
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
										<td>Jenis Cucian</td>
										<td>:</td>
										<td><?php echo $tRow->nama_laundry; ?></td>
									</tr>
									<tr>
										<td>Jumlah</td>
										<td>:</td>
										<td>
								<?php if ($tRow->jenis == "Kiloan"){
											echo $tRow->jumlah_kiloan . " Kg";
										}else{
											echo $tRow->jumlah_kiloan . " Buah";
								} ?>
										</td>
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
									<tr>
										<td>Metode Pembayaran</td>
										<td>:</td>
										<td><?php echo $tRow->metode_bayar; ?></td>
									</tr>
							<?php if(($tRow->komplain !== NULL)){ ?>
									<tr>
										<td>Komplain</td>
										<td>:</td>
										<td><?php echo $tRow->komplain; ?></td>
									</tr>
							<?php } ?>
								</table>
								<table width="45%" style="float:right;" class="detail">
									<tr>
										<th width="8%">No</th>
										<th width="40%">Aktivitas</th>
										<th>Pegawai</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Terima Cucian</td>
										<td style="text-align:left;padding-left:10px;"><?php echo $id1; ?></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Checklist</td>
										<td style="text-align:left;padding-left:10px;"><?php echo $id2; ?></td>
									</tr>
									<tr>
										<td>3</td>
										<td>Cuci</td>
										<td style="text-align:left;padding-left:10px;"><?php echo substr($cuci,0,-2); ?></td>
									</tr>
									<tr>
										<td>4</td>
										<td>Pengeringan</td>
										<td style="text-align:left;padding-left:10px;"><?php echo substr($kering,0,-2); ?></td>
									</tr>
									<tr>
										<td>5</td>
										<td>Packing</td>
										<td style="text-align:left;padding-left:10px;"><?php echo $id3; ?></td>
									</tr>
									<tr>
										<td>6</td>
										<td>Ambil Cucian</td>
										<td style="text-align:left;padding-left:10px;"><?php echo $id4; ?></td>
									</tr>
									<tr>
										<td>7</td>
										<td>Delivery</td>
										<td style="text-align:left;padding-left:10px;"><?php echo $id5; ?></td>
									</tr>
								</table>
								<div class="cleared"></div><br/>
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