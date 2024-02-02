<div class="d-flex justify-content-start" style="margin-top: 85px; margin-left: 35px">
  
  <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="admintablefnsort.php">First Name</a>
		  <a class="dropdown-item" href="admintablelnsort.php">Last name</a>
		  <a class="dropdown-item" href="admintablemailsort.php">Email</a>
		  <a class="dropdown-item" href="admintablepreflangsort.php">Preferrable Language</a>
		  <a class="dropdown-item" href="admintablegradesort.php">Grade</a>
		  <a class="dropdown-item" href="admintablestudynis.php">Studies at NIS</a>
		  <a class="dropdown-item" href="admintabledefaultsort.php">Default</a>
        </div>
  </div>
    <input class="form-control" id="searchinput" type="text" placeholder="Search.." style="width: 30%; margin-left: 10px; border-color: black">
    <button type="button" class="btn btn-dark" onclick="location.href='conference_registration.php'" style="margin-left: 10px">Create a new conference</button>
    <button type="button" class="btn btn-dark" onclick="location.href='conferencesmanagement.php'" style="margin-left: 10px">Active conferences</button>
  </div>

<div class="d-flex justify-content-center">
  <table class="table table-striped table-hover table-bordered" style="margin-top: 20px; text-align: center; width: 95%; border-collapse: collapse;">
    <thead>
      <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Preferrable Language</th>
        <th>Grade</th>
        <th>Studies at NIS</th>
      </tr>
    </thead>
<tbody id="searchtable">