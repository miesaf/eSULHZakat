<?php
	// Serves the proof of income uploaded with a suggestion (CADANG_ASNAF.BUKTI) to logged-in users.
	// The bukti/ folder itself is not served (bukti/.htaccess).
	session_start();
	require_once __DIR__ . '/connectDB.php';
	require_login();

	$types = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];

	$ID		= request_ic($_GET, 'ID');
	$file	= $ID === null ? '' : basename(db_value("SELECT BUKTI FROM CADANG_ASNAF WHERE NO_KP = ?", [$ID]));
	$ext	= strtolower(pathinfo($file, PATHINFO_EXTENSION));
	$path	= __DIR__ . '/bukti/' . $file;

	if ($file === '' || !isset($types[$ext]) || !is_file($path))
	{
		http_response_code(404);
		exit("Fail tidak dijumpai.");
	}

	header('Content-Type: ' . $types[$ext]);
	header('Content-Length: ' . filesize($path));
	header('Content-Disposition: inline; filename="bukti.' . $ext . '"');
	header('X-Content-Type-Options: nosniff');
	header('Cache-Control: private, no-store');
	readfile($path);
	exit;
?>
