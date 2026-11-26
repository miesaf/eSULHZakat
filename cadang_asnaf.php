<?php ob_start(); ?>
<html>
<head>
	<?php
		require_once __DIR__ . '/connectDB.php';
		
		// Checks the uploaded proof of income: PDF, JPEG or PNG (extension and content), 1 byte to 5 MB.
		// Returns [extension, error message or null].
		function semak_bukti($file): array
		{
			$allowed = ['pdf' => ['application/pdf'], 'jpg' => ['image/jpeg'], 'jpeg' => ['image/jpeg'], 'png' => ['image/png']];
			
			if (!is_array($file) || !is_string($file['tmp_name'] ?? null) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE)
			{
				return [null, "Sila muat naik bukti pendapatan/slip gaji!"];
			}
			if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > 5000000)
			{
				return [null, "Saiz fail melebihi 5MB!"];
			}
			if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name']))
			{
				return [null, "Fail gagal dimuat naik!"];
			}
			if ($file['size'] <= 0)
			{
				return [null, "Saiz fail adalah sifar/tiada data!"];
			}
			
			$ext	= strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
			$mime	= (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
			if (!isset($allowed[$ext]) || !in_array($mime, $allowed[$ext], true))
			{
				return [null, "Fail harus dalam format PDF/JPG/JPEG/PNG!"];
			}
			return [$ext, null];
		}
		
		if(isset($_POST['DAFTAR']))
		{
			[$f, $ralat] = asnaf_fields($_POST);
			
			if($ralat === null && !kod_sah('JENIS_ASNAF', 'KOD_JENIS', $f['JENIS']))
			{
				$ralat = "Sila pilih jenis asnaf.";
			}
			if($ralat === null && db_value("SELECT COUNT(*) FROM CADANG_ASNAF WHERE NO_KP = ?", [$f['NO_KP']]) !== "0")
			{
				$ralat = "Asnaf ini telah dicadangkan.";
			}
			
			$ext = null;
			if($ralat === null)
			{
				[$ext, $ralat] = semak_bukti($_FILES["imfile"] ?? null);
			}
			
			// A random file name: nothing from the visitor (name or IC number) ends up in it.
			$F_NAME	= null;
			if($ralat === null)
			{
				$F_NAME = bin2hex(random_bytes(16)) . "." . $ext;
				if(!move_uploaded_file($_FILES["imfile"]["tmp_name"], __DIR__ . "/bukti/" . $F_NAME))
				{
					$ralat = "Fail gagal dimuat naik!";
				}
			}
			
			if($ralat !== null)
			{
				js_alert("RALAT: " . $ralat);
			}
			elseif(db_query("INSERT INTO CADANG_ASNAF (NAMA, NO_KP, TEL, JLN_1, JLN_2, POSKOD, PERUMAHAN, BANDAR, DAERAH, NEGERI, PENDAPATAN, BUKTI, JENIS, BANK, NO_AKAUN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
				[$f['NAMA'], $f['NO_KP'], $f['TEL'], $f['JLN_1'], $f['JLN_2'], $f['POSKOD'], $f['PERUMAHAN'], $f['BANDAR'], $f['DAERAH'], $f['NEGERI'], $f['PENDAPATAN'], $F_NAME, $f['JENIS'], $f['BANK'], $f['NO_AKAUN']]))
			{
				js_alert("Cadangan berjaya disimpan!", "index.php");
			}
			else
			{
				@unlink(__DIR__ . "/bukti/" . $F_NAME);
				js_alert("Cadangan gagal disimpan!");
			}
		}
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />

    <title>[E-Asnaf Transfer] - Cadang Asnaf</title>
	
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
					<h1 class="page-header">Cadang Asnaf</h1>
				</div>
                <!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
				<!-- mula     ##########################################################################################     mula -->
			<div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Borang Penamaan Cadangan Asnaf (Penerima Zakat) Baru</b>
                        </div>
						<?php
							if(!isset($_POST['DAFTAR']))
							{
						?>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="cadang_asnaf" action ="cadang_asnaf.php" method ="POST" enctype="multipart/form-data">
										<input type="hidden" name="DAFTAR" value="YES">
                                        <div class="form-group">
											<label>Nama Penuh Asnaf</label>
                                            <input class="form-control" type="text" maxlength="100" size="50" name="NAMA">
                                        </div>
										<div class="form-group">
											<label>Nombor Kad Pengenalan Asnaf</label>
                                            <input class="form-control" type="text" size="12" maxlength="12" name="NO_KP">
                                            <p class="help-block">95xxxxxxxxxx (Tanpa sengkang '-')</p>
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
												<label>Negeri</label>
												<select class="form-control" id="input1" name="NEGERI">
													<option value=""> Sila pilih </option>
													<option disabled> </option>
													<?php
													$sql_choose = "SELECT KOD_NEGERI, NEGERI FROM NEGERI ORDER BY NEGERI";
													$result_choose = db_query($sql_choose);
													while ($row = mysqli_fetch_assoc($result_choose))
													{
														$NEGERI1 = e($row["KOD_NEGERI"]);
														$NEGERI2 = e($row["NEGERI"]);
														echo '<option value="' . $NEGERI1 . '"> ' . $NEGERI1 . ' - ' . $NEGERI2 . '</option>';
													} ?>
												</select>
												<label>Daerah</label>
												<select class="form-control" id="input2" name="DAERAH">
													<option value=""> Sila pilih </option>
													<option disabled> </option>
													<?php
													$sql_choose = "SELECT * FROM DAERAH ORDER BY KOD_NEGERI, NAMA_DAERAH";
													$result_choose = db_query($sql_choose);
													while ($row = mysqli_fetch_assoc($result_choose))
													{
														$DAERAH1 	= e($row["KOD_DAERAH"]);
														$DAERAH2 	= e($row["NAMA_DAERAH"]);
														$DAERAH3	= e($row["KOD_NEGERI"]);
														echo '<option class="' . $DAERAH3 . '" value="' . $DAERAH1 . '"> ' . $DAERAH1 . ' - ' . $DAERAH2 . '</option>';
													} ?>
												</select>
												<label>Bandar</label>
												<input class="form-control" type="text" size="12" maxlength="100" name="BANDAR">
												<label>Kawasan Perumahan</label>
												<select class="form-control" id="input3" name="PERUMAHAN">
													<option value=""> Sila pilih </option>
													<option disabled> </option>
													<?php
													$sql_choose = "SELECT * FROM PERUMAHAN ORDER BY KOD_DAERAH, NAMA_KWSN";
													$result_choose = db_query($sql_choose);
													while ($row = mysqli_fetch_assoc($result_choose))
													{
														$KWSN1	= e($row["KOD_KWSN"]);
														$KWSN2	= e($row["NAMA_KWSN"]);
														$KWSN3	= e($row["KOD_DAERAH"]);
														echo '<option class="' . $KWSN3 . '" value="' . $KWSN1 . '"> ' . $KWSN1 . ' - ' . $KWSN2 . '</option>';
													} ?>
												</select>
											</div>
                                        </div>
										<div class="form-group">
											<label>Pendapatan</label>
                                            <input class="form-control" type="text" size="12" maxlength="10" name="PENDAPATAN">
										</div>
										<div class="form-group">
											<label>Muat naik bukti pendapatan/slip gaji</label>
											<input class="form-control" type="file" name="imfile" accept=".pdf,.jpg,.jpeg,.png">
											<p class="help-block">
												<font color="red">Sila muat naik fail berformat PDF, JPG, JPEG, PNG serta bersaiz kurang <b>5MB</b> sahaja!</font>
											</p>
										</div>
										<div class="form-group">
											<label>Jenis Asnaf</label>
											<select class="form-control" name="JENIS">
												<option disabled selected> Sila pilih </option>
												<option disabled> </option>
												<?php
												$sql_choose = "SELECT * FROM JENIS_ASNAF ORDER BY JENIS";
												$result_choose = db_query($sql_choose);
												while ($row = mysqli_fetch_assoc($result_choose))
												{
													$JENIS1 = e($row["KOD_JENIS"]);
													$JENIS2 = e($row["JENIS"]);
													echo '<option value="' . $JENIS1 . '"> ' . $JENIS2 . '</option>';
												} ?>
											</select>
                                        </div>
										<div class="form-group">
											<label>Nama Bank</label>
                                            <select class="form-control" name="BANK">
												<option disabled selected> Sila pilih </option>
												<option disabled> </option>
												<?php
												$sql_choose = "SELECT * FROM BANK ORDER BY NAMA_BANK";
												$result_choose = db_query($sql_choose);
												while ($row = mysqli_fetch_assoc($result_choose))
												{
													$BANK1 = e($row["KOD_BANK"]);
													$BANK2 = e($row["NAMA_BANK"]);
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
								<button type="submit" class="btn btn-outline btn-success" form="cadang_asnaf" value="Submit">Hantar</button>
								<button type="reset" class="btn btn-outline btn-warning"form="cadang_asnaf" value="Reset">Reset</button>
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
