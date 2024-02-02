<?php 

$servername = "localhost";
$username = "root";
$password = "root";
$databasename = "mun";
//establishing connection
$connection = mysqli_connect($servername, $username, $password, $databasename);

//checking connection
/* if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully"; */

//creating database named "mun"
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
?>