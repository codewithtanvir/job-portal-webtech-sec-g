<?php $token = $token ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Job Portal</title>
  <link rel="stylesheet" href="/job-portal/public/css/style.css">
</head>
<body>
  <nav>
    <a href="/job-portal/public/">Home</a>
    <a href="/job-portal/public/auth/login">Login</a>
  </nav>

  <div class="card">
    <h2>Reset Password</h2>
    <form id="resetForm">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
      <table>
        <tr>
          <td>New Password</td>
          <td><input type="password" name="password" required></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Reset Password"></td>
        </tr>
      </table>
    </form>

    <p style="text-align:center; margin-top:15px;">
      Demo note: open this page with <code>?token=...</code> if you want to test the reset flow.
    </p>
  </div>

  <script src="/job-portal/public/js/auth.js"></script>
</body>
</html>
