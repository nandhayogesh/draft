<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer only

// Database connection
$conn = new mysqli("localhost", "root", "Kavin@2005", "clinic");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$message = $_POST['message'];

// Insert into database
$sql = "INSERT INTO appointments (name, phone, location, message)
        VALUES ('$name', '$phone', '$location', '$message')";

if ($conn->query($sql) === TRUE) {
  // ✅ Send Email
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kavinprabakaran5@gmail.com';
    $mail->Password = 'Kavin@2005';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('kavinprabakaran5@gmail.com', 'Clinic');
    $mail->addAddress('a1parchs@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'New Appointment';
    $mail->Body    = "Name: $name<br>Phone: $phone<br>Location: $location<br>Message: $message";

    $mail->send();
  } catch (Exception $e) {
    // echo "Mailer Error: " . $mail->ErrorInfo;
  }

  // ✅ Redirect to success page
  header("Location: success.html");
  exit();
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
