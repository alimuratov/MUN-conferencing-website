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

	<div style="margin-top: 100px; margin-left: 30px; text-align: center; margin">
	<h1 style="padding-left: 30px; padding-bottom: 10px; margin-top: 10px;">Active conferences</h1>
	<ol class="text-start" style="margin-bottom: 50px; margin-top: 30px; margin-left: 20px;">

<?php
$confregquerycm = "SELECT id, conftopic, committee, confdate, language, participantsnumber, ppisrequired, primechanie FROM registeredconferences";
$resultcm = $connection->query($confregquerycm);
// $confregisterednumber->mysql_num_rows($result);
if($resultcm-> num_rows > 0)
{
	while($confcm = $resultcm -> fetch_assoc())
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
	                    echo //<i class="bi bi-check2-circle iconconfregpage"></i>
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
					$resultcmadmintablequery = $connection->query($cmadmintablequery);
					$rowcmadmintablequery["fileID"];
					if($resultcmadmintablequery-> num_rows > 0) 
					{
						$t=0;
						while($rowcmadmintablequery = $resultcmadmintablequery -> fetch_assoc()) 
						{ 
							echo ' 
							<tr>
								<td>' . $rowcmadmintablequery["userID"] . '</td>
								<td>' . $rowcmadmintablequery["firstname"] . ' ' . $rowcmadmintablequery["lastname"] . '</td>
								<td>' . $rowcmadmintablequery["countries"]  . '</td>'; 
								if($rowcmadmintablequery["fileID"] != 0)
								{
								echo '<td><a href="conferencesmanagement.php?file_id_cm=' . $rowcmadmintablequery["fileID"] . '"> Download </a></td>';
								}
								else
								{
								echo '<td> File has not been uploaded yet </td>';
								} 
								echo '<td style="text-align: center">';
								if($rowcmadmintablequery["ppisrequired"] == 1 && $rowcmadmintablequery["fileID"] != 0)
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

			$resultsavingfileinfoquery = $connection->query($savingfileinfo); 
			$assocarraysavingfileinfoquery = $resultsavingfileinfoquery->fetch_assoc();
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
	{
		$originalfileidtodelete = $_POST["feedbackDeleteButton"]; 
		$originalfileidtodeletequery = "DELETE FROM feedbackfiles WHERE originalfileid = '$originalfileidtodelete'";
		if($connection->query($originalfileidtodeletequery) == TRUE)
		{
			echo "<script> alert('You have successfully deleted uploaded file') </script>";
			header("Refresh:0");
		}
		else
		{
			echo "something went very wrong:" . $connection->error;
		}
	}

if(isset($_GET['file_id_cm']))
{
	$fileidcm = $_GET['file_id_cm'];
	$filedownloadinfoquery = "SELECT * FROM files WHERE id='$fileidcm'";
	$resultfiledownloadinfoquery = $connection->query($filedownloadinfoquery);
	$rowfileinfo = $resultfiledownloadinfoquery -> fetch_assoc();
	$filepathcm = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $rowfileinfo["nameofthefile"];
	if(file_exists($filepathcm)) 
	{
 		// header('Content-Description: File Transfer');
   //      header('Content-Type: application/octet-stream');
   //      header('Content-Disposition: attachment; filename=' . basename($filepathcm));
   //      header('Expires: 0');
   //      header('Cache-Control: must-revalidate');
   //      header('Pragma: public');
   //      header('Content-Length: ' . $rowfileinfo['size']);
   //      readfile($filepathcm);
   //      ob_end_clean();
        $file_name = $rowfileinfo["nameofthefile"];
		$file_url = $filepathcm;
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=" . $file_name); 
		readfile($file_url);
		exit;
	}
	else
	{
		echo "<br> errorr <br>";
	}
	// $smth = $_SERVER['DOCUMENT_ROOT'] . "/uploads/rabota.docx";
	// echo $smth;
	// if(file_exists($smth))
	// {
	// 	echo "exists";
	// }
	// else
	// {
	// 	echo "not exists";
	// }

}

if(isset($_POST['subjectcm']))
{
	$idofconferencetobecancelled = $_POST['subjectcm'];
	$conferencecancellation2 = "UPDATE committees2 SET is_registered = '0' WHERE committee = (SELECT committee FROM registeredconferences WHERE id = '$idofconferencetobecancelled')";
	$conferencecancellation1 = "UPDATE committees SET ConferenceID = '0', userID = '0', fileID = '0' WHERE ConferenceID = '$idofconferencetobecancelled'";
	$conferencecancellation3 = "DELETE FROM registeredconferences WHERE id = '$idofconferencetobecancelled'";
	if($connection->query($conferencecancellation1) == TRUE && $connection->query($conferencecancellation2) == TRUE && $connection->query($conferencecancellation3) == TRUE)
	{
		echo "<script> alert('You have successfully canceled conference') </script>";
		header("Refresh:0");
	}
	else
	{
		echo $connection->error;
	}

}
?>

</ol>
</div>

</body>
</html>