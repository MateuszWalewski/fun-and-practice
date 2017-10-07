<?php

session_start();

if(!isset($_SESSION['zalogowany']) ) // to re-direct unlogged players
	{
		header('Location: index.php');
		exit();
		
	}


require_once "connect.php";

mysqli_report(MYSQLI_REPORT_STRICT);


try 
{
	$polaczenie0 = new mysqli($host, $db_user, $db_password, $db_name);
	
	$curr_id = $_SESSION['id'];
			
			if($polaczenie0->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{	
				$result0 =$polaczenie0->query("SELECT * FROM imiona WHERE id = '$curr_id' ");
				if(!$result0) throw new Exception($polaczenie0->error);
				
					$row = $result0->fetch_assoc();
					$current_name = $row['imie']; //updated credentials for placeholder and password alteration
					$current_mail = $row['email'];
					$current_passw = $row['haslo'];
					
			
					$result0->free();
					$polaczenie0->close();
				
					
			}
}

catch(Exception $e)
		{
			//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
			echo '<br/>Informacja developerska: '.$e;
		}
		
		
if(isset($_POST['email'])) // check whether the form was sent
	{
		
		$imie_OK=true; 
		
		$imie = $_POST['imie'];
		
		
		if(strlen($imie)<3 || (strlen($imie)>20))
		{
			$imie_OK = false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		
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
				
				$rezultat = $polaczenie->query("SELECT id FROM imiona WHERE imie='$imie'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				
				if($ile_takich_nickow > 0)
				{
					$imie_OK = false;
					$_SESSION['e_nick']="Istnieje juz gracz o takim nicku! Wybierz inny";
				}
				
				if(ctype_alnum($imie)==false)
				{
					$imie_OK = false;
					$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
					
				}
				$_SESSION['n_ok'] = $imie_OK; //variable to show or hidden appropriate comment

					
				$email_OK=true;
		
				$email = $_POST['email'];
				$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
				if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
				{
					$email_OK = false;
					$_SESSION['e_email']="Podaj poprawny adres email!";
			
				}
				
				$rezultat = $polaczenie->query("SELECT id FROM imiona WHERE email='$email'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				
				if($ile_takich_maili > 0)
				{
					$email_OK = false;
					$_SESSION['e_email']="Istnieje juz konto przypisane do tego adresu e-mail!";
				}
				$_SESSION['em_ok'] = $email_OK; //variable to show or hidden appropriate comment
				

				$haslo_OK=true;
		
				$haslo0 = $_POST['haslo0'];
				
				
				if(password_verify($haslo0, $current_passw))
				{
					
					$haslo1 = $_POST['haslo1'];
					$haslo2 = $_POST['haslo2'];
					
					if((strlen($haslo1)<8) || (strlen($haslo1)>20))
					{
						$haslo_OK = false;
						$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
						
					}
					
					if($haslo1!=$haslo2)
					{
						$haslo_OK = false;
						$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
						
					}
					
					$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT); // hashing password
					
					
				}
				else
				{
					$haslo_OK=false;
					$_SESSION['e_haslo0']="Niepoprawne hasło!";
				}
				$_SESSION['h_ok'] = $haslo_OK; //variable to show or hidden appropriate comment
			
				
				if($email_OK==true )
				{

						
						if($polaczenie->query("UPDATE imiona SET email='$email' WHERE imie= '$current_name'"))
						{
								header('Location: zmiana.php');
						}
						else
						{
							throw new Exception($polaczenie->error);
							
						}
				
				}
				else header('Location: zmiana.php');
				
				
				if($imie_OK==true)
				{
				
						if($polaczenie->query("UPDATE imiona SET imie='$imie' WHERE imie= '$current_name'"))
						{
							header('Location: zmiana.php');
							
						}
						else
						{
							throw new Exception($polaczenie->error);
							
						}
							
				}
				else header('Location: zmiana.php');
					
				if($haslo_OK==true)
				{
						
						
						if($polaczenie->query("UPDATE imiona SET haslo='$haslo_hash' WHERE imie= '$current_name'"))
						{
								header('Location: zmiana.php');
								
							
						}
						else
						{
							throw new Exception($polaczenie->error);
							
						}
					
					
				}
				else header('Location: zmiana.php');
					
			
					//leaving some boxes blank and submitting the fromular don't trigger any warning
					if($email =="") unset($_SESSION['e_email']);
					if($imie =="") unset($_SESSION['e_nick']);
					if($haslo0 =="") unset($_SESSION['e_haslo0']);
		
		
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
	<link rel="stylesheet" href="style_vv3.css" type="text/css" />
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
<a id="reg" href="losowanie.php">Powrót do strony profilowej</a>
<form method="post">

<input type="text" value="<?php 
			
			if(isset($_SESSION['fr_imie']))
			{
				echo $_SESSION['fr_imie'];
				unset($_SESSION['fr_imie']);
			}
		
		
		?>"  name="imie" placeholder="<?php echo $current_name; ?>"/>
		
		<?php
		
			if(isset($_SESSION['e_nick']) )
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				if($_SESSION['n_ok'] || !(isset($_POST['email']))) unset($_SESSION['e_nick']);
				//the warning disappear when data are correct or the page is reloaded
				
			}
		?>

<input type="email" value="<?php 
			
			if(isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		
		
		?>" name="email" placeholder="<?php echo $current_mail; ?>"/>
		
		<?php
		
			if(isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				if($_SESSION['em_ok'] || !(isset($_POST['email']))) unset($_SESSION['e_email']);
				//the warning disappear when data are correct or the page is reloaded
			}
		?>
		
<input id="psw" type="password" name="haslo0" placeholder="Podaj stare haslo"/>
		
		<?php
		
			if(isset($_SESSION['e_haslo0']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo0'].'</div>';
				if($_SESSION['h_ok'] || !(isset($_POST['email'])) )unset($_SESSION['e_haslo0']);
				//the warning disappear when data are correct or the page is reloaded
			}
		?>

 <input type="password" name="haslo1" placeholder="Nowe haslo"/>
		
		<?php
		
			if(isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				if($_SESSION['h_ok'] || !(isset($_POST['email'])) )unset($_SESSION['e_haslo']);
				//the warning disappear when data are correct or the page is reloaded
			}
		?>

 <input type="password" name="haslo2" placeholder="Powtórz hasło"/>


 
		<input type="submit" value="Zatwierdź zmiany"/>
		

		
		
</form>
<div>
<img src="img/rsz_2santa.png" id="santa" onclick="merry.play()"/>
</div>
</div>


</body>



</html>