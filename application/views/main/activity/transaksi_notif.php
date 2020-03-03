<?php if ($error == 'NIP') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, NIP YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'MEMBER') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, KODE MEMBER YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'SALDO') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, SALDO TIDAK MENCUKUPI ATAU MASA AKTIF SALDO ANDA TELAH HABIS. SILAHKAN LAKUKAN PENGISIAN ULANG.</b>
	</div>
<?php } ?>
<?php if ($error == 'CUCI') {?>
	<div class="attention" style="width:95%;">
		<b>Pilih jenis cucian dan masukkan jumlahnya.</b>
	</div>
<?php } ?>
<?php if ($error == 'YES1') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('id', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('cust', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('kiloan', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('laundry', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('pewangi', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>
<?php if ($error == 'YES2') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('cust', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nohp', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('kiloan', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('laundry', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('pewangi', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nip', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>
<?php if ($error == 'YESMEMBER') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('namabaru', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('nohpbaru', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('areabaru', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('jenisbaru', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>
<?php if ($error == 'RESI') {?>
	<div class="attention" style="width:95%;">
		<b>NO RESI IDAK DITEMUKAN.</b>
	</div>
<?php } ?>
<?php if ($error == 'PROMO') {?>
	<div class="attention" style="width:95%;">
		<b>MAAF, KODE PROMO YANG ANDA MASUKKAN SALAH!</b>
	</div>
<?php } ?>
<?php if ($error == 'YESBAYAR') {?>
	<div class="attention" style="width:95%;">
		<?php echo form_error('kartu', '&nbsp;', '&nbsp;'); ?>
		<?php echo form_error('depe', '&nbsp;', '&nbsp;'); ?>
	</div>
<?php } ?>