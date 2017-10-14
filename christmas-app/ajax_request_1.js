$(document).ready(function() 
{
 	   
	$.ajax({
			type: "POST",
			url: "admin_aux_1.php",
			dataType: "html",
			success: function(response)
			{                    
					$("#responsecontainer").html(response);
					
			}
		  });	 
});