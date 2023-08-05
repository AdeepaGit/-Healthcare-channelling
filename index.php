<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>
<body>
    <!-- main container strart from here-->
    <div class="main_wrapper">
        <!-- header strart from here-->
        <div class="header_wrapper">
            <a href="index.php"><img id="logo" src="images/logo.png"/></a>
        <h1>Healthcare Hospital</h1>
        </div>
        <!-- header end  here-->
        <!-- navigation bar strart from here-->
	<div class="menubar"> 
		
		<ul id="menu">
			<li><a href="index.php">Home</a></li> 
			<li><a href="staff.php">Staff </a></li>
	    </ul>
	</div>	
    <!-- navigation bar end here-->

	<!-- content_wrapper starts-->

	<div class="content_wrapper">
        <div class="">
        
         
  <div class="p-5 text-center bg-body-tertiary rounded-3">
  <img src="images/doc-icon.png" class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100" >
    
    <h1 class="text-body-emphasis">Healthcare OPD Service</h1>
    <p class="col-lg-8 mx-auto fs-5 text-muted">
    Hurry up book your appointment and enjoy fast service .
    </p>
     <form action="backEnd.php" method="get">
             <label for="appointmentDate">Select Appointment Date:</label>
             <input type="date" id="appointmentDate" name="appointmentDate" required="">
             <div class="d-inline-flex gap-2 mb-5">
             <button class="d-inline-flex align-items-center btn btn-primary btn-md px-4 rounded-pill" name="checkTime" >Check Availability</button>
             </div>
     </form>

  </div>

        </div>
    </div>


    </div>
</body>
</html>
