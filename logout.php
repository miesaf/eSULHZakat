<?php
	session_start();

	unset($_SESSION['zakat_login'], $_SESSION['zakat_ident'], $_SESSION['zakat_priv'], $_SESSION['zakat_nama']);
	session_regenerate_id(true);
?>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico">
	<title>[E-Asnaf Transfer] - Logout</title>
	<script>
		window.alert("Anda telah mendaftar keluar dari sistem!\nTerima kasih kerana menggunakan sistem ini.");
	</script>
</head>
<body>
		<meta http-equiv="refresh" content="0; url=index.php" />
</body>
</html>
