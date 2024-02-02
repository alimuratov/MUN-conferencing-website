<!DOCTYPE html>
<html>
<head>
	<title>Registration form</title>

	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css"> <!-- Подключение самописных стилей-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> <!-- Подключение бутстрапа -->

</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$databasename = "mun";
// Create connection
$connection = mysqli_connect($servername, $username, $password, $databasename);

// Check connection
/* if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully"; */

/*$firstquery = "CREATE DATABASE mun";
if (mysqli_query($connection, $firstquery)) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . mysqli_error($connection);
} */

/* $secondquery = "CREATE TABLE registeredUsers (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(40) NOT NULL,
lastname VARCHAR(40) NOT NULL,
email VARCHAR(60),
grade ENUM('7', '8', '9', '10', '11', '12'),
preferrableLanguage VARCHAR(100),
motivation LONGTEXT,	
studyNIS VARCHAR(3),
passwordhash VARCHAR(255) NOT NULL
)";  

if ($connection->query($secondquery) === TRUE) {
  echo "Table regsiteredUsers created successfully";
} else {
  echo "Error creating table: " . $connection->error;
} 

$connection->close(); */

$studyNIScheck = $_POST["studyNIS"];

function validation1($testdata) 
{
	$testdata = trim($testdata); //deleting spaces 
	$testdata = stripslashes($testdata); //deleting slashes
	return $testdata;
}

if($_SERVER["REQUEST_METHOD"] == "POST") //if the user submitted the form (using the method POST)
{

	$firstnameError = $lastnameError = $emailError = $passwordError1 = $passwordError2 = $passwordError3 = $passwordError4 = $passwordError5 = "";

	if(empty($_POST["firstname"]) == TRUE) //if the field is empty
		{
			$firstnameError = "First name is required"; //saving error
		}
	else
		{
			$firstname = validation1($_POST["firstname"]); //applying validation function if the field is not empty
		}

	if(empty($_POST["lastname"]) == TRUE)
		{
			$lastnameError = "Last name is required";
		}
	else
		{
			$lastname = validation1($_POST["lastname"]);
		}

	if(empty($_POST["email"]) == TRUE || filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == FALSE)
		{
			$emailError = "Valid email is required";
		}

	else
		{
			$email = validation1($_POST["email"]);
		}

	$grade = $_POST["grade"];
	$preferrableLanguage1 = $_POST["preferrableLanguageEnglish"];
	$preferrableLanguage2 = $_POST["preferrableLanguageRussian"];
	$preferrableLanguage3 = $_POST["preferrableLanguageKazakh"];
	$motive = $_POST["motive"];
	$password = trim($_POST["password"]); //deleting spaces before and after the password

	$patternCapitalLetters = "/[A-Z]/"; //determining regEx patterns
	$patternSpecialCharacters = "/[@$#^&!-*%])/";
	$patternNumbers = "/[0-9]/";

	if(mb_strlen($password) < 8) // determining the exact number of characters (according to the encoding)
		{
			$passwordError1 = "Password must contain at least 8 characters";
		}

	if(preg_match($patternCapitalLetters, $password) === 0) 
		{
			$passwordError2 = "Password must contain at least 1 capital letter";
		}

	if(preg_match($patternSpecialCharacters, $password) === 0)
		{
			$passwordError3 = "Password must contain at least 1 special character";
		}

	if(preg_match($patternNumbers, $password) === 0)
		{
			$passwordError4 = "Password must contain at least 1 digit";
		}
	if($_POST["password"] != $_POST["passwordRepeat"])
		{
			$passwordError5 = "Пароли не совпадают";
		}
	else
		{
			$passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);
		}

	// if($passwordError1 = $passwordError2 = $passwordError3 ... )

	$thirdquery = "INSERT INTO registeredusers (firstname, lastname, email, grade, preferrableLanguage, motivation, studyNIS, passwordhash)
	VALUES ('$firstname', '$lastname', '$email', '$grade', '$preferrableLanguage1 $preferrableLanguage2 $preferrableLanguage3', '$motive', '$studyNIScheck', '$passwordhash')"; 

	if ($connection->query($thirdquery) === TRUE) 
		{
			echo "New record created successfully";
		} 
	else 
		{
			echo "Error: " . $thirdquery . "<br>" . $connection->error;
		}  
}



/* if(isset($_POST['preferrableLanguageEnglish']) === TRUE)
{
	$_POST[preferrableLanguageEnglish] = "English"; 
	echo "vivel";
} */



?>

<?php 
	if($passwordError1 != "" || $passwordError2 != "" || $passwordError3 != "" || $passwordError4 != "" || $passwordError5 != "")
		{
			echo "<script> alert('" . $passwordError1 . "\\r\\" . $passwordError2 . "\\r\\" . $passwordError3 . "\n" . $passwordError4 . "\\r\\" . $passwordError5 . "') </script>"; //экранирование r
		}
	else
 	{
 		echo "Success";
 	}
?>

</body>
</html>