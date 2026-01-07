<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">Pending Jobs Approval</h1>
        <p>Review and approve employer job postings</p>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <?php if (empty($jobs)): ?>
            <div class="alert alert-info">No pending jobs at this time</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Employer</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Salary Range</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($job['title']); ?></td>
                            <td><?php echo htmlspecialchars($job['employer_name']); ?></td>
                            <td><span class="badge badge-info"><?php echo htmlspecialchars($job['category_name']); ?></span></td>
                            <td><?php echo ucfirst($job['job_type']); ?></td>
                            <td><?php echo htmlspecialchars($job['location']); ?></td>
                            <td><?php echo htmlspecialchars($job['salary_range'] ?? 'Not specified'); ?></td>
                            <td><?php echo date('M d, Y', strtotime($job['created_at'])); ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="<?php echo BASE_URL; ?>?page=jobs&action=view&id=<?php echo $job['id']; ?>"
                                        class="btn btn-sm btn-primary">View</a>
                                    <a href="<?php echo BASE_URL; ?>?page=jobs&action=approve&id=<?php echo $job['id']; ?>"
                                        class="btn btn-sm btn-success"
                                        data-confirm="Approve this job?">Approve</a>
                                    <a href="<?php echo BASE_URL; ?>?page=jobs&action=reject&id=<?php echo $job['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        data-confirm="Reject this job?">Reject</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="mt-3">
            <a href="<?php echo BASE_URL; ?>?page=jobs" class="btn btn-secondary">Back to All Jobs</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
