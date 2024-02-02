<!DOCTYPE html>
<html>
<head>
  <title>Registration form</title>

<?php require "config.php"?>
<!-- including configuration -->

</head>
<body>

<?php require "blocks/header.php" ?>
<!-- including code of 'header.php' -->
<?php require "databaseconnection.php"; ?>
<!-- establishing connection with the database -->


  <div class="container text-center" style="margin-top: 100px"> <h1> Registration form </h1> </div>
  <hr class="horline1">

<div class="d-flex justify-content-center">
  <div class="col-6">
    <div class="container px-40 my-5">
        <form id="registrationForm" action="#" method="post">
        	<!-- action='#' means that once the form is submitted, the data will be sent to the 
        	current page (registration.php); method='post' means that the data will be sent 
        	using the "POST" method, which is more secure and has no limitations of data size compared
        	to the "GET" method -->
            <div class="mb-3">
                <label class="form-label" for="firstName">First name</label>
                <input class="form-control" name="firstname" type="text" placeholder="First name">
            </div>
            <div class="mb-3">
                <label class="form-label" for="lastName">Last name</label>
                <input class="form-control" name="lastname" type="text" placeholder="Last name">
            </div>
            <div class="mb-3">
                <label class="form-label" for="emailAddress">Email Address</label>
                <input class="form-control" name="email" type="email" placeholder="Email Address">
            </div>
            <div class="mb-3">
                <label class="form-label" for="grade">Grade</label>
                <select class="form-select" name="grade" aria-label="Grade">
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Preferrable language of the elective course</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preferrableLanguageEnglish" value="English">
                    <label class="form-check-label" for="english">English</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preferrableLanguageRussian" value="Russian">
                    <label class="form-check-label" for="russian">Russian</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preferrableLanguageKazakh" value="Kazakh">
                    <label class="form-check-label" for="kazakh">Kazakh</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="motive">Why do you want to enter this elective course?</label>
                <textarea class="form-control" name="motive" type="text" placeholder="Why do you want to enter this elective course?" style="height: 10rem;"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Do you study at NIS?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="yes" type="radio" name="studyNIS" value="yes">
                    <label class="form-check-label" for="yes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="no" type="radio" name="studyNIS" value="no">
                    <label class="form-check-label" for="no">No</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" name="password" type="password" placeholder="Password">
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Repeat Password</label>
                <input class="form-control" name="passwordRepeat" type="password" placeholder="Repeat Password">
            </div>
            <div class="d-grid">
                <button class="btn btn-warning btn-lg" id="submitButton" type="submit">Submit</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div id="divmistakesregform">
        <p id="paragraphmistakeregistrationform" style="display: none"></p>
        <!-- As default value, the 'display' parameter of the 'style' attribute will be equal to 'none.' Once the user submits the form, the program will check whether the submitted data is valid or not. If it is not valid, mistakes will be displayed in this paragraph, and the 'display' parameter of the 'style attribute will change to 'block,' so the user can see it. -->
</div>

<?php 


function validation1($testdata) 
{
	$testdata = trim($testdata); // removing whitespaces from both sides of the $testdata  
	$testdata = stripslashes($testdata); // removing backslashes from the $testdata
	return $testdata; //returning result of the function
}

if($_SERVER["REQUEST_METHOD"] == "POST") // checking whether the form was submitted
{

	$firstnameError = $lastnameError = $emailError = $passwordError1 = $passwordError2 = $passwordError3 = $passwordError4 = $passwordError5 = ""; 
	//resetting 'error variables' in case they saved values from the previous form submission


	if(empty($_POST["firstname"]) == TRUE) //checking if the field is empty
		{
			$firstnameError = "First name is required"; //saving error if the field is empty
		}
	if(empty($_POST["lastname"]) == TRUE) //checking if the field is empty
		{
			$lastnameError = "Last name is required"; //saving error if the field is empty
		}
	if(empty($_POST["email"]) == TRUE || filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == FALSE)
		//checking if the field is empty or if the inputter email is a valid email address
		{
			$emailError = "Valid email is required";
		}
	else
		{
			//cleaning up data using validation1() function
			$firstname = validation1($_POST["firstname"]); 
			$lastname = validation1($_POST["lastname"]);
			$email = validation1($_POST["email"]);
		}
	//saving valid data from the submit form into the php variables 
	$studyNIScheck = $_POST["studyNIS"];
	$grade = $_POST["grade"];
	$preferrableLanguage1 = $_POST["preferrableLanguageEnglish"];
	$preferrableLanguage2 = $_POST["preferrableLanguageRussian"];
	$preferrableLanguage3 = $_POST["preferrableLanguageKazakh"];
	$motive = $_POST["motive"];
	$password = trim($_POST["password"]); //deleting spaces before and after the password

	$patternCapitalLetters = "/[A-Z]/"; //determining regEx patterns
	$patternSpecialCharacters = "/[!@#$%^&*]/";
	$patternNumbers = "/[0-9]/";

	if(mb_strlen($password) < 8) 
	// determining if the exact number of characters (according to the UTF-8) is less than 8
		{
			$passwordError1 = "Password must contain at least 8 characters";
			//saving error f the exact number of characters (according to the UTF-8) is less than 8
		}

	if(preg_match($patternCapitalLetters, $password) === 0)
		// checking if the inputted password contains at least 1 capital letter
		{
			$passwordError2 = "Password must contain at least 1 capital letter";
		}

	if(preg_match($patternSpecialCharacters, $password) === 0)
		//checking if the inputted password contains at least 1 special character
		{
			$passwordError3 = "Password must contain at least 1 special character";
		}

	if(preg_match($patternNumbers, $password) === 0)
		//checking if the inputted password contains at least 1 number
		{
			$passwordError4 = "Password must contain at least 1 digit";
		}
	if($_POST["password"] != $_POST["passwordRepeat"])
		//password verification
		{
			$passwordError5 = "Passwords do not match";
		}


	if($passwordError1 == "" && $passwordError2 == "" && $passwordError3 == "" && $passwordError4 == "" && $passwordError5 == "" && $emailError == "" && $firstnameError == "" && $lastnameError == "")
		//checking if there are no errors (if all submitted data is valid and ready to be inserted into the database)
		{
			$passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);
			//creates a password hash that is then stored in the database instead of the password itself to keep data secure
			$thirdquery = "INSERT INTO registeredusers (firstname, lastname, email, grade, preferrableLanguage, motivation, studyNIS, passwordhash)
			VALUES ('$firstname', '$lastname', '$email', '$grade', '$preferrableLanguage1 $preferrableLanguage2 $preferrableLanguage3', '$motive', '$studyNIScheck', '$passwordhash')"; 
			//inserting data from submit form into the table 'registeredusers'

			if ($connection->query($thirdquery) === TRUE) 
				{
					echo "<script> alert('New account has been registered successfully') </script>";
					//implementing JavaScript to display an alert box after successful account registration
					$firstname = $lastname = $email = $grade = $preferrableLanguage1 = $preferrableLanguage2 = $preferrableLanguage3 = $motive = $studyNIScheck = $passwordhash = "";
					//resetting all variables to avoid the error of inputting the same data twice
					echo "<script> window.location.replace('login_form.php') </script>";
					//implementing JavaScript to redirect the user to the login page

				} 
			else 
				{
					echo "Error: " . $thirdquery . "<br>" . $connection->error;
					//ouput error
				}
		}
	else
		//if submitted data is invalid
		{

			echo "<script> 
			document.getElementById('paragraphmistakeregistrationform').style.display = 'block'; 
			</script>";
			//implementing JavaScript to change the 'display' parameter of the 'style' attribute to 'block' so that the user can see the paragraph where errors will be outputted

			$errors = array(
				'Main fields' => array($firstnameError, $lastnameError, $emailError),
				'Password' => array($passwordError1, $passwordError2, $passwordError3, $passwordError4, $passwordError5)
			);	 
			//creating a two-dimensional associative array that is used to sort outputted errors by their type
			//named keys of these subarrays are used to name the list of errors

			foreach($errors as $key => $errorType)
			//this loop allows to iterate over $errors array and assign array's key to the $key variable
			//later $key variable (array's named key) is used to group errors by their type, so firstname, lastname and email errors are displayed first and then password errors
			{
				if(in_array("First name is required", $errorType) || in_array("Last name is required", $errorType) || in_array("Valid email is required", $errorType) || in_array("Password must contain at least 8 characters", $errorType) || in_array("Password must contain at least 1 capital letter", $errorType) || in_array("Password must contain at least 8 characters", $errorType) || in_array("Password must contain at least 1 capital letter", $errorType) || in_array("Password must contain at least 1 special character", $errorType) || in_array("Password must contain at least 1 digit", $errorType) || in_array("Пароли не совпадают", $errorType))
				//if there are any errors in the $errorType array (which is one of the subarrays of the $errors array)
				{
					echo "<script>
					document.getElementById('paragraphmistakeregistrationform').innerHTML +='" . $key . "'
					</script>";
					//implementing JavaScript to add to the paragraph with id 'paragraphmistakeregistrationform' name of the key of the associative array where an error was detected 
					echo "<script>
					document.getElementById('paragraphmistakeregistrationform').innerHTML +='<ul>'
					</script>";
					//implementing JavaScript to start the unordered item list in the paragraph 
					foreach($errorType as $error)
					//nested loops
					//iterating over $errorType array (one of the subarrays of the $errors array) to access its elements
						if($error != "")
						//if error exists
						{
							echo "<script>
								document.getElementById('paragraphmistakeregistrationform').innerHTML +='<li>" . $error . "</li>'
								</script>";
							//implementing JavaScript to add to the paragraph error as the list item 
						}
					echo "<script>
					document.getElementById('paragraphmistakeregistrationform').innerHTML +='</ul>'
					</script>";
					//implementing JavaScript to close the unordered item list in the paragraph
					if($key == 'Main fields')
						{
							echo "<script>
						document.getElementById('paragraphmistakeregistrationform').innerHTML +='<br>'
						</script>";
						}
					//this conditional operator is needed to add a line break between the 'Main fields' and 'Password' groups

				}
			}
		}

