<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Job Portal</title>
  <link rel="stylesheet" href="/job-portal/public/css/style.css">
</head>
<body>
  <nav>
    <a href="/job-portal/public/">Home</a>
    <a href="/job-portal/public/auth/login">Login</a>
  </nav>

  <div class="card">
    <h2>Forgot Password</h2>
    <form id="forgotForm">
      <table>
        <tr>
          <td>Email</td>
          <td><input type="email" name="email" required></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Send Reset Link"></td>
        </tr>
      </table>
    </form>

    <p style="text-align:center; margin-top:15px;">
      For this demo, the reset token will be shown in the browser console.
    </p>
  </div>

  <script src="/job-portal/public/js/auth.js"></script>
</body>
</html>
