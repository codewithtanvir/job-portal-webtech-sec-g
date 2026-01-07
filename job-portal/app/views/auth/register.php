<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Job Portal</title>
  <link rel="stylesheet" href="/job-portal/public/css/style.css">
</head>
<body>
  <nav>
    <a href="/job-portal/public/">Home</a>
    <a href="/job-portal/public/auth/login">Login</a>
  </nav>

  <div class="card">
    <h2>Create Account</h2>
    <form id="registerForm">
      <table>
        <tr>
          <td>Username</td>
          <td><input type="text" name="username" required></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input type="email" name="email" required></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password" required></td>
        </tr>
        <tr>
          <td>Date of Birth</td>
          <td><input type="date" name="dob" required></td>
        </tr>
        <tr>
          <td>Role</td>
          <td>
            <select name="role" required>
              <option value="seeker">Job Seeker</option>
              <option value="employer">Employer</option>
              <option value="admin">Admin</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Register"></td>
        </tr>
      </table>
    </form>

    <p style="text-align:center; margin-top:15px;">
      After registration, you will verify your email using OTP.
    </p>
  </div>

  <script src="/job-portal/public/js/auth.js"></script>
</body>
</html>