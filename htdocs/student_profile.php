<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php require "config.php"?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
	<?php require "databaseconnection.php" // calling databaseconnection.php ?> 
	<?php require "blocks/header.php" ?>
	<div class="container d-flex align-items-center justify-content-center" style="margin-top: 80px">
		<div class="btn-group" role="group" aria-label="RadioForMyProfilePage">
		  <input type="radio" class="btn-check" name="ButtonRadio" id="ButtonRadio1" autocomplete="off" onchange="ischecked1()" checked>
		  <label class="btn btn-outline-dark" for="ButtonRadio1">Personal info</label>

		  <input type="radio" class="btn-check" name="ButtonRadio" id="ButtonRadio2" autocomplete="off" onchange="ischecked1()">
		  <label class="btn btn-outline-dark" for="ButtonRadio2">My conferences</label>

		  <input type="radio" class="btn-check" name="ButtonRadio" id="ButtonRadio3" autocomplete="off" onchange="ischecked1()">
		  <label class="btn btn-outline-dark" for="ButtonRadio3">Feedback</label>
		</div>
	</div>
<p id="veryrandomid"></p>

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

	$randomquery = "SELECT committees.ConferenceID, committees.name, committees.userID, registeredconferences.conftopic, registeredusers.firstname, registeredconferences.language, registeredconferences.confdate, committees.countries, registeredconferences.ppisrequired FROM committees JOIN registeredconferences ON committees.name = registeredconferences.committee JOIN registeredusers ON registeredusers.id = committees.userID WHERE committees.userID = '$currentuserid'";
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
											<button class='btn btn-outline-danger' style='height: 40px; margin-top: 10px' name='deleteButton' type='submit' value='" . $row['ConferenceID'] . "'> Delete
											</button> 
										</form>
									</div>";
						}
					else 
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
	{
		$ConferenceIDtoDelete = $_POST["deleteButton"]; 
		$deleteUploadedFileRecordQuery = "UPDATE committees SET fileID = '0' WHERE ConferenceID = '$ConferenceIDtoDelete' AND userID = $currentuserid";
		if($connection->query($deleteUploadedFileRecordQuery) == TRUE)
		{
			echo "<script> alert('File has been successfully deleted') </script>";
		}
	}

	if(isset($_POST["uploadButton"]))
	{
		$fileName = $_FILES["fileUploader"]["name"];
		$fileDestinationShablon = uniqid() . "_" . str_replace(" ", "_", $fileName);
		$fileDestination = "uploads/" . $fileDestinationShablon;
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		$file = $_FILES["fileUploader"]["tmp_name"];
		$fileSize = $_FILES["fileUploader"]["size"];
		if(!in_array($fileExtension, ["docx", "pdf", "txt"]))
		{
			echo "<script> alert('File must have one of the following extensions: .docx, .pdf, .txt') </script>";
		}
		elseif($fileSize > 2000000)
		{
			echo "<script> alert('File must be less than 2MB in size') </script>";
		}
		else
		{
			$uniquenameofthefile = $fileDestinationShablon;
			move_uploaded_file($file, $fileDestination);
			$fileinfo = "INSERT INTO files (nameofthefile, size, usercurrentID) VALUES ('$uniquenameofthefile', '$fileSize', '$currentuserid')";
			if($connection->query($fileinfo) == TRUE)
				{
					$checkfileinfo = $_POST["uploadButton"];
					$fileIDupdate = "UPDATE committees SET fileID = (SELECT id FROM files WHERE nameofthefile = '$uniquenameofthefile') WHERE userID = '$currentuserid' AND ConferenceID = '$checkfileinfo'";
					if($connection->query($fileIDupdate) == FALSE)
					{
						echo "Error" . $connection->error;
					}
					else
					{
						echo '<script language="javascript"> alert("File has been succesfully uploaded") </script>';
						//выберем конференс айди где кантрис = button value AND userID = currentuserid
						//у нас есть конференс айди (button value) и каррент юсер айди и мы можем уникально определить каждый инпут груп
						//нам нужно скрыть инпут груп 
						// echo '<script>
						// 		let JSConferenceID ="' . $checkfileinfo . '";
						// 		let JScurrentuserID ="' . $currentuserid . '";
						// 		console.log(JSConferenceID);
						// 		console.log(JScurrentuserID);
						// 		document.getElementById("fileinput" + JSConferenceID + JScurrentuserID).style.display = "none";
						// 		document.getElementById("fileinputstatus" + JSConferenceID + JScurrentuserID).style.display = "block";
						// 	</script>';
						// header("Refresh:0");
					}
				}
			else
			{	
				echo "ploho";
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
			}
		}
	}
	else
	{
		echo "Error" . $connection->error;
	}

	?>

	</div>
