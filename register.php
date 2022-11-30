<?php
//if the form has been submitted
if (isset($_POST['submitted'])){
 //prepare the form input

  // connect to the database
  require_once('connectdb.php');
	
  $username=isset($_POST['username'])?$_POST['username']:false;
  $password=isset($_POST['password'])?password_hash($_POST['password'],PASSWORD_DEFAULT):false;
  
  if (!($username)){
	echo "Username wrong!";
    exit;
	}
  if (!($password)){
	exit("password wrong!");
	}
 try{
	
	//register user by inserting the user info 
	$stat=$db->prepare("insert into users values(default,?,?)");
	$stat->execute(array($username, $password));
	
	$id=$db->lastInsertId();
	echo "Congratulations! You are now registered. Your ID is: $id  ";  	
	
 }
 catch (PDOexception $ex){
	echo "Sorry, a database error occurred! <br>";
	echo "Error details: <em>". $ex->getMessage()."</em>";
 }

 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel = "stylesheet" type="text/css" href="style/style.css" />
  <title>Registration System </title>
</head>
<body>
<div id="register">
  <h2>Register</h2>
  <form method = "post" action="register.php">
	Username: <input type="text" name="username" /><br>
	Password: <input type="password" name="password" /><br><br>

	<input type="submit" value="Register" /> 
	<input type="reset" value="clear"/>
	<input type="hidden" name="submitted" value="true"/>
  </form>  
  <p> Already a user? <a href="index.php">Log in</a>  </p>
</div>
</body>
</html>