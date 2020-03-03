<?php
	$param=$_GET["param"];
	
	$con = mysql_connect('localhost', 'root', '');
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("db_six", $con);
	
	$sql = "SELECT * FROM wl_member WHERE id_member LIKE '$param' AND outlet_id=" . $outlet;
	$result = mysql_query($sql) or die ('');
	while($row = mysql_fetch_array($result)){
		echo $row['nama_member'];
	}
	
	mysql_close($con);
?>