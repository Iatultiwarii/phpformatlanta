<?php include 'db.php'; ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];
    $marital_status = $_POST['marital_status'];
    $dob = $_POST['dob'];
    $status = $_POST['status'];

    // Handle file upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        $photo = $_POST['existing_photo'];
    }

    // Update query
    $sql = "UPDATE users SET name=?, email=?, mobile=?, role=?, designation=?, photo=?, marital_status=?, dob=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $name, $email, $mobile, $role, $designation, $photo, $marital_status, $dob, $status, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <input type="hidden" name="existing_photo" value="<?php echo $user['photo']; ?>">

            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Mobile:</label>
                <input type="text" name="mobile" class="form-control" value="<?php echo $user['mobile']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Role:</label>
                <input type="text" name="role" class="form-control" value="<?php echo $user['role']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Designation:</label>
                <input type="text" name="designation" class="form-control" value="<?php echo $user['designation']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Marital Status:</label>
                <select name="marital_status" class="form-control" required>
                    <option value="Married" <?php echo ($user['marital_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                    <option value="Unmarried" <?php echo ($user['marital_status'] == 'Unmarried') ? 'selected' : ''; ?>>Unmarried</option>
                </select>
            </div>
            <div class="mb-3">
                <label>DOB:</label>
                <input type="date" name="dob" class="form-control" value="<?php echo $user['dob']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Photo:</label>
                <input type="file" name="photo" class="form-control">
                <img src="uploads/<?php echo $user['photo']; ?>" width="50">
            </div>
            <div class="mb-3">
                <label>Status:</label>
                <select name="status" class="form-control">
                    <option value="Active" <?php echo ($user['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo ($user['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
