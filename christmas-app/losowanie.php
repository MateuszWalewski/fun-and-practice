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
							$json_drawn_person = json_encode($drawn_person); // adjust to js function
							
						
								$result->free();
								$result2->free();
								
														
										
								
		//---------------------DRAWING FUNCTION ------------------------------------------							
echo<<<END


						
					<script >
					
					
					function losowanie()
					{
						
							document.getElementById("ll").value = $json_drawn_person;
						
					}
					</script>
					
END;
					}
					//-------------------------------------------------------------------		
					else
					{
echo<<<END
						<style>
						#kk
						{    
						visibility: hidden;
						margin: -35px;
						}
						</style>
END;
						
						$_SESSION['w_po_los'] = "<p> Dokonałeś już losowania! Wylosowana przez Ciebie
							osoba to: ".'<span id="los_im2" >'.$_SESSION['wylosowane_imie']. '</span>' .". Czas rozpocząć poszukiwania! :)</p>";
						$_SESSION['blad_los'] = '<span id="juz" > Już dokonałeś losowania! </span>';
						
					}
					
echo<<<END
<style>
#zmien
{
	visibility: hidden;
	margin: -115px;
	
}
#wyloguj
{
	text-align: center;
}

</style>

END;
					
				$polaczenie->close();
			 }
			 else
			 {
				 $_SESSION['e_po_los'] ='<span id="zamalo">'."Losowanie zablokowane. Poczekajmy, aż wszyscy zameldują się na pokładzie :)". '</span>';
				 $_SESSION['w_po_los'] = " ";
echo<<<END
		<style>
		#submit
		{    
		visibility: hidden;
		}
		#kk
		{    
		visibility: hidden;
		margin: -35px;
		}
		#wyl
		{
		visibility: hidden;
		}

		</style>
END;
				 
			 }
		}
			
				if(isset($_POST['losim'])) // check if drawning button was pressed
				{
					$zm = $_POST['losim'];
					
					
					$_SESSION['w_po_los_2'] = '<p id="dok"> Dokonałeś losowania! Wylosowana przez Ciebie
					osoba to: '.'<span id="los_im">'.$_POST['losim'].'</span>' .". Czas rozpocząć poszukiwania! :)</p>";
										
echo<<<END
		<style>
		#submit
		{    
		visibility: hidden;
		}
		#kk
		{    
		visibility: hidden;
		margin: -35px;
		}
		</style>
END;
					$polaczenie2 = @new mysqli($host, $db_user, $db_password, $db_name); // connection to save flags and drawn names in DB
			
					if($polaczenie2->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					
					}
					else
					{	
						
						$result =$polaczenie2->query("UPDATE imiona SET wylosowany=1 WHERE imie='$zm'");
						if(!$result) throw new Exception($polaczenie2->error);
						
						
						$result =$polaczenie2->query("UPDATE imiona SET losowal=1 WHERE id='$curr_id'");
						if(!$result) throw new Exception($polaczenie2->error);
						
						
						if($result =$polaczenie2->query("UPDATE imiona SET wylosowane_imie = '$zm' WHERE id='$curr_id'"));
						if(!$result) throw new Exception($polaczenie2->error);
						
					
						$polaczenie2->close();
						
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
		
		<script>
			
			
		
		</script>
	
	
</head>
<body>

		<div id="container">
		<?php
		echo "<p>Witaj ".$_SESSION['ch_nick'].'! <span id="wyloguj"> [ <a href="logout.php"> Wyloguj się!</a> ] </span> <span id="zmien"> [ <a href="zmiana.php">  Zmień swoje dane</a> ] </span> <p>';
		
		
		if(isset($_SESSION['e_po_los']))
		{
			echo $_SESSION['e_po_los'];
			unset($_SESSION['e_po_los']);
		}
		
		
		if($_SESSION['wylosowane_imie']!="" ) 
		{
				
			echo $_SESSION['w_po_los'];
			unset($_SESSION['w_po_los']);
				
echo<<<END
<style>
 #submit
    {    
        visibility: hidden;
    }	
 #wyl
 {
	  visibility: hidden;
 }
 
</style>
END;
	
		}
		if(isset($_POST['losim']))
		{
			
			echo $_SESSION['w_po_los_2'];
			unset($_SESSION['w_po_los_2']);
		}
		echo '<p id="kk">'."Zapraszam do losowania! Naciśnij przycisk na środku ekranu aby rozpocząć.".'</p>';
		?>
		
		<div id="wyl">Wylosowane imie to:</div><div id="wynik"> <?php if(isset($_POST['losim'])){ 
		echo $_POST['losim'];
		echo'<script> 
				var yes = new Audio("snd/yes.wav");
				yes.play();
			</script>';
		 } ?> 
		</div> 
		<form method="post">
		<input id="submit" type="submit" value="Losuj imię!" onclick="losowanie()"/>

		<input type="text" name="losim" id="ll"/>
		
		</form>
		<?php
		if(isset($_SESSION['blad_los'])) 
		{	
		 echo $_SESSION['blad_los'];
		 unset ($_SESSION['blad_los']);
		}
		?>
		</div>
		
</body>
</html>