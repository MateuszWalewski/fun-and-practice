<?php

session_start();

//Page displays when limit of players is reached.

if((!isset($_SESSION['cof'])))
{
	
	header('Location: index.php');
	exit();
}
else
{
	
	unset($_SESSION['cof']);
	
}

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="style_vv2.css" type="text/css" />
	<title>Losowanie - za duzo graczy</title>
</head>

<body>
	
	
	<div id="container">
	<span style="color:red;"> Losowanie rozpoczęte - rejestracja zablokowana!</span>  <br/><br/>
	
	<a href="index.php">Cofnij do strony logowania!</a>
	<br/><br/>
	
	</div>



</body>

</html>