</div>


<?php 
		$deleteCommittee = $_POST["checkDeleteButtonClicked"];
		$currentuseridMyProfilepage = $_SESSION["id"];

		if(isset($_POST["checkDeleteButtonClicked"])) 
		{
			$deleteConferenceRegistration = "UPDATE committees SET userID = '0', fileID = '0' WHERE name = '$deleteCommittee' AND userID = '$currentuseridMyProfilepage'";
			$result2 = $connection->query($deleteConferenceRegistration);
			header("Refresh:0");
		} 
?>

</div>

<div id="feedbackPage" style="display: none">
  <div style="margin-top: 10px">
    <div class="d-flex justify-content-center">
      <table class="table table-striped table-hover table-bordered" style=" text-align: center; width: 70%; border-collapse: collapse;">
        <thead>
          <tr>
            <th style="width: 11%">Committee</th>
            <th>Date</th>
            <th>Your feedback</th>
          </tr>
        </thead>
        <tbody>
           <?php 
          $currentuserid2 = $_SESSION['id'];
          $retrievingFeedback = "SELECT confname, fbconfdate FROM feedbackfiles WHERE fbUserID = '$currentuserid2'";
          $resultOfRetrievingFeedback = mysqli_query($connection, $retrievingFeedback);
          $feedbackFilesFetch = mysqli_fetch_all($resultOfRetrievingFeedback, MYSQLI_ASSOC);
          echo $connection->error;
          foreach ($feedbackFilesFetch as $feedbackfile):
          ?>
          <tr>
            <td><?php echo $feedbackfile['confname']; ?></td>
            <td><?php echo $feedbackfile['fbconfdate']; ?></td>
            <td><a href="student_profile.php?feedbackfile_id=<?php echo $feedbackfile['feedbackfileid']; ?>"> Download </a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

	  <?php 

	  if(isset($_GET['feedbackfile_id']))
	  {
	    $feedbackfileid2 = $_GET['feedbackfile_id'];
	    $feedbackfiledownloadinfoquery = "SELECT * FROM feedbackfiles WHERE feedbackfileid ='$feedbackfileid2'";
	    $resultfeedbackfiledownloadinfoquery = $connection->query($feedbackfiledownloadinfoquery);
	    $rowfeedbackfileinfo = $resultfeedbackfiledownloadinfoquery -> fetch_assoc();
	    $feedbackfilepath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $rowfeedbackfileinfo["feedbackfilename"];
	    if(file_exists($feedbackfilepath)) 
	    {
	      $file_name = $rowfeedbackfileinfo["feedbackfilename"];
	      $file_url = $feedbackfilepath;
	      header('Content-Type: application/octet-stream');
	      header("Content-Transfer-Encoding: Binary"); 
	      header("Content-disposition: attachment; filename=" . $file_name); 
	      readfile($file_url);
	      exit;
	    }
	    else
	    {
	      echo "<script> File does not exist </script>";
	    }

	  }


	  ?>
</div>

