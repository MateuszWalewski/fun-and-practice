
<?php


	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
		
	}
	

	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try
	{
	
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
			
		}
		else
		{
			
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8"); // to brush login up from insects
			
			$result = $connection->query(sprintf("SELECT * FROM imiona WHERE imie='%s'",
			mysqli_real_escape_string($connection, $login)));
			if(!$result) throw new Exception($connection->error);
			
			
				$nof_users = $result->num_rows;
				
				if($nof_users >0)
				{
					$row = $result->fetch_assoc();
					if(password_verify($haslo, $row['haslo']))
					{
						if($login == "admin")
						{
							$_SESSION['zalogowany_admin'] = true;
							
						}
						else
						{
							$_SESSION['zalogowany'] = true;
						}
						
						$_SESSION['id'] = $row['id'];
						$_SESSION['imie'] = $row['imie'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['losowal'] = $row['losowal'];
						$_SESSION['wylosowany'] = $row['wylosowany'];
						$_SESSION['wylosowane_imie'] = $row['wylosowane_imie'];
						
						unset($_SESSION['blad']);
						
						$result->free();
						
						if($login == "admin")
						{
							
							header('Location: admin.php');
		
						}
						else
						{
							
							header('Location: losowanie.php');
						}
						
					}
					else
					{
						$_SESSION['blad'] = "Nieprawidłowy login lub hasło!";
						
						header('Location: index.php');
					}
					
				}
				else
				{
					
					$_SESSION['blad'] =  "Nieprawidłowy login lub hasło!";
					
					header('Location: index.php');
					
				}
			
				
			
			
			$connection->close();
		}
	}
	catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
			//echo '<br/>Informacja developerska: '.$e;
		}
	
?>