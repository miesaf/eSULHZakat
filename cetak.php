<?php ob_start(); ?>
<html>
<head>
	<?php
		session_start();
		require_once __DIR__ . '/connectDB.php';
		require_login();
		$name	= $_SESSION['zakat_nama'];
	?>
	<title>[E-Asnaf Transfer] - Cetak Penyata Pembayaran</title>
</head>
<body onload="window.print()">
	<?php
	$row = permohonan_row(request_id($_GET, 'ID'));

	if($row)
	{
		echo "<h2>E-Asnaf Transfer</h2>";
		echo "<h1>Penyata Pembayaran Zakat</h1>";
		echo "<table>
				<tbody>
				<tr><td><b>Nama Penerima</b></td><td>: " . e($row["NAMA"]) . "</td></tr>
				<tr><td><b>Negeri Kediaman</b></td><td>: " . e($row["DNEGERI"]) . "</td></tr>
				<tr><td><b>Daerah Kediaman</b></td><td>: " . e($row["DDAERAH"]) . "</td></tr>
				<tr><td><b>Kawasan Perumahan</b></td><td>: " . e($row["DPERUMAHAN"]) . "</td></tr>
				<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>: " . e($row["DJENIS"]) . "</td></tr>";
		echo "</tbody></table>";
		echo "<h3>Log Pembayaran</h3>
			<h4>" . log_html($row["LOG_BAYARAN"]) . "</h4>";
	}
	else
	{
		echo "<table><tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
	}
	?>
</body>
</html>
