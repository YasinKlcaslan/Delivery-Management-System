<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Edit Shipment</title>
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
                    <li><a href="shipmentTracking.html">Where is My Cargo?</a></li>
                    <li><a href="commentPanel.html">Give Us A Comment!</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="loginPage.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
            </div>
        </div>
    </nav>';

    <div class="container">
        <h2>Edit Shipment</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "logisticproject";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];

            $sql = "SELECT * FROM shipments WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "No shipment found with the given ID.";
            }
        }

        $conn->close();
        ?>
        <form action="userPanel.php" method="post">
            <div class="form-group"> <label for="branch_to">Branch To:</label> <input type="text" class="form-control" id="branch_to" name="branch_to" value="<?php echo $row['branch_to']; ?>" required> </div>
            <div class="form-group"> <label for="employee_name">Name and Surname of the Employee Performing the Transaction:</label> <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?php echo $row['employee_name']; ?>" required> </div>
            <div class="form-group"> <label for="sender_phone_number">Sender Phone Number:</label> <input type="tel" class="form-control" id="sender_phone_number" name="sender_phone_number" value="<?php echo $row['sender_phone_number']; ?>" required> </div>
            <div class="form-group"> <label for="cargo_content">Content of the Cargo:</label> <textarea class="form-control" id="cargo_content" name="cargo_content" rows="4" required><?php echo $row['cargo_content']; ?></textarea> </div>
            <div class="form-group"> <label for="delivery_branch">Delivery Branch:</label> <input type="text" class="form-control" id="delivery_branch" name="delivery_branch" value="<?php echo $row['delivery_branch']; ?>" required> </div>
            <div class="form-group"> <label for="payment_type">Payment Type:</label> <select class="form-control" id="payment_type" name="payment_type" required>
                    <option value="credit_card" <?php if ($row['payment_type'] == 'credit_card') echo 'selected'; ?>>Credit Card</option>
                    <option value="cash" <?php if ($row['payment_type'] == 'cash') echo 'selected'; ?>>Cash</option>
                </select> </div>
            <div class="form-group"> <label for="fee">Fee:</label> <input type="number" class="form-control" id="fee" name="fee" value="<?php echo $row['fee']; ?>" required> </div>
            <div class="form-group"> <label for="recipient_name">Recipient Name and Surname:</label> <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="<?php echo $row['recipient_name']; ?>" required> </div>
            <div class="form-group"> <label for="recipient_phone_number">Recipient Phone Number:</label> <input type="tel" class="form-control" id="recipient_phone_number" name="recipient_phone_number" value="<?php echo $row['recipient_phone_number']; ?>" required> </div> <input type="hidden" name="shipment_id" value="<?php echo $row['id']; ?>"> <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

</body>

</html>