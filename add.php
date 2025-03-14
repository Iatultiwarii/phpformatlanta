<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];
    $marital_status = isset($_POST['marital_status']) ? $_POST['marital_status'] : "Unmarried"; 
    $dob = isset($_POST['dob']) ? $_POST['dob'] : "0000-00-00"; 
    $status = isset($_POST['status']) ? $_POST['status'] : "Active"; 

    // Handle file upload
    $photo = "default.png"; // Default photo if none uploaded
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    }

    // Insert into database
    $sql = "INSERT INTO users (name, email, mobile, role, designation, photo, marital_status, dob, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $email, $mobile, $role, $designation, $photo, $marital_status, $dob, $status);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
