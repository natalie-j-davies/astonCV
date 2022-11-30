<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type="text/css" href="style/style.css" />
    <title>Search page</title>
</head>
<body>

    <div id="cv-container">
 <?php
    include ('connectdb.php'); 

    if(isset($_POST['submit-search'])){
        if(!empty($_POST['searchbar'])){
	        $search= $_POST['searchbar'];
        }
	    try {
		    $query="SELECT *  FROM  cvs WHERE language LIKE '%$search%' OR name LIKE '%$search%'";
		//run  the query
		    $rows =  $db->query($query);	
		    if ( $rows && $rows->rowCount()> 0) {
                echo "<h3>These are the search results for '". $search ."'..</h3>";
			    while  ($row =  $rows->fetch())	{
			    	echo "<div id='cv-box'>
			    	<h3>". $row['name'] ."</h3
				    <p>". $row['email'] ."</p>
				    <p>". $row['language'] ."</p><a href='cv-info.php?name=". $row['name'] ."&email=". $row['email'] ."&language=". $row['language'] ."'>
                    <p> click here to find out more </p></a>
				    </div>";

	            }
            }
		
    else {
	    echo  "<p>0 results.</p>\n"; //no match found
    }   
}
        catch (PDOexception $ex){
            echo "Sorry, a database error occurred! <br>";
            echo "Error details: <em>". $ex->getMessage()."</em>";
        }
    }

?>
</div>
<a href="index.php"><p id="homepage-button">Return to Home Page</p></a>
</body>
</html>