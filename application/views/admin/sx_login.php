<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
	<link href="<?php echo base_url();?>themes/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.tambahan.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.admin.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/style.ie7.css" type="text/css" media="screen" /><![endif]-->
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/js/script.js"></script>
</head>

<body id="bgadmin">
		<div id="art-main">
			<div class="art-sheet" style="padding-top:130px">
				<center>
                    <div class="adminlogin">
						<img src="<?php echo base_url(); ?>themes/img/warning.png" title="ADMINISTRATOR AREA" width="200px"/><br/>
					<?php if ($error == 'YES') {?>
						<div class="attention" style='width:100%;'>
							<?php echo form_error('username', ' ', ' '); ?>
							<?php echo form_error('password', ' ', ' '); ?>
						</div><br/>
					<?php } ?>
    					<form action="<?php echo $form_action; ?>" method="post" name="form_login">
						<table width="280px" style="font-weight:bold;color:#666;">
    						<tr>
        						<td width="30%">Username</td>
            					<td width="1%">:</td>
            					<td><input type="text" name="username" autofocus /></td>
        					</tr>
        					<tr>
        						<td>Password</td>
            					<td>:</td>
            					<td><input type="password" name="password"/></td>
        					</tr>
        					<tr>
        						<td>Outlet</td>
            					<td>:</td>
            					<td>
									<select name="outlet">
							<?php foreach($outlet->result() as $out){ ?>
										<option value="<?php echo $out->outlet_id; ?>"><?php echo $out->outlet_code; ?></option>
							<?php } ?>
									</select>
								</td>
        					</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
        					<tr>
        						<td colspan="3" style="text-align:right"><a class="tombol" href="javascript:document.form_login.submit()">Login</a></td>
        					</tr>
							<tr>
        						<td colspan="3">&nbsp;</td>
        					</tr>
    					</table>
						</form>
                    </div>
				</center>
			</div><br/>
			<div class="cleared"></div>
			<center>
				<img src="<?php echo base_url();?>themes/img/gie-logo.png" style="display:block;width:100px;"/>
			</center>
		</div>
</body>
</html>