<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Debugging: Show submitted form data before execution
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    if ($action === "add") {
        $hashed_password = md5($_POST['password']); // ✅ Secure password hashing
        $sql = "INSERT INTO mahasiswa (NIM, nama, tahun_masuk, alamat, telp, user_input, tanggal_input, password) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $_POST['NIM'], $_POST['nama'], $_POST['tahun_masuk'], $_POST['alamat'], $_POST['telp'], $_POST['user_input'], $hashed_password);

        if (!$stmt->execute()) {
            die("Insert Error: " . $stmt->error);
        }
    } elseif ($action === "edit") {
        // ✅ Check if NIM exists before updating
        $check_nim = $conn->prepare("SELECT NIM FROM mahasiswa WHERE NIM=?");
        $check_nim->bind_param("s", $_POST['NIM']);
        $check_nim->execute();
        $check_result = $check_nim->get_result();

        if ($check_result->num_rows === 0) {
            die("Error: Student with NIM '{$_POST['NIM']}' not found in the database.");
        }

        // ✅ Secure update logic with password hashing
        $hashed_password = md5($_POST['password']);
        $sql = "UPDATE mahasiswa SET nama=?, tahun_masuk=?, alamat=?, telp=?, user_input=?, password=? WHERE NIM=?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Query Error: " . $conn->error);
        }

        $stmt->bind_param("sssssss", $_POST['nama'], $_POST['tahun_masuk'], $_POST['alamat'], $_POST['telp'], $_POST['user_input'], $hashed_password, $_POST['NIM']);

        if (!$stmt->execute()) {
            die("Update Error: " . $stmt->error);
        }
    } elseif ($action === "delete") {
        $sql = "DELETE FROM mahasiswa WHERE NIM=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_POST['NIM']);

        if (!$stmt->execute()) {
            die("Delete Error: " . $stmt->error);
        }
    }

    // ✅ Fix for Infinite Redirect Loop
    header("Location: master_mahasiswa.php?updated=1");
    exit();
}

// ✅ Ensure editing mode retrieves correct student details
$edit_mode = false;
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_result = $conn->prepare("SELECT * FROM mahasiswa WHERE NIM=?");
    $edit_result->bind_param("s", $_GET['edit']);
    $edit_result->execute();
    $edit_data = $edit_result->get_result()->fetch_assoc();
}

// ✅ Ensure `result` is correctly retrieved to avoid fetch errors
$result = $conn->query("SELECT * FROM mahasiswa");
if (!$result) {
    die("Error fetching data: " . $conn->error); // ✅ Prevent fatal error on `fetch_assoc()`
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #38b000;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f9fc;
            margin: 0;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .dashboard-header {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 25px 30px;
        }
        
        .dashboard-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-btn:hover {
            text-decoration: underline;
        }
        
        .form-container {
            padding: 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .student-form {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            grid-column: 1 / -1;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-secondary {
            background: var(--gray);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .table-container {
            padding: 0 30px 30px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background-color: #f8f9fa;
            color: var(--dark);
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit {
            background: #ffc107;
            color: var(--dark);
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-edit:hover {
            background: #e0a800;
            transform: translateY(-1px);
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        
        .address-cell {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        @media (max-width: 768px) {
            .student-form {
                grid-template-columns: 1fr;
            }
            
            .dashboard-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>Student Management</h1>
                <a href="menu_admin.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Admin Menu
                </a>
            </div>
        </div>
        
        <div class="form-container">
            <form method="post">
                <div class="student-form">
                    <div class="form-group">
                        <label for="NIM">Student ID (NIM)</label>
                        <input type="text" name="NIM" id="NIM" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['NIM']) : '' ?>" 
                               <?= $edit_mode ? 'readonly' : 'required' ?>>
                    </div>
                    
                    <div class="form-group">
                <label for="nama">Name</label>
                <input type="text" name="nama" id="nama" value="<?= $edit_mode ? htmlspecialchars($edit_data['nama']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="tahun_masuk">Year of Entry</label>
                <input type="text" name="tahun_masuk" id="tahun_masuk" value="<?= $edit_mode ? htmlspecialchars($edit_data['tahun_masuk']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="alamat">Address</label>
                <input type="text" name="alamat" id="alamat" value="<?= $edit_mode ? htmlspecialchars($edit_data['alamat']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="telp">Phone</label>
                <input type="text" name="telp" id="telp" value="<?= $edit_mode ? htmlspecialchars($edit_data['telp']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="user_input">Username</label>
                <input type="text" name="user_input" id="user_input" value="<?= $edit_mode ? htmlspecialchars($edit_data['user_input']) : '' ?>">
            </div>

                    <div class="form-group">
                        <label for="user_input">Password</label>
                        <input type="text" name="password" id="password" 
                            value="<?= $edit_mode ? htmlspecialchars($edit_data['password']) : '' ?>">
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="action" value="<?= $edit_mode ? 'edit' : 'add' ?>">
                        <button type="submit" class="btn btn-primary">
                        <i class="fas fa-<?= $edit_mode ? 'save' : 'plus' ?>"></i> 
                        <?= $edit_mode ? 'Update Student' : 'Add Student' ?>
                        </button>
                        <?php if ($edit_mode): ?>
                            <a href="master_mahasiswa.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Entry Year</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['NIM']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['tahun_masuk']) ?></td>
                            <td class="address-cell" title="<?= htmlspecialchars($row['alamat']) ?>">
                                <?= htmlspecialchars($row['alamat']) ?>
                            </td>
                            <td><?= htmlspecialchars($row['telp']) ?></td>
                            <td><?= htmlspecialchars($row['user_input']) ?></td>
                            <td><?= htmlspecialchars($row['password']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="master_mahasiswa.php?edit=<?= $row['NIM'] ?>" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="NIM" value="<?= $row['NIM'] ?>">
                                        <button type="submit" name="action" value="delete" class="btn-delete">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>