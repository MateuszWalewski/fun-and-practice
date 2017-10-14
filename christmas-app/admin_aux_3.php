
<?php
//deletion of all players from admin pannel
							
											
session_start(); 

require_once "connect.php"; //server information
	

	
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
						
							
						$polaczenie->close();				
				
				}
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
					echo '<br/>Informacja developerska: '.$e;
			} 
				




?>