?> 

</body>
</html>





<!DOCTYPE html>
<html>
<head>
	<title>Conference registration page</title>
<?php require "config.php"?>
<!-- including configuration -->
</head>
<body>
<?php require "databaseconnection.php" ?>
<!-- establishing connection with the database -->
<?php require "blocks/header.php" ?>
<!-- including code of 'header.php' -->

<form id="confregForm" action="#" method="post">
	<!-- action='#' means that once the form is submitted, the data will be sent to the 
   current page (conference_registration.php); method='post' means that the data will be sent 
   using the "POST" method, which is more secure and has no limitations of data size compared
   to the "GET" method -->
        <div class="container" style="margin-top: 100px">
            <div class="row">
                <div class="col-md-12">
                    <h2>Форма регистрации конференции</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Тема конференции</label>
                    <input class="form-control forms1" type="text" name="conftopic" required>
                    <label class="form-label">Комитет</label>
                    <select class="form-select forms1" name="committee" required>
                        	<?php 
								$viborkacomitetov = "SELECT committee FROM committees2 WHERE is_registered != '1'";
								//The value "1" in the column "is_registered" corresponding to a particular committee in the column "committee" means that a conference with this committee already exists. According to the customer's specifications, the same committee cannot be used to create two or more conferences at any given time. The above condition leaves a selection of only those committees that are not participating in any conference at the time of query execution 
								$result = $connection->query($viborkacomitetov);
								//saving the results of the query in the $result variable

								if ($result->num_rows > 0)
								//if there is at least one comittee that is not participating in any conference at the time of query execution
								{
								  while($state = $result->fetch_assoc())
								  	//creating associative array with the results of the $viborkacomitetov query and going through each row of the result one by one using the 'while' loop
								  {
								    echo "<option value='" . $state["committee"] . "'>" . $state["committee"] . "</option>";
								    //there will be as many options as the number of 'while' loop iterations, that is, how many committees are there that satisfy the conditions of the $viborkacomitetov query
								    //$state["committee"] variable has the value of one committee available for selection
								    //when the form is submitted, the value stored in the "value" attribute is sent
									//for this reason, the $state["committee"] variable is used twice: once to display the value of the available committee to the user, and the second time to send the value of the selected option along with the form 
								  }
								}
							?>

                    </select>
                    <label class="form-label">Дата проведения</label>
                    <input class="form-control forms1" type="date" name="confdate" required></div>
                <div class="col-md-6">
                    <label class="form-label">Язык проведения конференции</label>
                    <select class="form-select forms1" name="conflanguage">
                            <option value="English" selected="">Английский</option>
                            <option value="Russian">Русский</option>
                            <option value="Kazakh">Казахский</option>
                    </select>
                    <label class="form-label">Допустимое количество участников</label>
                    <input class="form-control forms1" type="number" name="confSeatsnumber" required>
                    <label class="form-label">Требовать у участников position paper?</label>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-check forms1">
                            	<input class="form-check-input" type="radio" id="formCheck-1" name="positionpaperkerek" value="1" required>
                            	<!--
								When the user selects "yes", the integer value "1" is sent to the database. When the user selects "no", the integer value "0" is sent to the database. This is done to use memory effectively, since the "tinyint(1)" data type used takes up less memory than the "varchar(3)" data type (which would be used if the program were to send to the database "yes" and "no" values).
                            	-->
                            	<label class="form-check-label" for="formCheck-1">Да</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check forms1">
                            	<input class="form-check-input" type="radio" id="formCheck-2" name="positionpaperkerek" value="0" required>
                            	<label class="form-check-label" for="formCheck-2">Нет</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="dobavit">
                <div class="col-3">
                    <label class="col-form-label" data-bs-toggle="tooltip" data-bss-tooltip="" title="" data-bs-original-title="Будет отображатсья у всех участников">Хотите добавить примечание?</label>
                </div>
                <div class="col-1 d-lg-flex" style="margin-top: 10px">
                    <div class="form-check">
                    	<input class="form-check-input" type="radio" id="formCheck-3" name="primechaniekerek" onclick="showtextarea('primechanie')">
                    	<!-- When user clicks on this radio button, the JavaScript function "showtextarea()" is called (written at the end of the code). The value "primechanie" is used as a parameter to this function. This parameter is an ID of the HTML element that needs to be displayed. In this case, "primechanie" is the ID of the input form, using which teacher can add additional information.
                    	--> 
                    	<label class="form-check-label" for="formCheck-3">Да</label>
                    </div>
                </div>
                <div class="col-1 d-lg-flex" style="margin-top: 10px">
                    <div class="form-check">
                    	<input class="form-check-input" type="radio" id="formCheck-4" name="primechaniekerek" onclick="hidetextarea('primechanie')">
                    	<!-- When user clicks on this radio button, the JavaScript function "hidetextarea()" is called (written at the end of the code). The value "primechanie" is used as a parameter to this function. This parameter is an ID of the HTML element that needs to be hid. In this case, "primechanie" is the ID of the input form, using which teacher can add additional information.
                    	--> 
                    	<label class="form-check-label" for="formCheck-4">Нет</label>
                    </div>
                </div>
            </div>
            <input class="form-control" id="primechanie" style="display: none" name="remark">
            <button class="btn btn-warning" type="submit" style="margin-top: 10px">Зарегистрировать</button>
        </div>
    </form>

    <?php 

    //saving data from the submit form into the php variables 
    $conftopic = $_POST["conftopic"];
    $committee = $_POST["committee"];
    $date = $_POST["confdate"];
    $language = $_POST["conflanguage"];
    $maxseats = $_POST["confSeatsnumber"];
    $ispaperrequired =  $_POST["positionpaperkerek"]; 
    $remark = $_POST["remark"];

   $confinput = "INSERT INTO registeredconferences (conftopic, committee, confdate, language, participantsnumber, ppisrequired, primechanie) VALUES ('$conftopic', '$committee', '$date', '$language', '$maxseats', '$ispaperrequired', '$remark')";
   	//inserting data from submit form (data about registered conference) into the table 'registeredconferences'

     if ($connection->query($confinput) === TRUE) 
     //checking if the query was successfully executed
	    {
	      $confregupdate = "UPDATE committees2 SET is_registered='1' WHERE committee='$committee'";
	      //the variable $committee is the committee that the user used to register a new conference. To ensure that the same committee will not be selected when registering next conference, the value of the record (for the committee = $committee) in the "is_registered" field is changed to "1".
	      if($connection->query($confregupdate))
	        {
	            echo "<script> alert('New conference has been registered successfully') </script>";
	            //implementing JavaScript to display success message
	        }
	        else
	        {
	            echo "<script> alert('Error:" . $connection->error . "') </script>";
	            //implementing JavaScript to display failure message
	        }
	    }
   

    ?>

