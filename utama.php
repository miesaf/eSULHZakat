<?php ob_start(); ?>
<html lang="ms-my">
<head>
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />
	<?php
		session_start();
		require_once __DIR__ . '/connectDB.php';
		require_login();
		$name	= $_SESSION['zakat_nama'];
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
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">E-Asnaf Transfer</h1>
				</div>
				<!-- /.col-lg-10 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-8">
<?php
	$priv	= $_SESSION['zakat_priv'] ?? '';
	$ID		= $_SESSION['zakat_ident'] ?? '';

	// ##### ADMN ##### ADMN ##### ADMN ############################################################################ ADMN #####
	// A state zakat body (table NEGERI).
	if($priv == "ADMN")
	{
		$result	= db_query("SELECT KOD_NEGERI, NEGERI, P_ZAKAT FROM NEGERI WHERE KOD_NEGERI = ?", [$ID]);
		$row	= $result ? mysqli_fetch_assoc($result) : null;
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
										  <td valign="center" ><div align="center"><b>Kod Negeri</b></div></td>
										  <td valign="center" ><?php echo e($row['KOD_NEGERI'] ?? ''); ?></td>
										</tr>
										<tr>
										  <td valign="center" ><div align="center"><b>Nama</b></div></td>
										  <td valign="center" ><div align="left"><?php echo e($row['P_ZAKAT'] ?? ''); ?></div></td>
										</tr>
										<tr>
										  <td valign="center" ><div align="center"><b>Negeri</b></div></td>
										  <td valign="center" ><div align="left"><?php echo e($row['NEGERI'] ?? ''); ?></div></td>
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
		if($priv == "MZKI")
		{
			$result	= db_query("SELECT NO_KP, NAMA, TEL, EMEL FROM MUZAKKI WHERE NO_KP = ?", [$ID]);
			$row	= $result ? mysqli_fetch_assoc($result) : null;
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Butiran Akaun
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td valign="center" ><div align="center"><b>Nombor K/P</b></div></td>
											<td valign="center" ><?php echo e($row['NO_KP'] ?? ''); ?></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>Nama</b></div></td>
											<td valign="center" ><div align="left"><?php echo e($row['NAMA'] ?? ''); ?></div></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>No. Telefon</b></div></td>
											<td valign="center" ><div align="left"><?php echo e($row['TEL'] ?? ''); ?></div></td>
										</tr>
										<tr>
											<td valign="center" ><div align="center"><b>E-Mel</b></div></td>
											<td valign="center" ><div align="left"><?php echo e($row['EMEL'] ?? ''); ?></div></td>
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
		if($priv == "ASNF")
		{
			$result	= db_query("SELECT A.NO_KP, A.NAMA, A.TEL, A.JLN_1, A.JLN_2, A.POSKOD, A.BANDAR, P.NAMA_KWSN, D.NAMA_DAERAH, N.NEGERI, J.JENIS, B.NAMA_BANK, A.NO_AKAUN
				FROM ASNAF A
				LEFT JOIN PERUMAHAN P ON P.KOD_KWSN = A.PERUMAHAN
				LEFT JOIN DAERAH D ON D.KOD_DAERAH = A.DAERAH
				LEFT JOIN NEGERI N ON N.KOD_NEGERI = A.NEGERI
				LEFT JOIN JENIS_ASNAF J ON J.KOD_JENIS = A.JENIS
				LEFT JOIN BANK B ON B.KOD_BANK = A.BANK
				WHERE A.NO_KP = ?", [$ID]);
			$row	= $result ? mysqli_fetch_assoc($result) : null;
			$fields	= [
				'Nombor K/P'		=> $row['NO_KP'] ?? '',
				'Nama'				=> $row['NAMA'] ?? '',
				'No. Telefon'		=> $row['TEL'] ?? '',
				'Alamat'			=> trim(($row['JLN_1'] ?? '') . ', ' . ($row['JLN_2'] ?? ''), ', '),
				'Poskod'			=> $row['POSKOD'] ?? '',
				'Kawasan Perumahan'	=> $row['NAMA_KWSN'] ?? '',
				'Bandar'			=> $row['BANDAR'] ?? '',
				'Daerah'			=> $row['NAMA_DAERAH'] ?? '',
				'Negeri'			=> $row['NEGERI'] ?? '',
				'Jenis Asnaf'		=> $row['JENIS'] ?? '',
				'Bank'				=> $row['NAMA_BANK'] ?? '',
				'Nombor Akaun'		=> $row['NO_AKAUN'] ?? '',
			];
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user fa-fw"></i> Butiran Akaun
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<?php foreach ($fields as $label => $value) { ?>
										<tr>
											<td valign="center" ><div align="center"><b><?php echo e($label); ?></b></div></td>
											<td valign="center" ><div align="left"><?php echo e($value); ?></div></td>
										</tr>
										<?php } ?>
										<tr>
											<td valign="center"><div align="center"><b>Jenis Akaun</b></div></td>
											<td valign="center">Asnaf</td>
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
