<head>
	<title>Waroenk Laundry | Resi Transaksi</title>
	<script language="JavaScript">
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
		.main{
			font-size: 9px;
			text-align: center;
			font-family: Verdana;
			width: 46mm;
		}
		.info{
			text-transform: uppercase;
		}
	</style>
	<link href="<?php echo base_url();?>themes/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
	<div class="main">
		<table style="border-bottom: solid 1px;">
			<tr>
				<td style="text-align: center;">
					<img src="<?php echo base_url();?>themes/img/comp-logo.jpg" width="100mm" /><br/>
					<?php echo $outlet->outlet_address; ?>
				</td>
			</tr>
		</table><br/>
		<table width="100%">
			<tr>
				<td width="25%">ID</td>
				<td width="1%">:</td>
				<td class="info" ><?php echo $tRow->id_member; ?></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td class="info" ><?php echo substr($tRow->nama_member,0,14); ?></td>
			</tr>
			<tr>
				<td>No. Tlp</td>
				<td>:</td>
				<td class="info" ><?php echo $tRow->tlp_member; ?></td>
			</tr>
			<tr>
				<td>Deposit</td>
				<td>:</td>
				<td class="info" >
					<?php
						if ($tRow->jenis_deposit == "Rupiah")
							echo "Rp " . number_format($tRow->jumlah_deposit, 0, ',', '.') . ",-  [". number_format($tRow->saldo_rp, 0, ',', '.') ."]";
						else if ($tRow->jenis_deposit == "Kiloan")
							echo "Rp " . number_format($tRow->jumlah_deposit, 0, ',', '.') . ",-  [". number_format($tRow->saldo_rp, 0, ',', '.') ."]";
						else
							echo "20 Kg [". $tRow->akhir_kg ."]";
					?>
				</td>
			</tr>
			<tr>
				<td>Total</td>
				<td>:</td>
				<td class="info">Rp <?php echo number_format($tRow->bayar_deposit, 0, ',', '.'); ?>,-</td>
			</tr>
		</table><br/>
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
						$("#bcTarget").barcode("<?php echo $tRow->dresi; ?>", "code128",{barWidth:1,barHeight:65}); 
					</script>
				</td>
			</tr>
			<tr>
				<td style="border-top: solid 1px;"><?php echo $outlet->footer; ?></td>
			</tr>
		</table>
	</div>
</body>