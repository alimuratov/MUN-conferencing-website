<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php require "config.php" ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>

<?php require "databaseconnection.php" // calling databaseconnection.php ?> 

<?php require "blocks/header.php" ?>

<div style="margin-top: 100px;">
  
  <?php 

$adminaccessquery = "SELECT * FROM adminids";
$resultadminaccessquery = $connection->query($adminaccessquery);
echo $connection->error;
$assocarrayforadminidquery = $resultadminaccessquery -> fetch_assoc();
var_dump(in_array('12', $assocarrayforadminidquery));
  ?>

</div>

</body>
</html>



                
