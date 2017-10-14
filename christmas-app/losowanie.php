<?php

	session_start(); 
	
	if(!isset($_SESSION['zalogowany']) ) // to re-direct unlogged players
	{
		header('Location: index.php');
		exit();
		
	}

	require_once "connect.php"; //server information
	
	 $curr_id = $_SESSION['id'];
	 $curr_name = $_SESSION['imie'];
	 
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
	
			 $result =$polaczenie->query("SELECT losowal FROM imiona WHERE imie='admin'"); 
			 $result0 =$polaczenie->query("SELECT imie FROM imiona WHERE id = '$curr_id'");
			 //fetch proper data: admin permission flag and the name of the current player
			 if(!$result) throw new Exception($polaczenie->error);
			 if(!$result0) throw new Exception($polaczenie->error);
			 
			 $row_01 = mysqli_fetch_assoc($result); //fetching data from DB
			 $row_02 = mysqli_fetch_assoc($result0); //fetching data from DB
			 
			 $_SESSION['ch_nick'] = $row_02['imie']; //updated name of the player for logging messagge 
			 
			
			  
			if($row_01['losowal'] == 1) //Check whether admin started the game.
			{
				 $result->free();
				 $result0->free();
	
				 $result =$polaczenie->query("SELECT losowal FROM imiona WHERE id='$curr_id'"); 
				 if(!$result) throw new Exception($polaczenie->error);
				
					$row_1 = mysqli_fetch_assoc($result);//fetching data from DB
					if($row_1['losowal'] == 0)// check whether current player already drawn
					{
						$result->free();
									
						$result =$polaczenie->query("SELECT * FROM imiona");
					
						if(!$result) throw new Exception($polaczenie->error);
						
							$ile = ($result->num_rows) - 1; // excluding admin
							
							if($curr_id < $ile + 1) $id_los = $curr_id +1;
							else $id_los = 2; // to omit admin
							
							$result2 =$polaczenie->query("SELECT imie FROM imiona WHERE id = $id_los");
							$row_2 = mysqli_fetch_assoc($result2);
							
							$drawn_person = $row_2['imie'];
							
							$_SESSION['drawn_person'] = $row_2['imie'];
							
								$result->free();
								$result2->free();
								
							$_SESSION['comment_flag_1'] = true; //values triggering display of the proper comment in HTML side
							$_SESSION['comment_flag_2'] = false;
										
					}
					else
					{
						$_SESSION['comment_flag_1'] = false;
						$_SESSION['comment_flag_2'] = true;	
						
					}
					
					$_SESSION['menu_register_option_flag'] = false;
					$_SESSION['comment_flag_3'] = false;
					
				$polaczenie->close();
			 }
			 else
			 {
				 $_SESSION['menu_register_option_flag'] = true;
				 $_SESSION['comment_flag_3'] = true;
				 
			 }
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
	<title>Losowanie</title>

	<link rel="stylesheet" href="style_v3.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script type="text/javascript" src="ajax_request.js"> </script>
		
</head>
<body>
		<div id="container">
		<?php
		echo '<span id="witaj"> Witaj '.$_SESSION['ch_nick'].'!  [ <a href="logout.php"> Wyloguj się!</a> ] <span>';
		if( isset($_SESSION['menu_register_option_flag']) && ($_SESSION['menu_register_option_flag'] == true ))
		{
			echo '<span id="zmien"> [ <a href="zmiana.php">  Zmień swoje dane</a> ] </span>';	
		
		}
		if(isset($_SESSION['comment_flag_1']) && $_SESSION['comment_flag_1'] == true)
		{
			echo '<div id="zapraszam"> Zapraszam do losowania! Naciśnij przycisk na środku ekranu aby rozpocząć. </div>';
			echo '<div id="wyl">Wylosowane imie to:</div>' ;
		}
		if(isset($_SESSION['draw_flag']) && ($_SESSION['draw_flag'] == true) )
		{
			echo '<div id="dokonales"> Dokonałeś losowania! Wylosowana przez Ciebie
							osoba to: '.'<span id="los_im2" >'.$_SESSION['drawn_person']. '</span>' .'. Czas rozpocząć poszukiwania! :)</p>';
			echo  '<div id="juz" > Już dokonałeś losowania! </div>';		
		}
		elseif (isset($_SESSION['comment_flag_2']) && $_SESSION['comment_flag_2'] == true)
		{
				echo '<div id="dokonales"> Dokonałeś już losowania! Wylosowana przez Ciebie
						osoba to: '.'<span id="los_im2" >'.$_SESSION['wylosowane_imie']. '</span>' .'. Czas rozpocząć poszukiwania! :)</div>';		
				echo  '<div id="juz" > Już dokonałeś losowania! </div>';		
		}
		if(isset($_SESSION['comment_flag_3']) && $_SESSION['comment_flag_3'] == true)
		{
			echo '<div id="zamalo">'.'Losowanie zablokowane. Poczekajmy, aż wszyscy zameldują się na pokładzie :)'. '</div>';
		 
		}
		if(!isset($_SESSION['draw_flag']) && ($_SESSION['comment_flag_3'] == false) && ($_SESSION['comment_flag_1'] == true))
		{
			
			echo '<button id="submit">  Losuj imię! </button>';
		}
		?>
		<div id="responsecontainer" align="center"> </div>
		</div>		
</body>
</html>