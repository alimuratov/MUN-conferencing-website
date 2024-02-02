<!DOCTYPE html>
<html>
<head>
  <title>Login form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> 
<body>
<?php require "blocks/header.php" ?>
<div class="col-md-10 mx-auto col-lg-5" style="margin-top: 150px">
  <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="#">
    <div class="form-floating mb-3">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="emaillogin">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="passwordlogin">
      <label for="floatingPassword">Password</label>
    </div>
    <div class="checkbox mb-3"> 
    </div>
    <button class="w-100 btn btn-lg btn-dark" type="submit">Log in</button>
    <hr class="my-4">
    <small class="text-muted">Don't have an account? <a href="registration_form.php">Click here</a></small>
  </form>
</div>

<?php require "databaseconnection.php" ?>

<?php 

if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $emaillogin = $_POST["emaillogin"]; 
    //sets the value of the "emaillogin" input form to $emaillogin variable
    $passwordlogin = $_POST["passwordlogin"]; 
    //sets the value of the "passwordlogin" input form to $passwordlogin variable


    $fifthquery = "SELECT id, firstname, email, passwordhash FROM registeredusers WHERE email = '$emaillogin'";
    //extracts records from the table registeredusers which fulfill a condition that email value equals to $emaillogin
    $result = $connection->query($fifthquery);
    //saves the results of the query to the variable $result
    if ($result->num_rows > 0) //if the number of results is more than 0 (if results exist)
      {
        $record = $result->fetch_assoc(); //fetches a result records as an associative array and saves that value to $record
        if(password_verify($passwordlogin, $record["passwordhash"]) === TRUE)
        //if the given passwordhash matches the $passwordlogin 
          {
            session_start(); //starts a new session
            $_SESSION["username"] = $record["firstname"]; 
            $_SESSION["id"] = $record["id"];
            //sets the value of the $record["firstname"] to $_SESSION["username"]
            header('location:index.php');
            //redirects user to the "index.php" page (main page of the website)
          }
        else
          {
            echo "<script> alert('Email or password is incorrect') </script>";
          }
        }           
    else 
      {
          echo "<script> alert('Email or password is incorrect') </script>";
          // header('location:login.php');
      } 
  }

?>



</body>
</html>
