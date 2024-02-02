
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css.css"> 
  <?php 

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "myDB";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    /* //Connection check

    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    echo "Connected successfully";
    
    //Create Database 

    $sql = "CREATE DATABASE myDB";
    if (mysqli_query($conn, $sql)) { echo "Database created successfully"; }
    else { echo "Error creating database: " . mysqli_error($conn); }
    mysqli_close($conn); 

    

    $sql = "CREATE TABLE Users (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(40) NOT NULL,
lastname VARCHAR(40) NOT NULL,
email VARCHAR(60) NOT NULL
)";

if (mysqli_query($conn, $sql)) { echo "Table MyGuests created successfully"; }
else { echo "Error creating table: " . mysqli_error($conn); } */

mysqli_close($conn);

  ?> 

	<title> MUN website </title>
</head>
<body>

<?php require "blocks/header.php" ?>

<div style="margin-top: 100px; text-align: center; margin-bottom: 30px">
<h1 style="margin-top: 30px">Welcome to the MUN community!</h1>
<p class="lead" style="width: 70%; display: inline-block;">Sign up to take part in the next MUN conference in NIS Ust-Kamenogorsk! Don't miss the opportunity to get acquainted with a lot of creative personalities and develop debating skills.</p>
</div>

    <div class="container-fluid" id="container1">
        <div class="row" id="row1">
            <div class="col-md-12">
                <h1>Наши ценности</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-globe" style="font-size: 32px;">
                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"></path>
                </svg>
                <h3 class="heading1">Глобальное гражданство</h3>
                <p class="lead d-inline-flex paragraph1">Это идея о том, что личность человека выходит за пределы географических или политических границ и что обязанности или права вытекают из принадлежности к более широкому классу: "человечество</p>
            </div>
            <div class="col-md-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-people" style="font-size: 32px;">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"></path>
                </svg>
                <h3 class="heading1">Коммуникативность</h3>
                <p class="lead d-inline-flex paragraph1">Коммуникативность - это умение верно передавать информацию, свои мысли. Способность формулировать высказывания таким образом, что весь вкладываемый смысл полностью понимается собеседником.</p>
            </div>
            <div class="col"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-book" style="font-size: 32px;">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"></path>
                </svg>
                <h3 class="heading1">Непрерывное образование</h3>
                <p class="lead d-inline-flex paragraph1">это процесс роста образовательного потенциала личности в течение всей жизни на основе использования системы государственных институтов и в соответствии с потребностями личности.</p>
            </div>
        </div>
    </div>
  <section class="bg-light py-5">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
                    <h2 class="fw-bolder">Get in touch</h2>
                    <p class="lead mb-0">We'd love to hear from you</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                        <form id="contactForm" class="" method="post" action="contactform.php">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="validationFullName" type="text" placeholder="Enter your name..." name="contactfullname" required>
                                <label for="validationFullName">Full name</label>
                                <div class="invalid-feedback">Full name is required.</div>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="validationEmail" type="email" placeholder="name@example.com" name="contactemail" required> 
                                <!-- валидация - required-->
                                <label for="validationEmail">Email address</label>
                                <div class="invalid-feedback">Email is not valid.</div>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="validationPhone" type="tel" placeholder="(+7) XXX-XXX-XX-XX" name="contacttel" required>
                                <label for="validationPhone">Phone number</label>
                                <div class="invalid-feedback">A phone number is required.</div>
                            </div>
                            <!-- Message input-->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" name="contactmessage" type="text" placeholder="Enter your message here..." style="height: 15rem" required></textarea>
                                <label for="message">Message</label>
                                <div class="invalid-feedback">A message is required.</div>
                            </div>
                            <div class="d-grid"><button class="btn btn-dark btn-lg" id="submitButton" type="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    

</body>
</html>