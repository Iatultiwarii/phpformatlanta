<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP DataTable CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Team Management</h2>
        <div class="table-container">
            <button class="btn btn-success mb-3" id="add" data-bs-toggle="modal" data-bs-target="#userModal">+ Add</button>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th style='display:none;'>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Designation</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$result = $conn->query("SELECT id, name, mobile, email, role, designation, photo, status FROM users ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    $statusClass = $row['status'] == 'Active' ? 'status-active' : 'status-inactive';
    $statusBadge = "<span class='status-badge $statusClass'>{$row['status']}</span>";
    
    echo "<tr data-id='{$row['id']}'>"; 
    echo "<td style='display:none;'>{$row['id']}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['mobile']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['role']}</td>";
    echo "<td>{$row['designation']}</td>";
    echo "<td><img src='uploads/{$row['photo']}' class='profile-pic'></td>";
    echo "<td>{$statusBadge}</td>";
    echo "<td class='action-buttons'>
            <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>✏️</a>
            <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>🗑️</a>
          </td>";
    echo "</tr>";
}
?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="add.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Mobile:</label>
                            <input type="text" name="mobile" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Role:</label>
                            <input type="text" name="role" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Designation:</label>
                            <input type="text" name="designation" class="form-control" required>
                        </div>
                        <div class="mb-3">
                        <label>Marital Status:</label>
                        <div>
                            <input type="radio" name="marital_status" value="Married" required> Married
                            <input type="radio" name="marital_status" value="Unmarried" required> Unmarried
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Date of Birth:</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                        <div class="mb-3">
                            <label>Photo:</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Status:</label>
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
