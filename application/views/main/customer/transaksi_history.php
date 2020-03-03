<head>
	<title>Waroenk Laundry | History Transaksi</title>
	<script language="JavaScript">
		function loadprint(){
			window.print();
		}
	</script>
	<style>
		table {
			font-size: 11px;
			font-family: Verdana;
		}
		.main{
			font-size: 12px;
			font-family: Verdana;
			text-align: center;
			padding: 50px 10px;
			width: 21cm;
		}
		.judul{
			padding: 10px 0px;
			font-weight: bold;
			font-size: 20px;
			text-decoration: underline;
		}
		table.list th{
			background-color: #ccc;
		}
		table.list td{
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
					<img src="<?php echo base_url();?>themes/img/comp-logo.jpg" width="200px" />
				</td>
			</tr>
		</table>
		<div class="judul">HISTORY 5 TRANSAKSI TERAKHIR</div>
		<table style="width:100%;">
			<tr>
				<td width="15%">Outlet</td>
				<td width="1%">:</td>
				<td><?php echo $outlet->outlet_name; ?></td>
			</tr>
		</table><br/>
		<table class="list" width="100%">
			<tr>
				<th width="5%">No</th>
				<th width="15%">No Resi</th>
				<th>Jenis Layanan</th>
				<th>Jumlah</th>
				<th>Tgl Cuci</th>
				<th>Status</th>
			</tr>
	<?php $i=0;
		foreach($tRow as $row){
			if($i<5) { ?>
			<tr>
				<td><?php echo ++$i; ?></td>
				<td><?php echo $row->resi; ?></td>
				<td style="text-align:left;padding-left:10px;"><?php echo $row->nama_laundry; ?></td>
				<td><?php echo $row->jumlah_kiloan; ?></td>
				<td><?php echo $row->tgl_trans; ?></td>
				<td><?php echo $row->status; ?></td>
			</tr>
	<?php 	}else
				break;
		} ?>
		</table><br/>
		
		<table width="100%">
			<tr>
				<td>&nbsp;</td>
				<td style="text-align:center;" width="30%">
					<?php echo $outlet->city_name; ?>, <?php echo date('d - m - Y', time()); ?>
					<table width="100%" class="ttd">
						<tr>
							<td>
								Petugas<br/><br/><br/><br/><br/>
								( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>