				<div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">
						<li>
                			<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'home','index',array('NO') ); ?>"><span class="l"></span><span class="r"></span><span class="t">Home</span></a>
                		</li>
                		<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Transaksi</span></a>
                			<ul>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")); ?>">Laundry</a></li>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('inventori','index',array('NO'));?>">Inventori</a></li>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('aset','index',array('NO'));?>">Aset</a></li>
                			</ul>
                		</li>
                		<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Pelanggan</span></a>
                			<ul>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'customer','member' ); ?>">Member</a></li>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'customer','nonmem' ); ?>">Non Member</a></li>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'customer','komplain' ); ?>">Komplain</a></li>
                			</ul>
                		</li>
                		<li>
                			<a><span class="l"></span><span class="r"></span><span class="t">Kas</span></a>
							<ul>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('kas','input',array('NO'));?>">Pengeluaran</a></li>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('kas','nabung',array('NO'));?>">Transfer Kas</a></li>
                				<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('kas','histori',array('NO'));?>">Histori Kas</a></li>
                			</ul>
                		</li>
                		<li>
                			<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'setting','index' ); ?>"><span class="l"></span><span class="r"></span><span class="t">Konfigurasi</span></a>
                		</li>
						<div id="logout" style="float:right;">
							<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('login','logout'); ?>">Logout</a>
						</div>
						<div id="top_time" style="float:right;">
                			<script language="javascript">
								var dayarray=new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")
								var montharray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember")
								function top_time(){
									var time = new Date()
									var year = time.getYear()
									
									if (year < 1000)
										year+=1900
									
									var day = time.getDay()
									var month = time.getMonth()
									var daym = time.getDate()
									
									if (daym<10)
										daym="0"+daym
									
									var hour = time.getHours();
									var minute = time.getMinutes();
									var second = time.getSeconds();
									if (hour < 10){
										hour = "0" + hour;
									}
									if (minute < 10){
										minute = "0" + minute;
									}
									if (second < 10){
										second = "0" + second;
									}
									var hour_div = document.getElementById("top_time");
									hour_div.innerHTML = hour + ":" + minute + ":" + second + " (" + dayarray[day] + ", " +  daym + " " + montharray[month] + " " + year + ")";
									setTimeout("top_time()", 1000);
								}
								top_time();
							</script>
                		</div>
                	</ul>
                </div>
