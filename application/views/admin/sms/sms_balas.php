<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend>Balas SMS</legend>
								<div class="pesan">
									<div class="judul"><?php echo $pengirim; ?>, <?php echo $pesan->ReceivingDateTime; ?></div>
									<div class="isi"><?php echo $pesan->TextDecoded; ?></div>
								</div><br/>
								<div style="padding-left:30px;">
								<form name="sms_form" action="<?php echo $sms_form; ?>" method="post">
									<table width="45%">
										<tr>
											<td>Penerima</td>
											<td>
												<input type="hidden" name="notlp" value="<?php echo $notlp; ?>" />
												<input type="text" name="penerima" value="<?php echo $pengirim; ?>" size="20" readonly />
											</td>
										</tr>
										<tr>
											<td width="25%">Isi Pesan</td>
											<td>
												<textarea name="isisms" cols="40" rows="4" id="isisms"></textarea>
											</td>
										</tr>
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td><?= $link; ?></td>
											<td colspan="2" style="text-align:right;"><a class="tombol" href="javascript:document.sms_form.submit()">Kirim</a></td>
										</tr>
									</table>
								</form>
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