<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">Job Details</h1>
        <p>Viewing job posting: <?php echo htmlspecialchars($job['title']); ?></p>
    </div>

    <div class="card mb-4">
        <h2 class="card-title">Job Information</h2>
        <table class="table">
            <tr>
                <th style="width: 200px;">Job ID</th>
                <td><?php echo $job['id']; ?></td>
            </tr>
            <tr>
                <th>Title</th>
                <td><?php echo htmlspecialchars($job['title']); ?></td>
            </tr>
            <tr>
                <th>Employer</th>
                <td>
                    <?php echo htmlspecialchars($job['employer_fullname']); ?>
                    (<?php echo htmlspecialchars($job['employer_name']); ?>)
                    <br><small><?php echo htmlspecialchars($job['employer_email']); ?></small>
                </td>
            </tr>
            <tr>
                <th>Category</th>
                <td><span class="badge badge-info"><?php echo htmlspecialchars($job['category_name']); ?></span></td>
            </tr>
            <tr>
                <th>Job Type</th>
                <td><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <td><?php echo htmlspecialchars($job['location']); ?></td>
            </tr>
            <tr>
                <th>Salary Range</th>
                <td><?php echo htmlspecialchars($job['salary_range'] ?? 'Not specified'); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php
                    $status_class = $job['status'] == 'approved' ? 'badge-success' : ($job['status'] == 'pending' ? 'badge-warning' : ($job['status'] == 'rejected' ? 'badge-danger' : 'badge-secondary'));
                    ?>
                    <span class="badge <?php echo $status_class; ?>">
                        <?php echo ucfirst($job['status']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Posted On</th>
                <td><?php echo date('F d, Y H:i', strtotime($job['created_at'])); ?></td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td><?php echo date('F d, Y H:i', strtotime($job['updated_at'])); ?></td>
            </tr>
        </table>
    </div>

    <div class="card mb-4">
        <h2 class="card-title">Description</h2>
        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
    </div>

    <?php if (!empty($job['requirements'])): ?>
        <div class="card mb-4">
            <h2 class="card-title">Requirements</h2>
            <p><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>
        </div>
    <?php endif; ?>

    <?php
    $stats = get_job_statistics($job['id']);
    if ($stats['total_applications'] > 0):
    ?>
        <div class="card mb-4">
            <h2 class="card-title">Application Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Applications</h3>
                    <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Pending Review</h3>
                    <div class="stat-value"><?php echo $stats['pending_applications']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Shortlisted</h3>
                    <div class="stat-value"><?php echo $stats['shortlisted_applications']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Accepted</h3>
                    <div class="stat-value"><?php echo $stats['accepted_applications']; ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($applications)): ?>
        <div class="card mb-4">
            <h2 class="card-title">Applications (<?php echo count($applications); ?>)</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Email</th>
                        <th>Applied On</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($app['email']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                            <td>
                                <?php
                                $app_status_class = $app['status'] == 'accepted' ? 'badge-success' : ($app['status'] == 'shortlisted' ? 'badge-info' : ($app['status'] == 'rejected' ? 'badge-danger' : 'badge-warning'));
                                ?>
                                <span class="badge <?php echo $app_status_class; ?>">
                                    <?php echo ucfirst($app['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="card">
        <h2 class="card-title">Actions</h2>
        <div class="flex gap-2">
            <?php if ($job['status'] == 'pending'): ?>
                <a href="<?php echo BASE_URL; ?>?page=jobs&action=approve&id=<?php echo $job['id']; ?>"
                    class="btn btn-success"
                    data-confirm="Approve this job posting?">Approve Job</a>
                <a href="<?php echo BASE_URL; ?>?page=jobs&action=reject&id=<?php echo $job['id']; ?>"
                    class="btn btn-danger"
                    data-confirm="Reject this job posting?">Reject Job</a>
            <?php endif; ?>

            <?php if ($job['status'] == 'approved'): ?>
                <a href="<?php echo BASE_URL; ?>?page=jobs&action=close&id=<?php echo $job['id']; ?>"
                    class="btn btn-warning"
                    data-confirm="Close this job posting?">Close Job</a>
            <?php endif; ?>

            <a href="<?php echo BASE_URL; ?>?page=jobs&action=delete&id=<?php echo $job['id']; ?>"
                class="btn btn-danger"
                data-confirm="Delete this job? This action cannot be undone.">Delete Job</a>

            <a href="<?php echo BASE_URL; ?>?page=jobs" class="btn btn-secondary">Back to Jobs</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
