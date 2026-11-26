<?php
	session_start();
	
	include('connectDB.php');
	
	$enteredIC	= mysqli_real_escape_string($condb, $_POST['nokp']);
	$enteredPW	= mysqli_real_escape_string($condb, $_POST['ktln']);
	$enteredTP	= mysqli_real_escape_string($condb, $_POST['akaun']);
		
	// Checking Asnaf Account ##################################################################################################
	function asnaf($condb, $enteredIC, $enteredPW)
	{
		//SQL query command
		$sql="SELECT NAMA, NO_KP, KATA_LALUAN FROM ASNAF WHERE NO_KP = $enteredIC";
		
		// execute query
		$res_sql	= mysqli_query($condb, $sql);

		if($res_sql)
		{
			$row		= mysqli_fetch_array($res_sql);
			
			// extract specific fields
			$NO_KP		= $row["NO_KP"];
			$KATA_LALUAN= $row["KATA_LALUAN"];
			$NAMA		= $row["NAMA"];
			
			if(($enteredIC == $NO_KP) && ($enteredPW == $KATA_LALUAN))
			{
				$_SESSION['login_ez']	= "YES";
				$_SESSION['name_ez']	= $NAMA;
				$_SESSION['priv_ez']	= "ASNF";
				$_SESSION['ident_ez'] 	= $NO_KP;
				
				$url = "Location: utama.php";
				header($url);
				exit;
			}
		}

		return $problem = "gagal";
	}
	
	// Checking Muzakki Account ##################################################################################################
	function muzakki($condb, $enteredIC, $enteredPW)
	{
		//SQL query command
		$sql="SELECT * FROM MUZAKKI WHERE NO_KP = $enteredIC";
		
		// execute query
		$res_sql	= mysqli_query($condb, $sql);

		if($res_sql)
		{
			$row		= mysqli_fetch_array($res_sql);
			
			// extract specific fields
			$NO_KP		= $row["NO_KP"];
			$KATA_LALUAN= $row["KATA_LALUAN"];
			$NAMA		= $row["NAMA"];
			
			if(($enteredIC == $NO_KP) && ($enteredPW == $KATA_LALUAN))
			{
				$_SESSION['login_ez']	= "YES";
				$_SESSION['name_ez']	= $NAMA;
				$_SESSION['priv_ez']	= "MZKI";
				$_SESSION['ident_ez'] 	= $NO_KP;
				
				$url = "Location: utama.php";
				header($url);
				exit;
			}
		}

		return $problem = "gagal";
	}
	
	// Checking Admin Account ##################################################################################################
	function admin($condb, $enteredIC, $enteredPW)
	{
		//SQL query command
		$sql="SELECT * FROM NEGERI WHERE KOD_NEGERI = \"$enteredIC\"";
		
		// execute query
		$res_sql = mysqli_query($condb, $sql);

		if($res_sql)
		{
			$row = mysqli_fetch_array($res_sql);
			
			// extract specific fields
			$KOD_NEGERI	= $row["KOD_NEGERI"];
			$KATA_LALUAN= $row["KATA_LALUAN"];
			$P_ZAKAT	= $row["P_ZAKAT"];

			if(($enteredIC == $KOD_NEGERI) && ($enteredPW == $KATA_LALUAN))
			{
				$_SESSION['login_ez']	= "YES";
				$_SESSION['name_ez']	= $P_ZAKAT;
				$_SESSION['priv_ez']	= "ADMN";
				$_SESSION['ident_ez'] 	= $KOD_NEGERI;
				
				$url = "Location: utama.php";
				header($url);
				exit;
			}
		}
	
		return $problem = "gagal";
	}
	
	if($enteredTP == "1")
	{
		$problem = asnaf($condb, $enteredIC, $enteredPW);
	}
	elseif($enteredTP == "2")
	{
		$problem = muzakki($condb, $enteredIC, $enteredPW);
	}
	elseif($enteredTP == "3")
	{
		$problem = admin($condb, $enteredIC, $enteredPW);
	}
	else
	{
		$problem = "type";
	}
	
	if(!$condb){ $problem = "server"; }
	//elseif(!$selection){ $problem = "db"; }
	
	$url = "Location: index.php?ralat=$problem";
	header($url);
	exit;
?>