<?php
// One-time: hashes every plain-text password in ASNAF, MUZAKKI and NEGERI. Run from the app folder after
// sql/2026-11-hash-passwords.sql:  php tools/hash-passwords.php
// Empty passwords are left empty (such an account cannot log in until a password is set).
if (PHP_SAPI !== 'cli') {
	http_response_code(404);
	exit;
}

require __DIR__ . '/../connectDB.php';

$tables = ['ASNAF' => 'NO_KP', 'MUZAKKI' => 'NO_KP', 'NEGERI' => 'KOD_NEGERI'];
foreach ($tables as $table => $key) {
	$hashed = 0;
	$skipped = 0;
	$rows = db_query("SELECT $key AS ID, KATA_LALUAN FROM $table");
	foreach (mysqli_fetch_all($rows, MYSQLI_ASSOC) as $row) {
		if ($row['KATA_LALUAN'] === '' || password_get_info($row['KATA_LALUAN'])['algo'] !== null) {
			$skipped++;
			continue;
		}
		db_query("UPDATE $table SET KATA_LALUAN = ? WHERE $key = ?", [password_hash($row['KATA_LALUAN'], PASSWORD_DEFAULT), $row['ID']]);
		$hashed++;
	}
	echo "$table: hashed $hashed, skipped (empty or already hashed) $skipped\n";
}
