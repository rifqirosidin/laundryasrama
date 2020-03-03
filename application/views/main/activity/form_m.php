<div class="tabtrans">
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")); ?>"><h2>ORDERAN</h2></a>
	</div>
	<div class="acttab">
		<a ref="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("NO")); ?>"><h2>MEMBER</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("NO")); ?>"><h2>NON MEMBER</h2></a>
	</div>
	<div class="nontab">
		<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","statCuci",array("NO")); ?>"><h2>STATUS CUCIAN</h2></a>
	</div>
	<div class="cleared"></div>
	<fieldset style="padding-top:25px;">
		<a class="tombol" onClick="tampil('mkiloan','msatuan')" id="tomkilo">Kiloan</a> &nbsp; 
		<a class="tombol" onClick="tampil('msatuan','mkiloan')" id="tomnon">Non Kiloan</a> &nbsp; 
		<a class="tombol" id="add-member">Daftar Member</a> &nbsp; <a class="tombol" id="add-depo">Isi Saldo</a><br/><br/>
		<div id="mkiloan">
			<?php $this->load->view("main/activity/form_m_kilo"); ?>
		</div>
		<div id="msatuan" style="display:none;">
			<?php $this->load->view("main/activity/form_m_satu"); ?>
		</div>
	</fieldset>
</div>
<?php $this->load->view("main/activity/form_m_deposit"); ?>
<?php $this->load->view("main/activity/form_m_daftar"); ?>
<script>
$(function() {
	var memberTags = [
		<?php
			$i=1;
			foreach($dbMember->result() as $member){
				if($i == $jumMember)
					echo '"'. $member->nama_member .'"';
				else
					echo '"'. $member->nama_member .'",';
					
				$i++;
			}
		?>
	];
	$( "#kmember" ).autocomplete({
		source: memberTags
	});
	$( "#member" ).autocomplete({
		source: memberTags
	});
});
</script>
<script>
function showMem(cid,cparam){
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(cid).value=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","<?php echo base_url();?>themes/js/getMember.php?param="+cparam,true);
	xmlhttp.send();
}

function showCust(cid,cjenis,cparam,coutlet){
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(cid).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","<?php echo base_url();?>themes/js/getCust.php?jenis="+cjenis+"&param="+cparam+"&outlet="+coutlet,true);
	xmlhttp.send();
	if (cjenis=="member")
		showID('mid','#member','#idNon');
	else
		showID('idm','#kmember','#idKilo');
	
	showID('iddepo','#kmember','#idKilo');
}

function showID(id,id2,id3){
	var idmem = $(id3).text();
	document.getElementById(id).value = idmem;
	$(id2).is(":hidden");
}

function tampil(id1,id2) {
	var e = document.getElementById(id1);
	var f = document.getElementById(id2);
	e.style.display = 'inline';
	f.style.display = 'none';
}

function tampilBayar(metode,id,id2){
	var e = document.getElementById(id);
	var f = document.getElementById(id2);
	if(metode == '2'){
		e.style.display = 'none';
		f.style.display = 'inline';
	}else if(metode == '3'){
		e.style.display = 'inline';
		f.style.display = 'none';
	}else{
		e.style.display = 'none';
		f.style.display = 'none';
	}
}
</script>