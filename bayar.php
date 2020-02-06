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
		
		// E-Mel Pembayaran
		function bayar_ok($NO_KP, $NO_SIRI)
		{
			// create the query
			$sql = "SELECT NAMA, NEGERI, DAERAH, PERUMAHAN, JENIS, LOG_BAYARAN FROM PERMOHONAN WHERE NO_SIRI = \"$NO_SIRI\"";
			
			// execute query
			$result = mysql_query($sql) or die("SQL select statement failed");
			
			// iterate through all rows in result set
			if($row = mysql_fetch_array($result))
			{
				// extract specific fields
				$NAMA 			= $row["NAMA"];
				$NEGERI 		= $row["NEGERI"];
				$DAERAH 		= $row["DAERAH"];
				$PERUMAHAN 		= $row["PERUMAHAN"];
				$JENIS			= $row["JENIS"];
				$LOG_BAYARAN	= $row["LOG_BAYARAN"];
				
				// Decode codes into string
				$sql_display = "SELECT NEGERI FROM NEGERI WHERE KOD_NEGERI = '$NEGERI'";
				$result_dispay = mysql_query($sql_display);
				while($row_display = mysql_fetch_array($result_dispay)) { $DNEGERI = $row_display["NEGERI"]; }
				
				$sql_display = "SELECT NAMA_DAERAH FROM DAERAH WHERE KOD_DAERAH = '$DAERAH'";
				$result_dispay = mysql_query($sql_display);
				while($row_display = mysql_fetch_array($result_dispay)) { $DDAERAH = $row_display["NAMA_DAERAH"]; }
				
				$sql_display = "SELECT NAMA_KWSN FROM PERUMAHAN WHERE KOD_KWSN = '$PERUMAHAN'";
				$result_dispay = mysql_query($sql_display);
				while($row_display = mysql_fetch_array($result_dispay)) { $DPERUMAHAN = $row_display["NAMA_KWSN"]; }
				
				$sql_display = "SELECT JENIS FROM JENIS_ASNAF WHERE KOD_JENIS = '$JENIS'";
				$result_dispay = mysql_query($sql_display);
				while($row_display = mysql_fetch_array($result_dispay)) { $DJENIS = $row_display["JENIS"]; }
				
				$sql_choose = "SELECT EMEL FROM MUZAKKI WHERE NO_KP =\"$NO_KP\"";
				$result_choose = mysql_query($sql_choose);
				if($row_choose = mysql_fetch_array($result_choose))
				{
					$EMEL	= $row_choose['EMEL'];
					
					// send e-mail
					$Subject = "Penyata Pembayaran Zakat";
					
					echo "<br><br>";
					
					$Message = "<html>
								<body>
									<h2>E-Asnaf Transfer</h2>
									<h1>Penyata Pembayaran Zakat</h1>
									<table>
										<tbody>
										<tr><td><b>Nama Penerima</b></td><td>: $NAMA</td></tr>
										<tr><td><b>Negeri Kediaman</b></td><td>: $DNEGERI</td></tr>
										<tr><td><b>Daerah Kediaman</b></td><td>: $DDAERAH</td></tr>
										<tr><td><b>Kawasan Perumahan</b></td><td>: $DPERUMAHAN</td></tr>
										<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>: $DJENIS</td></tr>
										</tbody>
									</table>
									<h3>Log Pembayaran</h3>
									<h4>$LOG_BAYARAN</h4>
								</body>
								</html>";
					
					// To send HTML mail, the Content-type header must be set
					$Headers[]	= "MIME-Version: 1.0";
					$Headers[]	= "Content-type: text/html; charset=\"ISO-8859-1\"";
					$Headers[]	= "From: E-Asnaf Transfer <donotreply@" . $_SERVER['SERVER_NAME'] . ">";
					$Headers[]	= "Bcc: Back Up <2013830392@isiswa.uitm.edu.my>";
					
					$PENERIMA	= $EMEL;
					
					$HANTAR		= mail($PENERIMA, $Subject, $Message, implode("\r\n", $Headers));
					
					return $HANTAR;
				}
			}
		}
		
		if(isset($_POST["BAYAR"]))
		{
			$NO_SIRI= $_POST["NO_SIRI"];
			$HAD	= $_POST["HAD"];
			$KREDIT	= $_POST["KREDIT"];
			$AMAUN	= $_POST["AMAUN"];
			$LOG	= $_POST["LOG"];
			
			$KIFAYAH_BAKI	= $HAD - $AMAUN;
			$KIFAYAH_KREDIT	= $KREDIT + $AMAUN;
			
			$ID_MUZAKKI		= $_SESSION["ident_ez"];
			
			$sql_3 = "SELECT * FROM MUZAKKI WHERE NO_KP = $ID_MUZAKKI";
			$result_3 = mysql_query($sql_3);
			while($row3 = mysql_fetch_array($result_3))
			{ 
				$NAMA	= $row3["NAMA"];
				$TEL	= $row3["TEL"];
			}
			
			// Sijil ID Generator
			$h = "8";	// to rematch time with Malaysian GMT +8 time (please truncate the +/- sign)
			$hm = $h * 60; 
			$ms = $hm * 60;
			$HARI	= gmdate("w", time()+($ms));
			$BULAN	= gmdate("n", time()+($ms));
			$TARIKH	= gmdate("d", time()+($ms));
			$MASA = gmdate("Y g:i:s a", time()+($ms));	// use (-) for -ve GMT and (+) for +ve GMT
						/* 	-----------------------
							Timestamp Configuration
							-----------------------
							Y - Full year
							m - month with leading zero
							d - date with leading zero
							H - 24-hour format hour
							i - minute with leading zero
							s - second with leading zero
							
							# Please reconfigure server time to:
							timezone - Asia/Kuala_Lumour
							latitude = 3.133333
							longitude = 101.683333
							
							#date() - will fetch server date
							#gmdate() - will fetch GMT 0:00 date
						*/
			//Library Hari
			$DHARI[0]	= "Ahad";
			$DHARI[1]	= "Isnin";
			$DHARI[2]	= "Selasa";
			$DHARI[3]	= "Rabu";
			$DHARI[4]	= "Khamis";
			$DHARI[5]	= "Jumaat";
			$DHARI[6]	= "Sabtu";
			
			//Library Bulan
			$DBULAN[1]	= "Januari";
			$DBULAN[2]	= "Februari";
			$DBULAN[3]	= "Mac";
			$DBULAN[4]	= "April";
			$DBULAN[5]	= "Mei";
			$DBULAN[6]	= "Jun";
			$DBULAN[7]	= "Julai";
			$DBULAN[8]	= "Ogos";
			$DBULAN[9]	= "September";
			$DBULAN[10]	= "Oktober";
			$DBULAN[11]	= "November";
			$DBULAN[12]	= "Disember";
			
			$DTARIKH	= "$DHARI[$HARI], $TARIKH $DBULAN[$BULAN] $MASA";
			
			// End of Sijil ID Generator
			
			$LOG_BAYARAN	= "---------------------------------------<br>"
							. "Nama Pembayar : $NAMA<br>"
							. "Telefon : $TEL<br>"
							. "Amaun : RM $AMAUN<br>"
							. "Tarikh : $DTARIKH<br>"
							. "---------------------------------------<br><br>";
							
			$LOG_BAYARAN = $LOG . $LOG_BAYARAN;
			
			if($AMAUN <= $HAD)
			{
				$sql="UPDATE PERMOHONAN SET KIFAYAH_BAKI = $KIFAYAH_BAKI, KIFAYAH_KREDIT = $KIFAYAH_KREDIT, LOG_BAYARAN = \"$LOG_BAYARAN\" WHERE NO_SIRI = $NO_SIRI";
				
				// execute query
				$exe_sql = mysql_query($sql);
				
				// confirming the record is added
				if ($exe_sql)
				{
					$MEL = bayar_ok($ID_MUZAKKI, $NO_SIRI);
					
					echo '<html>
							<head>
								<script>
									window.alert("Pembayaran berjaya!");
								</script>
								<meta http-equiv="refresh" content="0; url=rincian.php?ID=' . $NO_SIRI . '" />
							</head>
						</html>';
				}
				else
				{
					echo "SQL insert statement failed.<br>" . mysql_error();
					echo '<html>
							<head>
								<script>
									window.alert("Pembayaran gagal!");
									window.history.go(-1);
								</script>
							</head>
						</html>';
				}
			}
			else
			{
				echo '<html>
						<head>
							<script>
								window.alert("Amaun yang dimasukkan melebihi had!");
								window.history.go(-1);
							</script>
						</head>
					</html>';
			}
		}
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />

    <title>[E-Asnaf Transfer] - Pembayaran Zakat</title>
	
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
					<?php if($_SESSION['priv_ez'] == "ADMN") { print ("Admin | "); }
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
                    <h1 class="page-header">Pembayaran Zakat</h1>
                </div>
                <!-- /.col-lg-12 -->
			</div>
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-10">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <center><b>Pembayaran Zakat</b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
								<form id="bayar_zakat" action ="bayar.php" method ="POST">
									<input type="hidden" name="BAYAR" value="YES">
					<?php
					if(!isset($_POST["BAYAR"]))
					{
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
								$PEMOHON 		= $row["PEMOHON"];
								$NAMA 			= $row["NAMA"];
								$TAHUN			= $row["TAHUN"];
								$TARIKH_MOHON	= $row["TARIKH_MOHON"];
								$JENIS			= $row["JENIS"];
								$KIFAYAH_BAKI	= $row["KIFAYAH_BAKI"];
								$KIFAYAH_KREDIT	= $row["KIFAYAH_KREDIT"];
								$LOG_BAYARAN	= $row["LOG_BAYARAN"];
								
								$sql_display = "SELECT JENIS FROM JENIS_ASNAF WHERE KOD_JENIS = '$JENIS'";
								$result_dispay = mysql_query($sql_display);
								while($row = mysql_fetch_array($result_dispay)) { $DJENIS = $row["JENIS"]; }
								
								$sql_2 = "SELECT BANK, NO_AKAUN FROM ASNAF WHERE NO_KP = $PEMOHON";
								$result_2 = mysql_query($sql_2);
								while($row2 = mysql_fetch_array($result_2))
								{ 
									$BANK		= $row2["BANK"];
									$NO_AKAUN	= $row2["NO_AKAUN"];
								}
								
								$sql_display = "SELECT NAMA_BANK FROM BANK WHERE KOD_BANK = '$BANK'";
								$result_dispay = mysql_query($sql_display);
								while($row = mysql_fetch_array($result_dispay)) { $DBANK = $row["NAMA_BANK"]; }
								
								// output student information
								echo "	<input type=\"hidden\" name=\"NO_SIRI\" value=\"$NO_SIRI\">
										<input type=\"hidden\" name=\"HAD\" value=\"$KIFAYAH_BAKI\">
										<input type=\"hidden\" name=\"KREDIT\" value=\"$KIFAYAH_KREDIT\">
										<input type=\"hidden\" name=\"LOG\" value=\"$LOG_BAYARAN\">";
								echo "<tbody>
										<tr><td colspan='2' align='left' bgcolor='#F0F0F0'><b> A) Butiran Pemohon </b></td></tr>
										<tr><td><b>Nama Penerima</b></td><td>$NAMA</td></tr>
										<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>$DJENIS</td></tr>
										<tr><td><b>Baki Kifayah</b></td><td style='vertical-align:middle'>RM $KIFAYAH_BAKI</td></tr>
										<tr><td colspan='2'> &nbsp; </td></tr>
										<tr><td colspan='2' align='left' bgcolor='#F0F0F0'><b> B) Butiran Pembayaran </b></td></tr>
										<tr><td><b>Nama Pembayar</b></td><td>$name</td></tr>
										<tr><td><b>Jenis Bank Penerima</b></td><td>$DBANK</td></tr>
										<tr><td><b>No. Akaun Penerima</b></td><td>$NO_AKAUN</td></tr>
										<tr><td><b>Amaun Hendak Dibayar</b></td><td><table><td>RM&nbsp;</td><td><input class=\"form-control\" type=\"text\" maxlength=\"10\" size=\"3\" name=\"AMAUN\"></td><td>.00</td></table></td></tr>";
								echo "</tbody></table>";
								echo "<center><a target='_blank' href='bayar.php'><button class=\"btn btn-outline btn-success\" type=\"submit\" form=\"bayar_zakat\" value=\"Submit\">Bayar</button></a></center></form>";

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
