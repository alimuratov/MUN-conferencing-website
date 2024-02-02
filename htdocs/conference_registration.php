<!DOCTYPE html>
<html>
<head>
	<title></title>

<?php require "config.php"?>


</head>
<body>

<link rel="stylesheet" type="text/css" href="css/style.css.css"> 

<?php require "databaseconnection.php" ?>

<?php require "blocks/header.php" ?>

<!-- <?php

/* $eighthquery = "CREATE TABLE committees (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
countries SET('Argentina', 'Australia', 'Afghanistan', 'Austria', 'Belarus', 'Belgium', 'Brazil', 'Canada', 'Chile', 'China', 'Colombia', 'Denmark', 'Egypt', 'France', 'Greece', 'Honduras', 'India', 'Iraq', ' Kazakhstan', 'Luxembourg', 'Mexico', 'Netherlands', 'New Zealand', 'Norway', 'Philippines', 'Poland', 'Russian Federation', 'Saudi Arabia', 'South Africe', 'Syrian Atab Republic', 'Turkey', 'Ukraine', 'United Kingdom', 'USA', 'Uzbekistan', 'Viet Nam', 'Yemen', 'Zambia', 'Zimbabwe')
)";

if ($connection->query($eighthquery) === TRUE) {
  echo "Table regsiteredUsers created successfully";
} else {
  echo "Error creating table: " . $connection->error;
} 

$ninthquery = "INSERT INTO committees (name, countries) VALUES ('CERN', 'Belarus')";

if ($connection->query($ninthquery) === TRUE) 
		{
			echo "New record created successfully";
		} 
	else 
		{
			echo "Error: " . $thirdquery . "<br>" . $connection->error;
		} */
?> -->

<!-- <?php 

/* $tenthquery = "CREATE TABLE committees2 (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
committee VARCHAR(100) NOT NULL,
is_registered BIT(1)
)"; */


?> -->




<form id="confregForm" action="#" method="post">
        <div class="container" style="margin-top: 100px">
            <div class="row">
                <div class="col-md-12">
                    <h2>Conference registration form</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Topic</label>
                    <input class="form-control forms1" type="text" name="conftopic" required>
                    <label class="form-label">Committee</label>
                    <select class="form-select forms1" name="committee" required>
                        	<?php 
								$viborkacomitetov = "SELECT committee FROM committees2 WHERE is_registered != '1'";
								$result = $connection->query($viborkacomitetov);

								if ($result->num_rows > 0) {
								  while($state = $result->fetch_assoc()) {
								    echo "<option value='" . $state["committee"] . "'>" . $state["committee"] . "</option>";
								  }
								}
							?>

                    </select>
                    <label class="form-label">Date</label>
                    <input class="form-control forms1" type="date" name="confdate" required></div>
                <div class="col-md-6">
                    <label class="form-label">Language</label>
                    <select class="form-select forms1" name="conflanguage">
                            <option value="English" selected="">English</option>
                            <option value="Russian">Russian</option>
                            <option value="Kazakh">Kazakh</option>
                    </select>
                    <label class="form-label">Available seat number</label>
                    <input class="form-control forms1" type="number" name="confSeatsnumber" required>
                    <label class="form-label">Is position paper required?</label>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-check forms1">
                            	<input class="form-check-input" type="radio" id="formCheck-1" name="positionpaperkerek" value="1" required>
                            	<label class="form-check-label" for="formCheck-1">Yes</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check forms1">
                            	<input class="form-check-input" type="radio" id="formCheck-2" name="positionpaperkerek" value="0" required>
                            	<label class="form-check-label" for="formCheck-2">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="dobavit">
                <div class="col-3">
                    <label class="col-form-label" data-bs-toggle="tooltip" data-bss-tooltip="" title="" data-bs-original-title="Будет отображатсья у всех участников">Do you want to add additional information that can be seen by all participants?</label>
                </div>
                <div class="col-1 d-lg-flex" style="margin-top: 10px">
                    <div class="form-check">
                    	<input class="form-check-input" type="radio" id="formCheck-3" name="primechaniekerek" onclick="showtextarea('primechanie')">
                    	<label class="form-check-label" for="formCheck-3">Yes</label>
                    </div>
                </div>
                <div class="col-1 d-lg-flex" style="margin-top: 10px">
                    <div class="form-check">
                    	<input class="form-check-input" type="radio" id="formCheck-4" name="primechaniekerek" onclick="hidetextarea('primechanie')">
                    	<label class="form-check-label" for="formCheck-4">No</label>
                    </div>
                </div>
            </div>
            <input class="form-control" id="primechanie" style="display: none" name="remark">
            <button class="btn btn-warning" type="submit" style="margin-top: 10px">Register new conference</button>
        </div>
    </form>

    <?php 

    $conftopic = $_POST["conftopic"];
    $committee = $_POST["committee"];
    $date = $_POST["confdate"];
    $language = $_POST["conflanguage"];
    $maxseats = $_POST["confSeatsnumber"];
    $ispaperrequired =  $_POST["positionpaperkerek"]; 
    $remark = $_POST["remark"];

   $confinput = "INSERT INTO registeredconferences (conftopic, committee, confdate, language, participantsnumber, ppisrequired, primechanie) VALUES ('$conftopic', '$committee', '$date', '$language', '$maxseats', '$ispaperrequired', '$remark')";
     if ($connection->query($confinput) === TRUE) {
      $confregupdate = "UPDATE committees2 SET is_registered='1' WHERE committee='$committee'";
      if($connection->query($confregupdate))
        {
            echo "<script> alert('New conference has been registered successfully') </script>";
        }
        else
        {
            echo "<script> alert('Error:" . $connection->error . "') </script>";
        }
    }
    
   /* $sql = "INSERT INTO registeredconferences (conftopic) VALUES ('privet')";
    if ($connection->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();*/

    ?>

<script type="text/javascript">
		function showtextarea(textarea) {
            document.getElementById(textarea).style.display = 'block';
        }
        function hidetextarea(textarea) {
            document.getElementById(textarea).style.display = 'none';
        }
</script>
</body>
</html>