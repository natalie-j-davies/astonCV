<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel = "stylesheet" type="text/css" href="style/style.css"/>
	<script defer src="js/script.js"></script>
		<title>CV page</title>
	</head>
	<body>
		<div  id="header">
	<?php
	//start the session, check if the user is not logged in, redirect to start
	session_start();	

	if (!isset($_SESSION['username'])){
		header("Location: index.php");
		exit();
	}
	$username=$_SESSION['username'];
	echo "<h2> Welcome ".$_SESSION['username']."! </h2>";
	
	?>
	
	</div>	
				
	<div id="register-form">
	<h3>Add your CV to the database here</h3>

    <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <p><strong>Please fill in ALL your details </strong> </p>
      
      <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Your full name.." required><br>
      <br>
      <label for="email">Email</label> 
        <input type="text" id="email" name="email" placeholder="Your email address.." required><br>
      <br>
      <label for="conEmail">Confirm Email</label> 
        <input type="text" id="conEmail" name="conEmail" placeholder="Confirm your email address.." required><br>
      <p id="text"></p>
	<br>
	  <label class="language">Key Programming Language</label>
        <input type="text" id="language" name="language" placeholder="eg. JavaScript" required><br>
      <br>
      <label class="education">Highest level of education</label>
        <input type="text" id="education" name="education" placeholder="eg. BSc Computer Science" required><br>
      <br>
      <label for="profile">Profile</label>
        <textarea id="profile" name="profile" placeholder="eg. I love code! max 250 characters.." style="height:200px" required></textarea><br>
      
		<label class="url">URL</label>
        <input type="text" id="url" name="url" placeholder="url link for cv purpose" required><br>
      <br>
	<div  id="submit-clear">
	<input type="submit" value="submit" /> 
	<input  type="reset" value="clear"/>
	<input type="hidden" name="submitted" value="true"/>  
    </form>
	</div>
    </div>
<?php
//if the form has been submitted
if (isset($_POST['submitted'])){

  // connect to the database
  require_once('connectdb.php');
	
  $name=isset($_POST['name'])?$_POST['name']:false;
  $email=isset($_POST['email'])?$_POST['email']:false;
  $education=isset($_POST['education'])?$_POST['education']:false;
  $language=isset($_POST['language'])?$_POST['language']:false;
  $profile=isset($_POST['profile'])?$_POST['profile']:false;
  $url=isset($_POST['url'])?$_POST['url']:false;


 try{
	
	//register cv by inserting the cv info 

	$stat=$db->prepare("INSERT INTO cvs VALUES(default,?,?,?,?,?,?);");
	$stat->execute(array($name, $email,$language,$education,$profile,$url));

	echo "<p id='congrats'>Congratulations! You have added your CV to our database!</p>";
	echo "<h3>This is how your CV will be presented ..</h3>" 	;
	//SHOW CV JUST WRITTEN	
		$query="SELECT  * FROM  cvs WHERE name='$name' AND email='$email' AND language='$language'";
		$rows =  $db->query($query);	
		if ( $rows && $rows->rowCount()> 0) {
			while  ($row =  $rows->fetch())	{
				echo "<div id='cv-info-box'>
				<h3>". $row['name'] ."</h3>
				<p>Email Address:  ". $row['email'] ."</p>
				<p>Key Programming Language: ". $row['language'] ."</p>
                <p>Highest Level of Education: ". $row['education'] ."</p>
                <p>URL page: ". $row['url'] ."</p>
                <p>Profile: <br>". $row['profile'] ."</p>
				</div>";
			}
		}
	}
 	catch (PDOexception $ex){
	echo "Sorry, a database error occurred! <br>";
	echo "Error details: <em>". $ex->getMessage()."</em>";
 }
}
?>
<?php
//if the update form has been submitted
if (isset($_POST['update-submit'])){


//OLD INFO

  $oldName=isset($_POST['old-name'])?$_POST['old-name']:false;
//NEW INFO
  $newName=isset($_POST['new-name'])?$_POST['new-name']:false;
  $newEmail=isset($_POST['new-email'])?$_POST['new-email']:false;
  $newLanguage=isset($_POST['new-language'])?$_POST['new-language']:false;
  $newEducation=isset($_POST['new-education'])?$_POST['new-education']:false;
  $newProfile=isset($_POST['new-profile'])?$_POST['new-profile']:false;
  $newURL=isset($_POST['new-url'])?$_POST['new-url']:false;
 try{

	//update cv info in cvs database
	require_once('connectdb.php');
	$stat=$db->prepare("UPDATE cvs SET name = '$newName', email = '$newEmail', language ='$newLanguage', education = '$newEducation', profile = '$newProfile', url ='$newURL' 
	WHERE name = '$oldName'");
	$stat->execute();
	echo "<p id='congrats'>CV Updated.</p>"; 	
	echo "<h3>This is how your new CV will be presented ..</h3>" 	;
	//SHOW NEW CV JUST WRITTEN	
		$query="SELECT  * FROM  cvs WHERE name='$newName' AND email='$newEmail' AND language='$newLanguage'";
		$rows =  $db->query($query);	
		if ( $rows && $rows->rowCount()> 0) {
			while  ($row =  $rows->fetch())	{
				echo "<div id='cv-info-box'>
				<h3>". $row['name'] ."</h3>
				<p>Email Address:  ". $row['email'] ."</p>
				<p>Key Programming Language: ". $row['language'] ."</p>
                <p>Highest Level of Education: ". $row['education'] ."</p>
                <p>URL page: ". $row['url'] ."</p>
                <p>Profile: <br>". $row['profile'] ."</p>
				</div>";
			}
		}
 }
 catch (PDOexception $ex){
	echo "Sorry, a database error occurred! <br>";
	echo "Error details: <em>". $ex->getMessage()."</em>";

 }
}
?>	

<div id="register-form-update">

	<h3>Update your CV</h3>
	<form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      <p><strong>Please fill in ALL your details to update</strong> </p><br>
	  <p>Please spell your orginal CV name correctly, case sensitive</p>

	  <label for="name">Name on CV</label>
        <input type="text" id="old-name" name="old-name" placeholder="Full name on orginal CV.." required><br>
      <br>
      <label for="name">Full Name</label>
        <input type="text" id="name" name="new-name" placeholder="Your new full name.." required><br>
      <br>
      <label for="email">Email</label> 
        <input type="text" id="email" name="new-email" placeholder="Your new email address.." required><br>
      <br>
      <label for="conEmail">Confirm Email</label> 
        <input type="text" id="conEmail" name="conEmail" placeholder="Confirm your new email address.." required><br>
      <p id="text"></p>
	<br>
	  <label class="language">Key Programming Language</label>
        <input type="text" id="language" name="new-language" placeholder="eg. JavaScript" required><br>
      <br>
      <label class="education">Highest level of education</label>
        <input type="text" id="education" name="new-education" placeholder="eg. BSc Computer Science" required><br>
      <br>
      <label for="profile">Profile</label>
        <textarea id="profile" name="new-profile" placeholder="eg. I love code! max 250 characters.." style="height:200px" required></textarea><br>
      
		<label class="url">URL</label>
        <input type="text" id="url" name="new-url" placeholder="url link for cv purpose" required><br>
      <br>
	<div  id="submit-clear">
	<input type="submit" value="submit" /> 
	<input  type="reset" value="clear"/>
	<input type="hidden" name="update-submit" value="true"/>  
	</div>
    </form>
    </div>
   <p id="homepage-button">Would like to log out? <a href="logout.php">Log out</a>  </p>

	</body>
	</html>