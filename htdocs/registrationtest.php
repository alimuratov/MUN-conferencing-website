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


	/*if(empty($_POST["firstname"]) == TRUE) //if the field is empty
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
		}*/

	if(empty($_POST["firstname"]) == TRUE) //if the field is empty
		{
			$firstnameError = "First name is required"; //saving error
		}
	if(empty($_POST["lastname"]) == TRUE)
		{
			$lastnameError = "Last name is required";
		}
	if(empty($_POST["email"]) == TRUE || filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == FALSE)
		{
			$emailError = "Valid email is required";
		}
	else
		{
			$firstname = validation1($_POST["firstname"]);
			$lastname = validation1($_POST["lastname"]);
			$email = validation1($_POST["email"]);
		}

	$grade = $_POST["grade"];
	$preferrableLanguage1 = $_POST["preferrableLanguageEnglish"];
	$preferrableLanguage2 = $_POST["preferrableLanguageRussian"];
	$preferrableLanguage3 = $_POST["preferrableLanguageKazakh"];
	$motive = $_POST["motive"];
	$password = trim($_POST["password"]); //deleting spaces before and after the password

	$patternCapitalLetters = "/[A-Z]/"; //determining regEx patterns
	$patternSpecialCharacters = "/[!@#$%^&*]/";
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
			$passwordError5 = "Passwords do not match";
		}
	if($passwordError1 == "" && $passwordError2 == "" && $passwordError3 == "" && $passwordError4 == "" && $passwordError5 == "")
	{
		$passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);
	}
	/*else
		{
			$passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);
		}*/

	if($passwordError1 == "" && $passwordError2 == "" && $passwordError3 == "" && $passwordError4 == "" && $passwordError5 == "" && $emailError == "" && $firstnameError == "" && $lastnameError == "")
		{
			$thirdquery = "INSERT INTO registeredusers (firstname, lastname, email, grade, preferrableLanguage, motivation, studyNIS, passwordhash)
			VALUES ('$firstname', '$lastname', '$email', '$grade', '$preferrableLanguage1 $preferrableLanguage2 $preferrableLanguage3', '$motive', '$studyNIScheck', '$passwordhash')"; 

			if ($connection->query($thirdquery) === TRUE) 
				{
					echo "<script> alert('New account has been registered successfully') </script>";
					$firstname = $lastname = $email = $grade = $preferrableLanguage1 = $preferrableLanguage2 = $preferrableLanguage3 = $motive = $studyNIScheck = $passwordhash = "";
					echo "<script> window.location.replace('login_form.php') </script>";

				} 
			else 
				{
					echo "Error: " . $thirdquery . "<br>" . $connection->error;
				}
		}
	else 
		{
			/*$errors = [$firstnameError, $lastnameError, $emailError, $passwordError1, $passwordError2, $passwordError3, $passwordError4, $passwordError5];*/

			echo "<script> 
			document.getElementById('paragraphmistakeregistrationform').style.display = 'block'; 
			</script>";

			$errors = array(
				'Main fields' => array($firstnameError, $lastnameError, $emailError),
				'Password' => array($passwordError1, $passwordError2, $passwordError3, $passwordError4, $passwordError5)
			);

			$errorsOutput = array();

			foreach($errors as $key => $errorType)
			{
				if(in_array("First name is required", $errorType) || in_array("Last name is required", $errorType) || in_array("Valid email is required", $errorType) || in_array("Password must contain at least 8 characters", $errorType) || in_array("Password must contain at least 1 capital letter", $errorType) || in_array("Password must contain at least 8 characters", $errorType) || in_array("Password must contain at least 1 capital letter", $errorType) || in_array("Password must contain at least 1 special character", $errorType) || in_array("Password must contain at least 1 digit", $errorType) || in_array("Passwords do not match", $errorType))
				{
					echo "<script>
					document.getElementById('paragraphmistakeregistrationform').innerHTML +='" . $key . "'
					</script>";
					echo "<script>
					document.getElementById('paragraphmistakeregistrationform').innerHTML +='<ul>'
					</script>";
					foreach($errorType as $error)
					{
						if($error != "")
						{
							echo "<script>
								document.getElementById('paragraphmistakeregistrationform').innerHTML +='<li>" . $error . "</li>'
								</script>";
						}
					}
					echo "<script>
					document.getElementById('paragraphmistakeregistrationform').innerHTML +='</ul>'
					</script>";
					if($key == 'Main fields')
						{
							echo "<script>
						document.getElementById('paragraphmistakeregistrationform').innerHTML +='<br>'
						</script>";
						}

				}
			}

			/*echo "<script> 
			document.getElementById('paragraphmistakeregistrationform').style.display = 'block';
			document.getElementById('paragraphmistakeregistrationform').innerHTML = 'Ошибка! <br>" . $firstnameError . "<br>" . $lastnameError . "<br>" . $emailError . "<br>" . $passwordError1 . "<br>" . $passwordError2 . "<br>" . $passwordError3 . "<br>" . $passwordError4 . "<br>" . $passwordError5 . "';
			</script>";*/
		}

	/*$thirdquery = "INSERT INTO registeredusers (firstname, lastname, email, grade, preferrableLanguage, motivation, studyNIS, passwordhash)
	VALUES ('$firstname', '$lastname', '$email', '$grade', '$preferrableLanguage1 $preferrableLanguage2 $preferrableLanguage3', '$motive', '$studyNIScheck', '$passwordhash')"; 

	if ($connection->query($thirdquery) === TRUE) 
		{
			echo "New record created successfully";
		} 
	else 
		{
			echo "Error: " . $thirdquery . "<br>" . $connection->error;
		}  */
}



/* if(isset($_POST['preferrableLanguageEnglish']) === TRUE)
{
	$_POST[preferrableLanguageEnglish] = "English"; 
	echo "vivel";
} */



?>

<!-- <?php 
	/*if($passwordError1 != "" || $passwordError2 != "" || $passwordError3 != "" || $passwordError4 != "" || $passwordError5 != "")
		{
			echo "<script> alert('" . $passwordError1 . "\\r\\" . $passwordError2 . "\\r\\" . $passwordError3 . "\n" . $passwordError4 . "\\r\\" . $passwordError5 . "') </script>"; //экранирование r
		}
	else
 	{
 		echo "Success";
 	}*/
?> -->