<script type="text/javascript">
		function showtextarea(textarea) {
            document.getElementById(textarea).style.display = 'block';
            //using JavaScript HTML DOM to get access to the element with the ID = parameter of the function
            //'style.display' is the HTML element's property that is responsible for whether the user can or cannot see the element
            //if the value of the 'style.display' property is set to 'block', thenthe  user can see the HTML element
        }
        function hidetextarea(textarea) {
            document.getElementById(textarea).style.display = 'none';
            //if the value of the 'style.display' property is set to 'none', then the user cannot see the HTML element
        }
</script>
</body>
</html>






<!DOCTYPE html>
<html>
<head>
	<title></title>

	<?php require "config.php"?>
	<!-- including configuration -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<!-- including Bootstrap 5 icons library -->


</head>
<body>

<?php require "databaseconnection.php" ?> 
<!-- establishing connection with the database -->
<?php require "blocks/header.php" ?>
<!-- including code of 'header.php' -->

<div style="margin-top: 100px; margin-left: 30px">
	<h1 id="activeconfheading">Активные конференции</h1>
	<ol class="text-start" id="listconfregpage" style="margin-bottom: 50px; margin-top: 30px	">

<?php 
$k = 0;
//declaring variable $k, which will be later used to set value for the 'name' attribute of the inputs that the user will use to choose the country for the conference

$confregquery = "SELECT id, conftopic, committee, confdate, language, participantsnumber, ppisrequired, primechanie FROM registeredconferences";
//creating SQL statement to access data from the 'registeredconferences' table

$result = $connection->query($confregquery);
//saving the results of the query in the $result variable

if($result-> num_rows > 0)
//if there is at least one registered conference at the time of query execution
{
	while($conf = $result -> fetch_assoc())
	//creating an associative array with the results of the $confregquery query and going through each row of the result one by one using the 'while' loop
	{
		echo 
		'
	    <li style="margin-bottom: 50px;">
	        <div id="confdiv">
	            <h4>Topic: ' . $conf["conftopic"] . '</h4>
	            <div class="row">
	                <div class="col">
	                    <div class="row">
	                        <div class="col">
	                            <p>Conference id: ' . $conf["id"] . '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Position paper: '; 
	                            if($conf["ppisrequired"] == "1")
	                            //if the teacher indicated that "position paper" is required when registering for the conference, the value for this column will be '1' in the database. Accordingly, in the "HTML" element itself, it is necessary to display this information in words. Because of this, this conditional operator was implemented. It allows using the memory more effectively by avoiding storing string values but still displaying the needed string ('required')
	                            	{
	                            		echo "required";
	                        		} 
	                        	else 
	                        		{
	                        			echo "not required";
	                        		}
	                            echo '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Committee: ' . $conf["committee"] . '</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-9 offset-lg-0">
	                    <div class="row">
	                        <div class="col-7">
	                            <p>Conference language: ' . $conf["language"] . '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Available seats: '; 
	                            $committeename = $conf["committee"];
	                            //saving committee name in the new variable for easier use in SQL statement
	                            $availableseatsquery = "SELECT * FROM committees WHERE userID != '0' AND name = '$committeename'";
	                            //selecting all records from the 'committees' table where userID is not equal to '1' (that is, all records where userID is set) for currently considered conference (name = '$committeename')
	                            $availableseatsqueryresult = $connection->query($availableseatsquery);
	                            //saving the results of the query in the $availableseatsqueryresult variable
	                            $availableseats2 = $availableseatsqueryresult-> num_rows;
	                            //saving the number of registrations to the conference into the $availableseats2 variable
	                            $availableseats = $conf["participantsnumber"] - $availableseats2; 
	                            //setting the value of $availableseats variable, which is equal to the total number of available seats which the teacher set at the time of conference registration ($conf["participantsnumber"]) minus the number of registrations at the time of the $availableseatsquery query execution
	                            //currently available seats number = total seat number - number of registrations
								echo $availableseats;
								//displaying the currently available seat number

	                            echo '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Date: ' . $conf["confdate"] . '</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-6">
	                    <p>Примечание: ' . $conf["primechanie"] . '</p>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col offset-lg-0 my-auto" id="colstyleconfregpage3">
	                    <form style="display: inline-block;" action="#" method="post">
	                    	<div style="display: inline-block;">
	                    		<div class="confregdiv" id="' . $conf["committee"] . '">
			                    	<select class="form-select" name="' . ++$k . '" style="
			                    		display: inline-block;
									  	width: 250px;
									  	vertical-align: bottom;
									  	margin-right: 10px;">';

			                    	$viborkastran = "SELECT countries FROM committees WHERE name = '$committeename' AND userID = '0'";
			                    	//selecting the names of all countries which has not been chosen by users for registration by the time of registration to the conference
									$result2 = $connection->query($viborkastran);
									//saving the results of the query in the $result2 variable

									if ($result2->num_rows > 0)
										//if there is at least one available country for registration to the conference
									{
									  while($country = $result2->fetch_assoc()) 
									  	//creating an associative array with the results of the $viborkastran query and going through each row of the result one by one using the 'while' loop
										  {
										    echo "<option value='" . $country["countries"] . "'>" . $country["countries"] . "</option>";
										    //there will be as many options as the number of 'while' loop iterations, that is, how many countries are there that satisfy the conditions of the $viborkastran query
								    		//$country["countries"] variable has the value of one country available for selection
								   			//when the form is submitted, the value stored in the "value" attribute is sent
											//for this reason, the $country["countries"] variable is used twice: once to display the value of the available country to the user and the second time to send the value of the selected option along with the form 
										  }
									}
			                                echo '
			                        </select>
		                        <button class="btn btn-dark order-first confregbutton" name="subject" type="submit" value=' . $conf["committee"] . '>Register</button>
		                   		</div>
	                    	</div>
	                    </form>'; 
	                    echo
	               '</div>
	            </div>
	        </div>
	    </li>
	'; 
	if($availableseats <= 0) 
		//if there are no more available seats at the conference
		{
			$tempid = $conf["committee"];
			$failureicon2 = '<i class="bi bi-exclamation-circle-fill iconconfregpage2 text-warning"></i>';
			//saving code for icon in the $failureicon2 variable
			echo "<script> document.getElementById('{$tempid}').innerHTML ='" . $failureicon2 . "'</script>";
			echo "<script> document.getElementById('{$tempid}').innerHTML += 'No available seats left!'; </script>";
			//Each <div> block containing <select> input form and submit form button has id, which JavaScript can use to access and modify its contents. In this code, the id of each such element was set to the committee's name, for which that particular <div> corresponds. For example, the <div> displaying information about a conference where a committee is 'WHO' will have id = 'WHO.' As was discussed earlier, in this case, committee name can be considered as a unique key because it is impossible to register new conference with the committee that is being used in the ongoing conference. So, using that id, JavaScript code modifies the contents of that <div> if a specific condition was satisfied. In this case, if there are no more available seats at the conference, the program will replace <select> input form by icon and text "No available seats left!". 
		}
	}
}

$o = $_SESSION["id"];
$p = $_POST["subject"]; 
//name='subject' is applied to the <button> HTML element. So, whenever the button is clicked, the committee name of the conference corresponding to that button will be saved to the $p variable, which is later used in the $newRegistration query. 

