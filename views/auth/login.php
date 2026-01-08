<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f0f0f0;
    }

    .login-container {
        background: white;
        padding: 2rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
        max-width: 400px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #333;
        padding-bottom: 1rem;
    }

    .login-header h1 {
        color: #333;
        font-size: 1.8rem;
        margin-bottom: 0.3rem;
    }

    .login-header p {
        color: #666;
        font-size: 0.9rem;
    }

    .demo-info {
        background: #ffffcc;
        border: 1px solid #ccc;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .demo-info h3 {
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .demo-info p {
        margin: 0.3rem 0;
        font-size: 0.85rem;
        color: #333;
    }

    .demo-info strong {
        font-weight: bold;
    }

    .login-form .form-group {
        margin-bottom: 1rem;
    }

    .login-form .form-control {
        padding: 0.6rem;
        font-size: 1rem;
    }

    .login-form .btn {
        width: 100%;
        padding: 0.7rem;
        font-size: 1rem;
    }

    .login-footer {
        text-align: center;
        margin-top: 1rem;
        color: #666;
        font-size: 0.85rem;
    }

    .alert {
        margin-bottom: 1rem;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1><?php echo APP_NAME; ?></h1>
            <p>Admin Login Portal</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <div class="demo-info">
            <h3>🔐 Demo Credentials</h3>
            <p><strong>Username:</strong> admin</p>
            <p><strong>Password:</strong> admin123</p>
        </div>

        <form method="POST" action="<?php echo BASE_URL; ?>?page=auth&action=authenticate" class="login-form">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username"
                    required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="login-footer">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
        </div>
    </div>
</body>

</html>