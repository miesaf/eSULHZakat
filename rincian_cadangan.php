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

    <title>[E-Asnaf Transfer] - Butiran Cadangan Asnaf</title>
	
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
                    <h1 class="page-header">Butiran Cadangan Asnaf</h1>
                </div>
                <!-- /.col-lg-12 -->
			</div>
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-10">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <center><b>Butiran Cadangan Asnaf</b></center>
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
							$sql = "SELECT * FROM CADANG_ASNAF WHERE NO_KP = $ID";
							
							// execute query
							$result = mysql_query($sql) or die("SQL select statement failed");
							
							// iterate through all rows in result set
							if($row = mysql_fetch_array($result))
							{
								// display barcode
								$D_BC		= true;
								
								// extract specific fields
								$NO_KP			= $row["NO_KP"];
								$NAMA 			= $row["NAMA"];
								$TEL			= $row["TEL"];
								$JLN_1			= $row["JLN_1"];
								$JLN_2			= $row["JLN_2"];
								$POSKOD			= $row["POSKOD"];
								$PERUMAHAN 		= $row["PERUMAHAN"];
								$BANDAR			= $row["BANDAR"];
								$DAERAH 		= $row["DAERAH"];
								$NEGERI 		= $row["NEGERI"];
								$PENDAPATAN		= $row["PENDAPATAN"];
								$BUKTI			= $row["BUKTI"];
								$JENIS			= $row["JENIS"];
								$BANK			= $row["BANK"];
								$NO_AKAUN		= $row["NO_AKAUN"];
								
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
								
								// output student information
								echo "<tbody>
										<tr><td><b>Nama</b></td><td>$NAMA</td></tr>
										<tr><td><b>No. Telefon</b></td><td>$TEL</td></tr>
										<tr><td><b>Alamat</b></td><td>$JLN_1<br>$JLN_2</td></tr>
										<tr><td><b>Poskod</b></td><td>$POSKOD</td></tr>
										<tr><td><b>Kawasan Perumahan</b></td><td>$DPERUMAHAN</td></tr>
										<tr><td><b>Bandar</b></td><td>$BANDAR</td></tr>
										<tr><td><b>Daerah Kediaman</b></td><td>$DDAERAH</td></tr>
										<tr><td><b>Negeri Kediaman</b></td><td>$DNEGERI</td></tr>
										<tr><td><b>Pendapatan</b></td><td style='vertical-align:middle'>RM $PENDAPATAN</td></tr>
										<tr><td><b>Lampiran Slip Pendapatan/Gaji</b></td><td><a href=\"bukti/$BUKTI\" target=\"_blank\"><button class=\"btn btn-info\">Lihat</button></a></td></tr>
										<tr><td><b>Jenis Asnaf</b></td><td style='vertical-align:middle'>$DJENIS</td></tr>
										<tr><td><b>Bank</b></td><td>$BANK</td>
										<tr><td><b>Nombor Akaun</b></td><td>$NO_AKAUN</td>";
								echo "</tbody></table>";

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
