<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />

    <title>[E-Asnaf Transfer] - Daftar Masuk</title>
	
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
	
	<?php		
		session_start();
		if(isset($_SESSION['login_ez']))
		{
			header("Location: utama.php");
			exit;
		}
		
		// Clear reset
		include('connectDB.php');
		
		$problem = ""; // 2) Declare
		// $problem = $_GET["problem"];	// 1) Undefined index error
		if(isset($_GET["ralat"]))	// 3) The magic function
		{
			$problem = $_GET["ralat"];
		}
		$errormsg = "<font color='red'> RALAT: ";
		if($problem == "gagal")
		{
			$errormsg = $errormsg . " Nombor K/P atau Kata Laluan salah!!";
		}
		if($problem == "tdkAktif")
		{
			$errormsg = $errormsg . " Akaun anda telah dinyahaktifkan!!";
			?>
			<script>
				window.alert("Akaun anda telah dinyahaktifkan!<br>Sila hubungi pentadbir sistem.");
			</script>
			<?php
		}
		if($problem == "type")
		{
			$errormsg = $errormsg . " Sila pilih jenis akaun!!";
		}
		if($problem == "server")
		{
			$errormsg = $errormsg . " Server sedang mengalami masalah!!";
		}
		if($problem == "db")
		{
			$errormsg = $errormsg . " Pangkalan data gagal disambungkan!!";
		}
		if($problem == "luput")
		{
			$errormsg = $errormsg . " Anda telah didaftar keluar!<br>Sila daftar masuk semula.";
		}
		$errormsg = $errormsg . "</font>";
		/* original error
		if($problem != "")
		{
			print($errormsg);
		}
		*/
	?>

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
	<link rel="stylesheet" href="login_baru.css" type="text/css">
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="/"><< Kembali ke Laman Utama</a><br>
	
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
						<!-- JCIS<sup><font size="3">[Beta]</font></sup> -->
                        <h1><strong><center>E-Asnaf Transfer</center></strong></h1>
						<h5><strong><center>PROJEK SISTEM<br>PENGAGIHAN ZAKAT</center></strong></h5>
						
                    </div>
                    <div class="panel-body">
                        <form id="masuk" name="masuk" role="form" action="checkLogin.php" method="post">
                            <fieldset>
								<?php
									if($problem != "")
									{
										echo '<div class="form-group">
												<center><t class="ralat">
													' . $errormsg . '<br><br>
												</t></center>';
									}
								?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Nombor K/P" name="nokp" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Kata Laluan" name="ktln" type="password">
                                </div>
								<input name="akaun" type="hidden" value="2">
                                <!-- Change this to a button or input when using this as a form -->
								<input type="submit" class="btn btn-lg btn-success btn-block" form="masuk" value="Daftar Masuk" />
								<div class="form-group">
									<center>
										<br>
										<!--<h6>Daftar akaun asnaf baru? <a href="daftar_asnaf.php"> Klik Sini </a></h6>-->
										<h6>Daftar akaun muzakki baru? <a href="daftar_muzakki.php"> Klik Sini </a></h6>
										<h6>Cadang asnaf? <a href="cadang_asnaf.php"> Klik Sini </a></h6>
									</center>
								</div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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