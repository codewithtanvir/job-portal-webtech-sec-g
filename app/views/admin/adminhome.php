<?php
session_start();
require_once('../../models/userModel.php');
require_once('../../controllers/AdminController.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$adminCtrl = new AdminController();
$stats = $adminCtrl->getStats();
$users = getAllUsers();
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
                <p>Total Users:<?php echo $stats['users']; ?></p>
            </div>
            <div class="card">
                <h3>Employers</h3>
                <p>Active Employers: 0<?php echo $stats['employers']; ?></p>
            </div>
            <div class="card">
                <h3>Jobs</h3>
                <p>Job Listings:<?php echo $stats['jobs']; ?></p>
            </div>
            <div class="card">
                <h3>Apps</h3>
                <p>Applications: <?php echo $stats['apps']; ?> </p>
            </div>
        </div>
        <div id="manageUsers">
            <h3>User Management</h3>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="success-message" style="color: green; margin-bottom: 10px;"><?php echo $_SESSION['message'];
                                                                                        unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message" style="color: red; margin-bottom: 10px;"><?php echo $_SESSION['error'];
                                                                                    unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="manage-users-grid">
                <div class="add-user-card">
                    <h4>Add New User</h4>
                    <form id="addUserForm" action="../../controllers/userController.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="input-group">
                            <label for="newUsername">Username:</label>
                            <input type="text" id="newUsername" name="newUsername" placeholder="Enter username" required>
                        </div>
                        <div class="input-group">
                            <label for="newEmail">Email:</label>
                            <input type="email" id="newEmail" name="newEmail" placeholder="Enter email" required>
                        </div>
                        <div class="input-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" required>
                        </div>
                        <div class="input-group">
                            <label for="newRole">Role:</label>
                            <select name="newRole" id="newRole" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="admin">Admin</option>
                                <option value="employer">Employer</option>
                                <option value="seeker">Job Seeker</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="newPassword">Password:</label>
                            <input type="password" id="newPassword" name="newPassword" placeholder="Enter password" required>
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
                            <?php foreach ($users as $user): ?>
                                <tr data-id="<?php echo $user['id']; ?>">
                                    <td class="user-name"><?php echo $user['username']; ?></td>
                                    <td class="user-email"><?php echo $user['email']; ?></td>
                                    <td><span class="role-badge <?php echo $user['role']; ?>"><?php echo ucfirst($user['role']); ?></span></td>
                                    <td><span class="status-badge <?php echo $user['is_verified'] ? 'active' : 'inactive'; ?>">
                                            <?php echo $user['is_verified'] ? 'Verified' : 'Pending'; ?>
                                        </span></td>
                                    <td>
                                        <button class="action-btn edit" onclick="editUser(<?php echo $user['id']; ?>)">Edit</button>
                                        <button class="action-btn delete" onclick="deleteUser(this, <?php echo $user['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <script src="../../Asset/admin_script.js"></script>
    <script src="../../Asset/admin_manageUsers.js"></script>
</body>

</html>