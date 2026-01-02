<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Asset/admin_homestyle.css">
</head>

<body>
    <div class="header">
        <h2>Admin Dashboard - Welcome</h2>
        <button class="logout-btn">Logout</button>
    </div>
    <div class="sidebar">
        <ul>
            <li onclick="showSection('overview')">Overview</li>
            <li onclick="showSection('manageUsers')">User Management</li>
            <li onclick="showSection('manageJobs')">Job Management</li>
            <li onclick="showSection('reports')">Reports</li>
            <li onclick="showSection('notifications')">Notifications</li>
            <li onclick="showSection('activityLogs')">Activity Logs</li>
            <li onclick="showSection('dataExport')">Data Export</li>
        </ul>

    </div>
    <div class="main">
        <div id="overview">
            <h3>Overview</h3>
            <div class="card">
                <h3></h3>
                <p>Total Users: 0</p>
            </div>
            <div class="card">
                <h3></h3>
                <p>Active Employers: 0</p>
            </div>
            <div class="card">
                <h3></h3>
                <p>job Listings: 0</p>
            </div>
            <div class="card">
                <h3></h3>
                <p>Applications: 0</p>
            </div>
        </div>
        <div id="manageUsers">
            <h3>User Management</h3>
            <div id="messageArea"></div>

            <div class="manage-users-grid">
                <div class="add-user-card">
                    <h4>Add New User</h4>
                    <form id="addUserForm" onsubmit="return handleAddUser(event)">
                        <div class="input-group">
                            <label for="newUsername">Username:</label>
                            <input type="text" id="newUsername" name="newUsername" placeholder="Enter username" required>
                            <p id="usernameError" class="error"></p>
                        </div>
                        <div class="input-group">
                            <label for="newEmail">Email:</label>
                            <input type="email" id="newEmail" name="newEmail" placeholder="Enter email" required>
                            <p id="emailError" class="error"></p>
                        </div>
                        <div class="input-group">
                            <label for="newRole">Role:</label>
                            <select name="newRole" id="newRole" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="admin">Admin</option>
                                <option value="employer">Employer</option>
                                <option value="jobseeker">Job Seeker</option>
                            </select>
                            <p id="roleError" class="error"></p>
                        </div>
                        <div class="input-group">
                            <label for="newPassword">Password:</label>
                            <input type="password" id="newPassword" name="newPassword" placeholder="Enter password" required>
                            <p id="passwordError" class="error"></p>
                        </div>
                        <button type="submit" class="submit-btn">Add User</button>
                    </form>
                </div>
            </div>
        </div>



    </div>
</body>

</html>