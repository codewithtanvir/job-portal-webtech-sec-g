<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4 flex justify-between align-center">
        <div>
            <h1 class="card-title">Job Management</h1>
            <p>Review and manage all job postings</p>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="card mb-4">
        <form method="GET" action="" class="flex gap-2 align-center">
            <input type="hidden" name="page" value="jobs">

            <div class="form-group" style="flex: 1; margin: 0;">
                <input type="text" name="search" class="form-control" placeholder="Search by title or employer"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>

            <div class="form-group" style="margin: 0;">
                <select name="filter" class="form-control">
                    <option value="all">All Jobs</option>
                    <option value="pending" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    <option value="closed" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'closed') ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?php echo BASE_URL; ?>?page=jobs" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <!-- Jobs Table -->
    <div class="card">
        <?php if (empty($jobs)): ?>
            <p>No jobs found</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Employer</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td><?php echo $job['id']; ?></td>
                            <td><?php echo htmlspecialchars($job['title']); ?></td>
                            <td><?php echo htmlspecialchars($job['employer_name']); ?></td>
                            <td><span class="badge badge-info"><?php echo htmlspecialchars($job['category_name']); ?></span></td>
                            <td><?php echo ucfirst($job['job_type']); ?></td>
                            <td><?php echo htmlspecialchars($job['location']); ?></td>
                            <td>
                                <?php
                                $status_class = $job['status'] == 'approved' ? 'badge-success' : ($job['status'] == 'pending' ? 'badge-warning' : ($job['status'] == 'rejected' ? 'badge-danger' : 'badge-secondary'));
                                ?>
                                <span class="badge <?php echo $status_class; ?>">
                                    <?php echo ucfirst($job['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($job['created_at'])); ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="<?php echo BASE_URL; ?>?page=jobs&action=view&id=<?php echo $job['id']; ?>"
                                        class="btn btn-sm btn-primary">View</a>

                                    <?php if ($job['status'] == 'pending'): ?>
                                        <a href="<?php echo BASE_URL; ?>?page=jobs&action=approve&id=<?php echo $job['id']; ?>"
                                            class="btn btn-sm btn-success"
                                            data-confirm="Approve this job posting?">Approve</a>
                                        <a href="<?php echo BASE_URL; ?>?page=jobs&action=reject&id=<?php echo $job['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            data-confirm="Reject this job posting?">Reject</a>
                                    <?php endif; ?>

                                    <?php if ($job['status'] == 'approved'): ?>
                                        <a href="<?php echo BASE_URL; ?>?page=jobs&action=close&id=<?php echo $job['id']; ?>"
                                            class="btn btn-sm btn-warning"
                                            data-confirm="Close this job posting?">Close</a>
                                    <?php endif; ?>

                                    <a href="<?php echo BASE_URL; ?>?page=jobs&action=delete&id=<?php echo $job['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        data-confirm="Delete this job? This action cannot be undone.">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
