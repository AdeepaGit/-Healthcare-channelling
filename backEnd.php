<?php 
require_once "config.php";

use PHPMailer\PHPMailer\PHPmailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit'])){

    $name = $_POST["patientName"];
    $email = $_POST["patientEmail"];
    $appointmentDate = $_POST["appDate"];
    $mobile = $_POST["patientMobile"];
    //$lastBook = $_POST["lastBook"];
    $lastBook = isset($_POST["lastBook"]) ? $_POST["lastBook"] : $_POST['start_time'];

    $result = mysqli_query($conn, "SELECT * FROM appointment_time");

    if ($result === false) {
        // Handle the error, e.g., display an error message or log it
        die('Error executing the query: ' . mysqli_error($conn));
    }
     
    while ($row = mysqli_fetch_assoc($result)) {
        
        $time1=$row['duration']; 
       

// Calculate new time by adding minutes to the existing time
      $newTimeUnixTimestamp = strtotime($lastBook) + ($time1 * 60);
      $newTime = date("H:i", $newTimeUnixTimestamp);

        echo "ID: " .$row['start_time'] . ", Name: " . $row['end_time'] . ", Age: " .$newTime. "<br>";
       
        $result = mysqli_query($conn, "INSERT INTO appointment (patient_name,patient_email,patient_moile,appointment_date,start_time,end_time) 
        VALUES ('$name', '$email', '$mobile', '$appointmentDate', '$lastBook', '$newTime')");  

            if ($result) {
                
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
            
                $mail->Subject = $_POST["name"];
            
                $mail->Body = $_POST["patientName"];
            
                $mail->Body .= " your booking ";
            
                $mail->Body .= $_POST["patientMobile"];

                $mail->Body .= $_POST["appDate"];
            
                $mail->send();
            
                echo 
                "
                <script>
                alert('Sent Succesfully');
                document.location.href = 'index.php';
                </Script>
                 ";
                //echo "Record inserted successfully.";
            } else {
                echo "Error: " . $result->error;
            }
    }
    mysqli_free_result($result);



}

if(isset($_GET['checkTime'])){

    $appointmentDate = $_GET["appointmentDate"];

    
   
    $result = mysqli_query($conn, "SELECT * FROM appointment WHERE appointment_date = '$appointmentDate'");
    
    if (mysqli_num_rows($result) == 0) {
        echo 
        "
        <script>
        alert('no records');
        var appointmentDate = " . json_encode($appointmentDate) . ";
        document.location.href = 'book.php?Request=' + encodeURIComponent(appointmentDate);
        </Script>
        ";
    
        } else {

            $result = mysqli_query($conn, "SELECT end_time  FROM appointment WHERE appointment_date = '$appointmentDate' ORDER BY appointment_no DESC LIMIT 1");
            if ($result === false) {
                // Handle the error, e.g., display an error message or log it
                die('Error executing the query: ' . mysqli_error($conn));
            }
            while($row = mysqli_fetch_assoc($result)){
            $maxEndTime = $row['end_time'];

            echo "The maximum end time for appointments on $appointmentDate is: $maxEndTime";
            $result = mysqli_query($conn, "SELECT * FROM appointment_time");

            if ($result === false) {
                // Handle the error, e.g., display an error message or log it
                die('Error executing the query: ' . mysqli_error($conn));
            }
             
            while ($row = mysqli_fetch_assoc($result)) {
                
                $time1=$row['duration'];
                $appointEndTime=$row['end_time'];
            }      
            $newTimeUnixTimestamp = strtotime($maxEndTime) + ($time1 * 60);
            $newTime = date("H:i", $newTimeUnixTimestamp);

            echo "The maximum end time for appointments on $appointmentDate is: $maxEndTime and  $newTime and $appointEndTime";
             if($appointEndTime < $newTime){
                echo 
                "
                <script>
                alert('alread book ');
                document.location.href = 'index.php';
                </Script>
                ";
             }
             else{
                echo 
                "
                <script>
                alert('Available');
                var appointmentDate = " . json_encode($appointmentDate) . ";
                document.location.href = 'book.php?Request=' + encodeURIComponent(appointmentDate);
                </Script>
                ";
             }
          /*  echo 
            "
            <script>
            alert('Sent Succesfully');
            document.location.href = 'index.php';
            </Script>
            ";*/
            }
        }
}

if(isset($_POST['changeTime'])) {
    
    $start_time = $_POST["appStTime"];
    $end_time = $_POST["appEnTime"];
    $duration = $_POST["duration"];
     
    $result = mysqli_query($conn, "SELECT * FROM appointment_time WHERE id_time = 1");
    
    if (mysqli_num_rows($result) == 0) {

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