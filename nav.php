<li>
	<a href="utama.php"><i class="fa fa-dashboard fa-fw"></i> Laman Utama</a>
</li>
<?php
	if($_SESSION['priv_ez'] == "MZKI")
	{
		echo '<li>
					<a href="senarai_permohonan.php"><i class="fa fa-list fa-fw"></i> Senarai Pemohon Zakat</a>
				</li>
				<li>
					<a href="cadang_asnaf.php"><i class="fa fa-edit fa-fw"></i> Cadang Asnaf</a>
				</li>
				<!--
				<li>
					<a href="senarai_cadangan.php"><i class="fa fa-list fa-fw"></i> Senarai Cadangan Asnaf</a>
				</li>
				-->';
	}
?>