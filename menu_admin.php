<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        
        .admin-dashboard {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .dashboard-header {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .dashboard-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .dashboard-header p {
            margin: 5px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .user-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            margin-top: 15px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .dashboard-menu {
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .menu-card {
            background: var(--light);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }
        
        .menu-card a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            display: block;
            height: 100%;
        }
        
        .menu-card a:hover {
            color: var(--primary-dark);
        }
        
        .menu-icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .logout-section {
            text-align: center;
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .logout-btn {
            display: inline-block;
            padding: 10px 25px;
            background: linear-gradient(to right, var(--secondary), #d81159);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(216, 17, 89, 0.3);
        }
        
        @media (max-width: 600px) {
            .dashboard-menu {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <p>Management Control Panel</p>
            <div class="user-badge">
                <i class="fas fa-user-shield"></i> <?= htmlspecialchars($_SESSION['user_input']) ?>
            </div>
        </div>
        
        <div class="dashboard-menu">
            <div class="menu-card">
                <a href="master_admin.php">
                    <div class="menu-icon"><i class="fas fa-users-cog"></i></div>
                    Manage Admins
                </a>
            </div>
            
            <div class="menu-card">
                <a href="master_dosen.php">
                    <div class="menu-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    Manage Lecturers
                </a>
            </div>
            
            <div class="menu-card">
                <a href="master_mahasiswa.php">
                    <div class="menu-icon"><i class="fas fa-user-graduate"></i></div>
                    Manage Students
                </a>
            </div>
            
            <div class="menu-card">
                <a href="master_mata_kuliah.php">
                    <div class="menu-icon"><i class="fas fa-book"></i></div>
                    Manage Courses
                </a>
            </div>
            
            <div class="menu-card">
                <a href="add_course.php">
                    <div class="menu-icon"><i class="fas fa-plus-circle"></i></div>
                    Add Courses
                </a>
            </div>
            
            <div class="menu-card">
                <a href="krs.php">
                    <div class="menu-icon"><i class="fas fa-clipboard-list"></i></div>
                    Course Registrations
                </a>
            </div>
            
            <div class="menu-card">
                <a href="view_reports.php">
                    <div class="menu-icon"><i class="fas fa-chart-bar"></i></div>
                    View Reports
                </a>
            </div>
        </div>
        
        <div class="logout-section">
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </div>
    </div>
</body>
</html>