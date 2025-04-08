<?php
session_start();
include('config.php'); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$user_input = $_SESSION['user_input'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $sql = "INSERT INTO admin (user_input, password, nama, email, telp) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $hashed_password = md5($_POST['password']); 
        $stmt->bind_param("sssss", $_POST['user_input'], $hashed_password, $_POST['nama'], $_POST['email'], $_POST['telp']); 

        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM admin WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    }

    header("Location: master_admin.php");
    exit();
}

$result = $conn->query("SELECT * FROM admin");
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --danger: #dc3545;
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
            padding: 25px;
            text-align: center;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .form-container {
            padding: 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .admin-form {
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
        
        .table-container {
            padding: 30px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            text-align: left;
            padding: 15px;
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
        
        .btn-danger {
            background: var(--danger);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--gray);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .admin-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Admin Management</h1>
        </div>
        
        <div class="form-container">
            <form method="POST">
                <div class="admin-form">
                    <div class="form-group">
                        <label for="user_input">Username</label>
                        <input type="text" name="user_input" id="user_input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Full Name</label>
                        <input type="text" name="nama" id="nama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telp">Phone</label>
                        <input type="text" name="telp" id="telp" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="add" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Admin
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Admin List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['user_input']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['telp']) ?></td>
                            <td><?= htmlspecialchars($row['password']) ?></td>
                            <td>
                                <form method="POST" class="action-buttons">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" name="delete" class="btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div style="text-align: center;">
            <a href="menu_admin.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Admin Menu
            </a>
        </div>
    </div>
</body>
</html>