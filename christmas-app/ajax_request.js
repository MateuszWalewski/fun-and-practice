$(document).ready(function() {
 	 $("#submit").click(function(){          
 
 

$.ajax({
    type: "POST",
    url: "losowanie_aux_1.php",
    dataType: "html",
	success: function(response){                    
            $("#responsecontainer").html(response);
            
        }
});

	$(this).remove();
	var yes = new Audio("snd/yes.wav");
	yes.play();
	
  
  });

});
