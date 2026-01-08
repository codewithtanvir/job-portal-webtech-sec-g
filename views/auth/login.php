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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--secondary-color);
        }

        .demo-info {
            background: #e0f2fe;
            border: 1px solid #7dd3fc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .demo-info h3 {
            color: #0369a1;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .demo-info p {
            margin: 0.3rem 0;
            font-size: 0.9rem;
            color: #075985;
        }

        .demo-info strong {
            font-weight: 600;
        }

        .login-form .form-group {
            margin-bottom: 1.5rem;
        }

        .login-form .form-control {
            padding: 0.875rem;
            font-size: 1rem;
        }

        .login-form .btn {
            width: 100%;
            padding: 0.875rem;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .alert {
            margin-bottom: 1.5rem;
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
                <input type="text" id="username" name="username" class="form-control"
                    placeholder="Enter your username" required autofocus>
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
