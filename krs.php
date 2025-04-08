<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_input'])) {
    die("Error: User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === "add") {
        $kode_matkul = $_POST['kode_matkul'];
        $nik_dosen = $_POST['NIK_dosen'];
        $hari_matkul = $_POST['hari_matkul'];
        $ruangan = $_POST['ruangan'];
        $student_nims = explode(",", $_POST['NIM_mahasiswa']); // ✅ Split multiple NIMs

        $valid_nims = [];
        foreach ($student_nims as $nim) {
            $nim = trim($nim);

            // Ensure NIM exists in mahasiswa table
            $check_nim = $conn->prepare("SELECT NIM FROM mahasiswa WHERE NIM = ?");
            $check_nim->bind_param("s", $nim);
            $check_nim->execute();
            $result_nim = $check_nim->get_result();
            
            if ($result_nim->num_rows > 0) {
                $valid_nims[] = $nim; // ✅ Store only valid NIMs
            }
        }

        if (!empty($valid_nims)) {
            foreach ($valid_nims as $nim) {
                $sql = "INSERT INTO krs (kode_matkul, NIK_dosen, NIM_mahasiswa, hari_matkul, ruangan, user_input, tanggal_input, total_mahasiswa) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Query Error: " . $conn->error); // ✅ Debugging Output
                }

                $total_mahasiswa = 1; // ✅ Store in a variable instead of passing directly
                $stmt->bind_param("ssssssi", $kode_matkul, $nik_dosen, $nim, $hari_matkul, $ruangan, $_SESSION['user_input'], $total_mahasiswa);


                if (!$stmt->execute()) {
                    die("Insert Error: " . $stmt->error); // ✅ Debugging Output
                }
            }
        }
    } elseif ($action === "delete") {
        $sql = "DELETE FROM krs WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    }

    echo "Class registered successfully! Redirecting...";
    sleep(3); // ✅ Pause for debugging
    header("Location: krs.php");
    exit();
}

$result = $conn->query("
    SELECT MIN(id) as id, kode_matkul, NIK_dosen, hari_matkul, ruangan, COUNT(*) as total_mahasiswa 
    FROM krs 
    GROUP BY kode_matkul, NIK_dosen, hari_matkul, ruangan
");
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration (KRS)</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --danger: #dc3545;
            --success: #38b000;
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
            text-align: center;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .dashboard-content {
            padding: 30px;
        }
        
        .table-container {
            margin-bottom: 40px;
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
        
        .form-container {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
            border: 1px solid #e2e8f0;
        }
        
        h2 {
            color: var(--primary-dark);
            margin-top: 0;
            font-size: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
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
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--gray);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .student-count {
            display: inline-block;
            padding: 4px 10px;
            background-color: var(--accent);
            color: white;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .dashboard-content {
                padding: 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Course Registration (KRS)</h1>
        </div>
        
        <div class="dashboard-content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Lecturer NIK</th>
                            <th>Students</th>
                            <th>Day</th>
                            <th>Room</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode_matkul']) ?></td>
                                <td><?= htmlspecialchars($row['NIK_dosen']) ?></td>
                                <td><span class="student-count"><?= htmlspecialchars($row['total_mahasiswa']) ?> students</span></td>
                                <td><?= htmlspecialchars($row['hari_matkul']) ?></td>
                                <td><?= htmlspecialchars($row['ruangan']) ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <button type="submit" name="action" value="delete" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="form-container">
                <h2>Add New Course Registration</h2>
                <form method="post">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="user_input" value="<?= htmlspecialchars($_SESSION['user_input']) ?>">
                    
                    <div class="form-group">
                        <label for="kode_matkul">Course Code</label>
                        <input type="text" name="kode_matkul" id="kode_matkul" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="NIK_dosen">Lecturer NIK</label>
                        <input type="text" name="NIK_dosen" id="NIK_dosen" required>
                    </div>
                    
                    <div class="form-group">
                        <!-- ✅ Allow multiple student NIMs separated by commas -->
        <label>Student NIM(s) (comma-separated):</label> 
        <input type="text" name="NIM_mahasiswa" placeholder="e.g., 001,002,003,004,005" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="hari_matkul">Day</label>
                        <input type="text" name="hari_matkul" id="hari_matkul" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="ruangan">Room</label>
                        <input type="text" name="ruangan" id="ruangan" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Course Registration
                    </button>
                </form>
            </div>
            
            <a href="menu_admin.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Return to Admin Menu
            </a>
        </div>
    </div>
</body>
</html>

