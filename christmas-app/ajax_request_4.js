function zezw()
{
			
	$.ajax({
		type: "POST",
		url: "admin_aux_4.php",
		dataType: "html",
		success: function(response)
		{                    
		
			location.reload(true);
					
		}		
		  });
		
}
  
  