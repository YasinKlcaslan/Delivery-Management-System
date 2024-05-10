<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logisticproject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trackingID = $conn->real_escape_string($_POST["trackingID"]);


    $sql = "SELECT * FROM shipments WHERE `Tracking Number` = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $trackingID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                <title>Shipment Tracking</title>
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }

                    th, td {
                        border: 1px solid #dddddd;
                        padding: 8px;
                        text-align: left;
                    }

                    th {
                        background-color: #f2f2f2;
                    }

                    tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }
                </style>
            </head>
            <body>
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">JetExpress</a>
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="nav navbar-nav">
                                <li><a href="howMuch.html">Cost My Cargo?</a></li>
                                <li class="active"><a href="shipmentTracking.html">Where is My Cargo?</a></li>
                                <li><a href="commentPanel.html">Give Us A Comment!</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="loginPage.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>';

        echo '<table>';
        foreach ($row as $key => $value) {
            if ($key !== 'Status') {
                echo '<tr><th>' . $key . '</th><td>' . $value . '</td></tr>';
            }
        }


        echo '<tr><th>Status</th><td>' . $row['Status'] . '</td></tr>';

        echo '</table>
            </body>
            </html>';
    } else {
 
        echo '<script>alert("Cargo not found."); window.location.href = "shipmentTracking.html";</script>';
        exit();
    }

    $stmt->close();
}

$conn->close();
