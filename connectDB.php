<?php
	// Database connection. The credentials live in config.php (not in git); copy config.example.php to start.
	mysqli_report(MYSQLI_REPORT_OFF);
	date_default_timezone_set('Asia/Kuala_Lumpur');

	$zakat_config = require __DIR__ . '/config.php';
	$condb = mysqli_connect($zakat_config['db_host'], $zakat_config['db_user'], $zakat_config['db_pass'], $zakat_config['db_name']);
	define('ZAKAT_MAIL_FROM', (string) ($zakat_config['mail_from'] ?? ''));
	define('ZAKAT_MAIL_BCC', (string) ($zakat_config['mail_bcc'] ?? ''));
	unset($zakat_config);

	if (!$condb)
	{
		http_response_code(500);
		die("Pangkalan data gagal disambungkan.");
	}

	// The 2017 code relies on MySQL's non-strict mode.
	mysqli_query($condb, "SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

	// Runs a prepared statement: a mysqli_result for SELECT, true or false otherwise.
	function db_query(string $sql, array $params = [])
	{
		global $condb;
		return mysqli_execute_query($condb, $sql, $params);
	}

	// The first column of the first row, or '' when there is none (code-to-name lookups).
	function db_value(string $sql, array $params = []): string
	{
		$result = db_query($sql, $params);
		$row = $result ? mysqli_fetch_row($result) : null;
		return $row ? (string) $row[0] : '';
	}

	// True when $value is a code in a lookup table ($table and $column are constants in the code, never request data).
	function kod_sah(string $table, string $column, string $value): bool
	{
		return $value !== '' && db_value("SELECT COUNT(*) FROM $table WHERE $column = ?", [$value]) === "1";
	}

	// The address and bank fields of the asnaf forms (daftar_asnaf.php, cadang_asnaf.php, input.php), with the
	// codes checked against their lookup tables. Returns [fields, error message or null].
	function asnaf_fields(array $source): array
	{
		$f = [
			'NAMA'		=> request_text($source, 'NAMA'),
			'NO_KP'		=> request_ic($source, 'NO_KP'),
			'TEL'		=> request_text($source, 'TEL'),
			'JLN_1'		=> request_text($source, 'JLN_1'),
			'JLN_2'		=> request_text($source, 'JLN_2'),
			'POSKOD'	=> request_count($source, 'POSKOD'),
			'PERUMAHAN'	=> request_text($source, 'PERUMAHAN'),
			'BANDAR'	=> request_text($source, 'BANDAR'),
			'DAERAH'	=> request_text($source, 'DAERAH'),
			'NEGERI'	=> request_text($source, 'NEGERI'),
			'PENDAPATAN'	=> request_count($source, 'PENDAPATAN'),
			'JENIS'		=> request_text($source, 'JENIS'),
			'BANK'		=> request_text($source, 'BANK'),
			'NO_AKAUN'	=> request_text($source, 'NO_AKAUN'),
		];

		if ($f['NAMA'] === '' || $f['NO_KP'] === null)
		{
			return [$f, "Sila isi nama dan nombor K/P (12 digit tanpa sengkang)."];
		}
		if (!kod_sah('NEGERI', 'KOD_NEGERI', $f['NEGERI']) || !kod_sah('DAERAH', 'KOD_DAERAH', $f['DAERAH']) || !kod_sah('PERUMAHAN', 'KOD_KWSN', $f['PERUMAHAN']))
		{
			return [$f, "Sila pilih negeri, daerah dan kawasan perumahan."];
		}
		if (!kod_sah('BANK', 'KOD_BANK', $f['BANK']))
		{
			return [$f, "Sila pilih bank."];
		}
		return [$f, null];
	}

	// Rows changed by the last INSERT / UPDATE / DELETE.
	function db_affected(): int
	{
		global $condb;
		return (int) mysqli_affected_rows($condb);
	}

	// One application (PERMOHONAN) with its state, district, housing area and asnaf type names, or null.
	function permohonan_row(?int $NO_SIRI): ?array
	{
		if ($NO_SIRI === null)
		{
			return null;
		}
		$result = db_query("SELECT P.*, N.NEGERI AS DNEGERI, D.NAMA_DAERAH AS DDAERAH, K.NAMA_KWSN AS DPERUMAHAN, J.JENIS AS DJENIS
			FROM PERMOHONAN P
			LEFT JOIN NEGERI N ON N.KOD_NEGERI = P.NEGERI
			LEFT JOIN DAERAH D ON D.KOD_DAERAH = P.DAERAH
			LEFT JOIN PERUMAHAN K ON K.KOD_KWSN = P.PERUMAHAN
			LEFT JOIN JENIS_ASNAF J ON J.KOD_JENIS = P.JENIS
			WHERE P.NO_SIRI = ?", [$NO_SIRI]);
		return ($result ? mysqli_fetch_assoc($result) : null) ?: null;
	}

	// Escapes a value for HTML output.
	function e($value): string
	{
		return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	}

	// A value for a JavaScript string literal inside a <script> block.
	function js($value): string
	{
		return json_encode((string) $value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_INVALID_UTF8_SUBSTITUTE);
	}

	// A payment log (LOG_BAYARAN) for HTML: escaped, with the <br> line breaks it is stored with kept.
	function log_html($log): string
	{
		return str_ireplace(['&lt;br&gt;', '&lt;br /&gt;'], '<br>', e($log));
	}

	// A text value from $_GET or $_POST ('' when it is missing or not a single value), trimmed.
	function request_text(array $source, string $key): string
	{
		$value = $source[$key] ?? '';
		return is_string($value) ? trim($value) : '';
	}

	// A positive whole number from $_GET or $_POST, or null.
	function request_id(array $source, string $key): ?int
	{
		$id = filter_var($source[$key] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
		return $id === false ? null : $id;
	}

	// A whole number of at least 0 (counts, amounts, income); 0 when it is missing or not a number.
	function request_count(array $source, string $key): int
	{
		$value = filter_var($source[$key] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
		return $value === false ? 0 : $value;
	}

	// An IC number (NO_KP, 1-12 digits, no dashes) from $_GET or $_POST, or null.
	function request_ic(array $source, string $key): ?string
	{
		$value = request_text($source, $key);
		return preg_match('/^[0-9]{1,12}$/', $value) ? $value : null;
	}

	// Shows a browser alert, then goes to $url, or back to the previous page when $url is null.
	function js_alert(string $message, ?string $url = null): void
	{
		echo '<script>window.alert(' . js($message) . ');';
		echo $url === null ? 'window.history.go(-1);' : 'window.location.href = ' . js($url) . ';';
		echo '</script>';
	}

	// Sends a visitor who is not logged in (or whose account type is not in $roles) to the login page.
	// Account types: ASNF (asnaf), MZKI (muzakki), ADMN (state zakat body).
	function require_login(array $roles = []): void
	{
		if (empty($_SESSION['zakat_login']))
		{
			header("Location: index.php?ralat=luput");
			exit;
		}
		if ($roles && !in_array($_SESSION['zakat_priv'] ?? '', $roles, true))
		{
			header("Location: utama.php");
			exit;
		}
	}

	// The label shown before the user's name in the top bar.
	function account_label(): string
	{
		return match ($_SESSION['zakat_priv'] ?? '') {
			'ADMN' => 'Admin | ',
			'MZKI' => 'Muzakki | ',
			'ASNF' => 'Asnaf | ',
			default => '',
		};
	}
?>
