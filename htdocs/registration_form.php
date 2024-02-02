<!DOCTYPE html>
<html>
<head>
  <title>Registration form</title>

<?php require "config.php"?>

</head>
<body>

<?php require "blocks/header.php" ?>


  <div class="container text-center" style="margin-top: 100px"> <h1> Registration form </h1> </div>
  <hr class="horline1">

<div class="d-flex justify-content-center">
  <div class="col-6">
    <div class="container px-40 my-5">
        <form id="registrationForm" action="#" method="post">
            <div class="mb-3">
                <label class="form-label" for="firstName">First name</label>
                <input class="form-control" name="firstname" type="text" placeholder="First name" maxlength="40">
            </div>
            <div class="mb-3">
                <label class="form-label" for="lastName">Last name</label>
                <input class="form-control" name="lastname" type="text" placeholder="Last name" maxlength="40">
            </div>
            <div class="mb-3">
                <label class="form-label" for="emailAddress">Email Address</label>
                <input class="form-control" name="email" type="email" placeholder="Email Address" maxlength="60">
            </div>
            <div class="mb-3">
                <label class="form-label" for="grade">Grade</label>
                <select class="form-select" name="grade" aria-label="Grade">
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Preferrable language of the elective course</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preferrableLanguageEnglish" value="English">
                    <label class="form-check-label" for="english">English</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preferrableLanguageRussian" value="Russian">
                    <label class="form-check-label" for="russian">Russian</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preferrableLanguageKazakh" value="Kazakh">
                    <label class="form-check-label" for="kazakh">Kazakh</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="motive">Why do you want to enter this elective course?</label>
                <textarea class="form-control" name="motive" type="text" placeholder="Why do you want to enter this elective course?" style="height: 10rem;"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Do you study at NIS?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="yes" type="radio" name="studyNIS" value="yes">
                    <label class="form-check-label" for="yes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="no" type="radio" name="studyNIS" value="no">
                    <label class="form-check-label" for="no">No</label>
                </div>
            </div>
            <!-- <div class="d-none" id="submitErrorMessage">
                <div class="text-center text-danger mb-3">Error sending message!</div>
            </div> -->
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" name="password" type="password" placeholder="Password">
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Repeat Password</label>
                <input class="form-control" name="passwordRepeat" type="password" placeholder="Repeat Password">
            </div>
            <div class="d-grid">
                <button class="btn btn-warning btn-lg" id="submitButton" type="submit">Submit</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div id="divmistakesregform">
        <p id="paragraphmistakeregistrationform" style="display: none"></p>
</div>

<?php require "registrationtest.php" ?>

</body>
</html>
  