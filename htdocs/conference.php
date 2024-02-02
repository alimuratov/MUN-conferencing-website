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

<div style="margin-top: 100px; margin-left: 30px">
	<h1 id="activeconfheading">Active conferences</h1>
	<ol class="text-start" id="listconfregpage" style="margin-bottom: 50px; margin-top: 30px	">

<?php 
$k = 0;
$a = 'CERN';
$confregquery = "SELECT id, conftopic, committee, confdate, language, participantsnumber, ppisrequired, primechanie FROM registeredconferences";
$result = $connection->query($confregquery);
// $confregisterednumber->mysql_num_rows($result);
if($result-> num_rows > 0)
{
	while($conf = $result -> fetch_assoc())
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
	                            <p>Position paper: '; if($conf["ppisrequired"] == "1") {echo "required";} else {echo "not required";}
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
	                            $availableseatsquery = "SELECT * FROM committees WHERE userID != '0' AND name = '$committeename'";
	                            $availableseatsqueryresult = $connection->query($availableseatsquery);
	                            $availableseats2 = $availableseatsqueryresult-> num_rows;
	                            $availableseats = $conf["participantsnumber"] - $availableseats2; 
								echo $availableseats;
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
	                    <p>Note: ' . $conf["primechanie"] . '</p>
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

			                    	$c = $conf["committee"]; 

			                    	$viborkastran = "SELECT countries FROM committees WHERE name = '$c' AND userID = '0'";
									$result2 = $connection->query($viborkastran);

									if ($result2->num_rows > 0) {
									  while($country = $result2->fetch_assoc()) {
									    echo "<option value='" . $country["countries"] . "'>" . $country["countries"] . "</option>";
									  }
									}
			                                echo '
			                        </select>
		                        <button class="btn btn-dark order-first confregbutton" name="subject" type="submit" value=' . $conf["committee"] . '>Register</button>
		                   		</div>
	                    	</div>
	                    </form>'; 
	                    echo //<i class="bi bi-check2-circle iconconfregpage"></i>
	               '</div>
	            </div>
	        </div>
	    </li>
	'; 
	if($availableseats <= 0) 
		{
			$tempid = $conf["committee"];
			$failureicon2 = '<i class="bi bi-exclamation-circle-fill iconconfregpage2 text-warning"></i>';
			echo "<script> document.getElementById('{$tempid}').innerHTML ='" . $failureicon2 . "'</script>";
			echo "<script> document.getElementById('{$tempid}').innerHTML += 'Мест не осталось!'; </script>";
		}

	}
}


// for($j = 0; $j<=$k; $j++)
// {
// 	 $selectedcountry = $_POST["$j"];
// 	 var_dump($selectedcountry);
// 	$newRegistration = "INSERT INTO committees (userID) VALUES ('$_SESSION["username"]') WHERE name = '$c' AND countries = '$selectedcountry'";
// 	$result3 = $connection->query($newRegistration); 
// }
$o = $_SESSION["id"];
$p = $_POST["subject"];
$testqueryfortest = "SELECT id FROM registeredconferences WHERE committee = '$p'";
$result321312 = $connection->query($testqueryfortest);
$example = $result321312 -> fetch_assoc();


foreach ($_POST as $key => $value) 
{
 	for($j = 1; $j<=$k; $j++)
	{
 		if($key == $j)
 		{
 			$selectedcountry = $value; //какую страну выбрали
 			$newRegistration = "UPDATE committees SET userID = '$o', ConferenceID = (SELECT id FROM registeredconferences WHERE committee = '$p') WHERE name = '$p' AND countries = '$selectedcountry'";
 			
 			 if ($connection->query($newRegistration) === TRUE) 
				{
					echo "<script> alert('You have successfully registered to the conference') </script>";

				} 
			else 
				{
					echo "Error: " . $newRegistration . "<br>" . $connection->error;;
				}
 		}
 	}
}
$newquery = "SELECT COUNT(userID) FROM committees WHERE userID = '$o' and name='$p'";
$result4 = $connection->query($newquery);
// if($result4 -> num_rows != 0) 
// 	{
// 	}
$newnewquery = "SELECT DISTINCT name FROM committees WHERE userID = '$o'";
$result5 = $connection->query($newnewquery);

if($result5-> num_rows > 0)
{
	while($result5array = $result5 -> fetch_assoc())
	{
		$h = $result5array['name'];
		if(isset($_SESSION["id"]))
		{
			// echo "<script> document.getElementById('{$h}').style.display = 'none'; </script>";
			$sucessicon = '<i class="bi bi-check2-circle iconconfregpage"></i>'; 
			echo "<script> document.getElementById('{$h}').innerHTML ='" . $sucessicon . "'</script>";
			echo "<script> document.getElementById('{$h}').innerHTML += 'You have already registered to this conference!'; </script>";
		}
		else
		{
			$failureicon = '<i class="bi bi-exclamation-circle-fill iconconfregpage2 text-warning"></i>';
			echo "<script> document.getElementById('{$h}').innerHTML ='" . $failureicon . "'</script>";
			echo "<script> document.getElementById('{$h}').innerHTML += 'Sign-up to participate in the conference!'; </script>";
		}
	}
}



//var_dump($result5array = $result5 -> fetch_assoc());

// $newRegistration = "INSERT INTO committees (userID) VALUES ('$_SESSION["username"]') WHERE name = '$c' AND countries = '$selectedcountry'";
// $result3 = $connection->query($newRegistration); 
// var_dump($_POST["0"]);
// var_dump($_POST);
// var_dump($_POST["0"]);
// var_dump($_POST["1"]);

?>

</ol>
</div>

<!-- <div style="margin-top: 100px">
	<h1 id="activeconfheading">Зарегистрированные конференции</h1>
	<ol class="text-start" id="listconfregpage">
	    <li>
	        <div id="confdiv">
	            <h4>Date</h4>
	            <div class="row">
	                <div class="col">
	                    <div class="row">
	                        <div class="col">
	                            <p>Conference id:</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Position paper:</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Committee:</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-lg-9 offset-lg-0">
	                    <div class="row">
	                        <div class="col-7">
	                            <p>Conference language:</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Available seats:</p>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col">
	                            <p>Topic:</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-6">
	                    <p>Примечание:</p>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col offset-lg-0 my-auto" id="colstyleconfregpage3">
	                    <form>
	                    	<div style="display: inline-block;">
	                    	<button class="btn btn-warning" id="confregpagebutton2" type="button" style="display: inline-block;">Выбрать страну</button>
	                    	<div style="display: inline-block;">
	                    		<div id="confregdiv" class="hiddenelement">
		                    	<select class="form-select" id="confregselect">
		                                <option value="12" selected="">This is item 1</option>
		                                <option value="13">This is item 2</option>
		                                <option value="14">This is item 3</option>
		                        </select>
		                        <button class="btn btn-dark order-first" id="confregbutton" type="button">Зарегистрироваться</button>
		                   		</div>
	                    	</div>
	                    	</div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </li>
	</ol>
	<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
	<script id="bs-live-reload" data-sseport="24514" data-lastchange="1645277580161" src="/js/livereload.js"></script>
</div> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"> 

function newnewFunction() 
	{
		document.getElementById('{$h}').innerHTML += '<i class="bi bi-check2-circle iconconfregpage"></i>';
	}


</script>
</body>
</html>