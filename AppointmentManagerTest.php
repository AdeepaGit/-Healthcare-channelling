<?php 
use PHPUnit\Framework\TestCase;

class AppointmentManagerTest extends TestCase
{
    public function testCalculateAppointmentEndTime()
    {
        // Assum the database result
        $result = [
            [
                'duration' => 30, // Assuming the duration is 30 minutes
                'end_time' => '13:30', // Assuming the end time is 13:30
            ],
        ];

        // Create a mock of the database connection and set the expected behavior
        $mockDatabase = $this->createMock(mysqli_result::class);
        $mockDatabase->expects($this->once())
            ->method('fetch_assoc')
            ->willReturnOnConsecutiveCalls(...$result);

        // Create an instance of the AppointmentManager and inject the mock database
        $appointmentManager = new AppointmentManager($mockDatabase);

        // Set the value of $maxEndTime (this value must be provided based on the context of your application)
        $maxEndTime = '14:00'; // Assuming the maximum end time is 14:00

        // Call the method that calculates the appointment end time
        $appointmentManager->calculateAppointmentEndTime($maxEndTime);

        // Get the calculated appointment end time
        $calculatedEndTime = $appointmentManager->getAppointmentEndTime();

        // Assert that the calculated end time is as expected
        $this->assertEquals('14:30', $calculatedEndTime); // Expected end time: 14:30
    }
}
?>