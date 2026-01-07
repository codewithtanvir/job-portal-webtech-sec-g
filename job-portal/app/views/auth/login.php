<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Job Portal</title>
  <link rel="stylesheet" href="/job-portal/public/css/style.css">
</head>
<body>
  <nav>
    <a href="/job-portal/public/">Home</a>
    <a href="/job-portal/public/auth/register">Register</a>
  </nav>

  <div class="card">
    <h2>Login</h2>
    <form id="loginForm">
      <table>
        <tr>
          <td>Email</td>
          <td><input type="email" name="email" required></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password" required></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="submit" value="Login">
            <a href="/job-portal/public/auth/forgotpassword" style="margin-left:10px;">Forgot?</a>
          </td>
        </tr>
      </table>
    </form>
  </div>

  <script src="/job-portal/public/js/auth.js"></script>
</body>
</html>
