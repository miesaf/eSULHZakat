<html>
<head>
	<?php
		session_start();
		if(!$_SESSION['login_ez'])
		{
			header("Location: index.php?ralat=luput");
			exit;
		}
		$name	= $_SESSION['name_ez'];
		
		include('connectDB.php');
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />

    <title>[E-Asnaf Transfer] - Butiran Permohonan Zakat</title>
	
	<!-- New favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png?v=eEaoR4aKed">
	<link rel="icon" type="image/png" href="favicons/favicon-32x32.png?v=eEaoR4aKed" sizes="32x32">
	<link rel="icon" type="image/png" href="favicons/favicon-16x16.png?v=eEaoR4aKed" sizes="16x16">
	<link rel="manifest" href="favicons/manifest.json?v=eEaoR4aKed">
	<link rel="mask-icon" href="favicons/safari-pinned-tab.svg?v=eEaoR4aKed" color="#5bbad5">
	<link rel="shortcut icon" href="favicons/favicon.ico?v=eEaoR4aKed">
	<meta name="msapplication-TileColor" content="#00a300">
	<meta name="msapplication-TileImage" content="favicons/mstile-144x144.png?v=eEaoR4aKed">
	<meta name="msapplication-config" content="favicons/browserconfig.xml?v=eEaoR4aKed">
	<meta name="theme-color" content="#ffffff">

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script language="Javascript">
		function goBack()
		{
			window.history.go(-1);
		}
		
		function NewWindow(mypage, myname, w, h, scroll) {
		var winl = (screen.width - w) / 2;
		var wint = (screen.height - h) / 2;
		winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable=no'
		win = window.open(mypage, myname, winprops)
		if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
		}
	</script>
	
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">E-Asnaf Transfer</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
					<?php if($_SESSION['priv_ez'] == "ADMN") { print ("Admin "); }
					else if ($_SESSION['priv_ez'] == "MZKI") { print ("Muzakki | "); }
					else if ($_SESSION['priv_ez'] == "ASNF") { print ("Asnaf | "); } ?><strong><?php print($name); ?></strong>
				</li>				
				<li class="dropdown">
					<a href="logout.php">
                        <i class="fa fa-sign-out fa-fw"></i> Daftar Keluar
                    </a>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php
							include('nav.php');
						?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
		<!-- mula     ##########################################################################################     mula -->
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Butiran Permohonan Zakat</h1>
                </div>
                <!-- /.col-lg-12 -->
			</div>
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-10">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <center><b>Butiran Permohonan Zakat</b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
					<?php
						$ID = mysql_real_escape_string($_GET['ID']);
						
						$D_BC = false;
						
						if($ID != null)
						{
							// create the query
							$sql = "SELECT * FROM PERMOHONAN WHERE NO_SIRI = $ID";
							
							// execute query
							$result = mysql_query($sql) or die("SQL select statement failed");
							
							// iterate through all rows in result set
							if($row = mysql_fetch_array($result))
							{
								// display barcode
								$D_BC		= true;
								
								// extract specific fields
								$NO_SIRI		= $row["NO_SIRI"];
								$NAMA 			= $row["NAMA"];
								$TAHUN			= $row["TAHUN"];
								$TARIKH_MOHON	= $row["TARIKH_MOHON"];
								$NEGERI 		= $row["NEGERI"];
								$DAERAH 		= $row["DAERAH"];
								$PERUMAHAN 		= $row["PERUMAHAN"];
								$PENDAPATAN		= $row["PENDAPATAN"];
								
								$RUMAH			= $row["RUMAH"];
								$BINI_B			= $row["BINI_B"];
								$BINI_M			= $row["BINI_M"];
								$DEW_B			= $row["DEW_B"];
								$DEW_M			= $row["DEW_M"];
								$ANAK_I			= $row["ANAK_I"];
								$ANAK_R			= $row["ANAK_R"];
								$ANAK_M			= $row["ANAK_M"];
								$CACAT			= $row["CACAT"];
								$BAYI			= $row["BAYI"];
								$KRONIK			= $row["KRONIK"];
								
								$JENIS			= $row["JENIS"];
								$KIFAYAH_BAKI	= $row["KIFAYAH_BAKI"];
								$KIFAYAH_KREDIT	= $row["KIFAYAH_KREDIT"];
								$LOG_BAYARAN	= $row["LOG_BAYARAN"];
								
								// Decode codes into string
								$sql_display = "SELECT NEGERI FROM NEGERI WHERE KOD_NEGERI = '$NEGERI'";
								$result_dispay = mysql_query($sql_display);
								while($row = mysql_fetch_array($result_dispay)) { $DNEGERI = $row["NEGERI"]; }
								
								$sql_display = "SELECT NAMA_DAERAH FROM DAERAH WHERE KOD_DAERAH = '$DAERAH'";
								$result_dispay = mysql_query($sql_display);
								while($row = mysql_fetch_array($result_dispay)) { $DDAERAH = $row["NAMA_DAERAH"]; }
								
								$sql_display = "SELECT NAMA_KWSN FROM PERUMAHAN WHERE KOD_KWSN = '$PERUMAHAN'";
								$result_dispay = mysql_query($sql_display);
								while($row = mysql_fetch_array($result_dispay)) { $DPERUMAHAN = $row["NAMA_KWSN"]; }
								
								$sql_display = "SELECT JENIS FROM JENIS_ASNAF WHERE KOD_JENIS = '$JENIS'";
								$result_dispay = mysql_query($sql_display);
								while($row = mysql_fetch_array($result_dispay)) { $DJENIS = $row["JENIS"]; }
								
								if($RUMAH == 1)
								{
									$RUMAH = "Berbayar";
								}
								elseif($RUMAH == 0)
								{
									$RUMAH = "Percuma";
								}
								
								$HAD_KIFAYAH = $KIFAYAH_BAKI + $KIFAYAH_KREDIT;
								
								// output student information
								echo "<tbody>
										<tr><td><b>Nama</b></td><td>$NAMA</td></tr>
										<tr><td><b>Tarikh Mohon</b></td><td>$TARIKH_MOHON</td></tr>
										<tr><td><b>Negeri Kediaman</b></td><td>$DNEGERI</td></tr>
										<tr><td><b>Daerah Kediaman</b></td><td>$DDAERAH</td></tr>
										<tr><td><b>Kawasan Perumahan</b></td><td>$DPERUMAHAN</td></tr>
										<tr><td><b>Pendapatan</b></td><td style='vertical-align:middle'>RM $PENDAPATAN</td></tr>
										<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>$DJENIS</td></tr>
										<tr><td><b>Latar Belakang</b></td><td style='vertical-align:middle'>";
								echo "<table class=\"table table-striped table-bordered table-hover\">
										<tbody>
										<tr>
											<td align=\"center\"><b>Butiran</b></td><td align=\"center\"><b>Bilangan</b></td>
										</tr>
										<tr>
											<td>Jenis Pemilikan Rumah</td><td>$RUMAH</td>
										</tr>
										<tr>
											<td>Bilangan Pasangan Bekerja</td><td>$BINI_B</td>
										</tr>
										<tr>
											<td>Bilangan Pasangan Tidak Bekerja</td><td>$BINI_M</td>
										</tr>
										<tr>
											<td>Bilangan Anak Umur Lebih 18 Tahun Bekerja</td><td>$DEW_B</td>
										</tr>
										<tr>
											<td>Bilangan Anak Umur Lebih 18 Tahun Tidak Bekerja</td><td>$DEW_M</td>
										</tr>
										<tr>
											<td>Bilangan Anak Belajar Di IPT</td><td>$ANAK_I</td>
										</tr>
										<tr>
											<td>Bilangan Anak Bersekolah</td><td>$ANAK_R</td>
										</tr>
										<tr>
											<td>Bilangan Anak Tidak Bersekolah</td><td>$ANAK_M</td>
										</tr>
										<tr>
											<td>Bilangan Tanggungan Cacat</td><td>$CACAT</td>
										</tr>
										<tr>
											<td>Bilangan Tanggungan Bayi</td><td>$BAYI</td>
										</tr>
										<tr>
											<td>Bilangan Tanggungan Penyakit Kronik</td><td>$KRONIK</td>
										</tr>
										</tbody>
									</table>";
								echo "</td></tr>
										<tr><td><b>Had Kifayah</b></td><td style='vertical-align:middle'>RM $HAD_KIFAYAH</td></tr>
										<tr><td><b>Baki Kifayah</b></td><td style='vertical-align:middle'>RM $KIFAYAH_BAKI</td></tr>
										<tr><td><b>Amaun yang telah<br>dikreditkan kepada<br>asnaf</b></td><td style='vertical-align:middle'>RM $KIFAYAH_KREDIT</td></tr>
										<tr><td><b>Log pengkreditan<br>zakat kepada asnaf</b></td><td style='white-space: pre'>$LOG_BAYARAN<a href=\"cetak.php?ID=$NO_SIRI\"><button type='button' class='btn btn-outline btn-info' >Cetak Penyata Pembayaran</button></a></td></tr>";
								echo "</tbody></table>";
								
							if($KIFAYAH_BAKI > 0)
							{
								echo "<center><a href=\"bayar.php?ID=$NO_SIRI\"><button type='button' class='btn btn-outline btn-success' >Bayar zakat kepada asnaf</button></a></center>";
							}

								if($D_BC == false)
								{
									echo "<tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
								}
							}
							else
							{
								echo "<tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
							}
						}
						else
						{
							echo "<tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
						}
					?>
							</div>
							<!-- /.dataTable_wrapper -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel-default -->
				</div>
				<!-- /.col-lg-8 -->
			</div>
			<!-- /.row -->
		<!-- tamat     ########################################################################################     tamat -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
