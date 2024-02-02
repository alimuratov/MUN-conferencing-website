
<?php require "databaseconnection.php"; // calling databaseconnection.php ?> 

<?php

if(isset($_POST["uploadButton"]))
{
	$fileName = $_FILES["fileUploader"]["name"];
	$fileDestination = "uploads/" . $fileName;
	$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
	$file = $_FILES["fileUploader"]["tmp_name"];
	$fileSize = $_FILES["fileUploader"]["size"];
	if(!in_array($fileExtension, ["docx", "pdf", "txt"]))
	{
		echo "Допустыми расширения .docx .pdf .txt";
	}
	elseif ($fileSize > 4000000)
	{
		echo "Файл должен весить не больше 4 МБ";
	}
	else
	{
		move_uploaded_file($file, $fileDestination);
		$fileinfo = "INSERT INTO files (nameofthefile, size) VALUES ('$fileName', '$fileSize')";
		if($connection->query($fileinfo) == TRUE)
			{
				echo '<script language="javascript"> alert("message successfully sent") </script>';
			}
		else
		{
			echo "Error creating table: " . $connection->error;
		}
		echo "success";
	}
}

?>

