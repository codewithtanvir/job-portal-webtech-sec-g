<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
?>
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
        <h2>Admin Dashboard - Welcome, <?php echo $_SESSION['username']; ?></h2>
        <button class="logout-btn">Logout</button>
    </div>
    <div class="sidebar">
        <ul>
            <li onclick="showSection('overview')">Overview</li>
            <li onclick="showSection('manageUsers')">User Management</li>
            <li onclick="showSection('manageJobs')">Job Management</li>
            <li onclick="showSection('applications')">Applications</li>
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
                <h3>Users</h3>
                <p>Total Users: 0</p>
            </div>
            <div class="card">
                <h3>Employers</h3>
                <p>Active Employers: 0</p>
            </div>
            <div class="card">
                <h3>Jobs</h3>
                <p>Job Listings: 0</p>
            </div>
            <div class="card">
                <h3>Apps</h3>
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
                <div class="user-list-card">
                    <h4>Existing Users</h4>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <tr data-id="1">
                                <td class="user-name">Admin User</td>
                                <td class="user-email">admin@example.com</td>
                                <td><span class="role-badge admin">Admin</span></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="action-btn edit" onclick="editUser(1)">Edit</button>
                                    <button class="action-btn delete" onclick="deleteUser(this, 1)">Delete</button>
                                </td>
                            </tr>
                            <tr data-id="2">
                                <td class="user-name">John Doe</td>
                                <td class="user-email">john@example.com</td>
                                <td><span class="role-badge employer">Employer</span></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <button class="action-btn edit" onclick="editUser(2)">Edit</button>
                                    <button class="action-btn delete" onclick="deleteUser(this, 2)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="manageJobs">

        </div>

        <div id="applications">

        </div>
        <div id="activityLogs">

        </div>

        <div id="dataExport">

        </div>

    </div>
    <script src="../../Asset/admin_script.js"></script>
    <script src="../../Asset/admin_manageUsers.js"></script>
</body>

</html>