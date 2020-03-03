<head>
	<title>Waroenk Laundry | Nota Ceklist</title>
	<script type="text/javascript">
		window.print();
		window.onfocus=function(){ window.close(); }
	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-barcode.js"></script>
	<style>
		table {
			font-size: 10px;
			font-family: Verdana;
		}
		.resi{
			position: absolute;
			width: 55px;
			border: solid 1px;
			font-size: 14px;
			font-weight: bold;
			font-family: Courier New;
			text-align: center;
		}
		.main{
			font-size: 9px;
			font-family: Verdana;
			text-align: center;
			width:46mm;
		}
		.judul{
			padding: 10px 0px;
			font-weight: bold;
			font-size: 14px;
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
<?php for($no=1;$no<=$jumlah;$no++){ ?>
	<div class="main">
		<div class="resi"><?php echo $kresi . "-" . $no; ?></div>
		<table style="border-bottom:solid 1px;width:100%;">
			<tr>
				<td style="text-align:center;">
					<br/><img src="<?php echo base_url();?>themes/img/comp-logo.jpg" width="100mm" />
				</td>
			</tr>
		</table>
		<div class="judul">NOTA CEKLIST</div>
		<table class="list" width="100%">
			<tr>
				<th width="8%">No</th>
				<th>Jenis Pakaian</th>
				<th width="20%">Jumlah</th>
			</tr>
	<?php $i=0; foreach($tRow as $row){
					if($row->q_cloth > 0){?>
			<tr>
				<td><?php echo ++$i; ?></td>
				<td style="text-align:left;padding-left:5px;"><?php echo $row->nama_cloth; ?></td>
				<td><?php echo $row->q_cloth; ?>
				</td>
			</tr>
	<?php }} ?>
		</table><br/>
		<table width="100%">
			<tr>
				<td style="text-align:center;">
					<?php echo $outlet->city_name; ?>, <?php echo date('d-m-Y', time()); ?>
					<table width="100%" class="ttd">
						<tr>
							<td>
								Petugas<br/><br/><br/><br/><br/>
								( &nbsp; &nbsp; &nbsp; <?php echo $staff->nama_pegawai; ?> &nbsp; &nbsp; &nbsp; )
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div><br/>
<?php } ?>
</body>