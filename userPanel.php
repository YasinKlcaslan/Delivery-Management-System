<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>User Panel</title>
    <style>
        table {
            font-family: 'Arial', sans-serif;
            border-collapse: collapse;
            width: 70%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #5bc0de;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .add-cargo-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .edit-btn,
        .remove-btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .edit-btn {
            color: #fff;
            background-color: #5bc0de;
            border-color: #46b8da;
        }

        .remove-btn {
            color: #fff;
            background-color: #d9534f;
            border-color: #d43f3a;
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
                <a class="navbar-brand" href="index.html">JetExpress</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="howMuch.html">Cost My Cargo?</a></li>
                    <li><a href="shipmentTracking.html">Where is My Cargo?</a></li>
                    <li><a href="commentPanel.html">Give Us A Comment!</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="loginPage.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        <a href="newCargo.html" class="btn btn-primary add-cargo-btn">Add Cargo</a>
        <center>
            <table class="table">
                <tr>
                    <th>Branch To</th>
                    <th>Name and Surname of the Employee Performing the Transaction</th>
                    <th>Sender Phone Number</th>
                    <th>Content of the Cargo</th>
                    <th>Delivery Branch</th>
                    <th>Payment Type</th>
                    <th>Fee</th>
                    <th>Recipient Name and Surname</th>
                    <th>Recipient Phone Number</th>
                    <th>Edit Shipment</th>
                    <th>Remove Shipment</th>
                </tr>

                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "logisticproject";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove"])) {
                    $id_to_remove = $_POST["remove"];
                    $sql_remove = "DELETE FROM shipments WHERE id = $id_to_remove";
                    $conn->query($sql_remove);
                }

                $sql = "SELECT * FROM shipments";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['branch_to']}</td>
                                <td>{$row['employee_name']}</td>
                                <td>{$row['sender_phone_number']}</td>
                                <td>{$row['cargo_content']}</td>
                                <td>{$row['delivery_branch']}</td>
                                <td>{$row['payment_type']}</td>
                                <td>{$row['fee']}</td>
                                <td>{$row['recipient_name']}</td>
                                <td>{$row['recipient_phone_number']}</td>
                                <td><a href='editPage.php?id={$row['id']}' class='btn btn-info edit-btn'>Edit</a></td>
                                <td>
                                    <form method='post' action=''>
                                        <input type='hidden' name='remove' value='{$row['id']}'>
                                        <button type='submit' class='btn btn-danger remove-btn'>Remove</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No shipments available</td></tr>";
                }

                $conn->close();
                ?>

            </table>
        </center>
    </div>
</body>

</html>