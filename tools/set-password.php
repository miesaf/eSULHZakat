<?php
// Sets the password of one account (asks for it, hashes it):
//   php tools/set-password.php admin <state code, e.g. SLGR>
//   php tools/set-password.php muzakki <IC number>
//   php tools/set-password.php asnaf <IC number>
if (PHP_SAPI !== 'cli') {
	http_response_code(404);
	exit;
}

$tables = ['admin' => ['NEGERI', 'KOD_NEGERI'], 'muzakki' => ['MUZAKKI', 'NO_KP'], 'asnaf' => ['ASNAF', 'NO_KP']];
$type = $argv[1] ?? '';
$id = $argv[2] ?? '';
if (!isset($tables[$type]) || $id === '') {
	fwrite(STDERR, "Usage: php tools/set-password.php admin|muzakki|asnaf <id>\n");
	exit(1);
}

require __DIR__ . '/../connectDB.php';
[$table, $key] = $tables[$type];

if (db_value("SELECT COUNT(*) FROM $table WHERE $key = ?", [$id]) !== '1') {
	fwrite(STDERR, "No $type account $id.\n");
	exit(1);
}

echo "New password: ";
system('stty -echo');
$password = trim((string) fgets(STDIN));
system('stty echo');
echo "\n";
if ($password === '') {
	fwrite(STDERR, "Empty password, nothing changed.\n");
	exit(1);
}

db_query("UPDATE $table SET KATA_LALUAN = ? WHERE $key = ?", [password_hash($password, PASSWORD_DEFAULT), $id]);
echo "Password set for $type $id.\n";
