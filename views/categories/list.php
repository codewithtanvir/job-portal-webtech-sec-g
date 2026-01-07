<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4 flex justify-between align-center">
        <div>
            <h1 class="card-title">Category Management</h1>
            <p>Manage job categories</p>
        </div>
        <a href="<?php echo BASE_URL; ?>?page=categories&action=add" class="btn btn-primary">Add New Category</a>
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

    <!-- Statistics -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <h3>Total Categories</h3>
            <div class="stat-value"><?php echo count($categories); ?></div>
        </div>
        <div class="stat-card">
            <h3>Active Categories</h3>
            <div class="stat-value">
                <?php echo count(array_filter($categories, function ($c) {
                    return $c['status'] == 'active';
                })); ?>
            </div>
        </div>
        <div class="stat-card">
            <h3>Total Jobs</h3>
            <div class="stat-value">
                <?php echo array_sum(array_column($categories, 'job_count')); ?>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <?php if (empty($categories)): ?>
            <p>No categories found. <a href="<?php echo BASE_URL; ?>?page=categories&action=add">Add one now</a></p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Jobs Count</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($category['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars(substr($category['description'], 0, 80)) . (strlen($category['description']) > 80 ? '...' : ''); ?></td>
                            <td>
                                <span class="badge badge-info"><?php echo $category['job_count']; ?> jobs</span>
                            </td>
                            <td>
                                <?php
                                $status_class = $category['status'] == 'active' ? 'badge-success' : 'badge-secondary';
                                ?>
                                <span class="badge <?php echo $status_class; ?>">
                                    <?php echo ucfirst($category['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($category['created_at'])); ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="<?php echo BASE_URL; ?>?page=categories&action=edit&id=<?php echo $category['id']; ?>"
                                        class="btn btn-sm btn-primary">Edit</a>

                                    <a href="<?php echo BASE_URL; ?>?page=categories&action=toggle_status&id=<?php echo $category['id']; ?>"
                                        class="btn btn-sm <?php echo $category['status'] == 'active' ? 'btn-warning' : 'btn-success'; ?>"
                                        data-confirm="Change category status?">
                                        <?php echo $category['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>
                                    </a>

                                    <?php if ($category['job_count'] == 0): ?>
                                        <a href="<?php echo BASE_URL; ?>?page=categories&action=delete&id=<?php echo $category['id']; ?>"
                                            class="btn btn-sm btn-danger"
                                            data-confirm="Delete this category? This action cannot be undone.">Delete</a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-danger" disabled title="Cannot delete - has associated jobs">Delete</button>
                                    <?php endif; ?>
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
