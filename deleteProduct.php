<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logisticproject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove"])) {
    $id_to_remove = $_POST["remove"];

    $sql = "DELETE FROM shipments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_to_remove);

    if ($stmt->execute()) {
        echo "Kayıt başarıyla silindi.";
    } else {
        echo "Silme hatası: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
