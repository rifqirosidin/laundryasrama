<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<?php
	$this->load->view('invest/header');
?>
<body>
	<div id="art-main">
        <div class="art-sheet">
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
<?php
	$this->load->view('invest/top_menu');
	$this->load->view($content);
	//$this->load->view('invest/footer');
?>
			</div>
		</div>
        <div class="cleared"></div>
	</div>
</body>
</html>