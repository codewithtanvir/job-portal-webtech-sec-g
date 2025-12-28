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
</body>
</html>