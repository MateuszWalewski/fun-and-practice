
<?php
		
//connection to database and display the list of players on admin pannel		
											
session_start(); 

require_once "connect.php"; //server information
	
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
						
				$result =$polaczenie->query("SELECT * FROM imiona");
				if(!$result) throw new Exception($polaczenie->error);
				
					
							$ile = $result->num_rows;
						
								//Build Result String
								$display_string = "<table>";
								$display_string .= "<tr>";
								$display_string .= "<th>Numer</th>";
								$display_string .= "<th>Gracz</th>";
								$display_string .= "<th>Wylosowana osoba</th>";
								$display_string .= "<th>e-mail</th>";
								$display_string .= "</tr>";
						
							// Insert a new row in the table for each person returned
							while($row_1 = mysqli_fetch_assoc($result)){
								
							   if( $row_1['imie'] == "admin") continue; //do not display admin credentials
							   $nr = $row_1['id']-1;
							   $display_string .= "<tr>";
							   $display_string .= "<td>$nr</td>";
							   $display_string .= "<td>$row_1[imie]</td>";
							   $display_string .= "<td>$row_1[wylosowane_imie]</td>";
							   $display_string .= "<td>$row_1[email]</td>";
							   $display_string .= '<td><button class="del" onclick="usun_osobe('.$row_1['id'].')">Usuń</button></td>';
							   $display_string .= "</tr>";
							   
							}
							

							$display_string .= "</table>";

							echo $display_string;
							
					
								$result->free();
								$polaczenie->close();				
		
		}
		

	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i poprosimy o rejestracje w innym terminie!</span>';
			echo '<br/>Informacja developerska: '.$e;
	} 


?>