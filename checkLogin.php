<?php
	session_start();
	
	include('connectDB.php');
	
	$enteredIC	= mysql_real_escape_string($_POST['nokp']);
	$enteredPW	= mysql_real_escape_string($_POST['ktln']);
	$enteredTP	= mysql_real_escape_string($_POST['akaun']);
		
	// Checking Asnaf Account ##################################################################################################
	function asnaf($enteredIC, $enteredPW)
	{
		//SQL query command
		$sql="SELECT NAMA, NO_KP, KATA_LALUAN FROM ASNAF WHERE NO_KP = $enteredIC";
		
		// execute query
		$res_sql	= mysql_query($sql);
		$row		= mysql_fetch_array($res_sql);
		
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
		else
		{
			return $problem = "gagal";
		}
	}
	
	// Checking Muzakki Account ##################################################################################################
	function muzakki($enteredIC, $enteredPW)
	{
		//SQL query command
		$sql="SELECT * FROM MUZAKKI WHERE NO_KP = $enteredIC";
		
		// execute query
		$res_sql	= mysql_query($sql);
		$row		= mysql_fetch_array($res_sql);
		
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
		else
		{
			return $problem = "gagal";
		}
	}
	
	// Checking Admin Account ##################################################################################################
	function admin($enteredIC, $enteredPW)
	{
		//SQL query command
		$sql="SELECT * FROM NEGERI WHERE KOD_NEGERI = \"$enteredIC\"";
		
		// execute query
		$res_sql = mysql_query($sql);
		$row = mysql_fetch_array($res_sql);
		
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
		else		
		{
			$problem = "gagal";
		}
	
		return $problem;
	}
	
	if($enteredTP == "1")
	{
		$problem = asnaf($enteredIC, $enteredPW);
	}
	elseif($enteredTP == "2")
	{
		$problem = muzakki($enteredIC, $enteredPW);
	}
	elseif($enteredTP == "3")
	{
		$problem = admin($enteredIC, $enteredPW);
	}
	else
	{
		$problem = "type";
	}
	
	if(!$connection){ $problem = "server"; }
	elseif(!$selection){ $problem = "db"; }
	
	$url = "Location: index.php?ralat=$problem";
	header($url);
	exit;
?>