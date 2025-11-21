<!-- <?php
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $conn = new mysqli('projectx.cmhc15dvku39.us-east-1.rds.amazonaws.com', 'admin', 'JJA_123456', 'customermanagementdb');
  if ($conn->connect_error) {
    die('Connection Failed: '.$conn->connect_error);
  } else {
    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    $stmt->execute();
    echo "Customer added successfully...";
    $stmt->close();
    $conn->close();
  }
?> -->