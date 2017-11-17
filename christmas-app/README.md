# christmas-app

-----------------------------------------------------------------------------------
A web-based application to organize the buying of Christmas gifts.
It anonymously assigns ''givers'' and ''receivers'' of Christmas gifts in a group of registered players.

The main features:
- the admin pannel which allows for supervising the game. The "Zezwól na losowanie" button eneables the drawing option on each user's profile. After that, further registration or alteration of any data on users' pannel are disabled. Until this button is clicked, admin can delete each player separately. Otherwise the option disappear to avoid a mess. There is also the button to delete all the players which in fact starts the new game.
- the sign-up pannel to let people enter to the game. (disabled when admin starts the play)
- the sign-in pannel to let players log into their profile. The drawing button is disabled until
admin starts the game. After drawing, the name of assigned person is saved in database and displayed on the screen every time the player log in to his profile. 
-----------------------------------------------------------------------------------
Quick guide how to test the application:

- register at least two players typing fictitious names, emails etc. (in a proper format)
- log in to the given player's pannel to check-out how it looks like
- log in to admin pannel using:
	-- login: admin
	-- password: qwerty123
	
You should see the credentials of the already registered players together with 
some actions to take.
For ex. start from clicking "Zezwól na losowanie" and log in to any player account
to see what happened. Also check if registration of another player is possible.
By clicking "Usuń wszystkie osoby" you clear the database and start the new game.

-----------------------------------------------------------------------------------