foreach ($_POST as $key => $value) 
//$_POST is a super global variable that collects data after form submission in the form of 'key value' pairs (as an associative array)
//this loop allows to iterate over $_POST array and get access to every submitted value using $value variable
//$key variable specifies which input form was used to submit data (in this case, chosen country)
//in the HTML code shown above, each <select> (input form) has unique name (++$k) in the form of integer which is set using pre-increment operator ++
//so, each <select> element after form submission sends to the $_POST superglobal variable name of the country that user chooses to register to the conference and named key using which that name of the country can be accessed and that equals to ++$k
{
 	for($j = 1; $j<=$k; $j++)
 	//because there is only $k <select> HTML elements, number of iterations must be less or equal to $k
 	//this loop goes through every <select> HTML element, checking whether the data was submitted using that particular element
	{
 		if($key == $j)
 		//if form was submitted (if user successfully registered to the conference and submitted name of the selected country using POST method), $_POST will contain element that has named key equal to $key
 		//for that particular $key => $value pair the following code will be executed: 
 		{
 			$selectedcountry = $value; //saving the selected country value
 			$newRegistration = "UPDATE committees SET userID = '$o', ConferenceID = (SELECT id FROM registeredconferences WHERE committee = '$p') WHERE name = '$p' AND countries = '$selectedcountry'";
 			//the committee name of the conference to which user is trying to register is saved to the $p variable when the corresponding button is clicked
 			//subquery (SELECT id FROM registeredconferences WHERE committee = '$p') was used to determine id of the conference to which user is trying to register
 			//the program determines that the user is registered for a particular conference by checking the value in the "userID" field. If the value in this field is not equal to zero, then one of the users is already registered for the corresponding conference and country
 			//the significance of this query is that when the user clicks on the button to register for a particular conference, the relevant data (the name of the committee and the country selected by the user, which are sent using attributes of <button> and <select> input forms respectively) is used to uniquely determine the record for which the value of the "userID" field should be changed to the ID of the account from which the user registers for the conference.
 			 if ($connection->query($newRegistration) === TRUE)
 			 //if the user has successfully registered to the conference
				{
					echo "<script> alert('You have successfully registered to the conference') </script>";
					//implementing JavaScript to display a message about successful registration to the conference
				} 
			else 
				{
					echo "Error: " . $newRegistration . "<br>" . $connection->error;
					//output error
				}
 		}
 	}
}

$newnewquery = "SELECT DISTINCT name FROM committees WHERE userID = '$o'";
//selecting committee names of the conferences to which user is registered
$result5 = $connection->query($newnewquery);
//executing the query and saving the results

if($result5-> num_rows > 0)
{
	while($result5array = $result5 -> fetch_assoc())
	{
		$h = $result5array['name'];
		//saving the committee name of the conference to which user is registered to the $h variable
		if(isset($_SESSION["id"]))
		//if user is logged in
		{
			$sucessicon = '<i class="bi bi-check2-circle iconconfregpage"></i>'; 
			echo "<script> document.getElementById('{$h}').innerHTML ='" . $sucessicon . "'</script>";
			echo "<script> document.getElementById('{$h}').innerHTML += 'Вы уже зарегистрированы!'; </script>";
		}
		else
		//if user is not logged in
		{
			$failureicon = '<i class="bi bi-exclamation-circle-fill iconconfregpage2 text-warning"></i>';
			echo "<script> document.getElementById('{$h}').innerHTML ='" . $failureicon . "'</script>";
			echo "<script> document.getElementById('{$h}').innerHTML += 'Создайте аккаунт чтобы зарегистрироваться на конференцию!'; </script>";
		}
	}
}



?>

</ol>
</div>


</body>
</html>







<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php require "config.php"?>
	<!-- including configuration -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<!-- including Bootstrap 5 icons library -->
</head>
<body>
	<?php require "databaseconnection.php"?> 
	<!-- establishing connection with the database -->
	<?php require "blocks/header.php" ?>
	<!-- including code of 'header.php' -->
	<div class="container d-flex align-items-center justify-content-center" style="margin-top: 80px">
		<div class="btn-group" role="group" aria-label="RadioForMyProfilePage">
		  <input type="radio" class="btn-check" name="ButtonRadio" id="ButtonRadio1" autocomplete="off" onchange="ischecked1()" checked>
		  <!-- 'checked' attribute allows to pre-select 'Personal info' radio button in the 'My Profile' page, displaying user's personal info immediately after he/she clicks the button that redirects to the 'My Profile' page -->
		  <label class="btn btn-outline-dark" for="ButtonRadio1">Personal info</label>

		  <input type="radio" class="btn-check" name="ButtonRadio" id="ButtonRadio2" autocomplete="off" onchange="ischecked1()">
		  <label class="btn btn-outline-dark" for="ButtonRadio2">My Conferences</label>

		  <input type="radio" class="btn-check" name="ButtonRadio" id="ButtonRadio3" autocomplete="off" onchange="ischecked1()">
		  <!-- The task of the "onchange" attribute in each of the above radio buttons is to call the JavaScript function "isChecked1()" when any of them (buttons) is clicked -->
		  <label class="btn btn-outline-dark" for="ButtonRadio3">Feedback</label>
		</div>
	</div>

<div id="myConferencesPage" style="display: none">
	<div style="margin-top: 10px">
		<div class="d-flex justify-content-center">
	  	<table class="table table-striped table-hover table-bordered" style="margin-top: 20px; text-align: center; width: 95%; border-collapse: collapse;">
	    <thead>
	    	<tr>
		        <th style="width: 9%">Committee</th>
		        <th style="width: 11%">Language</th>
		        <th style="width: 9%">Date</th>
		        <th style="width: 25%">Topic</th>
		        <th style="width: 8%">Country</th>
		        <th style="width: 32%">Position Paper</th>
		        <th>Delete</th>
	      </tr>
	    </thead>
		<tbody id="myProfilePageTable">
	<?php 
	$currentuserid = $_SESSION["id"];
	//saving user's ID in the $currentuserid variable

	$randomquery = "SELECT committees.ConferenceID, committees.name, committees.userID, registeredconferences.conftopic, registeredusers.firstname, registeredconferences.language, registeredconferences.confdate, committees.countries, registeredconferences.ppisrequired FROM committees JOIN registeredconferences ON committees.name = registeredconferences.committee JOIN registeredusers ON registeredusers.id = committees.userID WHERE committees.userID = '$currentuserid'";
	//joining tables committees, registeredusers and registeredconferences and retrieving required data that will be displayed in 'My Profile --> My Conferences' page.
	$result = $connection->query($randomquery);
	if($result-> num_rows > 0) 
	{
		$k = 0; 
		while($row = $result -> fetch_assoc()) 
		{ 
			echo "<tr>
					<td>" . $row["name"] . "</td>
					<td>" . $row["language"] . "</td>
					<td>" . $row["confdate"] . "</td>
					<td>" . $row["conftopic"] . "</td>
					<td>" . $row["countries"] . "</td>
					<td>"; 
					if($row["ppisrequired"] == 1) 
					//if position paper is required in this conference, then output file input form
						{
							echo "<form action='#' method='post' enctype='multipart/form-data'>
									<div class='input-group' id='fileinput" . $row['ConferenceID'] . $currentuserid . "'>
									<label for='myProfilePageInputFile" . ++$k . "' class='form-label'></label>
									  <input class='form-control' type='file' id='myProfilePageInputFile" . ++$k . "' name='fileUploader'>
									  <button class='btn btn-outline-dark' type='submit' name='uploadButton' value='" . $row['ConferenceID'] . "'> Загрузить </button>
									</div>
									</form>
									<div id='fileinputstatus" . $row['ConferenceID'] . $currentuserid . "' style='display: none;'> File has been successfully uploaded <br>
										<form action='#' method='post'>
											<button class='btn btn-outline-danger' style='height: 40px; margin-top: 10px' name='deleteButton' type='submit' value='" . $row['ConferenceID'] . "'> Удалить
											</button> 
										</form>
									</div>";
						}
					else
					//if position paper is not required in this conference, then output "Not required"
						{
							echo "Not required";
						} 
					echo "</td>
					<td> <form action='#' method='POST'>
							<label class='btn btn-default'>
								<i class='bi bi-x-square-fill iconmyprofilepage1 text-danger'>
									<button class='btn' type='submit' hidden></button></i>
									<input type='text' name='checkDeleteButtonClicked' value='" . $row["name"] . "' hidden>
							</label>
						</form>
					</td>
					</tr>";
		}
		echo "</tbody></table>";
	}

	if(isset($_POST["deleteButton"]))
	//if deleteButton was clicked
	{
		$ConferenceIDtoDelete = $_POST["deleteButton"];
		//saving the ID of the conference for which user wants to delete uploaded file 
		$deleteUploadedFileRecordQuery = "UPDATE committees SET fileID = '0' WHERE ConferenceID = '$ConferenceIDtoDelete' AND userID = $currentuserid";
		//deleting info about uploaded file in the committees table
		if($connection->query($deleteUploadedFileRecordQuery) == TRUE)
		{
			echo "<script> alert('sucess') </script>";
			//implementing JavaScript to output success message
		}
	}

	if(isset($_POST["uploadButton"]))
	//if user clicked "Upload" buttom
	{
		$fileName = $_FILES["fileUploader"]["name"];
		//saving the name of the file
		$fileDestinationShablon = uniqid() . "_" . str_replace(" ", "_", $fileName);
		//using uniqid() function to set unique identifier for each uploaded file
		//in this case, unique identifier is the new name of the file that will be stored on the server
		//also replacing all white spaces in the name of the file by underscore sign
		$fileDestination = "uploads/" . $fileDestinationShablon;
		//identifying address of the file
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		//saving data about file's extension using pathinfo() function
		$file = $_FILES["fileUploader"]["tmp_name"];
		//saving data about file's temporary name using which file was stored on the server
		$fileSize = $_FILES["fileUploader"]["size"];
		//saving file's size
		if(!in_array($fileExtension, ["docx", "pdf", "txt"]))
		//if extension of the file is not '.docx' or '.pdf' or '.txt'
		{
			echo "File must have one of these extensions: .docx .pdf .txt";
			//output error message
		}
		elseif ($fileSize > 2000000)
		//if file's size is more than 2000000 bits
		{
			echo "File must weigh less than 2 MB";
			//output error message
		}
		else
		//if uploaded file is valid
		{
			$uniquenameofthefile = $fileDestinationShablon;
			move_uploaded_file($file, $fileDestination);
			//moving uploaded file to the 'uploads' folder and renaming it to $uniquenameofthefile (which has the same value as $fileDestinationShablon)
			$fileinfo = "INSERT INTO files (nameofthefile, size, usercurrentID) VALUES ('$uniquenameofthefile', '$fileSize', '$currentuserid')";
			//sending data about newly uploaded file (its unique name, size and id of the user who uploaded it) to the 'files' table 
			if($connection->query($fileinfo) == TRUE)
			//if data was successfully sent to the database
				{
					$checkfileinfo = $_POST["uploadButton"];
					//saving ID of the conference for which file was uploaded
					$fileIDupdate = "UPDATE committees SET fileID = (SELECT id FROM files WHERE nameofthefile = '$uniquenameofthefile') WHERE userID = '$currentuserid' AND ConferenceID = '$checkfileinfo'";
					//using subquery (SELECT id FROM files WHERE nameofthefile = '$uniquenameofthefile') to get automatically generated integer ID of the file
					//setting the result of the subquery to the 'fileID' field for the record that contains both ID of the user who uploaded the file and ID of the conference for which file was uploaded
					if($connection->query($fileIDupdate) == FALSE)
					//if query was not successfully executed
					{
						echo "Error" . $connection->error;
						//output error message
					}
					else
					{
						echo '<script language="javascript"> alert("File has been succesfully uploaded") </script>';
						//implementing JavaScript to output success message
					}
				}
		}
	}
	
	$isFileSetQuery = "SELECT ConferenceID, userID FROM committees WHERE fileID != '0'";
	if($connection->query($isFileSetQuery) == TRUE)
	{
		$resultIsFileSetQuery = $connection->query($isFileSetQuery);
		if($resultIsFileSetQuery -> num_rows > 0)
		{
			while($resultIsFileSetQueryAssocArray = $resultIsFileSetQuery -> fetch_assoc())
			{
				$IsFileSetConferenceID = $resultIsFileSetQueryAssocArray['ConferenceID'];
				$IsFileSetUserID = $resultIsFileSetQueryAssocArray['userID'];
				echo 	'<script>
							document.getElementById("fileinput" + '. $IsFileSetConferenceID .' + '. $IsFileSetUserID . ').style.display = "none";
							document.getElementById("fileinputstatus" + '. $IsFileSetConferenceID .' + '. $IsFileSetUserID . ').style.display = "block";
						</script>';
				//implementing JavaScript to hide file input form after file was submitted and to show block containing 'Delete' button
			}
		}
	}
	else
	{
		echo "Error" . $connection->error;
		//output error
	}

	?>

	</div>
