<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">User Details</h1>
        <p>Viewing profile for <?php echo htmlspecialchars($user['username']); ?></p>
    </div>
    
    <div class="card mb-4">
        <h2 class="card-title">Basic Information</h2>
        <table class="table">
            <tr>
                <th style="width: 200px;">User ID</th>
                <td><?php echo $user['id']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
            </tr>
            <tr>
                <th>User Type</th>
                <td>
                    <?php
                    $type_class = $user['user_type'] == 'admin' ? 'badge-danger' : 
                                ($user['user_type'] == 'employer' ? 'badge-info' : 'badge-secondary');
                    ?>
                    <span class="badge <?php echo $type_class; ?>">
                        <?php echo ucfirst($user['user_type']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php
                    $status_class = $user['status'] == 'approved' ? 'badge-success' : 
                                  ($user['status'] == 'pending' ? 'badge-warning' : 'badge-danger');
                    ?>
                    <span class="badge <?php echo $status_class; ?>">
                        <?php echo ucfirst($user['status']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Registered</th>
                <td><?php echo date('F d, Y H:i', strtotime($user['created_at'])); ?></td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td><?php echo date('F d, Y H:i', strtotime($user['updated_at'])); ?></td>
            </tr>
        </table>
    </div>
    
    <?php if(!empty($user_stats)): ?>
        <div class="card mb-4">
            <h2 class="card-title">Statistics</h2>
            <div class="stats-grid">
                <?php if($user['user_type'] == 'employer'): ?>
                    <div class="stat-card">
                        <h3>Total Jobs Posted</h3>
                        <div class="stat-value"><?php echo $user_stats['total_jobs']; ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Active Jobs</h3>
                        <div class="stat-value"><?php echo $user_stats['active_jobs']; ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Applications Received</h3>
                        <div class="stat-value"><?php echo $user_stats['total_applications']; ?></div>
                    </div>
                <?php elseif($user['user_type'] == 'jobseeker'): ?>
                    <div class="stat-card">
                        <h3>Total Applications</h3>
                        <div class="stat-value"><?php echo $user_stats['total_applications']; ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Pending Applications</h3>
                        <div class="stat-value"><?php echo $user_stats['pending_applications']; ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Accepted Applications</h3>
                        <div class="stat-value"><?php echo $user_stats['accepted_applications']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <h2 class="card-title">Actions</h2>
        <div class="flex gap-2">
            <?php if($user['status'] == 'pending'): ?>
                <a href="<?php echo BASE_URL; ?>?page=users&action=approve&id=<?php echo $user['id']; ?>" 
                   class="btn btn-success"
                   data-confirm="Approve this user?">Approve User</a>
            <?php endif; ?>
            
            <?php if($user['status'] != 'banned'): ?>
                <a href="<?php echo BASE_URL; ?>?page=users&action=ban&id=<?php echo $user['id']; ?>" 
                   class="btn btn-warning"
                   data-confirm="Ban this user?">Ban User</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>?page=users&action=unban&id=<?php echo $user['id']; ?>" 
                   class="btn btn-success"
                   data-confirm="Unban this user?">Unban User</a>
            <?php endif; ?>
            
            <?php if($user['id'] != $_SESSION['user_id']): ?>
                <a href="<?php echo BASE_URL; ?>?page=users&action=delete&id=<?php echo $user['id']; ?>" 
                   class="btn btn-danger"
                   data-confirm="Delete this user? This action cannot be undone.">Delete User</a>
            <?php endif; ?>
            
            <a href="<?php echo BASE_URL; ?>?page=users" class="btn btn-secondary">Back to Users</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
