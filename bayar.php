<?php ob_start(); ?>
<html>
<head>
	<?php
		session_start();
		require_once __DIR__ . '/connectDB.php';
		// Only a muzakki (zakat payer) pays; the payment log names the muzakki.
		require_login(['MZKI']);
		$name	= $_SESSION['zakat_nama'];

		// E-Mel Pembayaran: e-mails the payment statement of application $NO_SIRI to muzakki $NO_KP.
		function bayar_ok(string $NO_KP, int $NO_SIRI): bool
		{
			$result = db_query("SELECT P.NAMA, N.NEGERI, D.NAMA_DAERAH, K.NAMA_KWSN, J.JENIS, P.LOG_BAYARAN
				FROM PERMOHONAN P
				LEFT JOIN NEGERI N ON N.KOD_NEGERI = P.NEGERI
				LEFT JOIN DAERAH D ON D.KOD_DAERAH = P.DAERAH
				LEFT JOIN PERUMAHAN K ON K.KOD_KWSN = P.PERUMAHAN
				LEFT JOIN JENIS_ASNAF J ON J.KOD_JENIS = P.JENIS
				WHERE P.NO_SIRI = ?", [$NO_SIRI]);
			$row = $result ? mysqli_fetch_assoc($result) : null;
			$EMEL = db_value("SELECT EMEL FROM MUZAKKI WHERE NO_KP = ?", [$NO_KP]);

			if (!$row || !filter_var($EMEL, FILTER_VALIDATE_EMAIL))
			{
				return false;
			}

			$Subject = "Penyata Pembayaran Zakat";
			$Message = "<html>
						<body>
							<h2>E-Asnaf Transfer</h2>
							<h1>Penyata Pembayaran Zakat</h1>
							<table>
								<tbody>
								<tr><td><b>Nama Penerima</b></td><td>: " . e($row['NAMA']) . "</td></tr>
								<tr><td><b>Negeri Kediaman</b></td><td>: " . e($row['NEGERI']) . "</td></tr>
								<tr><td><b>Daerah Kediaman</b></td><td>: " . e($row['NAMA_DAERAH']) . "</td></tr>
								<tr><td><b>Kawasan Perumahan</b></td><td>: " . e($row['NAMA_KWSN']) . "</td></tr>
								<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>: " . e($row['JENIS']) . "</td></tr>
								</tbody>
							</table>
							<h3>Log Pembayaran</h3>
							<h4>" . log_html($row['LOG_BAYARAN']) . "</h4>
						</body>
						</html>";

			// The sender and the optional blind copy come from config.php.
			$host	= preg_replace('/[^A-Za-z0-9.-]/', '', (string) ($_SERVER['SERVER_NAME'] ?? 'localhost'));
			$from	= filter_var(ZAKAT_MAIL_FROM, FILTER_VALIDATE_EMAIL) ?: "donotreply@" . $host;
			$Headers	= [];
			$Headers[]	= "MIME-Version: 1.0";
			$Headers[]	= "Content-type: text/html; charset=\"UTF-8\"";
			$Headers[]	= "From: E-Asnaf Transfer <" . $from . ">";
			if (filter_var(ZAKAT_MAIL_BCC, FILTER_VALIDATE_EMAIL))
			{
				$Headers[]	= "Bcc: " . ZAKAT_MAIL_BCC;
			}

			return mail($EMEL, $Subject, $Message, implode("\r\n", $Headers));
		}

		if(isset($_POST["BAYAR"]))
		{
			$NO_SIRI	= request_id($_POST, "NO_SIRI");
			$AMAUN		= request_id($_POST, "AMAUN");	// whole ringgit, at least 1
			$ID_MUZAKKI	= $_SESSION["zakat_ident"];

			$result_3	= db_query("SELECT NAMA, TEL FROM MUZAKKI WHERE NO_KP = ?", [$ID_MUZAKKI]);
			$row3		= $result_3 ? mysqli_fetch_assoc($result_3) : null;
			$NAMA		= $row3["NAMA"] ?? $name;
			$TEL		= $row3["TEL"] ?? "";

			// Tarikh pembayaran (Malaysian time)
			$DHARI	= ["Ahad", "Isnin", "Selasa", "Rabu", "Khamis", "Jumaat", "Sabtu"];
			$DBULAN	= [1 => "Januari", "Februari", "Mac", "April", "Mei", "Jun", "Julai", "Ogos", "September", "Oktober", "November", "Disember"];
			$DTARIKH	= $DHARI[(int) date("w")] . ", " . date("d") . " " . $DBULAN[(int) date("n")] . " " . date("Y g:i:s a");

			// Stored with <br> line breaks; escaped when it is shown (log_html()).
			$LOG_BAYARAN	= "---------------------------------------<br>"
							. "Nama Pembayar : $NAMA<br>"
							. "Telefon : $TEL<br>"
							. "Amaun : RM $AMAUN<br>"
							. "Tarikh : $DTARIKH<br>"
							. "---------------------------------------<br><br>";

			if($NO_SIRI === null || db_value("SELECT COUNT(*) FROM PERMOHONAN WHERE NO_SIRI = ?", [$NO_SIRI]) !== "1")
			{
				js_alert("Permohonan tidak dijumpai!", "senarai_permohonan.php");
			}
			elseif($AMAUN === null)
			{
				js_alert("Sila masukkan amaun yang sah (RM 1 ke atas)!");
			}
			else
			{
				// The balance is read and changed in one statement, so the amount can never exceed it.
				$exe_sql = db_query("UPDATE PERMOHONAN SET KIFAYAH_BAKI = KIFAYAH_BAKI - ?, KIFAYAH_KREDIT = KIFAYAH_KREDIT + ?, LOG_BAYARAN = CONCAT(LOG_BAYARAN, ?)
					WHERE NO_SIRI = ? AND KIFAYAH_BAKI >= ?", [$AMAUN, $AMAUN, $LOG_BAYARAN, $NO_SIRI, $AMAUN]);

				if ($exe_sql && db_affected() === 1)
				{
					bayar_ok($ID_MUZAKKI, $NO_SIRI);
					js_alert("Pembayaran berjaya!", "rincian.php?ID=" . $NO_SIRI);
				}
				elseif ($exe_sql)
				{
					js_alert("Amaun yang dimasukkan melebihi had!");
				}
				else
				{
					js_alert("Pembayaran gagal!");
				}
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
						$ID		= request_id($_GET, 'ID');
						$row	= null;

						if($ID !== null)
						{
							$result = db_query("SELECT P.NO_SIRI, P.NAMA, P.KIFAYAH_BAKI, J.JENIS AS DJENIS, B.NAMA_BANK, A.NO_AKAUN
								FROM PERMOHONAN P
								LEFT JOIN JENIS_ASNAF J ON J.KOD_JENIS = P.JENIS
								LEFT JOIN ASNAF A ON A.NO_KP = P.PEMOHON
								LEFT JOIN BANK B ON B.KOD_BANK = A.BANK
								WHERE P.NO_SIRI = ?", [$ID]);
							$row = $result ? mysqli_fetch_assoc($result) : null;
						}

						if($row)
						{
							echo "	<input type=\"hidden\" name=\"NO_SIRI\" value=\"" . e($row["NO_SIRI"]) . "\">";
							echo "<tbody>
									<tr><td colspan='2' align='left' bgcolor='#F0F0F0'><b> A) Butiran Pemohon </b></td></tr>
									<tr><td><b>Nama Penerima</b></td><td>" . e($row["NAMA"]) . "</td></tr>
									<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>" . e($row["DJENIS"]) . "</td></tr>
									<tr><td><b>Baki Kifayah</b></td><td style='vertical-align:middle'>RM " . e($row["KIFAYAH_BAKI"]) . "</td></tr>
									<tr><td colspan='2'> &nbsp; </td></tr>
									<tr><td colspan='2' align='left' bgcolor='#F0F0F0'><b> B) Butiran Pembayaran </b></td></tr>
									<tr><td><b>Nama Pembayar</b></td><td>" . e($name) . "</td></tr>
									<tr><td><b>Jenis Bank Penerima</b></td><td>" . e($row["NAMA_BANK"]) . "</td></tr>
									<tr><td><b>No. Akaun Penerima</b></td><td>" . e($row["NO_AKAUN"]) . "</td></tr>
									<tr><td><b>Amaun Hendak Dibayar</b></td><td><table><td>RM&nbsp;</td><td><input class=\"form-control\" type=\"text\" maxlength=\"10\" size=\"3\" name=\"AMAUN\"></td><td>.00</td></table></td></tr>";
							echo "</tbody></table>";
							echo "<center><button class=\"btn btn-outline btn-success\" type=\"submit\" form=\"bayar_zakat\" value=\"Submit\">Bayar</button></center></form>";
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
