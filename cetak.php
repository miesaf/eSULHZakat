<html>
<head>
	<?php
		session_start();
		if(!$_SESSION['login_ez'])
		{
			header("Location: index.php?ralat=luput");
			exit;
		}
		$name	= $_SESSION['name_ez'];
		
		include('connectDB.php');
	?>
	<title>[E-Asnaf Transfer] - Cetak Penyata Pembayaran</title>
</head>
<body onload="window.print()">
	<?php
	$ID = mysql_real_escape_string($_GET['ID']);
	
	$D_BC = false;
	
	if($ID != null)
	{
		// create the query
		$sql = "SELECT * FROM PERMOHONAN WHERE NO_SIRI = $ID";
		
		// execute query
		$result = mysql_query($sql) or die("SQL select statement failed");
		
		// iterate through all rows in result set
		if($row = mysql_fetch_array($result))
		{
			// display barcode
			$D_BC		= true;
			
			// extract specific fields
			$NO_SIRI		= $row["NO_SIRI"];
			$NAMA 			= $row["NAMA"];
			$TAHUN			= $row["TAHUN"];
			$TARIKH_MOHON	= $row["TARIKH_MOHON"];
			$NEGERI 		= $row["NEGERI"];
			$DAERAH 		= $row["DAERAH"];
			$PERUMAHAN 		= $row["PERUMAHAN"];
			$PENDAPATAN		= $row["PENDAPATAN"];
			
			$RUMAH			= $row["RUMAH"];
			$BINI_B			= $row["BINI_B"];
			$BINI_M			= $row["BINI_M"];
			$DEW_B			= $row["DEW_B"];
			$DEW_M			= $row["DEW_M"];
			$ANAK_I			= $row["ANAK_I"];
			$ANAK_R			= $row["ANAK_R"];
			$ANAK_M			= $row["ANAK_M"];
			$CACAT			= $row["CACAT"];
			$BAYI			= $row["BAYI"];
			$KRONIK			= $row["KRONIK"];
			
			$JENIS			= $row["JENIS"];
			$KIFAYAH_BAKI	= $row["KIFAYAH_BAKI"];
			$KIFAYAH_KREDIT	= $row["KIFAYAH_KREDIT"];
			$LOG_BAYARAN	= $row["LOG_BAYARAN"];
			
			// Decode codes into string
			$sql_display = "SELECT NEGERI FROM NEGERI WHERE KOD_NEGERI = '$NEGERI'";
			$result_dispay = mysql_query($sql_display);
			while($row = mysql_fetch_array($result_dispay)) { $DNEGERI = $row["NEGERI"]; }
			
			$sql_display = "SELECT NAMA_DAERAH FROM DAERAH WHERE KOD_DAERAH = '$DAERAH'";
			$result_dispay = mysql_query($sql_display);
			while($row = mysql_fetch_array($result_dispay)) { $DDAERAH = $row["NAMA_DAERAH"]; }
			
			$sql_display = "SELECT NAMA_KWSN FROM PERUMAHAN WHERE KOD_KWSN = '$PERUMAHAN'";
			$result_dispay = mysql_query($sql_display);
			while($row = mysql_fetch_array($result_dispay)) { $DPERUMAHAN = $row["NAMA_KWSN"]; }
			
			$sql_display = "SELECT JENIS FROM JENIS_ASNAF WHERE KOD_JENIS = '$JENIS'";
			$result_dispay = mysql_query($sql_display);
			while($row = mysql_fetch_array($result_dispay)) { $DJENIS = $row["JENIS"]; }
			
			if($RUMAH == 1)
			{
				$RUMAH = "Berbayar";
			}
			elseif($RUMAH == 0)
			{
				$RUMAH = "Percuma";
			}
			
			$HAD_KIFAYAH = $KIFAYAH_BAKI + $KIFAYAH_KREDIT;
			
			// output student information
			echo "<h2>E-Asnaf Transfer</h2>";
			echo "<h1>Penyata Pembayaran Zakat</h1>";
			echo "<table>
					<tbody>
					<tr><td><b>Nama Penerima</b></td><td>: $NAMA</td></tr>
					<tr><td><b>Negeri Kediaman</b></td><td>: $DNEGERI</td></tr>
					<tr><td><b>Daerah Kediaman</b></td><td>: $DDAERAH</td></tr>
					<tr><td><b>Kawasan Perumahan</b></td><td>: $DPERUMAHAN</td></tr>
					<tr><td><b>Jenis Permohonan</b></td><td style='vertical-align:middle'>: $DJENIS</td></tr>";
			echo "</tbody></table>";
			echo "<h3>Log Pembayaran</h3>
				<h4>$LOG_BAYARAN</h4>";

			if($D_BC == false)
			{
				echo "<tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
			}
		}
		else
		{
			echo "<tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
		}
	}
	else
	{
		echo "<tr><td align='center'><i> Tiada data untuk dipaparkan </i></td></tr></table>";
	}
	?>
</body>
</html>