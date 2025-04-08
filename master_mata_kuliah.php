<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action === "add") {
        $sql = "INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, semester, user_input, tanggal_input)
                VALUES ('{$_POST['kode_matkul']}', '{$_POST['nama_matkul']}', '{$_POST['sks']}', '{$_POST['semester']}', '{$_POST['user_input']}', NOW())";
    } elseif ($action === "edit") {
        $sql = "UPDATE mata_kuliah SET nama_matkul='{$_POST['nama_matkul']}', sks='{$_POST['sks']}', semester='{$_POST['semester']}' WHERE kode_matkul='{$_POST['kode_matkul']}'";
    } elseif ($action === "delete") {
        $sql = "DELETE FROM mata_kuliah WHERE kode_matkul='{$_POST['kode_matkul']}'";
    }
    $conn->query($sql);
    header("Location: master_mata_kuliah.php");
    exit();
}

$edit_mode = false;
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_result = $conn->query("SELECT * FROM mata_kuliah WHERE kode_matkul='{$_GET['edit']}'");
    $edit_data = $edit_result->fetch_assoc();
}

$result = $conn->query("SELECT * FROM mata_kuliah");
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #7209b7;
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
        
        .course-form {
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
        
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        
        .form-group input:focus,
        .form-group select:focus {
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
        
        .sks-badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: var(--accent);
            color: white;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .course-form {
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
                <h1>Course Management</h1>
                <a href="menu_admin.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Admin Menu
                </a>
            </div>
        </div>
        
        <div class="form-container">
            <form method="post">
                <div class="course-form">
                    <div class="form-group">
                        <label for="kode_matkul">Course Code</label>
                        <input type="text" name="kode_matkul" id="kode_matkul" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['kode_matkul']) : '' ?>" 
                               <?= $edit_mode ? 'readonly' : 'required' ?>>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_matkul">Course Name</label>
                        <input type="text" name="nama_matkul" id="nama_matkul" 
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['nama_matkul']) : '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sks">Credits (SKS)</label>
                        <input type="number" name="sks" id="sks" 
                               min="1" max="10"
                               value="<?= $edit_mode ? htmlspecialchars($edit_data['sks']) : '' ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" required>
                            <option value="" disabled <?= !$edit_mode ? 'selected' : '' ?>>Select Semester</option>
                            <?php for($i=1; $i<=8; $i++): ?>
                                <option value="<?= $i ?>" <?= ($edit_mode && $edit_data['semester'] == $i) ? 'selected' : '' ?>>
                                    Semester <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <input type="hidden" name="user_input" value="<?= htmlspecialchars($_SESSION['user_input']) ?>">
                        <input type="hidden" name="action" value="<?= $edit_mode ? 'edit' : 'add' ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-<?= $edit_mode ? 'save' : 'plus' ?>"></i> 
                            <?= $edit_mode ? 'Update Course' : 'Add Course' ?>
                        </button>
                        <?php if ($edit_mode): ?>
                            <a href="master_mata_kuliah.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Semester</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_matkul']) ?></td>
                            <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                            <td><span class="sks-badge"><?= htmlspecialchars($row['sks']) ?> SKS</span></td>
                            <td>Semester <?= htmlspecialchars($row['semester']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="master_mata_kuliah.php?edit=<?= $row['kode_matkul'] ?>" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="kode_matkul" value="<?= $row['kode_matkul'] ?>">
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