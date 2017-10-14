<?php

	session_start(); 
	require_once "connect.php"; //server information
		
	
$curr_id = $_SESSION['id'];
$drawn_name = $_SESSION['drawn_person'];

$_SESSION['draw_flag'] = true;

echo '<span id="los_im">'.$drawn_name.'</span>';	
	try
	{			
									
		$polaczenie2 = @new mysqli($host, $db_user, $db_password, $db_name); // connection to save flags and drawn names in DB
			
			if($polaczenie2->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
					
			}
			else
			{	
						
					$result =$polaczenie2->query("UPDATE imiona SET wylosowany=1 WHERE imie='$drawn_name'");
					if(!$result) throw new Exception($polaczenie2->error);
						
					$result =$polaczenie2->query("UPDATE imiona SET losowal=1 WHERE id='$curr_id'");
					if(!$result) throw new Exception($polaczenie2->error);
			
					if($result =$polaczenie2->query("UPDATE imiona SET wylosowane_imie = '$drawn_name' WHERE id='$curr_id'"));
					if(!$result) throw new Exception($polaczenie2->error);	
					
					$polaczenie2->close();
						
			}		
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
			echo '<br/>Informacja developerska: '.$e;
	} 
	
	
?>