</div>


<?php 
		$deleteCommittee = $_POST["checkDeleteButtonClicked"];
		//saving name of the committee that corresponds to the conference for which the user wants to cancel the registration
		$currentuseridMyProfilepage = $_SESSION["id"];

		if(isset($_POST["checkDeleteButtonClicked"]))
		//if user clicked button with name'checkDeleteButtonClicked'
		{
			$deleteConferenceRegistration = "UPDATE committees SET userID = '0', fileID = '0' WHERE name = '$deleteCommittee' AND userID = '$currentuseridMyProfilepage'";
			$result2 = $connection->query($deleteConferenceRegistration);
			//cancelling user's registration to the conference by setting value of 'userID' and 'fileID' fields to '0'
			//program determnies which row of the committees table to update by specifying 'name' and 'userID' fields, which uniquely identify each registration to the conference
			header("Refresh:0");
			//using header() function to refresh the page, so updated data can be displayed
		} 
?>

</div>

<div id="divPersonalData" style="display: none;">
<div style="margin-top: 10px;">
	<div class="container">
	    <div class="row">
	    	<?php
	    	$currentidpersonaldata = $_SESSION["id"];
	    	$paraminput1a = "firstNamePersonalDataInput";
	    	$paraminput1b = "firstNamePersonalDataPage";
	    	$personaldataquery = "SELECT firstname, lastname, email, grade, preferrableLanguage, studyNIS FROM registeredusers WHERE id = '$currentidpersonaldata'";
	    	//retrieving user's personal details from the database using $_SESSION['id'] variable
	    	$result = $connection->query($personaldataquery); 
	    	//saving the result (one row, as there is only one id in the table that equals to the $_SESSION['id'])
	    	if ($result->num_rows > 0) //if the number of results is more than 0 (if results exist)
			{
				while($personalinfo = $result->fetch_assoc())
					//creating an associative array that contains elements, each of each represents 'registeredusers' table's one field 
				{
					echo '
					<div style="margin-bottom: 10px">
	            		<div style="display: inline-block;">
							<button class="btn" type="button" onclick="changepersonaldata1()"><i class="bi bi-pencil-square"></i></button>
						</div>
						<div style="display: inline-block;">
							<p> First name: </p>
						</div>
						<div style="display: inline-block;">
							<div id="firstNamePersonalDataPage">
								<p>' .  $personalinfo["firstname"] . '</p>
							</div>
						</div>
						<div style="display: inline-block;">
							<div id="firstNamePersonalDataInput" style="display: none; vertical-align: middle">
								<form action="#" method="POST">
									<div style="display: inline-block; margin-left: 5px; vertical-align: middle">
											<input class="form-control" type="text" name="firstNameMyProfilePage" required>
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Изменить </button>
									</div>
								</form>
							</div>
						</div>
	           		</div>

	           		<div style="margin-bottom: 10px">
	            		<div style="display: inline-block;">
							<button class="btn" type="button" onclick="changepersonaldata2()"><i class="bi bi-pencil-square"></i></button>
						</div>
						<div style="display: inline-block;">
							<p> Last name: </p>
						</div>
						<div style="display: inline-block;">
							<div id="lastNamePersonalDataPage">
								<p>' .  $personalinfo["lastname"] . '</p>
							</div>
						</div>
						<div style="display: inline-block;">
							<div id="lastNamePersonalDataInput" style="display: none; vertical-align: middle">
								<form action="#" method="POST">
									<div style="display: inline-block; margin-left: 5px; vertical-align: middle">
											<input class="form-control" type="text" name="lastNameMyProfilePage" required>
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Изменить </button>
									</div>
								</form>
							</div>
						</div>
	           		</div>

	           		<div style="margin-bottom: 10px">
	            		<div style="display: inline-block;">
							<button class="btn" type="button" onclick="changepersonaldata3()"><i class="bi bi-pencil-square"></i></button>
						</div>
						<div style="display: inline-block;">
							<p> Email: </p>
						</div>
						<div style="display: inline-block;">
							<div id="emailPersonalDataPage">
								<p>' .  $personalinfo["email"] . '</p>
							</div>
						</div>
						<div style="display: inline-block;">
							<div id="emailPersonalDataInput" style="display: none; vertical-align: middle">
								<form action="#" method="POST">
									<div style="display: inline-block; margin-left: 5px; vertical-align: middle">
											<input class="form-control" type="email" name="emailMyProfilePage" required>
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Изменить </button>
									</div>
								</form>
							</div>
						</div>
	           		</div>

	           		<div style="margin-bottom: 10px">
	            		<div style="display: inline-block;">
							<button class="btn" type="button" onclick="changepersonaldata4()"><i class="bi bi-pencil-square"></i></button>
						</div>
						<div style="display: inline-block;">
							<p> Grade: </p>
						</div>
						<div style="display: inline-block;">
							<div id="gradePersonalDataPage">
								<p>' .  $personalinfo["grade"] . '</p>
							</div>
						</div>
						<div style="display: inline-block;">
							<div id="gradePersonalDataInput" style="display: none; vertical-align: middle">
								<form action="#" method="POST">
									<div style="display: inline-block; margin-left: 5px; vertical-align: middle">
											<select class="form-select" name="gradeMyProfilePage" required>
												<option value="7">7</option>
							                    <option value="8">8</option>
							                    <option value="9">9</option>
							                    <option value="10">10</option>
							                    <option value="11">11</option>
							                    <option value="12">12</option>
							                </select>
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Изменить </button>
									</div>
								</form>
							</div>
						</div>
	           		</div>

	           		<div style="margin-bottom: 10px">
	            		<div style="display: inline-block;">
							<button class="btn" type="button" onclick="changepersonaldata5()"><i class="bi bi-pencil-square"></i></button>
						</div>
						<div style="display: inline-block;">
							<p> Preferred language: </p>
						</div>
						<div style="display: inline-block;">
							<div id="languagePersonalDataPage">
								<p>' .  $personalinfo["preferrableLanguage"] . '</p>
							</div>
						</div>
						<div style="display: inline-block;">
							<div id="languagePersonalDataInput" style="display: none; vertical-align: middle">
								<form action="#" method="POST" class="needs-validation">
									<div style="display: inline-block; margin-left: 5px; vertical-align: middle">
										<div class="checkboxgroup required">
											<div class="form-check form-check-inline">
							                    <input class="form-check-input" type="checkbox" name="englishLanguageMyProfilePage" value="English" onchange="languageCheck()">
							                    <label class="form-check-label" for="englishLanguageMyProfilePage">English</label>
							                </div>
							                <div class="form-check form-check-inline">
							                    <input class="form-check-input" type="checkbox" name="russianLanguageMyProfilePage" value="Russian" onchange="languageCheck()">
							                    <label class="form-check-label" for="russianLanguageMyProfilePage">Russian</label>
							                </div>
							                <div class="form-check form-check-inline">
							                    <input class="form-check-input" type="checkbox" name="kazakhLanguageMyProfilePage" value="Kazakh" onchange="languageCheck()">
							                    <label class="form-check-label" for="kazakhLanguageMyProfilePage">Kazakh</label>
							                </div>
							            </div>
						            </div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px" id="languagePersonalDataButton"> Изменить </button>
									</div>
									<div style="display: inline-block; margin-left: 10px">
										<div style="display: none;" class="text-danger" id="languagePersonalDataError">
											<i class="bi bi-exclamation-circle text-danger" style="vertical-align: middle"></i>
											<small style="vertical-align: middle">Выберите язык</small>
										</div>
									</div>
								</form>
							</div>
						</div>
	           		</div>';
				}
			}
	       	function checkforcorrectness($param1)
			{
				$param1 = trim($param1); 
				$param1 = stripslashes($param1); 
				return $param1;
			}
			
			$firstNamePersonalDataUpdate = checkforcorrectness($_POST["firstNameMyProfilePage"]);
			$lastNamePersonalDataUpdate = checkforcorrectness($_POST["lastNameMyProfilePage"]);
			$emailPersonalDataUpdate = checkforcorrectness($_POST["emailMyProfilePage"]);
			$gradePersonalDataUpdate = $_POST["gradeMyProfilePage"];
			$englishPersonalDataUpdate = $_POST["englishLanguageMyProfilePage"];
			$russianPersonalDataUpdate = $_POST["russianLanguageMyProfilePage"];
			$kazakhPersonalDataUpdate = $_POST["kazakhLanguageMyProfilePage"];
			//saving inputted data from the input fields in the corresponding variables

			if($_POST["firstNameMyProfilePage"] != "")
			//checking whether the input field was filled
			{
				$firstNameUpdateQuery = "UPDATE registeredusers SET firstname = '$firstNamePersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				//inserting inputted data into the table
				$connection->query($firstNameUpdateQuery);
				$firstNamePersonalDataUpdate = "";
				//resetting the variable so it is not mistakenly inputted when submitting next form
				header("Refresh:0");
				//using header() function to refresh the page, so updated data can be displayed
			}	

			if($_POST["lastNameMyProfilePage"] != "")
			//checking whether the input field was filled
			{
				$lastNameUpdateQuery = "UPDATE registeredusers SET lastname = '$lastNamePersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				//inserting inputted data into the table
				$connection->query($lastNameUpdateQuery);
				$lastNamePersonalDataUpdate = "";
				//resetting the variable so it is not mistakenly inputted when submitting next form
				header("Refresh:0");
				//using header() function to refresh the page, so updated data can be displayed
			}

			if($_POST["emailMyProfilePage"] != "")
			//checking whether the input field was filled
			{
				$emailUpdateQuery = "UPDATE registeredusers SET email = '$emailPersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				//inserting inputted data into the table
				$connection->query($emailUpdateQuery);
				$emailPersonalDataUpdate = "";
				//resetting the variable so it is not mistakenly inputted when submitting next form
				header("Refresh:0");
				//using header() function to refresh the page, so updated data can be displayed
			}

			if($_POST["gradeMyProfilePage"] != "")
			//checking whether the input field was filled
			{
				$gradeUpdateQuery = "UPDATE registeredusers SET grade = '$gradePersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				//inserting inputted data into the table
				$connection->query($gradeUpdateQuery);
				$gradePersonalDataUpdate = "";
				//resetting the variable so it is not mistakenly inputted when submitting next form
				header("Refresh:0");
				//using header() function to refresh the page, so updated data can be displayed
			}	

			if($_POST["englishLanguageMyProfilePage"] != "" || $_POST["russianLanguageMyProfilePage"] != "" || $_POST["kazakhLanguageMyProfilePage"] != "")
			//checking if at least one of the variants in the checkbox group was selected 
			{
				$languageUpdateQuery = "UPDATE registeredusers 
				SET preferrableLanguage = '$englishPersonalDataUpdate $russianPersonalDataUpdate $kazakhPersonalDataUpdate' 
				WHERE id='$currentuseridMyProfilepage'";
				//inserting inputted data into the table
				$connection->query($languageUpdateQuery);
				$englishPersonalDataUpdate = "";
				$russianPersonalDataUpdate = "";
				$kazakhPersonalDataUpdate = "";
				//resetting the variable so it is not mistakenly inputted when submitting next form
				header("Refresh:0");
				//using header() function to refresh the page, so updated data can be displayed
			}			

	        ?>

