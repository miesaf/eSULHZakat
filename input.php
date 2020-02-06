<html>
<head>
	<?php
		include('connectDB.php');
		
		if(isset($_POST['DAFTAR']))
		{
			// Declaring null value for optional variables
			$JLN_2		= null;
			
			// Sijil ID Generator
			$h = "8";	// to rematch time with Malaysian GMT +8 time (please truncate the +/- sign)
			$hm = $h * 60; 
			$ms = $hm * 60;
			$TARMOH	= gmdate("Y-m-d H:i:s", time()+($ms));
			$HARI	= gmdate("w", time()+($ms));
			$BULAN	= gmdate("n", time()+($ms));
			$TARIKH	= gmdate("d", time()+($ms));
			$TAHUN	= gmdate("Y", time()+($ms));
			$MASA = gmdate("g:i:s a", time()+($ms));	// use (-) for -ve GMT and (+) for +ve GMT
						/* 	-----------------------
							Timestamp Configuration
							-----------------------
							Y - Full year
							m - month with leading zero
							d - date with leading zero
							H - 24-hour format hour
							i - minute with leading zero
							s - second with leading zero
							
							# Please reconfigure server time to:
							timezone - Asia/Kuala_Lumour
							latitude = 3.133333
							longitude = 101.683333
							
							#date() - will fetch server date
							#gmdate() - will fetch GMT 0:00 date
						*/
			//Library Hari
			$DHARI[0]	= "Ahad";
			$DHARI[1]	= "Isnin";
			$DHARI[2]	= "Selasa";
			$DHARI[3]	= "Rabu";
			$DHARI[4]	= "Khamis";
			$DHARI[5]	= "Jumaat";
			$DHARI[6]	= "Sabtu";
			
			//Library Bulan
			$DBULAN[1]	= "Januari";
			$DBULAN[2]	= "Februari";
			$DBULAN[3]	= "Mac";
			$DBULAN[4]	= "April";
			$DBULAN[5]	= "Mei";
			$DBULAN[6]	= "Jun";
			$DBULAN[7]	= "Julai";
			$DBULAN[8]	= "Ogos";
			$DBULAN[9]	= "September";
			$DBULAN[10]	= "Oktober";
			$DBULAN[11]	= "November";
			$DBULAN[12]	= "Disember";
			
			$DTARIKH	= "$DHARI[$HARI], $TARIKH $DBULAN[$BULAN] $TAHUN $MASA";
			
			// End of Sijil ID Generator
			
			// Variables from pendaftaran.php
			$NAMA			= mysql_real_escape_string($_POST['NAMA']);
			$NO_KP			= mysql_real_escape_string($_POST['NO_KP']);
			$KATA_LALUAN	= mysql_real_escape_string($_POST['KATA_LALUAN']);
			$TEL			= mysql_real_escape_string($_POST['TEL']);
			$JLN_1			= mysql_real_escape_string($_POST['JLN_1']);
			$JLN_2			= mysql_real_escape_string($_POST['JLN_2']);
			$POSKOD			= mysql_real_escape_string($_POST['POSKOD']);
			$PERUMAHAN		= mysql_real_escape_string($_POST['PERUMAHAN']);
			$BANDAR			= mysql_real_escape_string($_POST['BANDAR']);
			$DAERAH			= mysql_real_escape_string($_POST['DAERAH']);
			$NEGERI			= mysql_real_escape_string($_POST['NEGERI']);
			$PENDAPATAN		= mysql_real_escape_string($_POST['PENDAPATAN']);
			$BANK			= mysql_real_escape_string($_POST['BANK']);
			$NO_AKAUN		= mysql_real_escape_string($_POST['NO_AKAUN']);
			
			$RUMAH			= mysql_real_escape_string($_POST['RUMAH']);
			$BINI_B			= mysql_real_escape_string($_POST['BINI_B']);
			$BINI_M			= mysql_real_escape_string($_POST['BINI_M']);
			$DEW_B			= mysql_real_escape_string($_POST['DEW_B']);
			$DEW_M			= mysql_real_escape_string($_POST['DEW_M']);
			$ANAK_I			= mysql_real_escape_string($_POST['ANAK_I']);
			$ANAK_M			= mysql_real_escape_string($_POST['ANAK_M']);
			$ANAK_R			= mysql_real_escape_string($_POST['ANAK_R']);
			$CACAT			= mysql_real_escape_string($_POST['CACAT']);
			$BAYI			= mysql_real_escape_string($_POST['BAYI']);
			$KRONIK			= mysql_real_escape_string($_POST['KRONIK']);
			
			// Penentuan Had Kifayah
			$HK_RUMAH = 0;
			
			if($RUMAH == 0)
			{
				$HK_RUMAH	= 570;
			}
			elseif($RUMAH == 1)
			{
				$HK_RUMAH = 895;
			}
			
			$HAD_KIFAYAH = $HK_RUMAH + ($BINI_B * 415) + ($BINI_M * 190) + ($DEW_B * 415) + ($DEW_M * 190) + ($ANAK_I * 235) + ($ANAK_R * 185) + ($ANAK_M * 120) + ($CACAT * 200) + ($BAYI * 190) + ($KRONIK * 200);
			
			$KELAS_HK	= 0 - ($HAD_KIFAYAH / 2);
			$KIF		= $PENDAPATAN - $HAD_KIFAYAH;
			if($KIF < 0)
			{
				if($KIF < $KELAS_HK)
				{
					$JENIS	= "FKIR";
				}
				else
				{
					$JENIS	= "MSKN";
				}
			}
			else
			{
				$JENIS	= "FSBL";
			}
			
			$KIFAYAH_BAKI	= $HAD_KIFAYAH;
			
			//SQL query command
			$sql="INSERT INTO ASNAF (NAMA, NO_KP, KATA_LALUAN, TEL, JLN_1, JLN_2, POSKOD, PERUMAHAN, BANDAR, DAERAH, NEGERI, PENDAPATAN, JENIS, BANK, NO_AKAUN) VALUES (\"$NAMA\", $NO_KP, \"$KATA_LALUAN\", \"$TEL\", \"$JLN_1\", \"$JLN_2\", \"$POSKOD\", \"$PERUMAHAN\", \"$BANDAR\", \"$DAERAH\", \"$NEGERI\", \"$PENDAPATAN\", \"$JENIS\", \"$BANK\", \"$NO_AKAUN\");";
			
			// execute query
			$exe_sql = mysql_query($sql);
			
			// confirming the record is added
			if ($exe_sql)
			{
				echo '<html>
						<head>
							<script>
								window.alert("Pendaftaran berjaya!\nRekod telah di simpan ke dalam pangkalan data ASNAF.");
							</script>
						</head>
					</html>';
					
				$sql2="INSERT INTO PERMOHONAN (PEMOHON, NAMA, TAHUN, TARIKH_MOHON, NEGERI, DAERAH, PERUMAHAN, PENDAPATAN, JENIS, KIFAYAH_BAKI, RUMAH, BINI_B, BINI_M, DEW_B, DEW_M, ANAK_I, ANAK_R, ANAK_M, CACAT, BAYI, KRONIK) VALUES (\"$NO_KP\", \"$NAMA\", $TAHUN, \"$TARMOH\", \"$NEGERI\", \"$DAERAH\", \"$PERUMAHAN\", $PENDAPATAN, \"$JENIS\", $KIFAYAH_BAKI, $RUMAH, $BINI_B, $BINI_M, $DEW_B, $DEW_M, $ANAK_I, $ANAK_R, $ANAK_M, $CACAT, $BAYI, $KRONIK)";
				
				// execute query
				$exe_sql2 = mysql_query($sql2);
				
				// confirming the record is added
				if($exe_sql2)
				{
					echo '<html>
						<head>
							<script>
								window.alert("Pendaftaran berjaya!\nRekod telah di simpan ke dalam pangkalan data PERMOHONAN.");
							</script>
							<meta http-equiv="refresh" content="0; url=input.php" />
						</head>
					</html>';
				}
				else
				{
					echo "SQL insert statement failed.<br>" . mysql_error();
					echo '<html>
							<head>
								<script>
									window.alert("Pendaftaran gagal!\nRekod tidak di simpan ke dalam pangkalan data PERMOHONAN!");
									window.history.go(-1);
								</script>
							</head>
						</html>';
				}
			}
			else
			{
				echo "SQL insert statement failed.<br>" . mysql_error();
				echo '<html>
						<head>
							<script>
								window.alert("Pendaftaran gagal!\nRekod tidak di simpan ke dalam pangkalan data ASNAF!");
								window.history.go(-1);
							</script>
						</head>
					</html>';
			}
		}
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />

    <title>[E-Asnaf Transfer] - Daftar Permohonan & Asnaf [Borang Bypass]</title>
	
	<!-- New favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png?v=eEaoR4aKed">
	<link rel="icon" type="image/png" href="favicons/favicon-32x32.png?v=eEaoR4aKed" sizes="32x32">
	<link rel="icon" type="image/png" href="favicons/favicon-16x16.png?v=eEaoR4aKed" sizes="16x16">
	<link rel="manifest" href="favicons/manifest.json?v=eEaoR4aKed">
	<link rel="mask-icon" href="favicons/safari-pinned-tab.svg?v=eEaoR4aKed" color="#5bbad5">
	<link rel="shortcut icon" href="favicons/favicon.ico?v=eEaoR4aKed">
	<meta name="msapplication-TileColor" content="#00a300">
	<meta name="msapplication-TileImage" content="favicons/mstile-144x144.png?v=eEaoR4aKed">
	<meta name="msapplication-config" content="favicons/browserconfig.xml?v=eEaoR4aKed">
	<meta name="theme-color" content="#ffffff">

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">E-Asnaf Transfer</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
							<a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Daftar Masuk</a>
						</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Daftar Permohonan & Asnaf [Borang Bypass]</h1>
				</div>
                <!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
				<!-- mula     ##########################################################################################     mula -->
			<div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Borang Pendaftaran Permohonan & Asnaf [Borang Bypass]</b>
                        </div>
						<?php
							if(!isset($_POST['DAFTAR']))
							{
						?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="daftar_asnaf" action ="input.php" method ="POST" enctype="multipart/form-data">
										<input type="hidden" name="DAFTAR" value="YES">
                                        <div class="form-group">
											<label>Nama Penuh</label>
                                            <input class="form-control" type="text" maxlength="100" size="50" name="NAMA">
                                        </div>
										<div class="form-group">
											<label>Nombor Kad Pengenalan</label>
                                            <input class="form-control" type="text" size="12" maxlength="12" name="NO_KP">
                                            <p class="help-block">95xxxxxxxxxx (Tanpa sengkang '-')</p>
                                        </div>
										<div class="form-group">
                                            <label>Kata Laluan</label>
                                            <input class="form-control" type="password" size="12" maxlength="50" name="KATA_LALUAN">
                                        </div>
										<div class="form-group">
											<label>Nombor Telefon</label>
                                            <input class="form-control" type="text" size="12" maxlength="20" name="TEL">
                                            <p class="help-block">+6012-xxxx xxx</p>
                                        </div>
										<div class="form-group">
											<label>Alamat</label>
											<div class="form-group">
												<label>Jalan 1</label>
												<input class="form-control" type="text" size="12" maxlength="100" name="JLN_1">
												<label>Jalan 2</label>
												<input class="form-control" type="text" size="12" maxlength="100" name="JLN_2">
												<label>Poskod</label>
												<input class="form-control" type="text" size="12" maxlength="5" name="POSKOD">
												<label>Kawasan Perumahan</label>
												<select class="form-control"  id="input3" name="PERUMAHAN">
													<option value=""> Sila pilih </option>
													<?php
													$sql_choose = "SELECT KOD_DAERAH, KOD_KWSN, NAMA_KWSN FROM PERUMAHAN ORDER BY NAMA_KWSN";
													$result_choose = mysql_query($sql_choose);
													while ($row = mysql_fetch_array($result_choose))
													{
														$KWSN1 = $row["KOD_DAERAH"];
														$KWSN2 = $row["KOD_KWSN"];
														$KWSN3 = $row["NAMA_KWSN"];
														
														echo "<option class=\"$KWSN1\" value=\"$KWSN2\"> $KWSN3 </option>";
													} ?>
												</select>
												<label>Bandar</label>
												<input class="form-control" type="text" size="12" maxlength="100" name="BANDAR">
												<label>Daerah</label>
												<select class="form-control"  id="input2" name="DAERAH">
													<option value=""> Sila pilih </option>
													<?php
													$sql_choose = "SELECT KOD_NEGERI, KOD_DAERAH, NAMA_DAERAH FROM DAERAH ORDER BY NAMA_DAERAH";
													$result_choose = mysql_query($sql_choose);
													while ($row = mysql_fetch_array($result_choose))
													{
														$DAE1 = $row["KOD_NEGERI"];
														$DAE2 = $row["KOD_DAERAH"];
														$DAE3 = $row["NAMA_DAERAH"];
														
														echo "<option class=\"$DAE1\" value=\"$DAE2\"> $DAE3 </option>";
													} ?>
												</select>
												<label>Negeri</label>
												<select class="form-control"  id="input1" name="NEGERI">
													<option value=""> Sila pilih </option>
													<option disabled> </option>
													<?php
													$sql_choose = "SELECT KOD_NEGERI, NEGERI, P_ZAKAT FROM NEGERI ORDER BY P_ZAKAT";
													$result_choose = mysql_query($sql_choose);
													while ($row = mysql_fetch_array($result_choose))
													{
														$NEGRI1 = $row["KOD_NEGERI"];
														$NEGRI2 = $row["NEGERI"];
														$NEGRI3 = $row["P_ZAKAT"];
														
														echo "<option value=\"$NEGRI1\"> $NEGRI3 </option>";
													} ?>
												</select>
											</div>
                                        </div>
										<div class="form-group">
											<label>Pendapatan</label>
                                            <input class="form-control" type="text" size="12" maxlength="10" value="0" name="PENDAPATAN" required>
										</div>
										<div class="form-group">
											<label>Jenis Pemilikan Rumah</label>
                                            <select class="form-control" name="RUMAH" required>
												<option disabled selected> Sila pilih </option>
												<option disabled> </option>
												<option value="1"> Berbayar </option>
												<option value="0"> Percuma </option>
											</select>
										</div>
										<div class="form-group">
											<label>Bilangan Pasangan Bekerja</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="BINI_B">
										</div>
										<div class="form-group">
											<label>Bilangan Pasangan Tidak Bekerja</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="BINI_M">
										</div>
										<div class="form-group">
											<label>Bilangan Anak Umur Lebih 18 Tahun Bekerja</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="DEW_B">
										</div>
										<div class="form-group">
											<label>Bilangan Anak Umur Lebih 18 Tahun Tidak Bekerja</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="DEW_M">
										</div>
										<div class="form-group">
											<label>Bilangan Anak Belajar Di IPT</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="ANAK_I">
										</div>
										<div class="form-group">
											<label>Bilangan Anak Bersekolah</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="ANAK_R">
										</div>
										<div class="form-group">
											<label>Bilangan Anak Tidak Bersekolah</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="ANAK_M">
										</div>
										<div class="form-group">
											<label>Bilangan Tanggungan Cacat</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="CACAT">
										</div>
										<div class="form-group">
											<label>Bilangan Tanggungan Bayi</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="BAYI">
										</div>
										<div class="form-group">
											<label>Bilangan Tanggungan Penyakit Kronik</label>
                                            <input class="form-control" type="number" size="12" maxlength="2" value="0" name="KRONIK">
										</div>
										<div class="form-group">
											<label>Nama Bank</label>
                                            <select class="form-control" name="BANK">
												<option disabled selected> Sila pilih </option>
												<option disabled> </option>
												<?php
												$sql_choose = "SELECT * FROM BANK ORDER BY NAMA_BANK";
												$result_choose = mysql_query($sql_choose);
												while ($row = mysql_fetch_array($result_choose))
												{
													$BANK1 = $row["KOD_BANK"];
													$BANK2 = $row["NAMA_BANK"];
													echo '<option value="' . $BANK1 . '"> ' . $BANK2 . '</option>';
												} ?>
											</select>
                                        </div>
										<div class="form-group">
											<label>Nombor Akaun</label>
                                            <input class="form-control" type="text" size="12" maxlength="50" name="NO_AKAUN">
                                        </div>
								</div>
								<!-- /.col-lg-12 -->
							</div>
							<!-- /.row -->
							<div class="row" align="center">
				<!-- Buttons #########################################################################################################-->
								<br />
								<button type="submit" class="btn btn-outline btn-success" form="daftar_asnaf" value="Submit">Daftar</button>
								<button type="reset" class="btn btn-outline btn-warning"form="daftar_asnaf" value="Reset">Reset</button>
								<a href="index.php"><button type="button" class="btn btn-outline btn-danger" >Batal</button></a>
								<br /><br />
							</div>
							<!-- /.row -->
									</form>
					<!-- tamat     ########################################################################################     tamat -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel-default -->
					<?php
							}
					?>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.page-wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
	
	<script language="Javascript">
		/*
		 * Chained - jQuery / Zepto chained selects plugin
		 *
		 * Copyright (c) 2010-2014 Mika Tuupola
		 *
		 * Licensed under the MIT license:
		 *   http://www.opensource.org/licenses/mit-license.php
		 *
		 * Project home:
		 *   http://www.appelsiini.net/projects/chained
		 *
		 * Version: 0.9.10
		 *
		 */

		;(function($, window, document, undefined) {
			"use strict";

			$.fn.chained = function(parent_selector, options) {

				return this.each(function() {

					/* Save this to child because this changes when scope changes. */
					var child   = this;
					var backup = $(child).clone();

					/* Handles maximum two parents now. */
					$(parent_selector).each(function() {
						$(this).bind("change", function() {
							updateChildren();
						});

						/* Force IE to see something selected on first page load, */
						/* unless something is already selected */
						if (!$("option:selected", this).length) {
							$("option", this).first().attr("selected", "selected");
						}

						/* Force updating the children. */
						updateChildren();
					});

					function updateChildren() {
						var trigger_change = true;
						var currently_selected_value = $("option:selected", child).val();

						$(child).html(backup.html());

						/* If multiple parents build classname like foo\bar. */
						var selected = "";
						$(parent_selector).each(function() {
							var selectedClass = $("option:selected", this).val();
							if (selectedClass) {
								if (selected.length > 0) {
									if (window.Zepto) {
										/* Zepto class regexp dies with classes like foo\bar. */
										selected += "\\\\";
									} else {
										selected += "\\";
									}
								}
								selected += selectedClass;
							}
						});

						/* Also check for first parent without subclassing. */
						/* TODO: This should be dynamic and check for each parent */
						/*       without subclassing. */
						var first;
						if ($.isArray(parent_selector)) {
							first = $(parent_selector[0]).first();
						} else {
							first = $(parent_selector).first();
						}
						var selected_first = $("option:selected", first).val();

						$("option", child).each(function() {
							/* Remove unneeded items but save the default value. */
							if ($(this).hasClass(selected) && $(this).val() === currently_selected_value) {
								$(this).prop("selected", true);
								trigger_change = false;
							} else if (!$(this).hasClass(selected) && !$(this).hasClass(selected_first) && $(this).val() !== "") {
								$(this).remove();
							}
						});

						/* If we have only the default value disable select. */
						if (1 === $("option", child).size() && $(child).val() === "") {
							$(child).prop("disabled", true);
						} else {
							$(child).prop("disabled", false);
						}
						if (trigger_change) {
							$(child).trigger("change");
						}
					}
				});
			};

			/* Alias for those who like to use more English like syntax. */
			$.fn.chainedTo = $.fn.chained;

			/* Default settings for plugin. */
			$.fn.chained.defaults = {};

		})(window.jQuery || window.Zepto, window, document);


		 $(document).ready(function(){
			  $("#input2").chained("#input1");
		 });
		 
		 $(document).ready(function(){
			  $("#input3").chained("#input2");
		 });
	</script>

</body>

</html>