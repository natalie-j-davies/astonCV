<?php

//if the form has been submitted
if (isset($_POST['submitted'])){
	if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	 exit('Please fill both the username and password fields!');
	}
	// connect DB
	require_once ("connectdb.php");
	try {
	//Query DB to find the matching username/password
	//using prepare to prevent SQL injection.
		$stat = $db->prepare('SELECT password FROM users WHERE username = ?');
		$stat->execute(array($_POST['username']));
		
		// fetch the result row and check 
		if ($stat->rowCount()>0){ 
			$row=$stat->fetch();

			if (password_verify($_POST['password'], $row['password'])){ 

			  session_start();
				$_SESSION["username"]=$_POST['username'];
				header("Location:addCV.php");
				exit();
			
			} else {
			 echo "<p style='color:red'>Error logging in, incorrect password </p>";
			 }
		} else {
		  echo "<p style='color:red'>Error logging in, Username not found </p>";
		}
	}
	catch(PDOException $ex) {
		echo("Failed to connect to the database.<br>");
		echo($ex->getMessage());
		exit;
	}

}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel = "stylesheet" type="text/css" href="style/style.css" />
	<title>Log in screen</title>
</head>
<body>
<div id="index-header">
	<h2>Aston CV</h2>
	<form action="index.php" method="post">
<div id="index-login">
	<label>User Name</label>
	<input type="text" name="username" size="15" maxlength="25" />
	<label>Password:</label>
	<input type="password" name="password" size="15" maxlength="25" />

	<input type="submit" value="Login" class="button"/>
	<input type="reset" value="clear" class="button"/>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>

	<p>Not registered yet? <a href="register.php">Register</a></p>
</div>
	<div id="index-pic">
	<h3>Add your CV onto our database and be discovered by Britain's biggest employers </h3>
	<img id="image" src="images/ComputerProgrammer.jpg" alt="picture of programmer">
	</div>
</div>
<div id="main">
<h2>Search our database for thousands of CV's</h2>


<form action="search.php" method="post">
<input id="search" name="searchbar" type="text" placeholder="search name or language.." required>
<input id="search-button" type="submit" name="submit-search" value="Search">
</form>
</div>
<div id="cv-container">

<?php
	//TO BE CHANGED ONCE DB CREATED
	require_once ('connectdb.php');  
	try {
		$query="SELECT  * FROM  cvs ";
		$rows =  $db->query($query);	
		if ( $rows && $rows->rowCount()> 0) {
			while  ($row =  $rows->fetch())	{
				echo "<div id='cv-container'><div id='cv-box'>
				<h3>Name: ". $row['name'] ."</h3
				<p>Email: ". $row['email'] ."</p>
				<p>Key Programming Language: ". $row['language'] ."</p>
				<a href='cv-info.php?name=". $row['name'] ."&email=". $row['email'] ."&language=". $row['language'] ."'>
                <p> click here to find out more </p></a>
				</div></div>";

	}
}
		
else {
	echo  "<p>0 results.</p>\n";
}
}
catch (PDOexception $ex){
echo "Sorry, a database error occurred! <br>";
echo "Error details: <em>". $ex->getMessage()."</em>";
}
	
?>
</div>
</body>
</html>