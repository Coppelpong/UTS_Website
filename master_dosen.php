<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === "add") {
        $sql = "INSERT INTO dosen (NIK, nama, gelar, lulusan, telp, user_input, tanggal_input, password) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);

        $hashed_password = md5($_POST['password']); // ✅ Secure password hashing
        $stmt->bind_param("sssssss", $_POST['NIK'], $_POST['nama'], $_POST['gelar'], $_POST['lulusan'], $_POST['telp'], $_POST['user_input'], $hashed_password);

        if (!$stmt->execute()) {
            die("Insert Error: " . $stmt->error);
        }
    } elseif ($action === "edit") {
        $sql = "UPDATE dosen SET nama=?, gelar=?, lulusan=?, telp=?, user_input=?, password=? WHERE NIK=?";
        $stmt = $conn->prepare($sql);

        $hashed_password = md5($_POST['password']);
        $stmt->bind_param("sssssss", $_POST['nama'], $_POST['gelar'], $_POST['lulusan'], $_POST['telp'], $_POST['user_input'], $hashed_password, $_POST['NIK']);

        if (!$stmt->execute()) {
            die("Update Error: " . $stmt->error);
        }
    } elseif ($action === "delete") {
        $sql = "DELETE FROM dosen WHERE NIK=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_POST['NIK']);

        if (!$stmt->execute()) {
            die("Delete Error: " . $stmt->error);
        }
    }

    header("Location: master_dosen.php");
    exit();
}

$edit_mode = false;
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_result = $conn->prepare("SELECT * FROM dosen WHERE NIK=?");
    $edit_result->bind_param("s", $_GET['edit']);
    $edit_result->execute();
    $edit_data = $edit_result->get_result()->fetch_assoc();
}

$result = $conn->query("SELECT * FROM dosen");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lecturer Management</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f9fc;
            margin: 0;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1200px;
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
        
        .lecturer-form {
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
        
        @media (max-width: 768px) {
            .lecturer-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>Lecturer Management</h1>
                <a href="menu_admin.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Admin Menu
                </a>
            </div>
        </div>
        
        <div class="form-container">
            <form method="post">
                <div class="lecturer-form">
                    <div class="form-group">
                        <label for="NIK">NIK</label>
                        <input type="text" name="NIK" id="NIK" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['NIK']) : '' ?>" 
                               <?= $edit_mode ? 'readonly' : 'required' ?>>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" name="nama" id="nama" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['nama']) : '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gelar">Title</label>
                        <input type="text" name="gelar" id="gelar" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['gelar']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="lulusan">Degree</label>
                        <input type="text" name="lulusan" id="lulusan" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['lulusan']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="telp">Phone</label>
                        <input type="text" name="telp" id="telp" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['telp']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="user_input">Username</label>
                        <input type="text" name="user_input" id="user_input" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['user_input']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" name="password" id="password" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['password']) : '' ?>">
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="action" value="<?= $edit_mode ? 'edit' : 'add' ?>">
                        <button type="submit" class="btn btn-primary">
                        <i class="fas fa-<?= $edit_mode ? 'save' : 'plus' ?>"></i> 
                        <?= $edit_mode ? 'Update Lecturer' : 'Add Lecturer' ?>
                        </button>
                        <?php if ($edit_mode): ?>
                            <a href="master_dosen.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>NIK</th><th>Name</th><th>Title</th><th>Degree</th><th>Phone</th><th>Username</th><th>Password</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['NIK']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['gelar']) ?></td>
                            <td><?= htmlspecialchars($row['lulusan']) ?></td>
                            <td><?= htmlspecialchars($row['telp']) ?></td>
                            <td><?= htmlspecialchars($row['user_input']) ?></td>
                            <td><?= htmlspecialchars($row['password']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="master_dosen.php?edit=<?= $row['NIK'] ?>" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="NIK" value="<?= $row['NIK'] ?>">
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
