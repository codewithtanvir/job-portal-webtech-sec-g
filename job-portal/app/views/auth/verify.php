<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Email - Job Portal</title>
  <link rel="stylesheet" href="/job-portal/public/css/style.css">
</head>
<body>
  <nav>
    <a href="/job-portal/public/">Home</a>
    <a href="/job-portal/public/auth/login">Login</a>
  </nav>

  <div class="card">
    <h2>Verify Your Email</h2>
    <form id="verifyForm">
      <table>
        <tr>
          <td>Email</td>
          <td><input type="email" id="verifyEmail" name="email" required></td>
        </tr>
        <tr>
          <td>OTP</td>
          <td><input type="text" name="otp" maxlength="6" required></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="Verify"></td>
        </tr>
      </table>
    </form>
    <p style="text-align:center; margin-top:10px;">
      Tip: In this demo, the OTP is shown in the alert after registration.
    </p>
  </div>

  <script>
    const savedEmail = localStorage.getItem('jobportal_email');
    if (savedEmail) {
      const el = document.getElementById('verifyEmail');
      if (el) el.value = savedEmail;
    }
  </script>
  <script src="/job-portal/public/js/auth.js"></script>
</body>
</html>