<div id="divPersonalData" style="display: block;">
<div style="margin-top: 10px;">
	<div class="container">
	    <div class="row">
	    	<?php
	    	$currentidpersonaldata = $_SESSION["id"];
	    	$paraminput1a = "firstNamePersonalDataInput";
	    	$paraminput1b = "firstNamePersonalDataPage";
	    	$personaldataquery = "SELECT firstname, lastname, email, grade, preferrableLanguage, studyNIS FROM registeredusers WHERE id = '$currentidpersonaldata'";
	    	$result = $connection->query($personaldataquery); 
	    	if ($result->num_rows > 0) //if the number of results is more than 0 (if results exist)
			{
				while($personalinfo = $result->fetch_assoc())
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
											<input class="form-control" type="text" name="firstNameMyProfilePage" required maxlength="40">
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Change </button>
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
											<input class="form-control" type="text" name="lastNameMyProfilePage" required maxlength="40">
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Change </button>
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
											<input class="form-control" type="email" name="emailMyProfilePage" required maxlength="60">
									</div>
									<div style="display: inline-block; vertical-align: middle">
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Change </button>
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
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px"> Change </button>
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
											<button type="submit" class="btn btn-outline-dark" style="margin-left: 10px" id="languagePersonalDataButton"> Change </button>
									</div>
									<div style="display: inline-block; margin-left: 10px">
										<div style="display: none;" class="text-danger" id="languagePersonalDataError">
											<i class="bi bi-exclamation-circle text-danger" style="vertical-align: middle"></i>
											<small style="vertical-align: middle">Choose at least 1 option</small>
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

			if($_POST["firstNameMyProfilePage"] != "")
			{
				$firstNameUpdateQuery = "UPDATE registeredusers SET firstname = '$firstNamePersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				$connection->query($firstNameUpdateQuery);
				$firstNamePersonalDataUpdate = "";
				header("Refresh:0");
			}	

			if($_POST["lastNameMyProfilePage"] != "")
			{
				$lastNameUpdateQuery = "UPDATE registeredusers SET lastname = '$lastNamePersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				$connection->query($lastNameUpdateQuery);
				$lastNamePersonalDataUpdate = "";
				header("Refresh:0");
			}

			if($_POST["emailMyProfilePage"] != "")
			{
				$emailUpdateQuery = "UPDATE registeredusers SET email = '$emailPersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				$connection->query($emailUpdateQuery);
				$emailPersonalDataUpdate = "";
				header("Refresh:0");
			}

			if($_POST["gradeMyProfilePage"] != "")
			{
				$gradeUpdateQuery = "UPDATE registeredusers SET grade = '$gradePersonalDataUpdate' WHERE id='$currentuseridMyProfilepage'";
				$connection->query($gradeUpdateQuery);
				$gradePersonalDataUpdate = "";
				header("Refresh:0");
			}	

			if($_POST["englishLanguageMyProfilePage"] != "" || $_POST["russianLanguageMyProfilePage"] != "" || $_POST["kazakhLanguageMyProfilePage"] != "")
			{
				$languageUpdateQuery = "UPDATE registeredusers 
				SET preferrableLanguage = '$englishPersonalDataUpdate $russianPersonalDataUpdate $kazakhPersonalDataUpdate' 
				WHERE id='$currentuseridMyProfilepage'";
				$connection->query($languageUpdateQuery);
				$englishPersonalDataUpdate = "";
				$russianPersonalDataUpdate = "";
				$kazakhPersonalDataUpdate = "";
				header("Refresh:0");
			}			

	        ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">

	function changepersonaldata1() 
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
			{
				document.getElementById("languagePersonalDataError").style.display="block";
				document.getElementById("languagePersonalDataButton").setAttribute("disabled", "");

			}

	function languageCheck() {
		if($('div.checkboxgroup.required :checkbox:checked').length != 0) 
			{
				document.getElementById("languagePersonalDataError").style.display="none";
				document.getElementById("languagePersonalDataButton").removeAttribute("disabled");
			}
		if($('div.checkboxgroup.required :checkbox:checked').length == 0)
			{
				document.getElementById("languagePersonalDataError").style.display="block";
				document.getElementById("languagePersonalDataButton").setAttribute("disabled", "");
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

 	let t3 = document.getElementById("ButtonRadio3");
 	if(t3.checked == true)
 	{
 		document.getElementById("feedbackPage").style.display = 'block';
 	}
 	else
 	{
 		document.getElementById("feedbackPage").style.display = 'none';
 	}
}

</script>

<!-- <script>
	let JSConferenceID2 ="' . $IsFileSetConferenceID . '";
	let JScurrentuserID2 ="' . $IsFileSetUserID . '";
	document.getElementById("fileinput" + JSConferenceID2 + JScurrentuserID2).style.display = "none";
	document.getElementById("fileinputstatus" + JSConferenceID2 + JScurrentuserID2).style.display = "block";
</script> -->

</body>
</html>