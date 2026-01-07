<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">Edit Category</h1>
        <p>Update category information</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <form method="POST" action="" data-validate>
            <div class="form-group">
                <label for="name" class="form-label">Category Name *</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="<?php echo htmlspecialchars($category['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($category['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="active" <?php echo $category['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo $category['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="<?php echo BASE_URL; ?>?page=categories" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Category Statistics -->
    <?php
    $stats = get_category_statistics($category['id']);
    ?>
    <div class="card">
        <h2 class="card-title">Category Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Jobs</h3>
                <div class="stat-value"><?php echo $stats['total_jobs']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Active Jobs</h3>
                <div class="stat-value"><?php echo $stats['active_jobs']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pending Jobs</h3>
                <div class="stat-value"><?php echo $stats['pending_jobs']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Applications</h3>
                <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
