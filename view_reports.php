<?php
session_start();
include('config.php');

if (!isset($_SESSION['role']) || !isset($_SESSION['user_input'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
$user_input = $_SESSION['user_input'];

if ($role === 'lecturer') {
    $sql_nik = "SELECT NIK FROM dosen WHERE user_input = ?";
    $stmt_nik = $conn->prepare($sql_nik);
    $stmt_nik->bind_param("s", $user_input);
    $stmt_nik->execute();
    $result_nik = $stmt_nik->get_result();
    $row_nik = $result_nik->fetch_assoc();

    if (!$row_nik) {
        die("Error: Lecturer's NIK not found.");
    }

    $identifier = $row_nik['NIK']; 
    $sql = "SELECT k.kode_matkul, m.nama_matkul, m.sks, k.hari_matkul, k.ruangan 
            FROM krs k 
            JOIN mata_kuliah m ON k.kode_matkul = m.kode_matkul 
            WHERE k.nik_dosen = ?";
} elseif ($role === 'mahasiswa') {
    $sql_nim = "SELECT NIM FROM mahasiswa WHERE user_input = ?";
    $stmt_nim = $conn->prepare($sql_nim);
    $stmt_nim->bind_param("s", $user_input);
    $stmt_nim->execute();
    $result_nim = $stmt_nim->get_result();
    $row_nim = $result_nim->fetch_assoc();

    if (!$row_nim) {
        die("Error: Student's NIM not found.");
    }

    $identifier = $row_nim['NIM']; 
    $sql = "SELECT k.kode_matkul, m.nama_matkul, m.sks, k.hari_matkul, k.ruangan, d.nama AS lecturer_name 
            FROM krs k 
            JOIN mata_kuliah m ON k.kode_matkul = m.kode_matkul 
            JOIN dosen d ON k.nik_dosen = d.NIK 
            WHERE k.nim_mahasiswa = ?";
} else {
    die("Error: Invalid role detected.");
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $identifier);
$stmt->execute();
$result = $stmt->get_result();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Schedule</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #7209b7;
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
            padding: 30px;
            text-align: center;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .user-info {
            margin-top: 10px;
            font-size: 16px;
            opacity: 0.9;
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
        
        .sks-badge {
            display: inline-block;
            padding: 4px 10px;
            background-color: var(--accent);
            color: white;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .action-section {
            text-align: center;
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .return-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--gray);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .return-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 25px 20px;
            }
            
            .table-container {
                padding: 20px;
            }
            
            th, td {
                padding: 12px 10px;
                font-size: 14px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Course Schedule</h1>
            <div class="user-info">
                <?= htmlspecialchars($user_input) ?> (<?= ucfirst($role) ?>)
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Day</th>
                        <th>Room</th>
                        <?php if ($role === 'mahasiswa'): ?>
                            <th>Lecturer</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_matkul']) ?></td>
                            <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                            <td><span class="sks-badge"><?= htmlspecialchars($row['sks']) ?> SKS</span></td>
                            <td><?= htmlspecialchars($row['hari_matkul']) ?></td>
                            <td><?= htmlspecialchars($row['ruangan']) ?></td>
                            <?php if ($role === 'mahasiswa'): ?>
                                <td><?= htmlspecialchars($row['lecturer_name']) ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div class="action-section">
            <a href="<?= ($role === 'lecturer') ? 'menu_lecturer.php' : 'menu_student.php'; ?>" class="return-btn">
                <i class="fas fa-arrow-left"></i> Return to Menu
            </a>
        </div>
    </div>
</body>
</html>