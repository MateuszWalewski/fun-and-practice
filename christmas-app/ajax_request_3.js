function usun()
{
			
	$.ajax({
		type: "POST",
		url: "admin_aux_3.php",
		dataType: "html",
		success: function(response){                    
			
		location.reload(true);
					
				}		
		});
		
		  }
  
  