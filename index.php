<?php
session_start();
include('config.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = $_POST['user_input'];
    $password = md5($_POST['password']); 

    if (str_ends_with($user_input, '@admin.ac.id')) {
        $role = 'admin';
        $table = 'admin';
        $redirect_page = 'menu_admin.php';
    } elseif (str_ends_with($user_input, '@lecturer.ac.id')) {
        $role = 'lecturer';
        $table = 'dosen';
        $redirect_page = 'menu_lecturer.php';
    } elseif (str_ends_with($user_input, '@student.ac.id')) {
        $role = 'mahasiswa';  
        $table = 'mahasiswa';
        $redirect_page = 'menu_student.php';
    } else {
        $error = "Invalid username format. Please use '@admin.ac.id', '@lecturer.ac.id', or '@student.ac.id'.";
    }

    if (isset($role)) {
        $sql = "SELECT * FROM $table WHERE user_input = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_input, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user_input'] = $user_input;
            $_SESSION['role'] = $role;

            header("Location: http://localhost/UTS/$redirect_page");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal Login</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --secondary: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('img_modules/Kampus-UMN.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-header {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .login-header p {
            margin: 8px 0 0;
            font-size: 15px;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--dark);
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }
        
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background: #fff5f5;
            border-radius: 8px;
            border-left: 4px solid #e53e3e;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: var(--gray);
            font-size: 13px;
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 15px;
            }
            
            .login-header, .login-body {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>University Portal</h1>
            <p>Sign in to your account</p>
        </div>
        
        <div class="login-body">
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="user_input">University Email</label>
                    <input type="text" name="user_input" id="user_input" placeholder="your.email@domain.ac.id" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            
            <p class="footer-text">© <?= date('Y') ?> University Portal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>