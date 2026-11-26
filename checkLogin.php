<?php
	session_start();

	require_once __DIR__ . '/connectDB.php';

	$enteredIC	= request_text($_POST, 'nokp');
	$enteredPW	= is_string($_POST['ktln'] ?? null) ? $_POST['ktln'] : '';
	$enteredTP	= request_text($_POST, 'akaun');

	// Account types: 1 = asnaf (ASNAF), 2 = muzakki (MUZAKKI, the login form), 3 = state zakat body (NEGERI).
	$types = [
		'1' => ['priv' => 'ASNF', 'sql' => "SELECT NO_KP AS ID, NAMA, KATA_LALUAN FROM ASNAF WHERE NO_KP = ?", 'table' => 'ASNAF', 'key' => 'NO_KP'],
		'2' => ['priv' => 'MZKI', 'sql' => "SELECT NO_KP AS ID, NAMA, KATA_LALUAN FROM MUZAKKI WHERE NO_KP = ?", 'table' => 'MUZAKKI', 'key' => 'NO_KP'],
		'3' => ['priv' => 'ADMN', 'sql' => "SELECT KOD_NEGERI AS ID, P_ZAKAT AS NAMA, KATA_LALUAN FROM NEGERI WHERE KOD_NEGERI = ?", 'table' => 'NEGERI', 'key' => 'KOD_NEGERI'],
	];

	if (!isset($types[$enteredTP]))
	{
		header("Location: index.php?ralat=type");
		exit;
	}
	$type = $types[$enteredTP];

	// IC numbers are digits only (no dashes); state codes are 4 letters.
	$validID = $enteredTP === '3' ? (bool) preg_match('/^[A-Za-z]{1,4}$/', $enteredIC) : (bool) preg_match('/^[0-9]{1,12}$/', $enteredIC);

	$row = null;
	if ($validID && $enteredPW !== '')
	{
		$res_sql = db_query($type['sql'], [$enteredIC]);
		$row = $res_sql ? mysqli_fetch_assoc($res_sql) : null;
	}

	$valid = false;
	$hashed = false;
	if ($row && $row['KATA_LALUAN'] !== '')
	{
		$stored = $row['KATA_LALUAN'];
		$hashed = password_get_info($stored)['algo'] !== null;
		$valid	= $hashed ? password_verify($enteredPW, $stored) : hash_equals($stored, $enteredPW);
	}

	if (!$valid)
	{
		header("Location: index.php?ralat=gagal");
		exit;
	}

	// A password still in plain text (tools/hash-passwords.php not run yet) is hashed on its first login.
	if (!$hashed || password_needs_rehash($row['KATA_LALUAN'], PASSWORD_DEFAULT))
	{
		db_query("UPDATE {$type['table']} SET KATA_LALUAN = ? WHERE {$type['key']} = ?", [password_hash($enteredPW, PASSWORD_DEFAULT), $row['ID']]);
	}

	session_regenerate_id(true);
	$_SESSION['zakat_login']	= "YES";
	$_SESSION['zakat_nama']		= $row['NAMA'];
	$_SESSION['zakat_priv']		= $type['priv'];
	$_SESSION['zakat_ident']	= (string) $row['ID'];

	header("Location: utama.php");
	exit;
?>
