

<?php
// redirecting logged players
session_start();

if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) header('Location: losowanie.php');
	
else if((isset($_SESSION['zalogowany_admin'])) && ($_SESSION['zalogowany_admin']==true)) header('Location: admin.php');



?>






<!DOCTYPE HTML >

<html lang="pl"> 

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title> Logowanie do aplikacji Losowanie </title>

	<link rel="stylesheet" href="style_vv2.css" type="text/css" />
	
	
</head>



<body>

	
	
	
	<div id="container">
		<a id="reg" href="registration.php">Rejestracja - załóż konto!</a>

		<form action="logowanie.php" method="post">
		<input type="text" placeholder="login" name="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'"/>
		<input type="password" placeholder="haslo" name="haslo" onfocus="this.placeholder=''" onblur="this.placeholder='haslo'"/>
		<input type="submit" value="Zaloguj się!"/>
		</form>
		
	
		<p id="warn"> <?php
	
		if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
	?> </p>
	<br/>	
		
	

	
	</div>
	
	
	


</body>


</html>