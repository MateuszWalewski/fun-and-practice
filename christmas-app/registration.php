<?php

session_start();


require_once "connect.php";

mysqli_report(MYSQLI_REPORT_STRICT);

	try 
	{
		$polaczenie0 = new mysqli($host, $db_user, $db_password, $db_name);
				
				if($polaczenie0->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{	
					$result0 =$polaczenie0->query("SELECT losowal FROM imiona WHERE imie='admin'");
					if(!$result0) throw new Exception($polaczenie0->error);
						$row_1 = mysqli_fetch_assoc($result0);
						$loso = $row_1['losowal'];
						
						$result0->free();
						$polaczenie0->close();
					
						if($loso == 1) // Check if admin started the play. If yes, disable further registation.
						{
							$_SESSION['cof'] = true;
							header('Location: cofn.php');
							exit();
							
						}	
						
				}
	}
	catch(Exception $e)
			{
				//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
				echo '<br/>Informacja developerska: '.$e;
			}
			
	if(isset($_POST['email'])) // check whether the form was sent
		{
			
			$wszystko_OK=true;
			
			$imie = $_POST['imie'];
			
			if(strlen($imie)<3 || (strlen($imie)>20))
			{
				$wszystko_OK = false;
				$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
			}
			
			if(ctype_alnum($imie)==false)
			{
				$wszystko_OK = false;
				$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
			}
			
			$email = $_POST['email'];
			$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
			
			if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
			{
				$wszystko_OK = false;
				$_SESSION['e_email']="Podaj poprawny adres email!";
				
			}
			
			$haslo1 = $_POST['haslo1'];
			$haslo2 = $_POST['haslo2'];
			
			if((strlen($haslo1)<8) || (strlen($haslo1)>20))
			{
				$wszystko_OK = false;
				$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
				
			}
			
			if($haslo1!=$haslo2)
			{
				$wszystko_OK = false;
				$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
				
			}
			
			$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT); // hashing password
			
				
			$sekret ="6LdDQTEUAAAAAKRrozyu7GNlBh6UZ5hult_4yTs8";
			$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
			
			
			$odpowiedz = json_decode($sprawdz);
			
			if($odpowiedz->success==false)
			{
				$wszystko_OK = false;
				$_SESSION['e_bot']="Potwierdz, że nie jesteś botem!";
			}
			
			// Remeber inserted data
			
			$_SESSION['fr_imie']=$imie;
			$_SESSION['fr_email']=$email;
			
			
			require_once "connect.php";
			
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
					$rezultat = $polaczenie->query("SELECT id FROM imiona WHERE email='$email'");
					if(!$rezultat) throw new Exception($polaczenie->error);
					
					$ile_takich_maili = $rezultat->num_rows;
					
					if($ile_takich_maili > 0)
					{
						$wszystko_OK = false;
						$_SESSION['e_email']="Istnieje juz konto przypisane do tego adresu e-mail!";
					}
					
					$rezultat = $polaczenie->query("SELECT id FROM imiona WHERE imie='$imie'");
					
					if(!$rezultat) throw new Exception($polaczenie->error);
					
					$ile_takich_nickow = $rezultat->num_rows;
					
					if($ile_takich_nickow > 0)
					{
						$wszystko_OK = false;
						$_SESSION['e_nick']="Istnieje juz gracz o takim nicku! Wybierz inny";
					}
					
					if($wszystko_OK==true)
						{
							
							//Every codition was met - save player in DB
							
							if($polaczenie->query("INSERT INTO imiona VALUES (NULL,'$imie','$haslo_hash','$email', 0, 0, '')"))
							{
								$_SESSION['udanarejestracja']=true;
								header('Location: witamy.php');
							}
							else
							{
								throw new Exception($polaczenie->error);
								
							}
						}
					
					
					$polaczenie->close();
					
					
			
				}
				
				
				
			}
			catch(Exception $e)
			{
				//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
				echo '<br/>Informacja developerska: '.$e;
			}
			
			
		}


?>


<!DOCTYPE HTML>

<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Losowanie - załóż konto</title>
	<link rel="stylesheet" type="text/css" href="style_vv2.css" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
		
	<style>
	
		.error
		{
			color:red;
			margin_top: 10px;
			margin_bottom: 10px;
			
		}
	
	</style>
</head>
<body>
<script>
var merry = new Audio("snd/merry.mp3");
</script>



<div id="container">
<a id="reg" href="index.php">Powrót do strony logowania</a>
<form method="post">

<input type="text" value="<?php 
			
			if(isset($_SESSION['fr_imie']))
			{
				echo $_SESSION['fr_imie'];
				unset($_SESSION['fr_imie']);
			}
		
		
		?>"  name="imie" placeholder="login"/>
		
		<?php
		
			if(isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
				
			}
		?>

<input type="email" value="<?php 
			
			if(isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		
		
		?>" name="email" placeholder="email"/>
		
		<?php
		
			if(isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
				
			}
		?>

 <input type="password" name="haslo1" placeholder="Twoje haslo"/>
		
		<?php
		
			if(isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
				
			}
		?>

 <input type="password" name="haslo2" placeholder="Powtórz hasło"/>

<div class="g-recaptcha" data-sitekey="6LdDQTEUAAAAAN8t7XBTioLJqYQNNiLaPRc2TmAf"></div>
		<?php
		
			if(isset($_SESSION['e_bot']))
			{
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
				
			}
		?>
 
		<input type="submit" value="Zarejestruj się"/>
		

		
		
</form>
<div>
<img src="img/rsz_2santa.png" id="santa" onclick="merry.play()"/>
</div>
</div>


</body>



</html>