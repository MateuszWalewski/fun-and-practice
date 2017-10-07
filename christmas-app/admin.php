<?php

	session_start(); 
	
	if(!isset($_SESSION['zalogowany_admin'])) // to re-direct unlogged player
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
						
				$result =$polaczenie->query("SELECT * FROM imiona");
				$result0 =$polaczenie->query("SELECT losowal FROM imiona WHERE imie='admin'");
				if(!$result0) throw new Exception($polaczenie->error);
				if(!$result) throw new Exception($polaczenie->error);
					$row_1 = mysqli_fetch_assoc($result0);
					
					$_SESSION['losow'] = $row_1['losowal']; //variable to disable player delete option after starting the game
					
							$ile = $result->num_rows;
							
							$players = array(); // array with player names 
							$drawnPlayers = array(); // array with drawn players 
							$idPlayers = array(); // array with id
						
						
							for ($i = 0; $i < $ile; $i++) 
							{
								$row = mysqli_fetch_assoc($result);
								
								if( $row['imie'] == "admin") continue; 
					
								$players[] = $row['imie'];
								$drawnPlayers[] = $row['wylosowane_imie'];
								$idPlayers[] = $row['id'];
							}
							
								$jsonPlayers = json_encode($players); // to cooperate with js script
								$jsonDrawnPlayers = json_encode($drawnPlayers); 
								$jsonIdPlayers = json_encode($idPlayers); 
								$json_losow = $_SESSION['losow'];
						
								$result->free();
							
					
			$polaczenie->close();				
		
		}
		
		
		
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
			//echo '<br/>Informacja developerska: '.$e;
	} 
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Panel admina</title>

	<link rel="stylesheet" href="style_v4.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">

		
	
</head>
<body>

		<div id="container">
		
		<?php
		echo "<p>Witaj ".$_SESSION['imie'].'! [ <a href="logout.php"> Wyloguj się!</a> ]<p>';
		?>
		
		
			<div id="players">
		
		<?php
		
		
		function usun()// connects with DB and deletes all players
		{
			
			$host="localhost";
			$db_user="hraboa89_root";
			$db_password="Mac8DeMarco9";
			$db_name="hraboa89_imiona";
	
			mysqli_report(MYSQLI_REPORT_STRICT); 
			
			try
			{
			 
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 
				 
				if($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{	
					
						$result =$polaczenie->query("DELETE FROM imiona WHERE NOT imie = 'admin'");
						if(!$result) throw new Exception($polaczenie->error);
						
						$result =$polaczenie->query("ALTER TABLE imiona DROP COLUMN id");
						if(!$result) throw new Exception($polaczenie->error);
						
						$result =$polaczenie->query("ALTER TABLE imiona ADD id int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");// dropping and adding new id column to avoid numbering mess
						if(!$result) throw new Exception($polaczenie->error);
						
						$result =$polaczenie->query("UPDATE imiona SET losowal = 0 WHERE imie= 'admin'");
						if(!$result) throw new Exception($polaczenie->error);
						//clear admin permission flag to allow for new game
						
							
						header('Location: admin.php');
						
						$polaczenie->close();				
				
				}
				
				
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
					echo '<br/>Informacja developerska: '.$e;
			} 
		}
		
		function usun_osobe()// deletes given player
		{
			
				$host="localhost";
				$db_user="hraboa89_root";
				$db_password="Mac8DeMarco9";
				$db_name="hraboa89_imiona";
		
			try
			{
		 
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); //connecting with DB
				 
				if($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{	
						
						$curr_player = $_GET['c_player'];
						
						$result =$polaczenie->query("DELETE FROM imiona WHERE imie = '$curr_player'");
						if(!$result) throw new Exception($polaczenie->error);
						
						
						$result =$polaczenie->query("ALTER TABLE imiona DROP COLUMN id");
						if(!$result) throw new Exception($polaczenie->error);
						
						$result =$polaczenie->query("ALTER TABLE imiona ADD id int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
						if(!$result) throw new Exception($polaczenie->error);
						// dropping and adding new id column to avoid numbering mess
						
						header('Location: admin.php');
				
					$polaczenie->close();				
				
				}
			
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
					echo '<br/>Informacja developerska: '.$e;
			} 
		
		}		
		function los()// changes admin permission flag to enable drawing for all players
		{
			
			
				$host="localhost";
				$db_user="hraboa89_root";
				$db_password="Mac8DeMarco9";
				$db_name="hraboa89_imiona";
	
	 
			mysqli_report(MYSQLI_REPORT_STRICT); 
			
			try
			{
			 
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); //connecting with DB
				 
				if($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{	
					
						$result =$polaczenie->query("UPDATE imiona SET losowal = 1 WHERE imie= 'admin'");
						if(!$result) throw new Exception($polaczenie->error);
							
						header('Location: admin.php');
						
						$polaczenie->close();				
				
				}
				
				
				
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
					echo '<br/>Informacja developerska: '.$e;
			} 
				
		
					
		
		}
		// triggering the functions by clicking corresponing link in the admin panel
		if(isset($_GET['del']))
		{
		
			usun();	
		}
		
		if(isset($_GET['zezw']))
		{
			los();
		}
		if(isset($_GET['c_player']))
		{
			usun_osobe();
		}
		
	/*----------------------------- JS Function displaying all registered players togheter with links to delete each of them. Additional links: to delete all players and start the game are included. 
	The deletion of the given player is possible only BEFORE the "Zezwól na losowanie" link is clicked. 
	
	
	-----------------------*/
		echo<<<END
				

					<script>
					
				
					var tabContent = "";
					var playersJs = $jsonPlayers;
					var drawnPlayersJs = $jsonDrawnPlayers;
					var idPlayersJs = $jsonIdPlayers;
					var nOfPlayersNoAdmin = $ile - 1;
				
		
					for(i = 0; i < nOfPlayersNoAdmin; i++)
					{
						
						tabContent = tabContent + '<tr><td >'+(idPlayersJs[i]-1)+'</td><td >'+playersJs[i]+'</td> <td >'+drawnPlayersJs[i]+ '</td><td><a class="us" href="admin.php?c_player='+playersJs[i]+'"> Usuń </a></td> </tr>'
					
					}
					
					var titl = '<tr><th id="nr" style="color:red"> Numer </th><th style="color:red"> Gracz </th> <th style="color:red"> Wylosowana osoba </th><th> </th></tr>'
					var tabl = '<table id="tabb">'+ titl + tabContent+'</table>';
					var del_link = '<a id = "usun" href="admin.php?del=true"> Usuń wszystkie osoby</a>';
					
					var cont = tabl + del_link;
				
					
					document.getElementById("players").innerHTML = cont;
					
					if($json_losow==1)
					{
						var divsToHide = document.getElementsByClassName("us");
						
						for(var i = 0; i < nOfPlayersNoAdmin; i++)
						{
							divsToHide[i].style.visibility = "hidden"; 
						}
						
						 
					}
					
					
					</script>
			
END;
	
		
		?>
		
				</div>
			
				<a id = "zezwol" href="admin.php?zezw=true">Zezwól na losowanie</a>
 
		</div>
		
		
</body>
</html>

