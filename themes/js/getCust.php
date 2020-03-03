<?php
	$jenis=$_GET["jenis"];
	$param=$_GET["param"];
	$outlet=$_GET["outlet"];
	
	$con = mysql_connect('localhost', 'root', '');
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("db_six", $con);
	
	if($jenis == "member" || $jenis == "kmember")
		$sql = "SELECT * FROM wl_member WHERE nama_member LIKE '$param' AND outlet_id=" . $outlet;
	else
		$sql = "SELECT * FROM wl_member_non WHERE nama_non LIKE '$param' AND outlet_id=" . $outlet;
	
	$result = mysql_query($sql) or die ('');
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
		while($row = mysql_fetch_array($result)){
			if($jenis == "member" || $jenis == "kmember"){
				if($jenis == "member")
					echo "<div id='idNon' style='position:absolute;display:none;'>" . $row['id_member'] . "</div>";
				else
					echo "<div id='idKilo' style='position:absolute;display:none;'>" . $row['id_member'] . "</div>";
				
				echo "
					<table width='50%' style='float:left;'>
						<tr>
							<td width='25%'>Alamat</td>
							<td>
								<textarea name='alamat' cols='40' rows='3' readonly >" . $row['alamat_member'] . "</textarea>
							</td>
						</tr>
						<tr>
							<td>No. HP</td>
							<td>
								<input type='hidden' name='areanya' value='" . $row['area_member'] . "' />
								<input type='text' name='nohp' size='20' value='" . $row['tlp_member'] . "' readonly />
							</td>
						</tr>
						<tr>
							<td>Saldo</td>
							<td>";
				
				if($row['jenis_member'] == "Rupiah")
					echo "<input type='text' name='saldo' size='10' value='" . $row['saldo_rp'] . "' style='text-align:right;' readonly /> &nbsp; s/d &nbsp; 
						<input type='text' name='akhir' size='10' value='" . $row['akhir_rp'] . "' readonly />";
				else
					echo "<input type='text' name='saldo' size='10' value='" . $row['saldo_kg'] . "' style='text-align:right;' readonly /> Kg &nbsp; s/d &nbsp; 
						<input type='text' name='akhir' size='10' value='" . $row['akhir_kg'] . "' readonly />";
				
				echo "</td>
						</tr>
						<tr>
							<td colspan='2'>&nbsp;</td>
						</tr>
					</table>
				";
			}else{
				echo "
					<table width='50%' style='float:left;'>
						<tr>
							<td width='25%'>Alamat</td>
							<td>
								<textarea name='alamat' cols='40' rows='3' readonly >" . $row['alamat_non'] . "</textarea>
							</td>
						</tr>
						<tr>
							<td>No. HP</td>
							<td>
								<input type='hidden' name='id' value='" . $row['id_non'] . "' />
								<input type='hidden' name='areanya' value='" . $row['area_non'] . "' />
								<input type='text' name='nohp' size='20' value='" . $row['tlp_non'] . "' readonly />
							</td>
						</tr>
						<tr>
							<td colspan='2'>&nbsp;</td>
						</tr>
					</table>
				";
			}
		}
	}else{
		echo "
					<table width='50%' style='float:left;'>
						<tr>
							<td width='25%'>Alamat</td>
							<td>
								<textarea name='alamat' cols='40' rows='3' readonly ></textarea>
							</td>
						</tr>
						<tr>
							<td>No. HP</td>
							<td>
								<input type='text' name='nohp' size='20' readonly />
							</td>
						</tr>
						<tr>
							<td colspan='2'>&nbsp;</td>
						</tr>
					</table>
				";
	}
	
	mysql_close($con);
?>