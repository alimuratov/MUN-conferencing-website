<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<!-- <?php // require "databaseconnection.php" ?>

<?php 

// if($_SERVER["REQUEST_METHOD"] == "POST")
// 	{
// 		$emaillogin = $_POST["emaillogin"]; 
// 		//sets the value of the "emaillogin" input form to $emaillogin variable
// 		$passwordlogin = $_POST["passwordlogin"]; 
// 		//sets the value of the "passwordlogin" input form to $passwordlogin variable


// 		$fifthquery = "SELECT id, firstname, email, passwordhash FROM registeredusers WHERE email = '$emaillogin'";
// 		//extracts records from the table registeredusers which fulfill a condition that email value equals to $emaillogin
// 		$result = $connection->query($fifthquery);
// 		//saves the results of the query to the variable $result
// 		if ($result->num_rows > 0) //if the number of results is more than 0 (if results exist)
// 			{
// 				$record = $result->fetch_assoc(); //fetches a result records as an associative array and saves that value to $record
// 				if(password_verify($passwordlogin, $record["passwordhash"]) === TRUE)
// 				//if the given passwordhash matches the $passwordlogin 
// 					{
// 						session_start(); //starts a new session
// 						$_SESSION["username"] = $record["firstname"]; 
// 						$_SESSION["id"] = $record["id"];
// 						//sets the value of the $record["firstname"] to $_SESSION["username"]
// 						header('location:index.php');
// 						//redirects user to the "index.php" page (main page of the website)
// 					}
// 				else
// 					{
// 						echo "<script> alert('Email or password is incorrect') </script>";
// 						header("Refresh:0");
// 					}
// 		    }	  				
// 		else 
// 			{
// 	  			echo "<script> alert('Email or password is incorrect') </script>";
// 	  			// header('location:login.php');
// 			} 
// 	}

?> -->

</body>
</html>