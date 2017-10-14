<?php



if(isset($_POST['personId']))
{
			require_once "connect.php";
		
			try
			{
		 
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); //connecting with DB
				 
				if($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{	
						
						$curr_player = $_POST['personId'];
						$result =$polaczenie->query("DELETE FROM imiona WHERE id = '$curr_player'");
						if(!$result) throw new Exception($polaczenie->error);
						
						$result =$polaczenie->query("ALTER TABLE imiona DROP COLUMN id");
						if(!$result) throw new Exception($polaczenie->error);
						
						$result =$polaczenie->query("ALTER TABLE imiona ADD id int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
						if(!$result) throw new Exception($polaczenie->error);
						// dropping and adding new id column to avoid numbering mess
						
						//header('Location: admin.php');
				
					$polaczenie->close();				
				
				}
			
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
					echo '<br/>Informacja developerska: '.$e;
			} 
		
			
	
	
	
}


?>