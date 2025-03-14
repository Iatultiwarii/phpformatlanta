<?php include 'db.php'; ?>

<?php
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Get current status
    $result = $conn->query("SELECT status FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $new_status = ($user['status'] == 'Active') ? 'Inactive' : 'Active';

        // Update status
        $stmt = $conn->prepare("UPDATE users SET status=? WHERE email=?");
        $stmt->bind_param("ss", $new_status, $email);
        $stmt->execute();
    }
}

header("Location: index.php");
exit();
?>
