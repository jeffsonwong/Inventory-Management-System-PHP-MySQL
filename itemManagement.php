<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<div id="navbarContainer"></div>

<head>
    <title>Item Management</title>
    <link rel="stylesheet" href="css/customerManagement.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <object data="navbar.html" width="100%" height="50"></object>

    <div id="firstHalf">

        <h2>Item Management</h2>

        <!-- Item Form -->
        <form id="itemForm" action="" method="POST" enctype="multipart/form-data">
            <p class="error" id="validationMessage"></p>
            <?php
            if (isset($_SESSION['success'])) {
                echo "<script>alert('" . $_SESSION['success'] . "');</script>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo "<script>alert('" . $_SESSION['error'] . "');</script>";
                unset($_SESSION['error']);
            }
            ?>
            <div class="form-group">
                <label for="item_id">Item ID*:</label>
                <?php
                // Generate a unique item ID
                $item_id = uniqid();
                echo "<input type='text' id='item_id' name='item_id' value='$item_id' readonly>";
                ?>
            </div>

            <div class="form-group">
                <label for="item_name">Item Name*:</label>
                <input type="text" id="item_name" name="item_name" required>
            </div>

            <div class="form-group">
                <label for="item_quantity">Item Quantity*:</label>
                <input type="number" id="item_quantity" name="item_quantity" required min="1">
            </div>

            <div class="form-group">
                <label for="item_price">Item Price*:</label>
                <input type="number" step="0.01" id="item_price" name="item_price" required min="0.01">
            </div>

            <input type="submit" value="Add Item">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['remove'])) {
                // Remove item
                $item_id = $_POST['item_id'];

                $dbServername = "projectx.cmhc15dvku39.us-east-1.rds.amazonaws.com";
                $dbUsername = "admin";
                $dbPassword = "JJA_123456";
                $dbName = "customermanagementdb";
                $dbPort = 3306;

                $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);

                if (!$conn) {
                    die('Connection Failed: ' . mysqli_connect_error());
                } else {
                    // Check if the item is associated with any sales
                    $stmt = $conn->prepare("SELECT COUNT(*) FROM purchases WHERE item_id = ?");
                    $stmt->bind_param("s", $item_id);
                    $stmt->execute();
                    $stmt->bind_result($salesCount);
                    $stmt->fetch();
                    $stmt->close();

                    if ($salesCount > 0) {
                        // The item is associated with sales, display error message
                        echo "<script>";
                        echo "alert('This item is currently associated with sales. Please remove the associated sales before removing this item.');";
                        echo "window.location = 'itemManagement.php';";
                        echo "</script>";
                    } else {
                        // No associated sales, proceed with item removal
                        $stmt = $conn->prepare("DELETE FROM cust_item WHERE item_id = ?");
                        $stmt->bind_param("s", $item_id);

                        if ($stmt->execute()) {
                            $_SESSION['success'] = "Item removed successfully...";
                            header("Location: itemManagement.php");
                            exit();
                        } else {
                            $_SESSION['error'] = "Error removing item";
                            header("Location: itemManagement.php");
                            exit();
                        }

                        $stmt->close();
                        mysqli_close($conn);
                    }
                }
            } else {
                // Add item
                $item_id = $_POST['item_id'];
                $item_name = $_POST['item_name'];
                $item_quantity = $_POST['item_quantity'];
                $item_price = $_POST['item_price'];

                $dbServername = "projectx.cmhc15dvku39.us-east-1.rds.amazonaws.com";
                $dbUsername = "admin";
                $dbPassword = "JJA_123456";
                $dbName = "customermanagementdb";
                $dbPort = 3306;

                $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);

                if (!$conn) {
                    die('Connection Failed: ' . mysqli_connect_error());
                } else {
                    $stmt = $conn->prepare("INSERT INTO cust_item (item_id, item_name, item_quantity, item_price) VALUES (?, ?, ?, ?)");
                    if (!$stmt) {
                        die('Error preparing statement: ' . mysqli_error($conn));
                    } else {
                        $stmt->bind_param("ssss", $item_id, $item_name, $item_quantity, $item_price);

                        if (!$stmt->execute()) {
                            die('Error executing statement: ' . mysqli_error($conn));
                        } else {
                            $_SESSION['success'] = "Item added successfully...";
                            header("Location: itemManagement.php");
                            exit();
                        }

                        $stmt->close();
                    }
                }
            }
        }
        ?>

    </div>
    <div id="secondHalf">
        <!-- Item List -->
        <h3>Item List</h3>
        <table>
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Item Quantity</th>
                    <th>Item Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="itemList">
                <?php
                $dbServername = "projectx.cmhc15dvku39.us-east-1.rds.amazonaws.com";
                $dbUsername = "admin";
                $dbPassword = "JJA_123456";
                $dbName = "customermanagementdb";
                $dbPort = 3306;

                $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);

                if (!$conn) {
                    die('Connection Failed: ' . mysqli_connect_error());
                } else {
                    $sql = "SELECT * FROM cust_item";
                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        echo "<tr><td colspan='5'>Error retrieving items: " . mysqli_error($conn) . "</td></tr>";
                    } else if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['item_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['item_quantity']) . "</td>";
                            echo "<td>" . htmlspecialchars(number_format($row['item_price'], 2)) . "</td>";
                            echo "<td><form action='' method='POST'><input type='hidden' name='remove' value='1'><input type='hidden' name='item_id' value='" . htmlspecialchars($row['item_id']) . "'><input type='submit' value='Remove'></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No items found.</td></tr>";
                    }

                    mysqli_close($conn);
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="js/navbar.js"></script>
    <script>
        // Form validation
        document.getElementById("itemForm").addEventListener("submit", function(event) {
            var item_name = document.getElementById("item_name").value;
            var item_quantity = document.getElementById("item_quantity").value;
            var item_price = document.getElementById("item_price").value;

            if (item_name == "" || item_quantity == "" || item_price == "") {
                event.preventDefault();
                document.getElementById("validationMessage").innerHTML = "Please enter all fields marked with a (*)";
            } else if (item_quantity <= 0 || !Number.isInteger(Number(item_quantity))) {
                event.preventDefault();
                document.getElementById("validationMessage").innerHTML = "Item quantity must be a positive integer";
            }
        });
    </script>

</body>

</html>