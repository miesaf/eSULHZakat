<html lang="ms-my">
<head>
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />
	<?php
		session_start();
		if(!$_SESSION['login_ez'])
		{
			header("Location: index.php?ralat=luput");
			exit;
		}
		$name = $_SESSION['name_ez'];
		
		include('connectDB.php');
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>[E-Asnaf Transfer] - Laman Utama</title>
	
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
	
	<!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
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
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">E-Asnaf Transfer</h1>
				<div>
				<!-- /.col-lg-10 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-8">
<?php
	// ##### ADMN ##### ADMN ##### ADMN ############################################################################ ADMN #####
	if($_SESSION['priv_ez'] == "ADMN")
	{
		include('connectDB.php');

		// create the query
		$ID = $_SESSION['ident'];
		$sql = "SELECT NO_ID, NAMA, JENIS FROM J_ADMIN WHERE NO_ID = $ID";
		
		// execute query
		$result = mysql_query($sql) or die("SQL select statement failed");
		
		// iterate through all rows in result set
		$row = mysql_fetch_array($result);
	
		// extract specific fields
		$NO_ID		= $row["NO_ID"];
		$NAMA 		= $row["NAMA"];
		$JENIS		= $row["JENIS"];
		
		?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Butiran Akaun
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<div align="center"><img src="images/admin.png" width="200" height="200" onerror="this.src='images/tiada_logo.png'"></div><br>
										</tr>
									</thead>
									<tbody>
										<tr>
										  <td valign="center" ><div align="center"><b>Nombor ID</b></div></td>
										  <td valign="center" ><?php print($NO_ID); ?></td>
										</tr>
										<tr>
										  <td valign="center" ><div align="center"><b>Nama</b></div></td>
										  <td valign="center" ><div align="left"><?php print($NAMA); ?></div></td>
										</tr>
										<tr>
										  <td valign="center"><div align="center"><b>Jenis Akaun</b></div></td>
										  <td valign="center">Pentadbir Sistem</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			<?php
		}
		
		// ##### MZKI ##### MZKI ##### MZKI ############################################################################ MZKI #####
		if($_SESSION['priv_ez'] == "MZKI")
		{
			include('connectDB.php');

			// create the query
			$ID = $_SESSION['ident_ez'];
			$sql = "SELECT NO_KP, NAMA, TEL, EMEL FROM MUZAKKI WHERE NO_KP = $ID";
			
			// execute query
			$result = mysql_query($sql) or die("SQL select statement failed");
			
			// iterate through all rows in result set
			$row = mysql_fetch_array($result);
		
			// extract specific fields
			$NO_KP	= $row["NO_KP"];
			$NAMA 	= $row["NAMA"];
			$TEL	= $row["TEL"];
			$EMEL	= $row["EMEL"];
			
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Butiran Akaun
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									</tbody>
										<tr>
											<td valign="center" ><div align="center"><b>Nombor K/P</b></div></td>
											<td valign="center" ><?php print($NO_KP); ?></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>Nama</b></div></td>
											<td valign="center" ><div align="left"><?php print($NAMA); ?></div></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>No. Telefon</b></div></td>
											<td valign="center" ><div align="left"><?php print($TEL); ?></div></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>E-Mel</b></div></td>
											<td valign="center" ><div align="left"><?php print($EMEL); ?></div></td>
										</tr>
										<tr>
											<td valign="center"><div align="center"><b>Jenis Akaun</b></div></td>
											<td valign="center">Muzakki</td>
										</tr>
									</tbody>
							  </table>
							</div>
						</div>
					</div>
			<?php
		}
		// ##### ASNF ##### ASNF ##### ASNF ############################################################################ ASNF #####
		if($_SESSION['priv_ez'] == "ASNF")
		{
			include('connectDB.php');

			// create the query
			$ID = $_SESSION['ident'];
			$sql = "SELECT * FROM J_KOMANDER WHERE NO_MATRIK = $ID";
			
			// execute query
			$result = mysql_query($sql) or die("SQL select statement failed");
			
			// iterate through all rows in result set
			$row = mysql_fetch_array($result);
		
			// extract specific fields
			$NO_MATRIK	= $row["NO_MATRIK"];
			$NO_BADAN	= $row["NO_BADAN"];
			$BATCH 		= $row["BATCH"];
			$PANGKAT	= $row["PANGKAT"];
			$NAMA 		= $row["NAMA"];
			$KOMPENI 	= $row["KOMPENI"];
			$BIRO		= $row["BIRO"];
			$TEL1		= $row["TEL1"];
			$EMEL1		= $row["EMEL1"];
			$STATUS		= $row["STATUS"];
			$VALIDASI	= $row["VALIDASI"];
			
			// Warna Status
			$WARNA	= null;
			if($STATUS == "Aktif")
			{	$WARNA = "#2eb82e";	}
			elseif(($STATUS == "Tidak Aktif") || ($STATUS == "Digantung (Halted)") || ($STATUS == "Dikeluarkan (Expeled)") || ($STATUS == "Direhatkan (Rest)") || ($STATUS == "Terkeluar (Quit)"))
			{	$WARNA = "red";	}
			elseif($STATUS == "Mantan")
			{	$WARNA = "#ff9900";	}
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Butiran Akaun
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<div align="center"><img class="img-thumbnail" src="NOK/<?php print($BATCH . "/" .$NO_MATRIK); ?>.JPG" width="140" height="210" onerror="this.src='images/nok_gagal.png'"></div><br>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td valign="center" ><div align="center"><b>Nombor Matrik</b></div></td>
											<td valign="center" ><?php print($NO_MATRIK); ?></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>Nombor Badan</b></div></td>
											<td valign="center" ><div align="left"><?php print($NO_BADAN); ?></div></td>
										</tr>
										<tr>
											<?php
												$sql_display = "SELECT BATCH FROM J_BATCH WHERE ID_BATCH = '$BATCH'";
												$result_dispay = mysql_query($sql_display);
												while($row = mysql_fetch_array($result_dispay)) { $DBATCH = $row["BATCH"]; } 
											?>
											<td valign="center"><div align="center"><b>Batch</b></div></td>
											<td valign="center"><?php print($DBATCH); ?></td>
										</tr>
										<tr>
											<?php
												$sql_display = "SELECT PANGKAT FROM J_PANGKAT WHERE ID_PANGKAT = '$PANGKAT'";
												$result_dispay = mysql_query($sql_display);
												while($row = mysql_fetch_array($result_dispay)) { $DPANGKAT = $row["PANGKAT"]; } 
											?>
											<td valign="center"><div align="center"><b>Pangkat</b></div></td>
											<td valign="center"><?php print($DPANGKAT); ?></td>
										</tr>
										<tr>
											<td valign="center"><div align="center"><b>Nama</b></div></td>
											<td valign="center"><?php print($NAMA); ?></td>
										</tr>
										<tr>
											<?php
												$sql_display = "SELECT KOMPENI FROM J_KOMPENI WHERE ID_KOMPENI = '$KOMPENI'";
												$result_dispay = mysql_query($sql_display);
												while($row = mysql_fetch_array($result_dispay)) { $DKOMPENI = $row["KOMPENI"]; } 
											?>
											<td valign="center"><div align="center"><b>Kompeni</b></div></td>
											<td valign="center"><?php print($DKOMPENI); ?></td>
										</tr>
										<tr>
											<?php
												$sql_display = "SELECT BIRO FROM J_BIRO WHERE ID_BIRO = '$BIRO'";
												$result_dispay = mysql_query($sql_display);
												while($row = mysql_fetch_array($result_dispay)) { $DBIRO = $row["BIRO"]; } 
											?>
											<td valign="center"><div align="center"><b>Biro</b></div></td>
											<td valign="center"><?php print($DBIRO); ?></td>
										</tr>
										<tr>
											<td valign="center"><div align="center"><b>Nombor Telefon</b></div></td>
											<td valign="center"><?php print($TEL1); ?></td>
										</tr>
										<tr>
											<td valign="center"><div align="center"><b>E-Mel</b></div></td>
											<td valign="center"><?php print($EMEL1); ?></td>
										</tr>
										<tr>
											<td valign="center"><div align="center"><b>Status</b></div></td>
											<td valign="center"><b><font color='<?php print($WARNA); ?>'><?php print($STATUS); ?></font></b></td>
										</tr>
										<tr>
											<td valign="center"><div align="center"><b>Validasi</b></div></td>
											<td valign="center"><?php print($VALIDASI); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			<?php
		}
	?>
				</div>
				<!-- /.col-lg-8 -->
			</div>
			<!-- /.row -->
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
