<?php

	session_start(); 
	
	if(!isset($_SESSION['zalogowany_admin'])) // to re-direct unlogged user
	{
		header('Location: index.php');
	
		
	}
	
	require_once "connect.php"; //server information
	
	mysqli_report(MYSQLI_REPORT_STRICT); // reports adjusted to try, catch
	 
	try
	{
	 
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); //connecting with DB 
		if($polaczenie->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{	
						
				$result0 =$polaczenie->query("SELECT losowal FROM imiona WHERE imie='admin'");
				if(!$result0) throw new Exception($polaczenie->error);
					$row_1 = mysqli_fetch_assoc($result0);
	
					$_SESSION['admin_permission_flag'] = $row_1['losowal']; //variable to disable player delete option after starting the game
			
							$result0->free();
							$polaczenie->close();				
		}	
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
			echo '<br/>Informacja developerska: '.$e;
	} 

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Panel admina</title>

	<link rel="stylesheet" href="style_v4.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  
		<script type="text/javascript" src="ajax_request_1.js"> </script>  
		<script type="text/javascript" src="ajax_request_2.js"> </script>
		<script type="text/javascript" src="ajax_request_3.js"> </script>
		<script type="text/javascript" src="ajax_request_4.js"> </script>
		
	</script>
		
	
</head>
<body>

		<div id="container">
		
		<?php
		echo "<p>Witaj ".$_SESSION['imie'].'! [ <a href="logout.php"> Wyloguj się!</a> ]<p>';
	
		if(isset($_SESSION['admin_permission_flag']) && ($_SESSION['admin_permission_flag'] == 1))
		{
			//disable player deletion option
			echo "<style> .del{visibility:hidden; } </style>";
		}
	
		?>
		<div id="responsecontainer" align="center"> </div>	
				<div id = "usun"><button class="del2" onclick="if (confirm('Are you sure you want to delete all players?')) {usun()} else {}"> Usuń wszystkie osoby</button></div>
				<div id = "zezwol"><button class="del2" onclick="if (confirm('Are you sure you want to start the game?')) {zezw()} else {}">Zezwól na losowanie</button></div>
		</div>
		
		
</body>
</html>

