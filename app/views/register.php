<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Job Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>Job Portal</h1>
        <nav>
            <a href="home">Home</a>
            <a href="login">Login</a>
        </nav>
    </header>
    <main>
        <h2>Register</h2>
        <form action="register" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="seeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>
            <button type="submit" name="btnRegister">Register</button>
        </form>
    </main>
</body>

</html>