<script type="text/javascript">

	function changepersonaldata1() 
	//code for toggle button, which hides and displays and element when is clicked
	{
		if(document.getElementById("firstNamePersonalDataInput").style.display=="none")
			{
				document.getElementById("firstNamePersonalDataInput").style.display="block";
				document.getElementById("firstNamePersonalDataPage").style.display="none";
			}
		else
			{
				document.getElementById("firstNamePersonalDataInput").style.display="none";
				document.getElementById("firstNamePersonalDataPage").style.display="block";
			}
	}

	function changepersonaldata2() 
	//code for toggle button, which hides and displays and element when is clicked
	{
		if(document.getElementById("lastNamePersonalDataInput").style.display=="none")
			{
				document.getElementById("lastNamePersonalDataInput").style.display="block";
				document.getElementById("lastNamePersonalDataPage").style.display="none";
			}
		else
			{
				document.getElementById("lastNamePersonalDataInput").style.display="none";
				document.getElementById("lastNamePersonalDataPage").style.display="block";
			}
	}

	function changepersonaldata3() 
	//code for toggle button, which hides and displays and element when is clicked
	{
		if(document.getElementById("emailPersonalDataInput").style.display=="none")
			{
				document.getElementById("emailPersonalDataInput").style.display="block";
				document.getElementById("emailPersonalDataPage").style.display="none";
			}
		else
			{
				document.getElementById("emailPersonalDataInput").style.display="none";
				document.getElementById("emailPersonalDataPage").style.display="block";
			}
	}

	function changepersonaldata4()
	//code for toggle button, which hides and displays and element when is clicked 
	{
		if(document.getElementById("gradePersonalDataInput").style.display=="none")
			{
				document.getElementById("gradePersonalDataInput").style.display="block";
				document.getElementById("gradePersonalDataPage").style.display="none";
			}
		else
			{
				document.getElementById("gradePersonalDataInput").style.display="none";
				document.getElementById("gradePersonalDataPage").style.display="block";
			}
	}

	function changepersonaldata5()
	//code for toggle button, which hides and displays and element when is clicked
	{
		if(document.getElementById("languagePersonalDataInput").style.display=="none")
			{
				document.getElementById("languagePersonalDataInput").style.display="block";
				document.getElementById("languagePersonalDataPage").style.display="none";
			}
		else
			{
				document.getElementById("languagePersonalDataInput").style.display="none";
				document.getElementById("languagePersonalDataPage").style.display="block";
			}
	}

	if($('div.checkboxgroup.required :checkbox:checked').length == 0) 
	//JavaScript + jQuery code for disabling 'submit' button of the 'preffered language' input form when none of the variants (english, russian or kazakh) were chosen (before any of the checkboxes were selected)
			{
				document.getElementById("languagePersonalDataError").style.display="block";
				document.getElementById("languagePersonalDataButton").setAttribute("disabled", "");

			}

	function languageCheck()
	 {
		if($('div.checkboxgroup.required :checkbox:checked').length != 0)
			//JavaScript + jQuery code for enabling 'submit' button of the 'preffered language' input form when at least one of the variants (english, russian or kazakh) were chosen (before any of the checkboxes were selected) 
			{
				document.getElementById("languagePersonalDataError").style.display="none";
				//changing 'display' property of the 'style' attribute of the HTML element that shows error to 'none', making it invisible (so error message is no longer displayed)
				document.getElementById("languagePersonalDataButton").removeAttribute("disabled");
				//removing "disabled" attribute from the <input> HTML tag, making button clickable
			}
		if($('div.checkboxgroup.required :checkbox:checked').length == 0)
			{
				document.getElementById("languagePersonalDataError").style.display="block";
				//changing 'display' property of the 'style' attribute of the HTML element that shows error to 'block', making it visible (so error message is displayed)
				document.getElementById("languagePersonalDataButton").setAttribute("disabled", "");
				//setting "disabled" attribute to the <input> HTML tag, making button unclickable
			}
	}
