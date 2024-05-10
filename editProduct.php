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
    if (isset($_POST["remove"])) {
        $id_to_remove = $_POST["remove"];
        include("deleteProduct.php");
    } elseif (isset($_POST["edit"])) {
        $id_to_edit = $_POST["edit"];
      
        $edited_column = isset($_POST["edited_column"]) ? $_POST["edited_column"] : '';
        $edited_value = isset($_POST["edited_value"]) ? $_POST["edited_value"] : '';
       
        if ($edited_column != '' && $edited_value != '') {
            $sql = "UPDATE shipments SET $edited_column='$edited_value' WHERE id=$id_to_edit";
            $conn->query($sql);
        }
    }
}

$result = $conn->query("SELECT * FROM shipments");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Shipments</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .edit-input {
            width: 100%;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tracking Number</th>
                <th>Branch To</th>
                <th>Employee Name</th>
                <th>Sender Phone Number</th>
                <th>Cargo Content</th>
                <th>Delivery Branch</th>
                <th>Payment Type</th>
                <th>Fee</th>
                <th>Recipient Name</th>
                <th>Recipient Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                $trackingNumber = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $trackingNumber . "</td>";
                    
 
                    $editableColumns = ['branch_to', 'employee_name', 'sender_phone_number', 'cargo_content', 'delivery_branch', 'payment_type', 'fee', 'recipient_name', 'recipient_phone_number'];
                    foreach ($editableColumns as $column) {
                        echo "<td class='editable' data-id='" . $row["id"] . "' data-column='$column'>" . $row[$column] . "</td>";
                    }

                    echo "<td>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='remove' value='" . $row["id"] . "'>";
                    echo "<input type='submit' value='Remove'>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";

                    $trackingNumber++;
                }
            } else {
                echo "<tr><td colspan='12'>No Records Found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editableCells = document.querySelectorAll('.editable');
            editableCells.forEach(function(cell) {
                cell.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var column = this.getAttribute('data-column');
                    var value = this.innerText;
                    this.innerHTML = "<input class='edit-input' type='text' value='" + value + "'>";
                    var input = this.querySelector('.edit-input');
                    input.focus();
                    input.addEventListener('blur', function() {
                        var editedValue = this.value;
                        this.parentNode.innerHTML = editedValue;
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", window.location.href, true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.send("edit=" + id + "&edited_column=" + column + "&edited_value=" + editedValue);
                    });
                });
            });
        });
    </script>

    <?php
    $conn->close();
    ?>

</body>

</html>
 