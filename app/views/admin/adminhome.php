<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="header">
        <h2>Admin Dashboard - Welcome</h2>
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
                <h3 id="totalusers">0</h3>
                <p>Total Users</p>
            </div>
            <div class="card">
                <h3 id="activeEmployers">0</h3>
                <p>Active Employers</p>
            </div>
            <div class="card">
                <h3 id="joblistings">0</h3>
                <p>job listings</p>
            </div>
            <div class="card">
                <h3 id="applications">0</h3>
                <p>Applications</p>
            </div>
        </div>
        <div id="manageUsers" style="display: none;">
            <h3>Manage Users</h3>
            <div id="messageArea"></div>
            <div class="form-section">
                <h4>Add new user</h4>
                <form id="addUserForm" onsubmit="return handleAddUser(event)">
                    <label for="newUsername">Username:</label>
                    <input type="text" id="newUsername" name="newUsername" required>
                    <br>

                    <label for="newemail">Email:</label>
                    <input type="email" id="newemail" name="newemail" required>
                    <br>

                    <label for="newaRole">Role:</label>
                    <select id="newaRole" name="newaRole" required>
                        <option value="">select role</option>
                        <option value="admin">Admin</option>
                        <option value="employer">Employer</option>
                        <option value="jobseeker">Job Seeker</option>
                    </select>
                    <br>
                    <label for="newPassword">Password:</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                    <br>

                    <button type="submit">Add User</button>
                </form>

            </div>
            <div class="table-section">
            <h4>current users</h4>
            <table id="userTable">
                <thead>
                    <tr>
                        
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            </div>
        </div>


    </div>
</body>

</html>