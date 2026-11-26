<?php ob_start(); ?>
<html>
<head>
<?php
		session_start();
		require_once __DIR__ . '/connectDB.php';
		require_login();
		$name	= $_SESSION['zakat_nama'];

	// Selected filters (shown again in the form).
	$GNEG = request_text($_GET, "NEGERI");
	$GDAE = request_text($_GET, "DAERAH");
	$GPER = request_text($_GET, "PERUMAHAN");
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ezakat" />
	<meta name="author" content="Dimensi Kini" />
	<meta name="description" content="E-Asnaf Transfer" />

    <title>[E-Asnaf Transfer] - Senarai Permohonan Zakat</title>
	
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
    
    <!-- DataTables CSS -->
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    
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
                <li class="dropdown">
                    <?php echo e(account_label()); ?><strong><?php echo e($name); ?></strong>
                </li>                
                <li class="dropdown">
                    <a href="logout.php">
                        <i class="fa fa-sign-out fa-fw"></i> Daftar Keluar
                    </a>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php
                            include __DIR__ . '/nav.php';
                        ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
        <!-- mula     ##########################################################################################     mula -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Senarai Permohonan Zakat</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
					<form role="form" id="senarai_permohonan" action ="senarai_permohonan_daerah.php" method ="get" enctype="multipart/form-data">
						<input type="hidden" name="PAPAR" value="YES">
						<table>
							<tr>
								<div class="form-group">
								<td>
									<label>Pilih negeri </label>
								</td>
								<td>
									 : <select id="input1" name="NEGERI">
										<option value=""> Sila pilih </option>
										<option disabled> </option>
										<?php
										$result_choose = db_query("SELECT KOD_NEGERI, NEGERI, P_ZAKAT FROM NEGERI ORDER BY P_ZAKAT");
										while ($row = mysqli_fetch_assoc($result_choose))
										{
											$selected = $row["KOD_NEGERI"] == $GNEG ? " selected" : "";
											echo "<option value=\"" . e($row["KOD_NEGERI"]) . "\"$selected> " . e($row["P_ZAKAT"]) . " </option>";
										} ?>
									</select>
								</td>
								</div>
								<td rowspan="3">
									&nbsp;&nbsp;
								</td>
								<td rowspan="3">
									<button type="submit" class="btn btn-outline btn-success" form="senarai_permohonan" value="Submit"> Papar </button>
								</td>
							</tr>
							<tr>
								<div class="form-group">
								<td>
									<label>Pilih daerah </label>
								</td>
								<td>
									 : <select id="input2" name="DAERAH">
										<option value=""> Sila pilih </option>
										<?php
										$result_choose = db_query("SELECT KOD_NEGERI, KOD_DAERAH, NAMA_DAERAH FROM DAERAH ORDER BY NAMA_DAERAH");
										while ($row = mysqli_fetch_assoc($result_choose))
										{
											$selected = $row["KOD_DAERAH"] == $GDAE ? " selected" : "";
											echo "<option class=\"" . e($row["KOD_NEGERI"]) . "\" value=\"" . e($row["KOD_DAERAH"]) . "\"$selected> " . e($row["NAMA_DAERAH"]) . " </option>";
										} ?>
									</select>
								</td>
								</div>
							</tr>
						</table>
					</form>
                    <?php
                        // Papar senarai
                        $result = null;
                        if(request_text($_GET, 'PAPAR') == "YES")
                        {
                            $result = db_query("SELECT * FROM PERMOHONAN WHERE NEGERI = ? AND DAERAH = ? ORDER BY JENIS, NAMA", [$GNEG, $GDAE]);
                        }
                    ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><b>Senarai Permohonan Zakat Mengikut Daerah</b></center>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-data">
                                    <thead>
                                        <tr>
                                            <td align="center"><b>Bil.</b></td>
                                            <td align="center"><b>Nama</b></td>
                                            <td align="center"><b>Jenis Asnaf</b></td>
                                            <td align="center"><b>Baki Had Kifayah</b></td>
                                            <td align="center"><b>Tindakan</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php
                            // Papar table
                            if($result)
                            {
                                // Initialise index number
                                $BIL = 0;

                                // Asnaf type names
                                $DJNS = [];
                                $result_jns	= db_query("SELECT KOD_JENIS, JENIS FROM JENIS_ASNAF");
                                while($row_jns	= mysqli_fetch_assoc($result_jns))
                                {
                                    $DJNS[$row_jns["KOD_JENIS"]] = $row_jns["JENIS"];
                                }

                                // iterate through all rows in result set
                                while ($row = mysqli_fetch_assoc($result))
                                {
                                    $BIL++;
                                    $DJENIS		= $DJNS[$row['JENIS']] ?? $row['JENIS'];

                                    echo "<tr>\n\t\t\t\t\t\t\t";
                                    echo "<td align=center>$BIL</td>\n\t\t\t\t\t\t\t";
                                    echo "<td>" . e($row['NAMA']) . "</td>\n\t\t\t\t\t\t\t<td align=center>" . e($DJENIS) . "</td>\n\t\t\t\t\t\t\t<td align=center>RM " . e($row['KIFAYAH_BAKI']) . "</td>\n\t\t\t\t\t\t\t<td align=center><a target='_blank' href='rincian.php?ID=" . e($row['NO_SIRI']) . "'><button class='btn btn-outline btn-info'>Butiran</button></a></td>\n\t\t\t\t\t\t\t";
                                    echo "</tr>\n\t\t\t\t\t\t";
                                }
                            }
                        ?>
                                </table>
                            </div>
                            <!-- /.dataTable_wrapper -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel-default -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- tamat     ########################################################################################     tamat -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-data').DataTable({
                responsive: true
        });
    });
    </script>
	
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
	</script>

</body>

</html>
