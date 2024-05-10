<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logisticproject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $branch_to = $_POST['branch_to'];
    $employee_name = $_POST['employee_name'];
    $sender_phone_number = $_POST['sender_phone_number'];
    $cargo_content = $_POST['cargo_content'];
    $delivery_branch = $_POST['delivery_branch'];
    $payment_type = $_POST['payment_type'];
    $fee = $_POST['fee'];
    $recipient_name = $_POST['recipient_name'];
    $recipient_phone_number = $_POST['recipient_phone_number'];

    $sql = "INSERT INTO shipments (branch_to, employee_name, sender_phone_number, cargo_content, delivery_branch, payment_type, fee, recipient_name, recipient_phone_number)
            VALUES ('$branch_to', '$employee_name', '$sender_phone_number', '$cargo_content', '$delivery_branch', '$payment_type', '$fee', '$recipient_name', '$recipient_phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New cargo added successfully";
        header("Location: userPanel.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
