<html>
<head>
	<?php
		include('connectDB.php');
		
		if(isset($_POST['DAFTAR']))
		{
			// Declaring null value for optional variables
			$JLN_2		= null;
			
			// Variables from pendaftaran.php
			$NAMA		= mysql_real_escape_string($_POST['NAMA']);
			$NO_KP		= mysql_real_escape_string($_POST['NO_KP']);
			$KATA_LALUAN= mysql_real_escape_string($_POST['KATA_LALUAN']);
			$TEL		= mysql_real_escape_string($_POST['TEL']);
			$EMEL		= mysql_real_escape_string($_POST['EMEL']);
			
			//SQL query command
			$sql="INSERT INTO MUZAKKI (NAMA, NO_KP, KATA_LALUAN, TEL, EMEL) VALUES (\"$NAMA\", $NO_KP, \"$KATA_LALUAN\", \"$TEL\", \"$EMEL\")";
			
			// execute query
			$exe_sql = mysql_query($sql);
			
			// confirming the record is added
			if ($exe_sql)
			{
				echo '<html>
						<head>
							<script>
								window.alert("Pendaftaran berjaya!\nRekod telah di simpan ke dalam pangkalan data.");
							</script>
							<meta http-equiv="refresh" content="0; url=index.php" />
						</head>
					</html>';
			}
			else
			{
				echo "SQL insert statement failed.<br>" . mysql_error();
				echo '<html>
						<head>
							<script>
								window.alert("Pendaftaran gagal!\nRekod tidak di simpan ke dalam pangkalan data");
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

    <title>[E-Asnaf Transfer] - Daftar Muzakki</title>
	
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
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
							<a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Daftar Masuk</a>
						</li>
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
					<h1 class="page-header">Daftar Muzakki</h1>
				</div>
                <!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
				<!-- mula     ##########################################################################################     mula -->
			<div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Borang Pendaftaran Muzakki (Pembayar Zakat) Baru</b>
                        </div>
						<?php
							if(!isset($_POST['DAFTAR']))
							{
						?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="daftar_muzakki" action ="daftar_muzakki.php" method ="POST" enctype="multipart/form-data">
										<input type="hidden" name="DAFTAR" value="YES">
                                        <div class="form-group">
											<label>Nama Penuh</label>
                                            <input class="form-control" type="text" maxlength="100" size="50" name="NAMA">
                                        </div>
										<div class="form-group">
											<label>Nombor Kad Pengenalan</label>
                                            <input class="form-control" type="text" size="12" maxlength="12" name="NO_KP">
                                            <p class="help-block">95xxxxxxxxxx (Tanpa sengkang '-')</p>
                                        </div>
										<div class="form-group">
                                            <label>Kata Laluan</label>
                                            <input class="form-control" type="password" size="12" maxlength="50" name="KATA_LALUAN">
                                        </div>
										<div class="form-group">
											<label>Nombor Telefon</label>
                                            <input class="form-control" type="text" size="12" maxlength="20" name="TEL">
                                            <p class="help-block">+6012-xxxx xxx</p>
                                        </div>
										<div class="form-group">
											<label>E-Mel</label>
                                            <input class="form-control" type="text" size="12" maxlength="100" name="EMEL">
                                        </div>
								</div>
								<!-- /.col-lg-12 -->
							</div>
							<!-- /.row -->
							<div class="row" align="center">
				<!-- Buttons #########################################################################################################-->
								<br />
								<button type="submit" class="btn btn-outline btn-success" form="daftar_muzakki" value="Submit">Daftar</button>
								<button type="reset" class="btn btn-outline btn-warning"form="daftar_muzakki" value="Reset">Reset</button>
								<a href="index.php"><button type="button" class="btn btn-outline btn-danger" >Batal</button></a>
								<br /><br />
							</div>
							<!-- /.row -->
									</form>
					<!-- tamat     ########################################################################################     tamat -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel-default -->
					<?php
							}
					?>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.page-wrapper -->

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