</script>
</div>

<script>

	let t2 = document.getElementById("ButtonRadio1");
 	if(t2.checked == true)
 	{
 		document.getElementById("divPersonalData").style.display = 'block';
 	}
 	else
 	{
 		document.getElementById("divPersonalData").style.display = 'none';
 	}

function ischecked1() 
{
	let t1 = document.getElementById("ButtonRadio2");
 	if(t1.checked == true)
 	{
 		document.getElementById("myConferencesPage").style.display = 'block';
 	} 
 	else
 	{
 		document.getElementById("myConferencesPage").style.display = 'none';
 	}

 	let t2 = document.getElementById("ButtonRadio1");
 	if(t2.checked == true)
 	{
 		document.getElementById("divPersonalData").style.display = 'block';
 	}
 	else
 	{
 		document.getElementById("divPersonalData").style.display = 'none';
 	}

 	let t3 = document.getElementById("ButtonRadio3")
 	if(t3.checked == true)
 	{
 		document.getElementById("divFeedback").style.display = 'block';
 	}
 	else
 	{
 		document.getElementById("divFeedback").style.display = 'none';
 	}
}

</script>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<?php require "config.php"?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>

	<?php require "databaseconnection.php" // establishing connection with the database ?> 

	<?php require "blocks/header.php" // addding the code of the navigation menu bar ?>

	<div style="margin-top: 100px; margin-left: 30px; text-align: center; margin">
	<h1 style="padding-left: 30px; padding-bottom: 10px; margin-top: 10px;">Active conferences</h1>
	<ol class="text-start" style="margin-bottom: 50px; margin-top: 30px; margin-left: 20px;">

<?php
$confregquerycm = "SELECT id, conftopic, committee, confdate, language, participantsnumber, ppisrequired, primechanie FROM registeredconferences";
//retrieving data from the 'registeredconferences' table 
$resultcm = $connection->query($confregquerycm);
//executing the query
if($resultcm-> num_rows > 0)
//if the number of query results is not zero
{
	while($confcm = $resultcm -> fetch_assoc())
	//repeat until no records are left
	{
		echo 
		'
	    <li style="margin-bottom: 50px;">
	        <div style="padding-left:30px">
	            <h4>Topic: ' . $confcm["conftopic"] . '</h4>
	            <div class="row">
	                <div class="col">
	                    <div class="row">
	                        <div class="col">
	                            <p>Conference id: ' . $confcm["id"] . '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Position paper: '; if($confcm["ppisrequired"] == "1") {echo "required";} else {echo "not required";}
	                            echo '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Committee: ' . $confcm["committee"] . '</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-9 offset-lg-0">
	                    <div class="row">
	                        <div class="col-7">
	                            <p>Conference language: ' . $confcm["language"] . '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Available seats: '; echo ($confcm["participantsnumber"] - $confcm["participantsregistered"]); 
	                            echo '</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Date: ' . $confcm["confdate"] . '</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-6">
	                    <p>Note: ' . $confcm["primechanie"] . '</p>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col offset-lg-0 my-auto" style="display: inline-block; float: left;">
	                    <form style="display: inline-block;" action="#" method="post">
	                    	<div style="display: inline-block;">
	                    		<div class="confregdiv" id="confrencemanagementpagediv' . $confcm["id"] . '">
		                        <button class="btn btn-outline-danger order-first confregbutton" name="subjectcm" type="submit" value="' . $confcm["id"] . '">Cancel Conference</button>
		                   		</div>
	                    	</div>
	                    </form>'; 
	                    echo 
	               '</div>
	            </div>
	            <div style="margin-top: 20px"> 
		            <table class="table table-striped table-hover" style="width: 95%">
			            <thead class="table-dark">
			            	<tr>
			            		<th> Student ID </th>
			            		<th> Student name </th>
			            		<th> Country </th>
			            		<th> Position paper </th>
			            		<th style="text-align: center"> Feedback </th> 
			            	</tr>
			            </thead>';
		            $currentConfID = $confcm["id"];
		            $cmadmintablequery = "SELECT DISTINCT committees.userID, registeredusers.firstname, registeredusers.lastname, committees.countries, committees.fileID, registeredconferences.ppisrequired FROM committees JOIN registeredconferences ON committees.ConferenceID = registeredconferences.id JOIN registeredusers ON registeredusers.id = committees.userID WHERE committees.ConferenceID = '$currentConfID'";
		            //joining 'committees', 'registeredconferences' and 'registeredusers' tables using 'JOIN' SQL statement
					$resultcmadmintablequery = $connection->query($cmadmintablequery);
					//executing the query
					if($resultcmadmintablequery-> num_rows > 0)
					//if the number of query results is not zero 
					{
						$t=0;
						while($rowcmadmintablequery = $resultcmadmintablequery -> fetch_assoc())
						//repeat the number of times that is equal to the number of records in the table from which the data is being retrieved 
						{ 
							echo ' 
							<tr>
								<td>' . $rowcmadmintablequery["userID"] . '</td>
								<td>' . $rowcmadmintablequery["firstname"] . ' ' . $rowcmadmintablequery["lastname"] . '</td>
								<td>' . $rowcmadmintablequery["countries"]  . '</td>'; 
								if($rowcmadmintablequery["fileID"] != 0)
								//if the position paper was uploaded by the student
								{
								echo '<td><a href="conferencesmanagement.php?file_id_cm=' . $rowcmadmintablequery["fileID"] . '"> Download </a></td>';
								}
								else
								//if the position paper was not uploaded by the student
								{
								echo '<td> File has not been uploaded yet </td>';
								} 
								echo '<td style="text-align: center">';
								if($rowcmadmintablequery["ppisrequired"] == 1 && $rowcmadmintablequery["fileID"] != 0)
									//if position paper is required by the conference settings but the teacher has not uploaded the feedback yet 
									{
										echo "<form action='#' method='post' enctype='multipart/form-data'>
											<div class='input-group' id='feedbackfile" . $rowcmadmintablequery["fileID"] . "'>
											  <input class='form-control' type='file' name='feedbackUploader'>
											  <button class='btn btn-outline-dark' type='submit' name='feedbackButton' value='" . $rowcmadmintablequery["fileID"] . "'> Загрузить </button>
											</div>
											</form>
											<div id='feedbackUploadStatus" . $rowcmadmintablequery["fileID"] . "' style='display: none; text-align: center'> File has been successfully uploaded <br>
												<form action='#' method='post'>
													<button class='btn btn-outline-danger' style='height: 40px; margin-top: 10px' name='feedbackDeleteButton' type='submit' value='" . $rowcmadmintablequery["fileID"] . "'> Delete
													</button> 
												</form>
											</div>";
									}
								elseif($rowcmadmintablequery["ppisrequired"] == 1 && $rowcmadmintablequery["fileID"] == 0)
									//if position paper is required by the settings of the conference but the student has not uploaded the position paper yet
								{
									echo "File has not been uploaded by user yet";
								}
								else
								{
									echo "Not required";
								}
								echo '</td> </tr>';
						}
					}
		            echo '
		            </table>
	            </div>
	        </div>
	    </li>
	'; 
	}
}

