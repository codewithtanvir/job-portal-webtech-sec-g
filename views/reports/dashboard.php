<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">Reports & Analytics</h1>
        <p>System statistics and performance metrics</p>
    </div>

    <!-- Overall Statistics -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="stat-value"><?php echo $overall_stats['total_users']; ?></div>
            <p class="mt-1">
                <span class="badge badge-success">+<?php echo $overall_stats['new_users_month']; ?> this month</span>
            </p>
        </div>
        <div class="stat-card">
            <h3>Total Jobs</h3>
            <div class="stat-value"><?php echo $overall_stats['total_jobs']; ?></div>
            <p class="mt-1">
                <span class="badge badge-success"><?php echo $overall_stats['active_jobs']; ?> active</span>
            </p>
        </div>
        <div class="stat-card">
            <h3>Total Applications</h3>
            <div class="stat-value"><?php echo $overall_stats['total_applications']; ?></div>
            <p class="mt-1">
                <span class="badge badge-success">+<?php echo $overall_stats['applications_month']; ?> this month</span>
            </p>
        </div>
        <div class="stat-card">
            <h3>Growth Trend</h3>
            <div class="stat-value">
                <?php
                $growth = $recent_trends['user_growth'];
                echo ($growth >= 0 ? '+' : '') . $growth . '%';
                ?>
            </div>
            <p class="mt-1">User growth (30 days)</p>
        </div>
    </div>

    <!-- Quick Reports -->
    <div class="card mb-4">
        <h2 class="card-title">Quick Reports</h2>
        <div class="flex gap-2">
            <a href="<?php echo BASE_URL; ?>?page=reports&action=users" class="btn btn-primary">User Reports</a>
            <a href="<?php echo BASE_URL; ?>?page=reports&action=jobs" class="btn btn-primary">Job Reports</a>
            <a href="<?php echo BASE_URL; ?>?page=reports&action=applications" class="btn btn-primary">Application Reports</a>
            <a href="<?php echo BASE_URL; ?>?page=reports&action=categories" class="btn btn-primary">Category Reports</a>
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="card mb-4">
        <h2 class="card-title">6-Month Trends</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>New Users</th>
                    <th>New Jobs</th>
                    <th>Applications</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly_stats as $stat): ?>
                    <tr>
                        <td><strong><?php echo $stat['month']; ?></strong></td>
                        <td><span class="badge badge-info"><?php echo $stat['users']; ?></span></td>
                        <td><span class="badge badge-success"><?php echo $stat['jobs']; ?></span></td>
                        <td><span class="badge badge-warning"><?php echo $stat['applications']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Top Categories and Employers -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div class="card">
            <h2 class="card-title">Top Categories</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Jobs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                            <td><span class="badge badge-primary"><?php echo $category['job_count']; ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2 class="card-title">Top Employers</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Employer</th>
                        <th>Jobs Posted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_employers as $employer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($employer['full_name']); ?></td>
                            <td><span class="badge badge-primary"><?php echo $employer['job_count']; ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Export Options -->
    <div class="card mt-4">
        <h2 class="card-title">Export Reports</h2>
        <div class="flex gap-2">
            <a href="<?php echo BASE_URL; ?>?page=reports&action=export&type=overall" class="btn btn-secondary">Export Overall</a>
            <a href="<?php echo BASE_URL; ?>?page=reports&action=export&type=users" class="btn btn-secondary">Export Users</a>
            <a href="<?php echo BASE_URL; ?>?page=reports&action=export&type=jobs" class="btn btn-secondary">Export Jobs</a>
            <a href="<?php echo BASE_URL; ?>?page=reports&action=export&type=applications" class="btn btn-secondary">Export Applications</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
