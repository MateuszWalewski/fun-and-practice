# christmas-app

-----------------------------------------------------------------------------------
This is my first web application. 
It performs a draw of nicknames in a group of registered players.

The main features:
- admin pannel which displays the list of registered players together with corresponding names of drawn persons. It also allow admin to start the game whereby drawing button on each user's profile is enabled as well as further registration or alteration of any data on users' pannel are disabled. Also, until this button is clicked, admin can delete each player separately. Otherwise the option disappear to avoid a mess. There is also the button to delete all the players which in fact starts the new game.
- sign-up pannel to let people enter to the game. (disabled when admin starts the play)
- sign-in pannel to let players log into their profile. The drawing button is disabled until
admin starts the game. Each player can draw one time per game.

-----------------------------------------------------------------------------------
Quick guide how to test the application:

- register at least two players typing fictitous names, emails etc. (in a proper format)
- log-in to the given player's pannel to check-out how it looks like
- log-in to admin pannel using:
	-- login: admin
	-- password: qwerty123
	
You should see the credentials of the already registered players together with 
some actions to take.
For ex. start from clicking "Zezwól na losowanie" and log into any player account
to see what happened. Also check if registration of another player is possible.
By clicking "Usuń wszystkie osoby" you clear the database and start the new game.

-----------------------------------------------------------------------------------