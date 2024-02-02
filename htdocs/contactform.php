<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php require "databaseconnection.php" ?>

<?php 

/* Создание таблицы contactformtable*/

/* $contacttable = "CREATE TABLE contactformtable (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
fullname VARCHAR(40) NOT NULL,
email VARCHAR(60),
phonenumber VARCHAR(100), 
message LONGTEXT
)";

//не использую numeric datatype чтобы избежать неправильного сохраения номера в базе данных (например, если номер начинается на 0) 

//использую require вместо include чтобы в случае отсутсвия файла databaseconnection.php программа сразу выдавала ошибку не продолжая выполнение скрипта

if ($connection->query($contacttable) === TRUE) {
  echo "Table contactformtable created successfully";
} else {
  echo "Error creating table: " . $connection->error;
} */

function validation1($testdata) 
	{
		$testdata = trim($testdata); //удаляем пробелы
		$testdata = stripslashes($testdata); //удаляем слэши
		return $testdata;
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$contactfullname = validation1($_POST["contactfullname"]);
	$contactemail = validation1($_POST["contactemail"]);
	$contacttel = validation1($_POST["contacttel"]);
	$contactmessage = validation1($_POST["contactmessage"]);

	/* $contactrecord = "INSERT INTO contactformtable (fullname, email, phonenumber, message)
	VALUES ('$contactfullname', '$contactemail', '$contacttel', '$contactmessage')"; */  

	$preparedfunction = $connection->prepare("INSERT INTO contactformtable (fullname, email, phonenumber, message) VALUES (?, ?, ?, ?)");
	$preparedfunction->bind_param("ssss", $contactfullname, $contactemail, $contacttel, $contactmessage); 
	$preparedfunction->execute();


	// "ssss" означает что вводимые переменные имеют data type string string string string 

	//bind_param function binds the parameters to the SQL query and tells the database what the parameters are

	/* 

Prepared statements reduce parsing time as the preparation on the query is done only once (although the statement is executed multiple times)

Bound parameters minimize bandwidth to the server as you need send only the parameters each time, and not the whole query

Prepared statements are very useful against SQL injections, because parameter values, which are transmitted later using a different protocol, need not be correctly escaped. If the original statement template is not derived from external input, SQL injection cannot occur.

	*/

}

?>



</body>
</html>