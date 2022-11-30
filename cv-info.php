<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type="text/css" href="style/style.css" />
    <title>cv Information</title>
</head>
<body>
<?php
        echo "<h2 id='cv-info-header'>Welcome to the CV of: ". $_GET['name'] ."</h2>";
    ?>
    <div id="cv-container">
<?php
	include ('connectdb.php');  

	try {
        $name = $_GET['name'];
        $email = $_GET['email'];
        $language = $_GET['language'];

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
    <a href="index.php"><p id="homepage-button">Return to Home Page</p></a>
</body>
</html>