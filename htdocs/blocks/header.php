<?php session_start(); ?>
<?php require "databaseconnection.php" ?>

<script>
  
  function sessionend()
  {
      session_start(); 
      session_destroy();
  }

</script>

<?php 

$adminaccessquery = "SELECT * FROM adminids";
$resultadminaccessquery = $connection->query($adminaccessquery);
$assocarrayforadminidquery = $resultadminaccessquery -> fetch_assoc();

if(isset($_SESSION["username"]) === TRUE && in_array($_SESSION["id"], $assocarrayforadminidquery) === FALSE) 
{
echo  '<header class="p-3 bg-dark text-white fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Homepage</a></li>
          <li><a href="conference.php" class="nav-link px-2 text-white">Conference</a></li>
          <li><a href="dates.php" class="nav-link px-2 text-white">Important dates</a></li>
          <li><a href="information.php" class="nav-link px-2 text-white">Information</a></li>
        </ul>

        <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <span> Hello '. $_SESSION["username"] . '! Your student ID is: ' . $_SESSION["id"] . '</span>
        </div>

        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2" onclick="location.href='."'sessionend.php'".'">Log out</button>
          <button type="button" class="btn btn-warning" onclick="location.href='."'student_profile.php'".'">My Profile</button>
        </div>
      </div>
    </div>
  </header>';
}

elseif(isset($_SESSION["username"]) === TRUE && in_array($_SESSION["id"], $assocarrayforadminidquery) === TRUE)
{
  echo  '<header class="p-3 bg-dark text-white fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Homepage</a></li>
          <li><a href="conference.php" class="nav-link px-2 text-white">Conference</a></li>
          <li><a href="dates.php" class="nav-link px-2 text-white">Important dates</a></li>
          <li><a href="information.php" class="nav-link px-2 text-white">Information</a></li>
        </ul>

        <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <span> Hello '. $_SESSION["username"] . '! Your teacher ID is: ' . $_SESSION["id"] . '</span>
        </div>

        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2" onclick="location.href='."'sessionend.php'".'">Log out</button>
          <button type="button" class="btn btn-warning" onclick="location.href='."'admintable.php'".'">Control panel</button>
        </div>
      </div>
    </div>
  </header>';
}

else

{

echo  '<header class="p-3 bg-dark text-white fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Homepage</a></li>
          <li><a href="conference.php" class="nav-link px-2 text-white">Conference</a></li>
          <li><a href="dates.php" class="nav-link px-2 text-white">Important dates</a></li>
          <li><a href="information.php" class="nav-link px-2 text-white">Information</a></li>
        </ul>

        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2" onclick="location.href='."'login_form.php'".'">Login</button>
          <button type="button" class="btn btn-warning" onclick="location.href='."'registration_form.php'".'">Sign-up</button>
        </div>
      </div>
    </div>
  </header>';

}

?>