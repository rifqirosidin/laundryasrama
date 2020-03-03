<head>
	<title><?php echo $page_title; ?></title>
	<script language="JavaScript">
		function loadprint(){
			window.print();
		}
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
		.judul{
			font-weight: bold;
			font-size: 14px;
			text-decoration: underline;
		}
		table.list th{
			background-color: #ccc;
		}
		table.list tfoot td{
			text-align: center;
			font-weight: bold;
		}
		table.list tbody td{
			text-align: center;
			border-bottom: solid 1px;
		}
		table.ttd td{
			text-align: center;
			vertical-align: top;
		}
	</style>
	<link href="<?php echo base_url();?>themes/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
	<div class="main">
		<table style="border-bottom:solid 1px;width:100%;">
			<tr>
				<td style="text-align:center;">
					<img src="<?php echo base_url();?>themes/img/comp-logo.jpg" width="100mm" />
				</td>
			</tr>
		</table><br/>
		<div class="judul">LIST CUCIAN</div><br/>
		<table width="100%">
			<tr>
				<td width="20%">Outlet</td>
				<td width="1%">:</td>
				<td><?php echo $outlet->outlet_code; ?></td>
			</tr>
			<tr style="vertical-align:top;">
				<td>Member</td>
				<td>:</td>
				<td><?php echo substr($scust,0,-2); ?></td>
			</tr>
			<tr style="vertical-align:top;">
				<td>Status</td>
				<td>:</td>
				<td><?php echo substr($scuci,0,-2); ?></td>
			</tr>
			<tr>
				<td>Bayar</td>
				<td>:</td>
				<td><?php echo substr($sbayar,0,-2); ?></td>
			</tr>
		</table><br/>
		<table class="list" width="100%">
			<tr>
				<th width="5%">No</th>
				<th>No Resi</th>
				<th>Nama Pelanggan</th>
				<th>Cuci (Kg)</th>
			</tr>
	<?php $i=0; $jum=0; foreach($tRow as $row){ ?>
			<tr>
				<td><?php echo ++$i; ?></td>
				<td><?php echo substr($row->resi,7); ?></td>
				<td style="text-align:left;padding-left:5px;"><?php echo substr($row->nama,0,9); ?></td>
				<td>
		<?php if($row->kiloan == "Kiloan"){
					echo $row->jumlah_kiloan;
					$jum = $jum + $row->jumlah_kiloan;
				}else{
					echo "-";
		} ?>
				</td>
			</tr>
	<?php } ?>
			<tfoot>
				<td colspan="3">&nbsp;</td>
				<td><?php echo $jum; ?></td>
			</tfoot>
		</table><br/>
		
		<table width="100%">
			<tr>
				<td style="text-align:center;">
					<?php echo $outlet->city_name; ?>, <?php echo date('d-m-Y', time()); ?><br/>
					<table width="100%" class="ttd">
						<tr>
							<td>
								Petugas<br/><br/><br/><br/><br/>
								( &nbsp; &nbsp; <?php echo $staff->nama_pegawai; ?> &nbsp; &nbsp; )
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>