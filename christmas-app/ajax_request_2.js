function usun_osobe(id)
{
			
	$.ajax({
		type: "POST",
		url: "admin_aux_2.php",
		data: {personId: id},
		dataType: "html",
		success: function(response)
		{                    
			
		location.reload(true);
					
		}		
		  });
		
}
  