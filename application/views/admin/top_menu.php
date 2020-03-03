                <div class="art-nav">
                	<div class="adl"></div>
                	<div class="adr"></div>
                	<ul class="art-menu">
						<li>
                			<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'administrator','outlet_form',array($this->session->userdata('out'),"Ubah","NO") ); ?>"><span class="l"></span><span class="r"></span><span class="t">Outlet</span></a>
                		</li>
						<li>
                			<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'admin_finance','index' ); ?>"><span class="l"></span><span class="r"></span><span class="t">Keuangan</span></a>
                		</li>
						<li>
							<a><span class="l"></span><span class="r"></span><span class="t">Laporan</span></a>
							<ul>
								<li><a>Frekuensi Transaksi</a>
									<ul>
										<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciArea'); ?>">per Area</a><li>
										<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciCust'); ?>">per Pelanggan</a><li>
										<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciProd'); ?>">per Produk</a></li>
									</ul>
								</li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','krisan',array(-1)); ?>">Respon Pelanggan</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','statusTrans'); ?>">Status Transaksi</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','kinerja'); ?>">Kinerja</a><li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_grafik','omset'); ?>">Omset</a><li>
							</ul>
						</li>
						<li>
							<a><span class="l"></span><span class="r"></span><span class="t">SMS Gateway</span></a>
							<ul>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_sms','inbox',array(0,'NO')); ?>">Kotak Masuk</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_sms','outbox',array(0,'NO')); ?>">Kotak Keluar</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_sms','sent',array(0,'NO')); ?>">Pesan Terkirim</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_sms','broadcast',array(0,'NO')); ?>">SMS Broadcast</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_sms','konfig'); ?>">Konfigurasi</a></li>
							</ul>
						</li>
						<li>
                			<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode( 'administrator','investorList' ); ?>"><span class="l"></span><span class="r"></span><span class="t">Investor</span></a>
                		</li>
						<div id="logout" style="float:right;">
							<a href="<?php echo base_url(); ?>index.php/<?php echo $this->mza_secureurl->setSecureUrl_encode('admin_login','logout'); ?>">Logout</a>
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
