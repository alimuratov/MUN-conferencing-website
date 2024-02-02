<!DOCTYPE html>
<html>
<head>
	<title></title>

<?php require "config.php"?>

</head>
<body>

<?php require "databaseconnection.php" ?>

<?php require "blocks/header.php" ?>

<?php require "sortandsearch.php" ?>

<?php 

$sixthquery = "SELECT id, firstname, lastname, email, grade, preferrableLanguage, motivation, studyNIS from registeredusers ORDER BY preferrableLanguage";
$result = $connection->query($sixthquery);

if($result-> num_rows > 0) {
	while($row = $result -> fetch_assoc()) //создание associative array
	{ 
		echo "<tr><td><a href=student_profile.php>" . $row["id"] . "</a></td><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["email"] . "</td><td>" . $row["preferrableLanguage"] . "</td><td>" . $row["grade"] . "</td><td>" . $row["studyNIS"] . "</td></tr>";
	}

	echo "</tbody></table>";
}

?>
</div>

<?php require "searchjs.php" ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>
</html>
