<?php ob_start(); ?>
<html>
<head>
	<?php
		session_start();
		require_once __DIR__ . '/connectDB.php';
		require_login();
		$name	= $_SESSION['zakat_nama'];
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
					<?php echo e(account_label()); ?><strong><?php echo e($name); ?></strong>
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
							include __DIR__ . '/nav.php';
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
						$row = permohonan_row(request_id($_GET, 'ID'));

						if($row)
						{
							$NO_SIRI		= (int) $row["NO_SIRI"];
							$KIFAYAH_BAKI	= (int) $row["KIFAYAH_BAKI"];
							$KIFAYAH_KREDIT	= (int) $row["KIFAYAH_KREDIT"];
							$HAD_KIFAYAH	= $KIFAYAH_BAKI + $KIFAYAH_KREDIT;

							$RUMAH = "";
							if($row["RUMAH"] !== null && (int) $row["RUMAH"] === 1)
							{
								$RUMAH = "Berbayar";
							}
							elseif($row["RUMAH"] !== null && (int) $row["RUMAH"] === 0)
							{
								$RUMAH = "Percuma";
							}

							$latar = [
								'Jenis Pemilikan Rumah'								=> $RUMAH,
								'Bilangan Pasangan Bekerja'							=> $row["BINI_B"],
								'Bilangan Pasangan Tidak Bekerja'					=> $row["BINI_M"],
								'Bilangan Anak Umur Lebih 18 Tahun Bekerja'			=> $row["DEW_B"],
								'Bilangan Anak Umur Lebih 18 Tahun Tidak Bekerja'	=> $row["DEW_M"],
								'Bilangan Anak Belajar Di IPT'						=> $row["ANAK_I"],
								'Bilangan Anak Bersekolah'							=> $row["ANAK_R"],
								'Bilangan Anak Tidak Bersekolah'					=> $row["ANAK_M"],
								'Bilangan Tanggungan Cacat'							=> $row["CACAT"],
								'Bilangan Tanggungan Bayi'							=> $row["BAYI"],
								'Bilangan Tanggungan Penyakit Kronik'				=> $row["KRONIK"],
							];

							echo "<tbody>
									<tr><td><b>Nama</b></td><td>" . e($row["NAMA"]) . "</td></tr>
									<tr><td><b>Tarikh Mohon</b></td><td>" . e($row["TARIKH_MOHON"]) . "</td></tr>
									<tr><td><b>Negeri Kediaman</b></td><td>" . e($row["DNEGERI"]) . "</td></tr>
									<tr><td><b>Daerah Kediaman</b></td><td>" . e($row["DDAERAH"]) . "</td></tr>
									<tr><td><b>Kawasan Perumahan</b></td><td>" . e($row["DPERUMAHAN"]) . "</td></tr>
									<tr><td><b>Pendapatan</b></td><td style='vertical-align:middle'>RM " . e($row["PENDAPATAN"]) . "</td></tr>
									<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>" . e($row["DJENIS"]) . "</td></tr>
									<tr><td><b>Latar Belakang</b></td><td style='vertical-align:middle'>";
							echo "<table class=\"table table-striped table-bordered table-hover\">
									<tbody>
									<tr>
										<td align=\"center\"><b>Butiran</b></td><td align=\"center\"><b>Bilangan</b></td>
									</tr>";
							foreach ($latar as $label => $value)
							{
								echo "
									<tr>
										<td>" . e($label) . "</td><td>" . e($value) . "</td>
									</tr>";
							}
							echo "
									</tbody>
								</table>";
							echo "</td></tr>
									<tr><td><b>Had Kifayah</b></td><td style='vertical-align:middle'>RM " . e($HAD_KIFAYAH) . "</td></tr>
									<tr><td><b>Baki Kifayah</b></td><td style='vertical-align:middle'>RM " . e($KIFAYAH_BAKI) . "</td></tr>
									<tr><td><b>Amaun yang telah<br>dikreditkan kepada<br>asnaf</b></td><td style='vertical-align:middle'>RM " . e($KIFAYAH_KREDIT) . "</td></tr>
									<tr><td><b>Log pengkreditan<br>zakat kepada asnaf</b></td><td style='white-space: pre'>" . log_html($row["LOG_BAYARAN"]) . "<a href=\"cetak.php?ID=" . $NO_SIRI . "\"><button type='button' class='btn btn-outline btn-info' >Cetak Penyata Pembayaran</button></a></td></tr>";
							echo "</tbody></table>";

							// Only a muzakki pays (bayar.php).
							if($KIFAYAH_BAKI > 0 && ($_SESSION['zakat_priv'] ?? '') == "MZKI")
							{
								echo "<center><a href=\"bayar.php?ID=" . $NO_SIRI . "\"><button type='button' class='btn btn-outline btn-success' >Bayar zakat kepada asnaf</button></a></center>";
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
