<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">Admin Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="stat-value"><?php echo $stats['total_users']; ?></div>
            <p class="mt-1">
                <span class="badge badge-warning"><?php echo $stats['pending_users']; ?> Pending</span>
                <span class="badge badge-success"><?php echo $stats['approved_users']; ?> Approved</span>
            </p>
        </div>

        <div class="stat-card">
            <h3>Total Jobs</h3>
            <div class="stat-value"><?php echo $stats['total_jobs']; ?></div>
            <p class="mt-1">
                <span class="badge badge-warning"><?php echo $stats['pending_jobs']; ?> Pending</span>
                <span class="badge badge-success"><?php echo $stats['approved_jobs']; ?> Approved</span>
            </p>
        </div>

        <div class="stat-card">
            <h3>Total Applications</h3>
            <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
            <p class="mt-1">Applications received</p>
        </div>

        <div class="stat-card">
            <h3>Active Categories</h3>
            <div class="stat-value"><?php echo $stats['total_categories']; ?></div>
            <p class="mt-1">Job categories</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Quick Actions</h2>
        </div>
        <div class="flex gap-2">
            <?php if ($pending_users > 0): ?>
                <a href="<?php echo BASE_URL; ?>?page=users&action=pending" class="btn btn-warning">
                    Review Pending Users (<?php echo $pending_users; ?>)
                </a>
            <?php endif; ?>

            <?php if ($pending_jobs > 0): ?>
                <a href="<?php echo BASE_URL; ?>?page=jobs&action=pending" class="btn btn-warning">
                    Review Pending Jobs (<?php echo $pending_jobs; ?>)
                </a>
            <?php endif; ?>

            <a href="<?php echo BASE_URL; ?>?page=categories" class="btn btn-primary">
                Manage Categories
            </a>

            <a href="<?php echo BASE_URL; ?>?page=reports" class="btn btn-primary">
                View Reports
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Activities</h2>
        </div>

        <?php if (empty($recent_activities)): ?>
            <p>No recent activities</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_activities as $activity): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($activity['username'] ?? 'System'); ?></td>
                            <td><span class="badge badge-info"><?php echo htmlspecialchars($activity['action']); ?></span></td>
                            <td><?php echo htmlspecialchars($activity['description']); ?></td>
                            <td><?php echo htmlspecialchars($activity['ip_address']); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($activity['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- System Overview Chart -->
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title">System Overview</h2>
        </div>
        <div class="flex gap-3">
            <div style="flex: 1;">
                <h4>User Distribution</h4>
                <ul>
                    <li>Employers: <?php
                                    $conn = get_db_connection();
                                    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE user_type = 'employer'");
                                    echo mysqli_fetch_assoc($result)['count'];
                                    ?></li>
                    <li>Job Seekers: <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE user_type = 'jobseeker'");
                                        echo mysqli_fetch_assoc($result)['count'];
                                        ?></li>
                    <li>Admins: <?php
                                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE user_type = 'admin'");
                                echo mysqli_fetch_assoc($result)['count'];
                                ?></li>
                </ul>
            </div>

            <div style="flex: 1;">
                <h4>Job Status</h4>
                <ul>
                    <li>Pending: <?php echo $stats['pending_jobs']; ?></li>
                    <li>Approved: <?php echo $stats['approved_jobs']; ?></li>
                    <li>Rejected: <?php
                                    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'rejected'");
                                    echo mysqli_fetch_assoc($result)['count'];
                                    ?></li>
                    <li>Closed: <?php
                                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'closed'");
                                echo mysqli_fetch_assoc($result)['count'];
                                ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
