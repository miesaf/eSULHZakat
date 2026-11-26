<?php
// Copy to config.php (git-ignored) and fill in the database credentials.
return [
	'db_host' => 'localhost',
	'db_user' => '',
	'db_pass' => '',
	'db_name' => '',
	// Payment statements e-mailed to the muzakki: sender address (empty = donotreply@<this host>)
	// and an optional blind copy.
	'mail_from' => '',
	'mail_bcc' => '',
];
