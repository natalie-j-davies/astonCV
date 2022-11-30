<?php
	session_start();

	session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel = "stylesheet" type="text/css" href="style/style.css" />
	<title>Logged Out Page</title>
</head>
<body>
<div id="log-out">
	<h2> Logged out of your AstonCV account </h2> 
	<p>Would like to log in again? <br></p>
	<button id="button" onclick= "document.location='index.php'">Log in</button>
</div>

</body>
</html>
