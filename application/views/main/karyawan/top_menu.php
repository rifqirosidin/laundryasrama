               <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">
						<li>
                			<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'karyawan','index',array($nip) ); ?>"><span class="l"></span><span class="r"></span><span class="t">Home</span></a>
                		</li>
						<div id="logout" style="float:right;">
							<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('home','index',array('NO')); ?>">Logout</a>
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
