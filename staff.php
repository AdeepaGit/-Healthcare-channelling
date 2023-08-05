<?php 
require_once "config.php";
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
          <li><a href="staff.php">Staff </a></li>
        </ul>
	   </div>	
      <!-- navigation bar end here-->

	    <!-- content_wrapper starts-->

	     <div class="content_wrapper">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
          <h1 class="text-body-emphasis mb-3">Set appointment time</h1>
              <div class="row g-3">
                <div class="col-8 ms-3 mb-3">
                     <table class="table">
                      <tr class="table-primary">
                        <th scope="col">#</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                      </tr>
                      <?php   
                         // Display appointment time
                        $result = mysqli_query($conn, "SELECT start_time,end_time FROM appointment_time");
                        while ($row = mysqli_fetch_assoc($result)) {
                         $start_time = $row['start_time'];
                         $end_time = $row['end_time'];

                        // Create a DateTime object from the start_time value
                        $date1 = new DateTime($start_time);
                        $date2 = new DateTime($end_time);

                        // Get the formatted time (hours:minutes)
                        $formattedStart = $date1->format('H:i');
                        $formatted_End = $date2->format('H:i');
                      ?>
                      <tr>
                        <td></th>
                        <td><input type="text" name="lastBook" class="form-label" value="<?php echo $row['start_time']; ?>" hidden></input>
                        <?php echo $formattedStart; ?></td>
                        <td>
                        <?php echo $formatted_End;  ?></td>
                      </tr>
                      <?php } ?>
                    </table>
                </div>
                <div class="col-3 mt-3">
                   <!-- Button trigger modal -->
                   <button type="button" class="btn btn-primary btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Set Time</button>
                    <form action="backEnd.php" method="post">
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Set Appointment Time</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <div class="row g-3">
                                          <div class="col-3 mb-3">
                                              <label for="Startingtime" class="form-label">Starting time</label>
                                              <input type="time" class="form-control" id="appStTime" name="appStTime" pattern="[0-2][0-9]:[0-5][0-9]" required>
                                          </div>
                                          <div class="col-3 mb-3">
                                              <label for="Endingtime" class="form-label">Ending time</label>
                                              <input type="time" class="form-control" id="appEnTime" name="appEnTime" pattern="[0-2][0-9]:[0-5][0-9]" required>
                                          </div>
                                          <div class="col-3 mb-3 form-check">
                                              <label for="DurationPerAppointment" class="form-label">Duration</label>
                                              <input class="form-control" type="number" min="10" max="60" name="duration" placeholder="Minute" required>
                                          </div> 
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="changeTime">Save changes</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
              <div class="row g-3" >
                <div style="overflow-y:auto !important; max-height: 500px;">
                     <table class="table " >
                      <thead>
                      <tr class="table-primary">
                        <th scope="col">Appointment No</th>
                        <th scope="col">Appointment Date</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Appointment Time</th>
                        <th scope="col">Patient Mobile</th>
                        <th scope="col">Patient Mobile</th>
                      </tr>
                      </thead>
                      <?php   
                         // Display All appointments
                        $result = mysqli_query($conn, "SELECT * FROM appointment ORDER BY appointment_date");
                        while ($row = mysqli_fetch_assoc($result)) {
                        $AppStart = $row['start_time'];

                        // Create a DateTime object from the start_time value
                        $date1 = new DateTime($AppStart);
                        
                        // Get the formatted time (hours:minutes)
                        $appointmentStart = $date1->format('H:i');
                       
                      ?>
                      <tbody>
                      <tr >
                        <td><?php echo $row['appointment_no']; ?></td></th>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td><?php echo $row['patient_name']; ?></td>
                        <td><?php echo $appointmentStart; ?></td>
                        <td><?php echo $row['patient_moile']; ?></td>
                        <td><?php echo $row['patient_email']; ?></td>
                      </tr>
                      </tbody>
                      <?php } ?>
                    </table>
                    </div>
              </div>
  </div>
</body>
</html>
