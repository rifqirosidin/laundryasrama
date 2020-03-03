<div class="tabtrans">
	<div class="acttab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")); ?>"><h2>ORDERAN</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("NO")); ?>"><h2>MEMBER</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("NO")); ?>"><h2>NON MEMBER</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","statCuci",array("NO")); ?>"><h2>STATUS CUCIAN</h2></a>
	</div>
	<div class="cleared"></div>
	<fieldset>
		<form name="resi_form" action="<?php echo $fresi; ?>" method="post"><br/>
			<table class="laundry">
				<tr>
					<td width="160px">NOMOR RESI</td>
					<td width="225px">
						<input type="text" name="resi" size="12" maxlength="13" autofocus />
						<a class="tombol" href="javascript:document.resi_form.submit()">Cari</a>
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
</div>