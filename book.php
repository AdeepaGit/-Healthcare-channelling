<?php 
require_once "config.php";
      
$appointmentDate = $_GET['Request']; 
?>
         
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
    <!-- main container strart from here-->
    <div class="main_wrapper">
        <!-- header strart from here-->
        <div class="header_wrapper">
            <a href="index.php"><img id="logo" src="images/logo.png"/></a>
            <a href="index.php"> 
                <h1 style="width:800px; margin-top: 50px;float: right;">Healthcare Hospital</h1>
            </a>
        </div>
        <!-- header end  here-->
        <!-- navigation bar strart from here-->
	<div class="menubar"> 
		
		<ul id="menu">
			<li><a href="index.php">Home</a></li> 
			<li><a onclick="Pemission()">Staff </a></li>
	  </ul>
	</div>	
    <!-- navigation bar end here-->

	<!-- content_wrapper starts-->

	<div class="content_wrapper">
        <div class="">
      
    <div class="p-5 text-center bg-body-tertiary rounded-3">
  
     <form action="backEnd.php" method="post">
      <h3 class="mb-3">Appointment</h3>
      <hr class="my-4">
      <div class="row g-3">
        <div class="col-8" >
            <div class="col-6 mx-auto d-block">
              <label for="name" class="form-label">Patient Name</label>
              <input type="text" class="form-control" id="patientName" name="patientName" placeholder="Name Requierd" value="" required="">
              <div class="invalid-feedback">
                Valid patient name is required.
              </div>
            </div>
              <br>
            <div class="col-6 mx-auto d-block">
              <label for="email" class="form-label">Email</label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" id="patientEmail" name="patientEmail" placeholder="you@example.com" required="">
              <div class="invalid-feedback">
                  Your email is required.
                </div>
              </div>
            </div>
              <br>
            <div class="col-6 mx-auto d-block">
              <label for="lastName" class="form-label">Appointment Date</label>
              <input type="date" class="form-control" value="<?php echo $appointmentDate; ?>" required="" disabled>
              <input type="date" class="form-control" id="appDate" name="appDate" placeholder="" value="<?php echo $appointmentDate; ?>" required="" hidden>
              <div class="invalid-feedback">
              </div>
            </div>
               <br>
            <div class="col-6 mx-auto ">
              <label for="" class="form-label">Mobile No </label>
              <input type="text" class="form-control" id="patientMobile" name="patientMobile"  placeholder="07xxxxxxxxx" required="">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit">Appointment Submit</button>
          </div>
          <div class="col-4">
            <h4>OPD Time</h4>
            <table class="table">
             
             <tr>
               <th scope="col">#</th>
               <th scope="col">Start Time</th>
               <th scope="col">End Time</th>
               
             </tr>
             <?php   
             
             $result = mysqli_query($conn, "SELECT start_time,end_time FROM appointment_time");
  
                  while ($row = mysqli_fetch_assoc($result)) {
                        $AppStart = $row['start_time'];
                        $AppEnd = $row['end_time'];

                        // Create a DateTime object from the start_time value
                        $date1 = new DateTime($AppStart);
                        $date2 = new DateTime($AppEnd);
                        
                        // Get the formatted time (hours:minutes)
                        $appointmentStart = $date1->format('H:i');
                        $appointmentEnd = $date2->format('H:i');
                    ?>
             <tr>
               <td></th>
               <td><input type="text" name="lastBook" class="form-label" value="<?php echo $row['start_time']; ?>" hidden></input>
               <?php echo $appointmentStart; ?></td>
               <td>
               <?php echo $appointmentEnd; ?></td>
             </tr>
             <?php } ?>
          </table>
            <h4>Booking records</h4>
            <table class="table">
             
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Start Time</th>
                  <th scope="col">End Time</th>
                  
                </tr>
                <?php   
                
                $result = mysqli_query($conn, "SELECT start_time,end_time FROM appointment where appointment_date='$appointmentDate' ");
     
                    while ($row = mysqli_fetch_assoc($result)) {
             
                        $AppStart = $row['start_time'];
                        $AppEnd = $row['end_time'];

                        // Create a DateTime object from the start_time value
                        $date1 = new DateTime($AppStart);
                        $date2 = new DateTime($AppEnd);
                        
                        // Get the formatted time (hours:minutes)
                        $appStart = $date1->format('H:i');
                        $appotEnd = $date2->format('H:i');
                ?>
                <tr>
                  <td></th>
                  <td><?php echo  $appStart; ?></td>
                  <td><input type="text" name="lastBook" class="form-label" value="<?php echo $row['end_time']; ?>" hidden></input>
                  <?php echo $appotEnd; ?></td>
                </tr>
                <?php } ?>
             </table>
          </div>
        </div>
      </form>
    </div>


</div>
</body>
</html>
