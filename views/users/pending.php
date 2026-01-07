<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4">
        <h1 class="card-title">Pending Users Approval</h1>
        <p>Review and approve new user registrations</p>
    </div>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <?php if(empty($users)): ?>
            <div class="alert alert-info">No pending users at this time</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Type</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td>
                                <span class="badge badge-info">
                                    <?php echo ucfirst($user['user_type']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="<?php echo BASE_URL; ?>?page=users&action=approve&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-sm btn-success"
                                       data-confirm="Approve this user?">Approve</a>
                                    <a href="<?php echo BASE_URL; ?>?page=users&action=delete&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       data-confirm="Reject and delete this user?">Reject</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div class="mt-3">
            <a href="<?php echo BASE_URL; ?>?page=users" class="btn btn-secondary">Back to All Users</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
