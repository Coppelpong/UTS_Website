<?php
session_start();
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'mahasiswa') {
    header("Location: index.php");
    exit();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e2e8f0 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .dashboard-container {
            width: 100%;
            max-width: 600px;
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
        
        .dashboard-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .dashboard-header p {
            margin: 8px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .user-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            margin-top: 15px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .dashboard-menu {
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
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
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }
        
        .menu-card a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            display: block;
            font-size: 16px;
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
            padding: 12px 30px;
            background: linear-gradient(to right, var(--accent), #38b6ff);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(56, 182, 255, 0.3);
        }
        
        @media (max-width: 480px) {
            .dashboard-header {
                padding: 25px 20px;
            }
            
            .dashboard-menu {
                padding: 25px 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Student Dashboard</h1>
            <p>Academic Management System</p>
            <div class="user-badge">
                <i class="fas fa-user-graduate"></i> <?= htmlspecialchars($_SESSION['user_input']) ?>
            </div>
        </div>
        
        <div class="dashboard-menu">
            <div class="menu-card">
                <a href="view_reports.php">
                    <div class="menu-icon"><i class="fas fa-calendar-alt"></i></div>
                    View Class Schedule
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