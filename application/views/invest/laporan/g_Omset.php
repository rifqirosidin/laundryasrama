<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#start" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end" ).datepicker({
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				$( "#start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
</script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend>Grafik Jumlah Omset</legend><br/>
							<form name="g_form" method="post" action="<?php echo $g_form; ?>" accept-charset="utf-8">
								<table width='55%'>
									<tr>
										<td width='25%'>Oulet</td>
										<td><?php echo $outlet; ?></td>
									</tr>
									<tr>
										<td>Dari Tanggal</td>
										<td>
											<input type="text" name="dari" id="start" size="10" value="<?php echo $dari; ?>" readonly /> s/d 
											<input type="text" name="sampai" id="end" size="10" value="<?php echo $sampai; ?>" readonly />
										</td>
									</tr>
									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:right;" colspan="2"><a class="tombol" href="javascript:document.g_form.submit()">Tampilkan</a></td>
									</tr>
								</table>
							</form><br/>
							<div id="graph1"></div>
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
<script type="text/javascript" src="<?= base_url(); ?>themes/js/graph/highcharts.js"></script>
<script type="text/javascript">
$(function () {
	Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
	
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graph1',
				zoomType: 'x',
				margin: [ 40, 0, 40, 40]
			},
			title: {
				text: 'Grafik Jumlah Omset',
				x: -20 //center
			},
			xAxis: [{
					type: 'datetime',
					maxZoom: 7*24*3600000
				},{
					type: 'linear',
					labels:{
						enable: true
					}
			}],
			yAxis: {
				title: {
					text: 'Total Omset / hari'
				},
				allowDecimals: false,
				plotLines: [{
					value: 0,
					width: 1
				}]
			},
			tooltip: {
				xDateFormat: '%A, %d %B %Y'
			},
			plotOptions: {
				column: {
					stacking: 'normal'
				}
			},
			legend: {
				enabled : false
			},
			series: [
			<?php
					for($a=0;$a<sizeOf($db['date']);$a++){
						if($a == 0){
							echo '{name: \''.$db['area'][$a].'\',';
							echo 'type: \'column\',';
							echo 'xAxis: 0,';
							echo 'data: [';
							echo '[Date.parse("'.$db['date'][$a].'"), '.$db['omset'][$a].']';
							echo ']}';
						}else{
							echo ',{name: \''.$db['area'][$a].'\',';
							echo 'type: \'column\',';
							echo 'xAxis: 0,';
							echo 'data: [';
							echo '[Date.parse("'.$db['date'][$a].'"), '.$db['omset'][$a].']';
							echo ']}';
						}
					}
				?>,{
						name: 'Total per Hari',
						type: 'spline',
						xAxis: 0,
						data: [
							<?php
								for($a=0;$a<sizeOf($db['cuci']);$a++){
									$total = 0;
									foreach($db['cuci'][$a]->result() as $get){
										$total = $total + $get->jum_debit_jurnal;
									}
									if($a == 0)
										echo '[Date.parse("'.$db['tgl'][$a].'"), '.$total.']';
									else
										echo ',[Date.parse("'.$db['tgl'][$a].'"), '.$total.']';
								}
							?>
						]
					}
				]
		});
	});
});
</script>