<head>
	<title>Waroenk Laundry | Resi Transaksi</title>
	<script type="text/javascript">
		window.print();
		window.onfocus=function(){ window.close(); }
	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-barcode.js"></script>
	<style>
		table {
			font-size: 9px;
			font-family: Verdana;
		}
		table td {
			vertical-align: top;
		}
		.resi{
			position: absolute;
			width: 40px;
			border: solid 1px;
			font-size: 14px;
			font-family: Courier New;
			text-align: center;
		}
		.main{
			font-size: 9px;
			text-align: center;
			font-family: Verdana;
			width: 46mm;
		}
		.info{
			text-transform: uppercase;
		}
		table.list th{
			background-color: #ccc;
		}
		table.list td{
			text-align: center;
			border-bottom: solid 1px;
		}
	</style>
	<link href="<?php echo base_url();?>themes/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
	<div class="main">
		<div class="resi"><?php echo substr($tRow->resi,9,4); ?></div>
		<table style="border-bottom: solid 1px;" width="100%">
			<tr>
				<td style="text-align: center;">
					<img src="<?php echo base_url();?>themes/img/comp-logo.jpg" width="100mm" /><br/>
					<?php echo $outlet->outlet_address; ?>
				</td>
			</tr>
		</table><br/>
		<table width="100%">
			<tr>
				<td width="25%">Nama</td>
				<td width="1%">:</td>
				<td class="info" ><?php echo substr($tRow->nama,0,14); ?></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td class="info" ><?php echo $tRow->alamat; ?></td>
			</tr>
			<tr>
				<td>No. Tlp</td>
				<td>:</td>
				<td class="info" ><?php echo $tRow->no_tlp; ?></td>
			</tr>
			<tr>
				<td>Layanan</td>
				<td>:</td>
				<td class="info"><?php echo $tRow->nama_laundry; ?></td>
			</tr>
			<tr>
				<td>Jumlah</td>
				<td>:</td>
				<td class="info" >
		<?php if($tRow->kiloan == "Kiloan"){
					echo $tRow->jumlah_kiloan . " Kg";
				}else{
					echo $tRow->jumlah_kiloan . " Buah";
		} ?>
				</td>
			</tr>
			<tr>
				<td>Pewangi</td>
				<td>:</td>
				<td class="info"><?php echo $tRow->nama_pewangi; ?></td>
			</tr>
			<tr>
				<td>Total</td>
				<td>:</td>
				<td class="info">Rp <?php echo number_format($tRow->total, 0, ',', '.'); ?>,-</td>
			</tr>
<?php if($tRow->member == "Ya"){ ?>
			<tr>
				<td>Saldo</td>
				<td>:</td>
				<td class="info"><?php echo $saldo; ?></td>
			</tr>
<?php } ?>
			<tr>
				<td>Bayar</td>
				<td>:</td>
				<td class="info">
					<?php echo $tRow->status_bayar . " (" . $tRow->metode_bayar . ")"; ?>
				</td>
			</tr>
<?php if($tRow->status_bayar == "BELUM") {
		if($tRow->dp_bayar > 0){ ?>
			<tr>
				<td>DP</td>
				<td>:</td>
				<td class="info">Rp <?php echo number_format($tRow->dp_bayar, 0, ',', '.') . ",-"; ?></td>
			</tr>
<?php } }?>
		</table><br/>
	<?php if ($tRow->jenis == "Non" || $tRow->extra == "Ya") {?>
		<div class="detail">Cucian / Tambahan :</div>
		<table class="list" width="100%">
			<tr>
				<th width="8%">No</th>
				<th>Item</th>
				<th>Harga Satuan</th>
				<th width="15%">Jumlah</th>
			</tr>
		<?php $i=0; foreach($dbDetail as $det){ ?>
			<tr>
				<td><?php echo ++$i; ?></td>
				<td style="text-align:left;"><?php echo $det->nama_laundry; ?></td>
				<td style="text-align:right;"><?php echo number_format($det->harga_laundry,0,',','.'); ?></td>
				<td><?php echo $det->jum_non; ?></td>
			</tr>
		<?php } ?>
		<?php foreach($dbExtra as $ex){ ?>
			<tr>
				<td><?php echo ++$i; ?></td>
				<td style="text-align:left;"><?php echo $ex->nama_laundry; ?></td>
				<td style="text-align:right;"><?php echo number_format($ex->harga_laundry,0,',','.'); ?></td>
				<td><?php echo $ex->jum_extra; ?></td>
			</tr>
		<?php } ?>
		</table><br/>
	<?php } ?>
		<table width="100%" style="text-align: center;">
			<tr>
				<td>
					<?php echo $outlet->city_name; ?>, <?php echo date('d-m-Y', time()); ?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;">
					<center><div id="bcTarget"></div></center>
					<script>
						$("#bcTarget").barcode("<?php echo $tRow->resi; ?>", "code128",{barWidth:1,barHeight:65}); 
					</script>
				</td>
			</tr>
			<tr>
				<td style="border-top: solid 1px;"><?php echo $outlet->footer; ?></td>
			</tr>
		</table>
	</div>
</body>