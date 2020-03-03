<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
<link href="<?php echo base_url();?>themes/css/ui/jquery.ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>themes/js/jquery.ui.js"></script>
<script>
	$(function() {
		$( "#date" ).datepicker({
			minDate: 0,
			changeMonth: true,
			changeYear: true
		});
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
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.tables.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery.dataTables.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
	$('#smsTable').dataTable({
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered ){
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ){
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		},
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 0 ] }
		],
		"aaSorting": [[ 1, 'asc' ]]
	});
} );
</script>
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell art-content">
			<div class="art-post">
				<div class="art-post-body">
					<div class="art-post-inner art-article">
						<div class="art-postcontent">
				<!-- MULAI KONTEN -->
							
							<fieldset><legend>Frekuensi Transaksi Produk</legend><br/>
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
											<a class="tombol" href="javascript:document.g_form.submit()">Tampilkan</a>
										</td>
									</tr>
								</table>
							</form><br/>
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
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b> : '+ this.y +' transaksi';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                y: 100,
                floating: true
            },
            series: [{
                name: 'Total Produk',
                type: 'pie',
                data: [
                    <?php
							for($a=0;$a<sizeOf($db['kdProd']);$a++){
								$count = 0;
								if($a == 0){
									echo '[\''.$db['kdProd'][$a].'\',';
									foreach($db['trProd'][$a]->result() as $trans){
										$count += 1;
									}
									echo ''.$count.']';
								}else{
									echo ',[\''.$db['kdProd'][$a].'\',';
									foreach($db['trProd'][$a]->result() as $trans){
										$count += 1;
									}
									echo ''.$count.']';
								}
							}
						?>
                ]
            }]
        });
    });
    
});
</script>
							<div id="graph1" style="width: 60%; float: left"></div>
								<table width='30%' class="crmLink" style="float:right;text-align:center;margin-top:100px;">
									<tr>
										<td><img src="<?php echo base_url(); ?>themes/img/home-menu/send.png" width="100px"/></td>
									</tr>
									<tr>
										<td><a id="sendButt" class="tombol" style="font-size:16px;">Kirim SMS</a></td>
									</tr>
								</table>
								<div class="cleared"></div><br/>
								<div id="sendForm" title="Kirim SMS">
									<form name="s_Send" action="<?php echo $s_Send; ?>" method="post">
										<table width="100%">
											<tr>
												<td colspan="2">
													<input type="hidden" name="kdar" value="<?php echo $dari; ?>" />
													<input type="hidden" name="kake" value="<?php echo $sampai; ?>" />
												</td>
											</tr>
											<tr>
												<td style="vertical-align:top;">Area</td>
												<td>
											<?php foreach ($dbarea->result() as $row){ ?>
													<input type="checkbox" name="area<?php echo $row->id_area; ?>" value="Yes" /> <?php echo $row->area_name; ?><br/>
											<?php } ?>
												</td>
											</tr>
											<tr>
												<td>Tgl Kirim</td>
												<td><input type="text" name="tgl" id="date" size="10"/></td>
											</tr>
											<tr>
												<td style="vertical-align:top;" width='28%'>Isi Pesan</td>
												<td><textarea name="isi" id="isisms" style="width:100%;height:100px;"></textarea></td>
											</tr>
										</table>
									</form>
								</div>
								<table id="smsTable">
									<thead><tr>
										<th width="3%">No</th>
										<th width="10%">Kode Produk</th>
										<th>Nama Produk</th>
							<?php for($i=0;$i<sizeOf($kodeArea);$i++){ ?>
										<th><?php echo $kodeArea[$i]; ?></th>
							<?php } ?>
										<th width="5%">Total</th>
									</tr></thead>
									<tbody>
							<?php for($i=0;$i<sizeOf($kodeProd);$i++){ ?>
									<tr>
										<td><?php echo $i+1; ?></td>
										<td><?php echo $kodeProd[$i]; ?></td>
										<td style="text-align:left;padding-left:10px;"><?php echo $namaProd[$i]; ?></td>
								<?php for($j=0;$j<sizeOf($kodeArea);$j++){ ?>
										<td><?php if($countTrans[$i][$j] > 0) echo $countTrans[$i][$j] . "x"; else echo "-"; ?></td>
								<?php } ?>
										<td><b><?php if($totTrans[$i] > 0) echo $totTrans[$i] . "x"; else echo "-"; ?></b></td>
									</tr>
							<?php } ?>
									</tbody>
								</table>
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
<style>
	table.crmLink{
<?php if ($transProd == null){ ?>
		display : none;
<?php }?>
	}	
</style>
<script>
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var tgl = $( "#date" ),
			allFields = $( [] ).add( tgl ),
			tips = $( ".validateTips" );
		var isisms = $( "#isisms" ),
			allFields = $( [] ).add( isisms ),
			tips = $( ".validateTips" );
		
		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		
		function checkRequired( o, n ) {
			if ( o.val() == "" ) {
				o.addClass( "ui-state-error" );
				return false;
			} else {
				return true;
			}
		}
		
		$( "#sendForm" ).dialog({
			autoOpen: false,
			height: 500,
			width: 500,
			modal: true,
			buttons: {
				"Kirim": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
						bValid = bValid && checkRequired( tgl, "Tgl. Kirim" ) && checkRequired( isisms, "Isi Pesan" );
						if ( bValid ) {
						document.s_Send.submit();
						$( this ).dialog( "close" );
					}
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
			$( "#sendButt" )
			.click(function() {
				$( "#sendForm" ).dialog( "open" );
		});
		
	});
</script>