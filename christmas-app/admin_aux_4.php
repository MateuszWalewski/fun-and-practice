<?php

//update of 'admin permission' flag							
											
session_start(); 

require_once "connect.php"; //server information
	
$_SESSION['permition_flag'] = true;
	
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
							
						//header('Location: admin.php');
						
						$polaczenie->close();	
						
				
				}
					
				
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
					echo '<br/>Informacja developerska: '.$e;
			} 
				




?>