if(isset($_POST["feedbackButton"]))
	//if user clicked "Upload" buttom
	{
		$fileName = $_FILES["feedbackUploader"]["name"];
		//saving the name of the file
		$fileDestinationShablon = uniqid() . "_" . str_replace(" ", "_", $fileName);
		//using uniqid() function to set unique identifier for each uploaded file
		//in this case, unique identifier is the new name of the file that will be stored on the server
		//also replacing all white spaces in the name of the file by underscore sign
		$fileDestination = "uploads/" . $fileDestinationShablon;
		//identifying address of the file
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		//saving data about file's extension using pathinfo() function
		$file = $_FILES["feedbackUploader"]["tmp_name"];
		//saving data about file's temporary name using which file was stored on the server
		$fileSize = $_FILES["feedbackUploader"]["size"];
		//saving file's size
		if(!in_array($fileExtension, ["docx", "pdf", "txt"]))
		//if extension of the file is not '.docx' or '.pdf' or '.txt'
		{
			echo "File must have one of these extensions: .docx .pdf .txt";
			//output error message
		}
		elseif ($fileSize > 2000000)
		//if file's size is more than 2000000 bits
		{
			echo "File must weigh less than 2 MB";
			//output error message
		}
		else
		//if uploaded file is valid
		{
			$originalfileid = $_POST['feedbackButton'];
			$uniquenameofthefile = $fileDestinationShablon;
			move_uploaded_file($file, $fileDestination);
			//moving uploaded file to the 'uploads' folder and renaming it to $uniquenameofthefile (which has the same value as $fileDestinationShablon)
			$savingfileinfo = "SELECT registeredconferences.confdate, registeredconferences.committee, committees.userID FROM committees JOIN registeredconferences ON committees.ConferenceID = registeredconferences.id WHERE committees.fileID = '$originalfileid'";
			//joining 'committees' and 'registeredconferences' tables and retrieving conference related data

			$resultsavingfileinfoquery = $connection->query($savingfileinfo); 
			//executing the query
			$assocarraysavingfileinfoquery = $resultsavingfileinfoquery->fetch_assoc();
			//declaring an associative array and assigning to it results of the query
			$confnamearchive = $assocarraysavingfileinfoquery['committee'];
			$confdatearchive = $assocarraysavingfileinfoquery['confdate'];
			$fbUserID = $assocarraysavingfileinfoquery['userID'];

			$fileinfo = "INSERT INTO feedbackfiles (feedbackfilename, feedbacksize, originalfileid, confname, fbconfdate, fbUserID) VALUES ('$uniquenameofthefile', '$fileSize', '$originalfileid', '$confnamearchive', '$confdatearchive', '$fbUserID')";
			//sending data about newly uploaded file (its unique name, size and id of the user who uploaded it) to the 'files' table 
			if($connection->query($fileinfo) == TRUE)
			//if data was successfully sent to the database
				{
					
					echo '<script language="javascript"> alert("File has been succesfully uploaded") </script>';
						//implementing JavaScript to output success message
					echo $originalfileid . "<br>";
					echo $fbUserID . "<br>";
					echo $assocarraysavingfileinfoquery['userID'];
				}
			else
			{
				echo $connection->error;
			}
		}
	}

$isFeedbackSetquery = "SELECT originalfileid FROM feedbackfiles WHERE originalfileid != '0'";
if($connection->query($isFeedbackSetquery) == TRUE)
{
	$resultIsFeedbackSetquery = $connection->query($isFeedbackSetquery);
	if($resultIsFeedbackSetquery -> num_rows > 0)
	{
		while($resultIsFeedbackSetqueryAssocArray = $resultIsFeedbackSetquery -> fetch_assoc())
		{
			$isFeedbackSetOriginalFileID = $resultIsFeedbackSetqueryAssocArray['originalfileid'];
			echo 	'<script>
						document.getElementById("feedbackfile" + '. $isFeedbackSetOriginalFileID . ').style.display = "none";
						document.getElementById("feedbackUploadStatus" + '. $isFeedbackSetOriginalFileID . ').style.display = "block";
					</script>';
		}
	}
}

if(isset($_POST["feedbackDeleteButton"]))
	//if 'delete' button was clicked
	{
		$originalfileidtodelete = $_POST["feedbackDeleteButton"];
		//saving the value stored in the 'delete' button (id of the file for which the feedback was written)
		$originalfileidtodeletequery = "DELETE FROM feedbackfiles WHERE originalfileid = '$originalfileidtodelete'";
		//query that deletes data about feedback from the table named 'feedbackfiles'
		if($connection->query($originalfileidtodeletequery) == TRUE)
		//if query was successfully executed
		{
			echo "<script> alert('You have successfully deleted uploaded file') </script>";
			header("Refresh:0");
			//displaying success message and refreshing the page, so updated data can be outputted
		}
		else
		{
			echo "something went very wrong:" . $connection->error;
			//display error if something went wrong
		}
	}

if(isset($_GET['file_id_cm']))
//if user clicked the 'download' link
{
	$fileidcm = $_GET['file_id_cm'];
	//saving the ID of the file which user tried to download by clicking the download link
	$filedownloadinfoquery = "SELECT * FROM files WHERE id='$fileidcm'";
	//query retrieving all data related to the file which user tries to download
	$resultfiledownloadinfoquery = $connection->query($filedownloadinfoquery);
	//executing the query
	$rowfileinfo = $resultfiledownloadinfoquery -> fetch_assoc();
	//creating an associative array which would store all data related to the file which user tries to download
	$filepathcm = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $rowfileinfo["nameofthefile"];
	//declaring variable which would store path of the file. 
	if(file_exists($filepathcm))
	//if the file actually exists and can be found using the path of the file that was declared a step earlier
	{
        $file_name = $rowfileinfo["nameofthefile"];
        //declaring file's name
		$file_url = $filepathcm;
		//declaring file's path again
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=" . $file_name); 
		//headers that are essential for the download process performed by browser 
		readfile($file_url);
		exit;
		//ending the connection so that data does not get stucked
	}
	else
	{
		echo "<br> errorr <br>";
		//display error if something goes wrong
	}


}

if(isset($_POST['subjectcm']))
//if user clicked the button named 'Cancel Conference'
{
	$idofconferencetobecancelled = $_POST['subjectcm'];
	//saving the id of the conference that user wants to cancel
	$conferencecancellation2 = "UPDATE committees2 SET is_registered = '0' WHERE committee = (SELECT committee FROM registeredconferences WHERE id = '$idofconferencetobecancelled')";
	//changing status of the committee that was involved in the conference that is going to be cancelled so that the committee becomes available for creating a new conference again
	$conferencecancellation1 = "UPDATE committees SET ConferenceID = '0', userID = '0', fileID = '0' WHERE ConferenceID = '$idofconferencetobecancelled'";
	//deleting data about students' registration to this conference, deleting connections between the student's registration to the conference and the position paper uploaded by the student
	$conferencecancellation3 = "DELETE FROM registeredconferences WHERE id = '$idofconferencetobecancelled'";
	//deleting record for the cancelled conference
	if($connection->query($conferencecancellation1) == TRUE && $connection->query($conferencecancellation2) == TRUE && $connection->query($conferencecancellation3) == TRUE)
	{
		echo "<script> alert('You have successfully canceled conference') </script>";
		header("Refresh:0");
		//displaying success message and refreshing the page so that updated data is shown
	}
	else
	{
		echo $connection->error;
		//if something goes wrong, then the error will be displayed in the console
	}

}
?>

</ol>
</div>

</body>
</html>

<meta charset="utf-8">
//setting the most popular type of character encoding
<meta name="viewport" content="width=device-width, initial-scale=1.0">
//establishing settings for the website's scaling 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
//connecting Bootstrap 5 - CSS styles
<link rel="stylesheet" type="text/css" href="css/style.css.css">
//connecting CSS stylesheet
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
//connecting jQuery library
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
//connecting Bootstrap 5 - JavaScript library




