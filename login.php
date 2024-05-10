<?php
session_start();

include "dbconnect.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Sorgu hazırlanırken hata oluştu: " . $conn->error);
}

$stmt->bind_param("ss", $username, $password);

$result = $stmt->execute();

if (!$result) {
    die("Sorgu çalıştırılırken hata oluştu: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $username;
    header("Location: userPanel.php");
} else {
    $error = "Böyle bir kullanıcı bulunamadı.";
    header("Location: loginPage.html?error=" . urlencode($error));
}

$stmt->close();
$conn->close();
?>
