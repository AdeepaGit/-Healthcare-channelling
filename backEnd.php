<?php 
require_once "config.php";

use PHPMailer\PHPMailer\PHPmailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//For Proccess the booking and sent email
if(isset($_POST['submit'])){

    $name = $_POST["patientName"];
    $email = $_POST["patientEmail"];
    $appointmentDate = $_POST["appDate"];
    $mobile = $_POST["patientMobile"];
    //if not available last booking get appointment start time as last booking
    $lastBook = isset($_POST["lastBook"]) ? $_POST["lastBook"] : $_POST['start_time'];

    //Getting appointment for the cal the appointment Duration
    $result1 = mysqli_query($conn, "SELECT * FROM appointment_time");

    if ($result1 === false) {
        // Handle the error, e.g., display an error message or log it
        die('Error executing the query: ' . mysqli_error($conn));
    }
     
    while ($row = mysqli_fetch_assoc($result1)) {
        
        $time1=$row['duration']; 

     // Calculate  appointment Duration 
      $newTimeUnixTimestamp = strtotime($lastBook) + ($time1 * 60);
      $newTime = date("H:i", $newTimeUnixTimestamp);
        //Inert appointments details
        $result = mysqli_query($conn, "INSERT INTO appointment (patient_name,patient_email,patient_moile,appointment_date,start_time,end_time) 
        VALUES ('$name', '$email', '$mobile', '$appointmentDate', '$lastBook', '$newTime')");  

            if ($result) {
                 $query = mysqli_query($conn, "SELECT * FROM appointment 
                           WHERE appointment_date='$appointmentDate'
                           AND start_time='$lastBook'");
                if (!$query) {
                // Query execution failed, display the error message
                die("Query failed: " . mysqli_error($conn));
                 }
                while ($row = mysqli_fetch_assoc($query)) {
                    $AppStart = $row['start_time'];
                    // Create a DateTime object from the start_time value
                    $date1 = new DateTime($AppStart);
                    // Get the formatted time (hours:minutes)
                    $appointmentStart = $date1->format('H:i');
                                 
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rajanslions@gmail.com';
                $mail->Password = 'roswsqovxztjlnwk';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
            
                $mail->setFrom('rajanslions@gmail.com');
                
                $mail->addAddress($_POST["patientEmail"]);
            
                $mail->isHTML(true);
            
                $mail->Subject = "Healthcare Hospital";
            
                $mail->Body = "Patiant Name: ";

                $mail->Body .= $_POST["patientName"];
            
                $mail->Body .= " your appointment no: ";

                $mail->Body .= $row['appointment_no'];

                $mail->Body .= " Appointment Date: ";
            
                $mail->Body .= $_POST["appDate"];

                $mail->Body .= " Appointment Time: ";

                $mail->Body .= "$appointmentStart";
            
                $mail->send();
            
                echo 
                "
                <script>
                alert('Your Booking Detail will sent you email');
                document.location.href = 'index.php';
                </Script>
                 ";
             }
            } else {
                echo "Error: " . $result->error;
            }
    }
   // mysqli_free_result($result);


}

//For checking availability of booking
if(isset($_GET['checkTime'])){

    $appointmentDate = $_GET["appointmentDate"];

    //checking booking available for this date
    $result = mysqli_query($conn, "SELECT * FROM appointment WHERE appointment_date = '$appointmentDate'");
    
    if (mysqli_num_rows($result) == 0) {
        echo 
        "
        <script>
        var appointmentDate = " . json_encode($appointmentDate) . ";
        document.location.href = 'book.php?Request=' + encodeURIComponent(appointmentDate);
        </Script>
        ";
    
        } else {
            //Getting appointment for checking if appointment available on tis date
            $result = mysqli_query($conn, "SELECT end_time  FROM appointment WHERE appointment_date = '$appointmentDate' ORDER BY appointment_no DESC LIMIT 1");
            if ($result === false) {
                // Handle the error, e.g., display an error message or log it
                die('Error executing the query: ' . mysqli_error($conn));
            }
            while($row = mysqli_fetch_assoc($result)){
            $maxEndTime = $row['end_time'];

            //Getting appointment for the cal the appointment Duration
            $result = mysqli_query($conn, "SELECT * FROM appointment_time");

            if ($result === false) {
                // Handle the error, e.g., display an error message or log it
                die('Error executing the query: ' . mysqli_error($conn));
            }
             
            while ($row = mysqli_fetch_assoc($result)) {
                
                $time1=$row['duration'];
                $appointEndTime=$row['end_time'];
            }      
            //cal appointment end time
            $newTimeUnixTimestamp = strtotime($maxEndTime) + ($time1 * 60);
            $newTime = date("H:i", $newTimeUnixTimestamp);

            //checking, if appointment end time override or not
             if($appointEndTime < $newTime){
                echo 
                "
                <script>
                alert('Already Booking Completed. Try another date ');
                document.location.href = 'index.php';
                </Script>
                ";
             }
             else{
                echo 
                "
                <script>
                var appointmentDate = " . json_encode($appointmentDate) . ";
                document.location.href = 'book.php?Request=' + encodeURIComponent(appointmentDate);
                </Script>
                ";
             }
         
            }
        }
}
//For change appontment time
if(isset($_POST['changeTime'])) {
    
    $start_time = $_POST["appStTime"];
    $end_time = $_POST["appEnTime"];
    $duration = $_POST["duration"];
     
    //check ing if it is first time or not
    $result = mysqli_query($conn, "SELECT * FROM appointment_time WHERE id_time = 1");
    
    if (mysqli_num_rows($result) == 0) {
        //if first time insert 
         $result = mysqli_query($conn, "INSERT INTO appointment_time (start_time,end_time,duration,last_update ) 
                                   VALUE ('$start_time','$end_time','$duration',now())");
                
                if ($result ) {
                    echo 
                        "
                        <script>
                        alert('Set Appointment Time Succesfully');
                        document.location.href = 'staff.php';
                        </Script>
                        ";
                }
            }
            else{
                //if available update the appointment time
                 $result = mysqli_query($conn, "UPDATE appointment_time 
                                                SET 
                                                start_time='$start_time',
                                                end_time='$end_time',
                                                duration='$duration',
                                                last_update=now()");
                if ($result ) {
                    echo 
                        "
                        <script>
                        alert('Set Appointment Time Succesfully');
                        document.location.href = 'staff.php';
                        </Script>
                        ";
                }
              
            }
   }
?>