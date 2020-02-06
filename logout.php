<?php
	session_start();
	
	unset($_SESSION['login_ez']);
	unset($_SESSION['ident_ez']);
	unset($_SESSION['priv_ez']);
	unset($_SESSION['name_ez']);
	// session_destroy();
?>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico">
	<title>[E-Asnaf Transfer] - Logout</title>
	<script>
		window.alert("Anda telah mendaftar keluar dari sistem!\nTerima kasih kerana menggunakan sistem ini.");
	</script>
	<?php
		//$name = $_GET['name'];
	?>
</head>
<body>
		<!--<h1> Goodbye</h1>-->
		<meta http-equiv="refresh" content="0; url=index.php" />
</body>
</html>